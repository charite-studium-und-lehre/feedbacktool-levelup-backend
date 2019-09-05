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

    /** @var StudiHashCreator */
    private $studiHashCreator;

    /** @var int */
    private $hinzugefuegt = 0;

    /** @var int */
    private $geloescht = 0;

    /** @var int */
    private $geaendert = 0;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiHashCreator $studiHashCreator
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiHashCreator = $studiHashCreator;
    }

    public function persistiereStudiListe($studiDataObjectsToImport) {

        $this->loescheObsoleteStudis($studiDataObjectsToImport);

        $this->neueStudisInternHinzufuegenOderUpdate($studiDataObjectsToImport);

    }

    public function getHinzugefuegt(): int {
        return $this->hinzugefuegt;
    }

    public function getGeloescht(): int {
        return $this->geloescht;
    }

    public function getGeaendert(): int {
        return $this->geaendert;
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
            echo "-";
            $this->geloescht++;
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
                echo "+";
                $this->hinzugefuegt++;
            } else {
                if (!$this->studiHashCreator->isCorrectStudiHash(
                    $existierenderStudiIntern->getStudiHash(),
                    $studiDataObject)
                ) {
                    $this->studiInternRepository->delete($existierenderStudiIntern);
                    $this->addStudiFromStudiData($studiDataObject);
                    $this->geaendert++;
                    echo "M";
                }
            }
        }
        $this->studiInternRepository->flush();
    }

    private function addStudiFromStudiData(StudiData $studiDataObject): void {
        $studiHash = $this->studiHashCreator->createStudiHash($studiDataObject);
        $studiInternNeu = StudiIntern::fromMatrikelUndStudiHash(
            $studiDataObject->getMatrikelnummer(),
            $studiHash
        );
        $this->studiInternRepository->add($studiInternNeu);
    }

}