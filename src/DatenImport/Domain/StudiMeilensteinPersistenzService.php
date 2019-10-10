<?php

namespace DatenImport\Domain;

use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiInternRepository;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilenstein;
use Studienfortschritt\Domain\StudiMeilensteinRepository;

class StudiMeilensteinPersistenzService
{
    /** @var StudiInternRepository */
    private $studiInternRepository;

    /** @var StudiHashCreator */
    private $studiHashCreator;

    /** @var StudiMeilensteinRepository */
    private $StudiMeilensteinRepository;

    /** @var int */
    private $hinzugefuegt = 0;

    /** @var int */
    private $geloescht = 0;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiHashCreator $studiHashCreator,
        StudiMeilensteinRepository $StudiMeilensteinRepository
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->studiHashCreator = $studiHashCreator;
        $this->StudiMeilensteinRepository = $StudiMeilensteinRepository;
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
            foreach (FortschrittsItem::FORTSCHRITT_KUERZEL_ZU_CODE as $kuerzel => $codeExistierend) {
                if (!isset($dataLine[$kuerzel])) {
                    if ($codeExistierend < 400) {
                        echo "\n Fehler: Kürzel nicht gefunden:  $kuerzel";
                    }
                    continue;
                }
                if ($dataLine[$kuerzel]) {
                    $meilensteinCodesHinzuzufuegen[] = $codeExistierend;
                }
            }

            $alleMeilensteineDesStudis = $this->StudiMeilensteinRepository->allByStudiHash(
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
                $StudiMeilenstein = StudiMeilenstein::fromValues(
                    $this->StudiMeilensteinRepository->nextIdentity(),
                    $existierenderStudiIntern->getStudiHash(),
                    FortschrittsItem::fromCode($hinzufuegenCode)
                );
                $this->StudiMeilensteinRepository->add($StudiMeilenstein);
                $this->hinzugefuegt++;
            }

            foreach ($zuLoeschen as $meilensteinZuLoeschen) {
                $this->StudiMeilensteinRepository->delete($meilensteinZuLoeschen);
                $this->geloescht++;
            }
            $this->StudiMeilensteinRepository->flush();
        }

    }

    public function getHinzugefuegt(): int {
        return $this->hinzugefuegt;
    }

    public function getGeloescht(): int {
        return $this->geloescht;
    }

}