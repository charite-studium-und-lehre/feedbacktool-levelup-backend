<?php

namespace DatenImport\Domain;


use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

class StudiStammdatenPersistenzService
{
    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiStammdatenImportService */
    private $studiStammdatenImportService;

    /** @var StudiHashCreator */
    private $studiHashCreator;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiStammdatenImportService $studiStammdatenImportService,
        StudiHashCreator $studiHashCreator
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiStammdatenImportService = $studiStammdatenImportService;
        $this->studiHashCreator = $studiHashCreator;
    }

    /** @param StudiIntern[] $studiInternArray */
    public function persistiereStudiListe(array $importSettings) {

        $studiDataObjectsToImport = $this->studiStammdatenImportService->getStudiData($importSettings);

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

    /**
     * @param $studiDataObject
     * @return array
     */
    private function addStudiFromStudiData($studiDataObject): array {
        $studiHash = $this->studiHashCreator->createStudiHash($studiDataObject);
        $studiInternNeu = StudiIntern::fromMatrikelUndStudiHash(
            $studiDataObject->getMatrikelnummer(),
            $studiHash
        );
        $this->studiInternRepository->add($studiInternNeu);

        return array($studiHash, $studiInternNeu);
    }

}