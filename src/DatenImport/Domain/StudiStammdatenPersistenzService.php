<?php

namespace DatenImport\Domain;

use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\Studi;
use Studi\Domain\StudiData;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;
use Studi\Domain\StudiRepository;

class StudiStammdatenPersistenzService
{
    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiRepository */
    private $studiRepository;

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
        StudiRepository $studiRepository,
        StudiHashCreator $studiHashCreator
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiRepository = $studiRepository;
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
            $matrikelZuLoeschen[$studiInternAktuell->getMatrikelnummer()->getValue()] = $studiInternAktuell;
        }

        // Studis, die im Import vorhanden sind, werden von Löschliste entfernt.
        foreach ($alleStudisImport as $studiImport) {
            unset($matrikelZuLoeschen[$studiImport->getMatrikelnummer()->getValue()]);
        }

        foreach ($matrikelZuLoeschen as $matrikelValue => $studiInternAktuell) {
            $this->studiInternRepository->delete($studiInternAktuell);
            $this->studiRepository->delete($this->studiRepository->byStudiHash($studiInternAktuell->getStudiHash()));
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
                    $studi = $this->studiRepository->byStudiHash($existierenderStudiIntern->getStudiHash());
                    if ($studi) {
                        $this->studiRepository->delete($studi);
                    }
                    $this->addStudiFromStudiData($studiDataObject);
                    $this->geaendert++;
                    echo "M";
                }
            }
        }
        $this->studiRepository->flush();
        $this->studiInternRepository->flush();
    }

    private function addStudiFromStudiData(StudiData $studiDataObject): void {
        $studiHash = $this->studiHashCreator->createStudiHash($studiDataObject);
        $studiInternNeu = StudiIntern::fromMatrikelUndStudiHash(
            $studiDataObject->getMatrikelnummer(),
            $studiHash
        );
        $this->studiInternRepository->add($studiInternNeu);

        $studiNeu = Studi::fromStudiHash($studiHash);
        $this->studiRepository->add($studiNeu);
    }

}