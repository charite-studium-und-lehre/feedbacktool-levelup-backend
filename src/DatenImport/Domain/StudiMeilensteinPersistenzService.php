<?php

namespace DatenImport\Domain;

use Studi\Domain\StudiData;
use Studi\Domain\StudiInternRepository;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilenstein;
use Studienfortschritt\Domain\StudiMeilensteinRepository;

class StudiMeilensteinPersistenzService
{
    private StudiInternRepository $studiInternRepository;

    private StudiMeilensteinRepository $StudiMeilensteinRepository;

    private int $hinzugefuegt = 0;

    private int $geloescht = 0;

    public function __construct(
        StudiInternRepository $studiInternRepository,
        StudiMeilensteinRepository $StudiMeilensteinRepository
    ) {
        $this->studiInternRepository = $studiInternRepository;
        $this->StudiMeilensteinRepository = $StudiMeilensteinRepository;
    }

    /** @param StudiData[] $studiDataObjectsToImport */
    public function persistiereStudiListe(array $studiDataObjectsToImport): void {

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
                $codeExistierend = $existierenderMeilenstein->getFortschrittsItem()->getCode();
                if (!in_array($codeExistierend, $meilensteinCodesHinzuzufuegen)) {
                    $zuLoeschen[] = $existierenderMeilenstein;
                } else {
                    $meilensteinCodesHinzuzufuegen =
                        array_diff($meilensteinCodesHinzuzufuegen,
                                   [$existierenderMeilenstein->getFortschrittsItem()->getCode()]
                        );
                }
            }
            foreach ($meilensteinCodesHinzuzufuegen as $meilensteinCodeHinzuzufuegen) {
                $gefunden = FALSE;
                foreach ($alleMeilensteineDesStudis as $existierenderMeilenstein) {
                    if ($existierenderMeilenstein->getFortschrittsItem()->getCode() == $meilensteinCodeHinzuzufuegen) {
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