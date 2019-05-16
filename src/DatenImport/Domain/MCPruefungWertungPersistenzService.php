<?php

namespace DatenImport\Domain;

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

class MCPruefungWertungPersistenzService
{
    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var McPruefungsdatenImportService */
    private $mcPruefungsdatenImportService;

    /** @var PruefungsId */
    private $pruefungsId;

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
        McPruefungsdatenImportService $mcPruefungsdatenImportService,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        PruefungsId $pruefungsId,
        StudiInternRepository $studiInternRepository
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->mcPruefungsdatenImportService = $mcPruefungsdatenImportService;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsId = $pruefungsId;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->studiInternRepository = $studiInternRepository;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistierePruefung() {

        $pruefungsWertungen = $this->mcPruefungsdatenImportService->getMCData();
        foreach ($pruefungsWertungen as [$matrikelnummer, $punktzahl, $pruefungsItemId, $clusterTitel]) {

            $studiHash = $this->studiInternRepository->byMatrikelnummer($matrikelnummer);
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
                $this->pruefungsItemRepository->flush();
            }

            $itemWertung = $this->itemWertungsRepository->byStudiPruefungsIdUndPruefungssItemId(
                $studiPruefung->getId(),
                $pruefungsItemId
            );
            $punktWertung = PunktWertung::fromPunktzahlUndSkala(
                $punktzahl,
                PunktSkala::fromMaxPunktzahl(1000)
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
                $this->itemWertungsRepository->flush();
            }
        }

    }

}

}