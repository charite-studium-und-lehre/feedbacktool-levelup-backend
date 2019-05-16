<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

class ChariteMcPruefungsErgebnissePersistenzService
{
    /** @var PruefungsId */
    private $pruefungsId;

    /** @var StudiStammdatenImportService */
    private $studiStammdatenImportService;

    /** @var StudiHashCreator */
    private $studiHashCreator;

    public function __construct(
        PruefungsId $pruefungsId,
        StudiStammdatenImportService $studiStammdatenImportService,
        StudiHashCreator $studiHashCreator
    ) {
        $this->pruefungsId = $pruefungsId;
        $this->studiStammdatenImportService = $studiStammdatenImportService;
        $this->studiHashCreator = $studiHashCreator;
    }
    
    public function persistiereStudiListe() {

        $studiDataObjectsToImport = $this->studiStammdatenImportService->getStudiData();

        $this->loescheObsoleteStudis($studiDataObjectsToImport);

        $this->neueStudisInternHinzufuegenOderUpdate($studiDataObjectsToImport);

    }

    /**
     * @param $alleStudisImport StudiIntern[]
     */
    private function loescheObsoleteStudis(array $alleStudisImport): void {
        $alleStudisInternAktuell = $this->studiInternRepository->all();
        $matrikelZuLoeschen = [];

        // alle Studis werden erstmal zum Löschen markiert
        foreach ($alleStudisInternAktuell as $studiInternAktuell) {
            $matrikelZuLoeschen[] = $studiInternAktuell->getMatrikelnummer()->getValue();
        }

        // Studis, die im Import vorhanden sind, werden von Löschliste entfernt.
        foreach ($alleStudisImport as $studiImport) {
            $matrikelZuLoeschen = array_diff($matrikelZuLoeschen,
                                             [$studiImport->getMatrikelnummer()->getValue()]
            );
        }

        foreach ($matrikelZuLoeschen as $matrikelValue) {
            $this->studiInternRepository->delete($this->studiInternRepository->byMatrikelnummer(
                Matrikelnummer::fromInt($matrikelValue)
            ));
        }
        $this->studiInternRepository->flush();
    }

    /**
     * @param $studiDataObjectsToImport StudiData[]
     */
    private function neueStudisInternHinzufuegenOderUpdate($studiDataObjectsToImport): void {
        foreach ($studiDataObjectsToImport as $studiDataObject) {
            $existierenderStudiIntern = $this->studiInternRepository->byMatrikelnummer(
                $studiDataObject->getMatrikelnummer()
            );
            if (!$existierenderStudiIntern) {
                $this->addStudiFromStudiData($studiDataObject);
            } else {
                if (!$this->studiHashCreator->isCorrectStudiHash(
                    $existierenderStudiIntern->getStudiHash(),
                    $studiDataObject)
                ) {
                    $this->studiInternRepository->delete($existierenderStudiIntern);
                    $this->addStudiFromStudiData($studiDataObject);
                }
            }
        }
        $this->studiInternRepository->flush();
    }

    private function addStudiFromStudiData(StudiData $studiDataObject) : void {
        $studiHash = $this->studiHashCreator->createStudiHash($studiDataObject);
        $studiInternNeu = StudiIntern::fromMatrikelUndStudiHash(
            $studiDataObject->getMatrikelnummer(),
            $studiHash
        );
        $this->studiInternRepository->add($studiInternNeu);
    }

}