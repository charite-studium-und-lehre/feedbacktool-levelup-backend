<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnung;
use Cluster\Domain\ClusterZuordnungsRepository;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiInternRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

class CharitePTMPersistenzService
{
    public const TYP_FALSCH = 'f';
    public const TYP_RICHTIG = 'r';
    public const TYP_WEISSNICHT = 'w';

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var ClusterRepository */
    private $clusterRepository;

    /** @var ClusterZuordnungsRepository */
    private $clusterZuordnungsRepository;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        ClusterRepository $clusterRepository,
        ClusterZuordnungsRepository $clusterZuordnungsRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
        $this->clusterRepository = $clusterRepository;
        $this->clusterZuordnungsRepository = $clusterZuordnungsRepository;
    }

    public function persistierePruefung($ptmPruefungsDaten, PruefungsId $pruefungsId) {
        $counter = 0;
        $lineCount = count($ptmPruefungsDaten);
        $einProzent = round($lineCount / 100);

        foreach ($ptmPruefungsDaten as $matrikelnummer => $studiErgebnis) {
            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
            }
            foreach ($studiErgebnis as $clusterTypValue => $clusterTypErgebnis) {
                foreach ($clusterTypErgebnis as $clusterPTMCode => $bewertungsTyp) {

                    $this->createOrUpdateWertung($matrikelnummer, $clusterPTMCode, $bewertungsTyp, $pruefungsId);
                    $this->createFachClusterZuordnung($clusterTypValue, $clusterPTMCode, $pruefungsId);

                    // evtl. in Zukunft auch Organsysteme
                    //   $this->createOrgansystemClusterZuordnung($clusterTypValue, $clusterPTMCode);
                }
            }
        }

        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();
        $this->clusterZuordnungsRepository->flush();

    }

    private function createOrUpdateWertung($matrikelnummer, $clusterPTMCode, $bewertungsTyp, PruefungsId $pruefungsId):
    void {
        $studiIntern = $this->studiInternRepository->byMatrikelnummer(
            Matrikelnummer::fromInt($matrikelnummer)
        );
        if (!$studiIntern) {
            return;
        }
        $studiHash = $studiIntern->getStudiHash();
        $studiPruefung = $this->studiPruefungsRepository->byStudiHashUndPruefungsId(
            $studiHash,
            $pruefungsId
        );
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

        $pruefungsItemId = $this->getPruefungsItemId($clusterPTMCode, $pruefungsId);

        $pruefungsItem = $this->pruefungsItemRepository->byId($pruefungsItemId);
        if (!$pruefungsItem) {
            $pruefungsItem = PruefungsItem::create(
                $pruefungsItemId,
                $pruefungsId
            );
            $this->pruefungsItemRepository->add($pruefungsItem);

        }

        $itemWertung = $this->itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefung->getId(),
            $pruefungsItemId
        );
        $richtigFalschWeissnichtWertung = RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat($bewertungsTyp[SELF::TYP_RICHTIG]),
            Punktzahl::fromFloat($bewertungsTyp[SELF::TYP_FALSCH]),
            Punktzahl::fromFloat($bewertungsTyp[SELF::TYP_WEISSNICHT])
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

    private function getPruefungsItemId($clusterPTMCode, $pruefungsId): PruefungsItemId {
        $pruefungsItemIdInt = $pruefungsId->getValue() . "-" . $clusterPTMCode;
        $pruefungsItemId = PruefungsItemId::fromString($pruefungsItemIdInt);

        return $pruefungsItemId;
    }

    /**
     * @param $clusterTypValue
     * @param $clusterPTMCode
     */
    private function createFachClusterZuordnung($clusterTypValue, $clusterPTMCode, PruefungsId $pruefungsId): void {
        $clusterTyp = ClusterTyp::fromConst($clusterTypValue);
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
                $found = FALSE;
            }
            break;
        }
        if (!$found) {
            $clusterZuordnung = ClusterZuordnung::byIds(
                $fachCluster->getId(),
                $pruefungsItemId
            );
            $this->clusterZuordnungsRepository->addZuordnung($clusterZuordnung);
        }
    }

}