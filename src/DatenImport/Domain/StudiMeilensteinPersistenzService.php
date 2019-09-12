<?php

namespace DatenImport\Domain;

use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiInternRepository;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\StudiMeilenstein;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;

class StudiMeilensteinPersistenzService
{
    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiHashCreator */
    private $studiHashCreator;

    /** @var StudiMeilensteinRepository */
    private $studiMeilensteinRepository;

    /** @var int */
    private $hinzugefuegt = 0;

    /** @var int */
    private $geloescht = 0;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiHashCreator $studiHashCreator,
        StudiMeilensteinRepository $studiMeilensteinRepository
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiHashCreator = $studiHashCreator;
        $this->studiMeilensteinRepository = $studiMeilensteinRepository;
    }

    public function persistiereStudiListe($studiDataObjectsToImport) {

        foreach ($studiDataObjectsToImport as $studiDataObject) {
            $existierenderStudiIntern = $this->studiInternRepository->byMatrikelnummer(
                $studiDataObject->getMatrikelnummer()
            );
            if (!$existierenderStudiIntern) {
                echo "\nStudi mit Matrikelnummer nicht gefunden: " . $studiDataObject->getMatrikelnummer();
                continue;
            }

            $dataLine = $studiDataObject->getDataLine();
            $meilensteinCodesHinzuzufuegen = [];
            foreach (Meilenstein::MEILENSTEINE_KUERZEL_ZU_CODE as $kuerzel => $codeExistierend) {
                if (!isset($dataLine[$kuerzel])) {
                    echo "\n Fehler: Kürzel nicht gefunden:  $kuerzel";
                    continue;
                }
                if ($dataLine[$kuerzel]) {
                    $meilensteinCodesHinzuzufuegen[] = $codeExistierend;
                }
            }


            $alleMeilensteineDesStudis = $this->studiMeilensteinRepository->allByStudiHash(
                $existierenderStudiIntern->getStudiHash()
            );

            $zuLoeschen = [];
            foreach ($alleMeilensteineDesStudis as $existierenderMeilenstein) {
                $codeExistierend = $existierenderMeilenstein->getMeilenstein()->getCode();
                if (!in_array($codeExistierend, $meilensteinCodesHinzuzufuegen)) {
                    $zuLoeschen[] = $existierenderMeilenstein;
                } else {
                    $meilensteinCodesHinzuzufuegen =
                        array_diff($meilensteinCodesHinzuzufuegen,
                                    [$existierenderMeilenstein->getMeilenstein()->getCode()]
                        );
                }
            }
            foreach ($meilensteinCodesHinzuzufuegen as $meilensteinCodeHinzuzufuegen) {
                $gefunden = FALSE;
                foreach ($alleMeilensteineDesStudis as $existierenderMeilenstein) {
                    if ($existierenderMeilenstein->getMeilenstein()->getCode() == $meilensteinCodeHinzuzufuegen) {
                        $gefunden = TRUE;
                        break;
                    }
                }
                if ($gefunden) {
                    $meilensteinCodesHinzuzufuegen = array_diff($meilensteinCodesHinzuzufuegen, [$codeExistierend]);
                }
            }

            echo $meilensteinCodesHinzuzufuegen ? "+" : "";
            echo $zuLoeschen ? "-" : "";

            foreach ($meilensteinCodesHinzuzufuegen as $hinzufuegenCode) {
                $studiMeilenstein = StudiMeilenstein::fromValues(
                    $this->studiMeilensteinRepository->nextIdentity(),
                    $existierenderStudiIntern->getStudiHash(),
                    Meilenstein::fromCode($hinzufuegenCode)
                );
                $this->studiMeilensteinRepository->add($studiMeilenstein);
                $this->hinzugefuegt++;
            }

            foreach ($zuLoeschen as $meilensteinZuLoeschen) {
                $this->studiMeilensteinRepository->delete($meilensteinZuLoeschen);
                $this->geloescht++;
            }
            $this->studiMeilensteinRepository->flush();
        }

    }

    public function getHinzugefuegt(): int {
        return $this->hinzugefuegt;
    }

    public function getGeloescht(): int {
        return $this->geloescht;
    }

}