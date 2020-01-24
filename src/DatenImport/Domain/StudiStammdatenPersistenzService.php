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
    private \Studi\Domain\StudiInternRepository $studiInternRepository;

    private \Studi\Domain\Service\StudiHashCreator $studiHashCreator;

    private int $hinzugefuegt = 0;

    private int $geloescht = 0;

    private int $geaendert = 0;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiHashCreator $studiHashCreator
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiHashCreator = $studiHashCreator;
    }

    public function persistiereStudiListe($studiDataObjectsToImport) {

        $this->neueStudisInternHinzufuegenOderUpdate($studiDataObjectsToImport);
        $this->loescheObsoleteStudis($studiDataObjectsToImport);


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
                $studiHash = $this->studiHashCreator->createStudiHash($studiDataObject);
                $existierenderStudiInternByHash = $this->studiInternRepository->byStudiHash(
                    $studiHash
                );
                if ($existierenderStudiInternByHash) {
                    $this->studiInternRepository->delete($existierenderStudiInternByHash);
                    $this->studiInternRepository->flush();
                    echo "D\n";
                }
            }
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
                    $this->studiInternRepository->flush();
                    $studi = $this->studiInternRepository->byStudiHash($existierenderStudiIntern->getStudiHash());
                    if ($studi) {
                        $this->studiInternRepository->delete($studi);
                        echo "-";
                    }
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