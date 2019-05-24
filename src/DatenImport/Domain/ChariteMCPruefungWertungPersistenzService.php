<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
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
    public function persistierePruefung($mcPruefungsDaten) {

        foreach ($mcPruefungsDaten as [$matrikelnummer, $punktzahl, $pruefungsItemId, $clusterTitel]) {

            $studiIntern = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
            $studiHash = $studiIntern->getStudiHash();
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
            $punktWertung = PunktWertung::fromPunktzahlUndSkala(
                $punktzahl,
                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(1))
            );
            if (!$itemWertung
                || $itemWertung->getWertung()->equals(
                    $punktWertung)) {
                if ($itemWertung) {
                    $this->itemWertungsRepository->delete($itemWertung);
                }
                $itemWertung = ItemWertung::create(
                    $this->itemWertungsRepository->nextIdentity(),
                    $pruefungsItemId,
                    $studiPruefung->getId(),
                    $punktWertung
                );
                $this->itemWertungsRepository->add($itemWertung);
            }
        }
        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();

    }

}