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
    /** @var PruefungsId */
    private $pruefungsId;

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
        PruefungsId $pruefungsId,
        PruefungsRepository $pruefungsRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        StudiInternRepository $studiInternRepository
    ) {
        $this->pruefungsId = $pruefungsId;
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistierePruefung($pruefungsDaten) {

        foreach ($pruefungsDaten as $dataLine) {
            $ergebnisse = $dataLine["ergebnisse"];
            $matrikelnummer = Matrikelnummer::fromInt($dataLine["matrikelnummer"]);
            $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
            $studiHash = $studiIntern->getStudiHash();
            $fach = $dataLine["fach"];
            $datum = $dataLine["datum"];

            $studiPruefung = $this->studiPruefungsRepository->byStudiHashUndPruefungsId(
                $studiHash,
                $this->pruefungsId,
                );
            if (!$studiPruefung) {
                $studiPruefung = StudiPruefung::fromValues(
                    $this->studiPruefungsRepository->nextIdentity(),
                    $studiHash,
                    $this->pruefungsId
                );
                $this->studiPruefungsRepository->add($studiPruefung);
                $this->studiPruefungsRepository->flush();
            }

            foreach ($ergebnisse as $ergebnisKey => $ergebnis) {
                $itemCode = $ergebnisKey . $fach;

                $pruefungsItemIdInt = base_convert(substr(md5($itemCode), 0, 5), 16, 10);
                $pruefungsItemId = PruefungsItemId::fromString($pruefungsItemIdInt);

                $pruefungsItem = $this->pruefungsItemRepository->byId($pruefungsItemId);
                if (!$pruefungsItem) {
                    $pruefungsItem = PruefungsItem::create(
                        $pruefungsItemId,
                        $this->pruefungsId
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