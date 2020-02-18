<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsRepository;
use Exception;
use Pruefung\Domain\FachCodeKonstanten;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiInternRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\StudiPruefungsWertung;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

class CharitePTMPersistenzService
{
    public const TYP_FALSCH = 'f';
    public const TYP_RICHTIG = 'r';
    public const TYP_WEISSNICHT = 'w';

    private StudiPruefungsRepository $studiPruefungsRepository;

    private ItemWertungsRepository $itemWertungsRepository;

    private PruefungsItemRepository $pruefungsItemRepository;

    private StudiInternRepository $studiInternRepository;

    private ClusterRepository $clusterRepository;

    private ClusterZuordnungsRepository $clusterZuordnungsRepository;

    private StudiPruefungsWertungRepository $studiPruefungsWertungRepository;

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
        $this->clusterRepository = $clusterRepository;
        $this->clusterZuordnungsRepository = $clusterZuordnungsRepository;
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
    }

    /**
     * @param array<int|string, array<int|string, array<string, array<string, float|int|string>>>> $ptmPruefungsDaten
     */
    public function persistierePruefung(array $ptmPruefungsDaten, PruefungsId $pruefungsId): void {
        $counter = 0;
        $lineCount = count($ptmPruefungsDaten);
        $einProzent = max(1, round($lineCount / 100));

        foreach ($ptmPruefungsDaten as $matrikelnummer => $studiErgebnis) {
            try {
                $matrikelnummerVO = Matrikelnummer::fromInt((int) $matrikelnummer);
            } catch (Exception $e) {
                echo "\n" . $e->getMessage() . " --- Skipping!";
                continue;
            }
            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
            }
            foreach ($studiErgebnis as $clusterTypValue => $clusterTypErgebnis) {
                foreach ($clusterTypErgebnis as $clusterPTMCode => $bewertungsTypArray) {

                    if ($clusterTypValue === "gesamtergebnis") {
                        $this->createOrUpdateGesamtWertung(
                            $matrikelnummerVO,
                            $clusterTypErgebnis["all"],
                            $pruefungsId
                        );
                        continue;
                    }

                    $this->createOrUpdateWertung($matrikelnummerVO, $clusterPTMCode, $bewertungsTypArray, $pruefungsId);
                    if ($counter == 1) {
                        $this->createFachClusterZuordnung($clusterTypValue, $clusterPTMCode, $pruefungsId);
                    }

                    // evtl. in Zukunft auch Organsysteme
                    //   $this->createOrgansystemClusterZuordnung($clusterTypValue, $clusterPTMCode);
                }
            }
        }

        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();
        $this->clusterZuordnungsRepository->flush();

    }

    /** @param array<string, float|int|string> $bewertungsTypArray */
    private function createOrUpdateWertung(
        Matrikelnummer $matrikelnummer,
        string $clusterPTMCode,
        array $bewertungsTypArray,
        PruefungsId $pruefungsId
    ): void {
        $studiPruefung = $this->getOrAddStudiPruefung($pruefungsId, $matrikelnummer);
        if (!$studiPruefung) {
            return;
        }

        $pruefungsItemId = $this->getPruefungsItemId($clusterPTMCode, $pruefungsId);

        $this->checkAddPruefungsItem($pruefungsId, $pruefungsItemId);

        $itemWertung = $this->itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefung->getId(),
            $pruefungsItemId
        );
        $richtigFalschWeissnichtWertung = RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_RICHTIG]),
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_FALSCH]),
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_WEISSNICHT])
        );
        if (!$itemWertung
            || !$itemWertung->getWertung()->equals($richtigFalschWeissnichtWertung)) {
            if ($itemWertung) {
                $this->itemWertungsRepository->delete($itemWertung);
            }
            $itemWertung = ItemWertung::create(
                $this->itemWertungsRepository->nextIdentity(),
                $pruefungsItemId,
                $studiPruefung->getId(),
                $richtigFalschWeissnichtWertung
            );
            $this->itemWertungsRepository->add($itemWertung);
        } else {
            $itemWertung->setWertung($richtigFalschWeissnichtWertung);
        }
    }

    private function getPruefungsItemId(string $clusterPTMCode, PruefungsId $pruefungsId): PruefungsItemId {
        $pruefungsItemIdInt = $pruefungsId->getValue() . "-" . $clusterPTMCode;

        return PruefungsItemId::fromString($pruefungsItemIdInt);
    }

    /** @param int|string $clusterTypValue */
    private function createFachClusterZuordnung(
        $clusterTypValue,
        string $clusterPTMCode,
        PruefungsId $pruefungsId
    ): void {
        $clusterTyp = ClusterTyp::fromConst((int) $clusterTypValue);
        if (!$clusterTyp->isFachTyp()) {
            return;
        }
        $fachCode = FachCodeKonstanten::PTM_CODE_ZU_FACH_CODE[$clusterPTMCode];
        if (!$fachCode) {
            echo "PTM-Fach-Zuordnung nicht gefuden: '$clusterPTMCode'";

            return;
        }
        $fachCluster = $this->clusterRepository->byClusterTypUndCode(
            $clusterTyp,
            ClusterCode::fromString($fachCode)
        );
        if (!$fachCluster) {
            echo "PTM: Fach für Code nicht gefunden: '$fachCode'";

            return;
        }
        $pruefungsItemId = $this->getPruefungsItemId($clusterPTMCode, $pruefungsId);
        $alleClusterIds = $this->clusterZuordnungsRepository->alleClusterIdsVonPruefungsItem($pruefungsItemId);
        $found = FALSE;
        foreach ($alleClusterIds as $clusterId) {
            $cluster = $this->clusterRepository->byId($clusterId);
            if (!$cluster->getClusterTyp()->equals($clusterTyp)) {
                continue;
            }

            if ($cluster->equals($fachCluster)) {
                $found = TRUE;
            } else {
                $this->clusterZuordnungsRepository->delete(
                    ClusterZuordnung::byIds($clusterId, $pruefungsItemId)
                );
            }
        }
        if (!$found) {
            $clusterZuordnung = ClusterZuordnung::byIds(
                $fachCluster->getId(),
                $pruefungsItemId
            );
            $this->clusterZuordnungsRepository->addZuordnung($clusterZuordnung);
        }
    }

    private function getOrAddStudiPruefung(PruefungsId $pruefungsId, Matrikelnummer $matrikelnummer): ?StudiPruefung {
        static $nichtGefundeneNummern = [];
        $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
        if (!$studiIntern) {
            if (!in_array($matrikelnummer, $nichtGefundeneNummern)) {
                echo "\nMatrikelnummer nicht gefunden: $matrikelnummer -> überspringe;";
                $nichtGefundeneNummern[] = $matrikelnummer;
            }

            return NULL;
        }
        $studiHash = $studiIntern->getStudiHash();
        $studiPruefung = $this->studiPruefungsRepository->byStudiHashUndPruefungsId($studiHash, $pruefungsId);

        if (!$studiPruefung) {
            $studiPruefung = StudiPruefung::fromValues(
                $this->studiPruefungsRepository->nextIdentity(),
                $studiHash,
                $pruefungsId
            );
            $this->studiPruefungsRepository->add($studiPruefung);
            echo "+";
            $this->studiPruefungsRepository->flush();
        }

        return $studiPruefung;
    }

    /**
     * @param PruefungsId $pruefungsId
     * @param PruefungsItemId $pruefungsItemId
     */
    private function checkAddPruefungsItem(PruefungsId $pruefungsId, PruefungsItemId $pruefungsItemId): void {
        $pruefungsItem = $this->pruefungsItemRepository->byId($pruefungsItemId);
        if (!$pruefungsItem) {
            $pruefungsItem = PruefungsItem::create(
                $pruefungsItemId,
                $pruefungsId
            );
            $this->pruefungsItemRepository->add($pruefungsItem);
        }
    }

    /**
     * @param array<string,float|int|string> $bewertungsTypArray
     */
    private function createOrUpdateGesamtWertung(
        Matrikelnummer $matrikelnummer,
        array $bewertungsTypArray,
        PruefungsId $pruefungsId
    ): void {
        $studiPruefung = $this->getOrAddStudiPruefung($pruefungsId, $matrikelnummer);
        if (!$studiPruefung) {
            return;
        }

        $richtigFalschWeissnichtWertung = RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_RICHTIG]),
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_FALSCH]),
            Punktzahl::fromFloat((float) $bewertungsTypArray[SELF::TYP_WEISSNICHT])
        );
        $studiPruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
        if (!$studiPruefungsWertung) {
            $studiPruefungsWertung = StudiPruefungsWertung::create(
                $studiPruefung->getId(),
                $richtigFalschWeissnichtWertung
            );
            $this->studiPruefungsWertungRepository->add($studiPruefungsWertung);
        } else {
            $studiPruefungsWertung->setGesamtErgebnis($richtigFalschWeissnichtWertung);
        }
        $this->studiPruefungsWertungRepository->flush();
    }

}