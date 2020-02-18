<?php

namespace DatenImport\Domain;

use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\ItemSchwierigkeit;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Studi\Domain\Matrikelnummer;
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

    private StudiPruefungsRepository $studiPruefungsRepository;

    private ItemWertungsRepository $itemWertungsRepository;

    private PruefungsItemRepository $pruefungsItemRepository;

    private StudiInternRepository $studiInternRepository;

    private StudiPruefungsWertungRepository $studiPruefungsWertungRepository;

    private int $hinzugefuegt = 0;

    private int $geaendert = 0;

    /** @var Matrikelnummer[] */
    private array $matrikelnummernNichtZuzuordnen = [];

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

    /** @param array<array<mixed>> $mcPruefungsDaten */
    public function persistierePruefung($mcPruefungsDaten): void {
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

            $gesamtErreichtePunktzahl = (float) $gesamtErreichtePunktzahl;

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

            $this->erzeugeStudiPruefungsWertung(
                $studiPruefung,
                $gesamtErreichtePunktzahl,
                $fragenAnzahl,
                $bestehensGrenze
            );

            $this->pruefeOderErzeugePruefungsItem(
                $pruefungsItemId,
                $pruefungsId,
                $schwierigkeit
            );

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

    /**
     * @return Matrikelnummer[];
     */
    public function getMatrikelnummernNichtZuzuordnen(): array {
        return $this->matrikelnummernNichtZuzuordnen;
    }

    private function holeOderErzeugeStudiPruefung(
        StudiHash $studiHash,
        PruefungsId $pruefungsId,
        float $gesamtPunktzahl = NULL,
        float $bestehensgrenze = NULL
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

    private function holeStudiIntern(Matrikelnummer $matrikelnummer): ?StudiIntern {
        $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
        if (!$studiIntern) {
            if (!in_array($matrikelnummer, $this->matrikelnummernNichtZuzuordnen)) {
                echo "\n Warnung: Studi mit Matrikel als Hash nicht gefunden: " . $matrikelnummer;
                echo " -> Ignoriere Matrikelnummer in allen Zeilen.";
                $this->matrikelnummernNichtZuzuordnen[] = $matrikelnummer;

                return NULL;
            }

        }

        return $studiIntern;
    }

    private function erzeugeStudiPruefungsWertung(
        StudiPruefung $studiPruefung,
        float $gesamtErreichtePunktzahl,
        int $fragenAnzahl,
        float $bestehensGrenze
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
        } elseif ($studiPruefungsWertung && !$gesamtErreichtePunktzahl) {
            $this->studiPruefungsWertungRepository->delete($studiPruefungsWertung);
            $this->studiPruefungsWertungRepository->flush();
        }
    }

    private function pruefeOderErzeugePruefungsItem(
        PruefungsItemId $pruefungsItemId,
        PruefungsId $pruefungsId,
        ?int $schwierigkeit
    ): void {
        $schwierigkeitVO = NULL;
        if ($schwierigkeit !== 0) {
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
        PruefungsItemId $pruefungsItemId,
        Punktzahl $punktzahl,
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
            || ($itemWertung->getAntwortCode() != $antwortCode
                && (!$itemWertung->getAntwortCode()
                    || $itemWertung->getAntwortCode()->getValue() != "0")
                && (!$antwortCode
                    || $antwortCode->getValue() != "0"))) {
            if ($itemWertung) {
                $this->itemWertungsRepository->delete($itemWertung);
                $this->geaendert++;
                echo "-";
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