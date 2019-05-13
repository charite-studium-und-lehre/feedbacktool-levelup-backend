<?php

namespace DatenImport\Infrastructure\Persistence;


use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

class StudiStammdatenPersistenzService
{
    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiStammdatenCSVImportService */
    private $stammdatenCSVImportService;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiStammdatenCSVImportService $stammdatenCSVImportService
    ) {

        $this->studiInternRepository = $studiInternRepository;
        $this->stammdatenCSVImportService = $stammdatenCSVImportService;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistiereStudiListe(array $importSettings) {
        $alleStudisInternAktuell = $this->studiInternRepository->all();
        $alleStudisCSV = $this->stammdatenCSVImportService->getStudiInternObjects($importSettings);

        $studisZuLoeschen = [];

        foreach ($alleStudisInternAktuell as $studiInternAktuell) {
            $studisZuLoeschen[] = $studiInternAktuell->getMatrikelnummer()->getValue();
        }

        foreach ($alleStudisCSV as $studiCSV) {
            $studisZuLoeschen = array_diff($studisZuLoeschen,
                                           [$studiCSV->getMatrikelnummer()->getValue()]
            );
        }



    }

}