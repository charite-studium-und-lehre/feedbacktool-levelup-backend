<?php

namespace DatenImport\Domain;

use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\ItemSchwierigkeit;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemRepository;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\StudiPruefungsWertung;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteMCPruefungWertungPersistenzService
{

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiPruefungsWertungRepository */
    private $studiPruefungsWertungRepository;

    /** @var int */
    private $hinzugefuegt = 0;

    /** @var int */
    private $geaendert = 0;

    /** @var int */
    private $nichtZuzuordnen = [];

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        StudiInternRepository $studiInternRepository,
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistierePruefung($mcPruefungsDaten) {
        $counter = 0;
        $lineCount = count($mcPruefungsDaten);
        $einProzent = round($lineCount / 100);

        foreach ($mcPruefungsDaten as
        [$matrikelnummer,
            $punktzahl,
            $pruefungsId,
            $pruefungsItemId,
            $fragenNr,
            $lzNummer,
            $gesamtErreichtePunktzahl,
            $fragenAnzahl,
            $bestehensGrenze,
            $schwierigkeit,
            $antwortCode]
        ) {

            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
                $this->pruefungsItemRepository->flush();
                $this->itemWertungsRepository->flush();
            }

            $studiIntern = $this->holeStudiIntern($matrikelnummer);
            if (!$studiIntern) {
                continue;
            }

            $studiHash = $studiIntern->getStudiHash();
            $studiPruefung = $this->holeOderErzeugeStudiPruefung(
                $studiHash,
                $pruefungsId,
                $gesamtErreichtePunktzahl,
                $bestehensGrenze
            );

            //            $this->erzeugeStudiPruefungsWertung(
            //                $studiPruefung,
            //                $gesamtErreichtePunktzahl,
            //                $fragenAnzahl,
            //                $bestehensGrenze
            //            );
            //
            //            $this->pruefeOderErzeugePruefungsItem(
            //                $pruefungsItemId,
            //                $pruefungsId,
            //                $schwierigkeit
            //            );

            $this->pruefeOderErzeugeItemWertung(
                $studiPruefung,
                $pruefungsItemId,
                $punktzahl,
                $antwortCode
            );

        }
        $this->flushAllRepos();

    }

    public function getHinzugefuegt(): int {
        return $this->hinzugefuegt;
    }

    public function getGeaendert(): int {
        return $this->geaendert;
    }

    public function getNichtZuzuordnen(): array {
        return $this->nichtZuzuordnen;
    }

    private function holeOderErzeugeStudiPruefung(
        StudiHash $studiHash,
        PruefungsId $pruefungsId,
        $gesamtPunktzahl = NULL,
        $bestehensgrenze = NULL
    ): StudiPruefung {
        $bestanden = $gesamtPunktzahl && $bestehensgrenze && $gesamtPunktzahl > $bestehensgrenze;

        $studiPruefung = $this->studiPruefungsRepository->byStudiHashUndPruefungsId(
            $studiHash,
            $pruefungsId,
            );

        if (!$studiPruefung) {
            $studiPruefung = StudiPruefung::fromValues(
                $this->studiPruefungsRepository->nextIdentity(),
                $studiHash,
                $pruefungsId,
                $bestanden
            );
            $this->studiPruefungsRepository->add($studiPruefung);
            $this->studiPruefungsRepository->flush();
        }
        if ($studiPruefung->isBestanden() != $bestanden) {
            $studiPruefung->setBestanden($bestanden);
        }

        return $studiPruefung;
    }

    private function holeStudiIntern($matrikelnummer) {
        $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
        if (!$studiIntern) {
            if (!in_array($matrikelnummer, $this->nichtZuzuordnen)) {
                echo "\n Fehler: Studi mit Matrikel als Hash nicht gefunden: " . $matrikelnummer;
                echo " -> Ignoriere Matrikelnummer in allen Zeilen.";
                $this->nichtZuzuordnen[] = $matrikelnummer;

                return NULL;
            }

        }

        return $studiIntern;
    }

    private function erzeugeStudiPruefungsWertung(
        StudiPruefung $studiPruefung,
        $gesamtErreichtePunktzahl,
        $fragenAnzahl,
        $bestehensGrenze
    ): void {
        $studiPruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId(
            $studiPruefung->getId()
        );

        if ($gesamtErreichtePunktzahl) {
            $gesamtErgebnisWertung = PunktWertung::fromPunktzahlUndSkala(
                Punktzahl::fromFloat($gesamtErreichtePunktzahl),
                PunktSkala::fromMaxPunktzahl(
                    Punktzahl::fromFloat($fragenAnzahl)
                )
            );
            $bestehensGrenzeWertung = NULL;
            if ($bestehensGrenze) {
                $bestehensGrenzeWertung = PunktWertung::fromPunktzahlUndSkala(
                    Punktzahl::fromFloat($bestehensGrenze),
                    PunktSkala::fromMaxPunktzahl(
                        Punktzahl::fromFloat($fragenAnzahl)
                    )
                );
            }
            if (!$studiPruefungsWertung) {
                $studiPruefungsWertung = StudiPruefungsWertung::create(
                    $studiPruefung->getId(),
                    $gesamtErgebnisWertung,
                    $bestehensGrenzeWertung
                );
                $this->studiPruefungsWertungRepository->add($studiPruefungsWertung);
            } else {
                $studiPruefungsWertung->setGesamtErgebnis($gesamtErgebnisWertung);
                $studiPruefungsWertung->setBestehensGrenze($bestehensGrenzeWertung);
            }

            $this->studiPruefungsWertungRepository->flush();
        } elseif ($studiPruefungsWertung) {
            if ($studiPruefungsWertung && !$gesamtErreichtePunktzahl) {
                $this->studiPruefungsWertungRepository->delete($studiPruefungsWertung);
                $this->studiPruefungsWertungRepository->flush();
            }
        }
    }

    private function pruefeOderErzeugePruefungsItem($pruefungsItemId, $pruefungsId, ?int $schwierigkeit): void {
        $schwierigkeitVO = NULL;
        if ($schwierigkeit) {
            $schwierigkeitVO = ItemSchwierigkeit::fromConst($schwierigkeit);
        }

        $pruefungsItem = $this->pruefungsItemRepository->byId($pruefungsItemId);
        if (!$pruefungsItem) {
            $pruefungsItem = PruefungsItem::create(
                $pruefungsItemId,
                $pruefungsId,
                $schwierigkeitVO
            );
            $this->pruefungsItemRepository->add($pruefungsItem);
        }
        $pruefungsItem->setItemSchwierigkeit(ItemSchwierigkeit::fromConst($schwierigkeit));
    }

    private function pruefeOderErzeugeItemWertung(
        StudiPruefung $studiPruefung,
        $pruefungsItemId,
        $punktzahl,
        ?AntwortCode $antwortCode
    ): void {
        $itemWertung = $this->itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
            $studiPruefung->getId(),
            $pruefungsItemId
        );
        $punktWertung = PunktWertung::fromPunktzahlUndSkala(
            $punktzahl,
            PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1))
        );
        if (!$itemWertung
            || !$itemWertung->getWertung()->equals($punktWertung)
            || $itemWertung->getAntwortCode() != $antwortCode) {
            if ($itemWertung) {
                $this->itemWertungsRepository->delete($itemWertung);
                $this->geaendert++;
            } else {
                $this->hinzugefuegt++;
            }
            $itemWertung = ItemWertung::create(
                $this->itemWertungsRepository->nextIdentity(),
                $pruefungsItemId,
                $studiPruefung->getId(),
                $punktWertung,
                $antwortCode
            );
            $this->itemWertungsRepository->add($itemWertung);
            echo "+";
        }
    }

    private function flushAllRepos(): void {
        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();
        $this->studiPruefungsWertungRepository->flush();
    }

}