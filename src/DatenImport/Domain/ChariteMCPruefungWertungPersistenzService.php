<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemRepository;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
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

    /** @var int */
    private $hinzugefuegt = 0;

    /** @var int */
    private $geaendert = 0;

    /** @var int */
    private $nichtZuzuordnen = [];

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        StudiInternRepository $studiInternRepository
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistierePruefung($mcPruefungsDaten) {
        $counter = 0;
        $lineCount = count($mcPruefungsDaten);
        $einProzent = round($lineCount / 100);

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsId, $pruefungsItemId,
            $clusterTitel]) {
            $counter++;

            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
                $this->pruefungsItemRepository->flush();
                $this->itemWertungsRepository->flush();
            }

            $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
            if (!$studiIntern) {
                if (!in_array($matrikelnummer, $this->nichtZuzuordnen)) {
                    echo "\n Fehler: Studi mit Matrikel als Hash nicht gefunden: " . $matrikelnummer;
                    echo " -> Ignoriere Matrikelnummer in allen Zeilen.";
                    $this->nichtZuzuordnen[] = $matrikelnummer;
                }
                continue;
            }
            $studiHash = $studiIntern->getStudiHash();
            $studiPruefung = $this->studiPruefungsRepository->byStudiHashUndPruefungsId(
                $studiHash,
                $pruefungsId,
                );
            if (!$studiPruefung) {
                $studiPruefung = StudiPruefung::fromValues(
                    $this->studiPruefungsRepository->nextIdentity(),
                    $studiHash,
                    $pruefungsId
                );
                $this->studiPruefungsRepository->add($studiPruefung);
                $this->studiPruefungsRepository->flush();
            }

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
            $punktWertung = PunktWertung::fromPunktzahlUndSkala(
                $punktzahl,
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1))
            );
            if (!$itemWertung
                || !$itemWertung->getWertung()->equals($punktWertung)) {
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
                    $punktWertung
                );
                $this->itemWertungsRepository->add($itemWertung);
                echo "+";
            }

        }
        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();

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

}