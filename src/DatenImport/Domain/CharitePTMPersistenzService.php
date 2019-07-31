<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Studi\Domain\StudiIntern;
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
    public function persistierePruefung($ptmPruefungsDaten) {
        foreach ($ptmPruefungsDaten as $matrikelnummer => $studiErgebnis) {
            foreach ($studiErgebnis as $clusterTyp => $clusterTypErgebnis) {
                foreach ($clusterTypErgebnis as $clusterName => $bewertungsTyp) {

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

                    $pruefungsItemIdInt = base_convert(substr(md5($clusterTyp . "-" . $clusterName), 0, 5), 16, 10);
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
                    }
                }
            }

        }


        $this->pruefungsItemRepository->flush();
        $this->itemWertungsRepository->flush();

    }

}