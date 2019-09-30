<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;

class ChariteStationenPruefungPersistenzService
{

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

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        StudiInternRepository $studiInternRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistierePruefung($pruefungsDaten, PruefungsId $pruefungsId) {

        foreach ($pruefungsDaten as $dataLine) {
            $ergebnisse = $dataLine["ergebnisse"];
            $matrikelnummer = Matrikelnummer::fromInt($dataLine["matrikelnummer"]);
            $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
            if (!$studiIntern) {
                echo "\nWarnung: Studi mit Matrikel " . $dataLine["matrikelnummer"] . " nicht gef. Ignoriere Zeile.";
                continue;
            }
            $studiHash = $studiIntern->getStudiHash();
            $fach = $dataLine["fach"];
            $datum = $dataLine["datum"];

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

            foreach ($ergebnisse as $ergebnisKey => $ergebnis) {
                $itemCode = $fach . "-" . $ergebnisKey;

                $pruefungsItemId = PruefungsItemId::fromString( $pruefungsId->getValue() . "-" . $itemCode);

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
                if (strstr($itemCode, "#") == FALSE) {
                    $ergebnis /= 100;
                }
                $prozentWertung = ProzentWertung::fromProzentzahl(
                    Prozentzahl::fromFloatRunden($ergebnis)
                );

                if (!$itemWertung
                    || !$itemWertung->getWertung()->equals($prozentWertung)) {
                    if ($itemWertung) {
                        $this->itemWertungsRepository->delete($itemWertung);
                    }
                    $itemWertung = ItemWertung::create(
                        $this->itemWertungsRepository->nextIdentity(),
                        $pruefungsItemId,
                        $studiPruefung->getId(),
                        $prozentWertung
                    );
                    $this->itemWertungsRepository->add($itemWertung);
                }

            }
        }
        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();

    }

}