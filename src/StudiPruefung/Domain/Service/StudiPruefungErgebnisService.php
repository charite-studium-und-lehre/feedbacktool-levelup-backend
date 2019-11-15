<?php

namespace StudiPruefung\Domain\Service;

use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use DatenImport\Domain\FachCodeKonstanten;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsItemRepository;
use Pruefung\Domain\PruefungsRepository;
use Studienfortschritt\Domain\FortschrittsItem;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\StudiPruefungsWertungRepository;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;

class StudiPruefungErgebnisService
{
    /** @var StudiPruefungsWertungRepository */
    private $studiPruefungsWertungRepository;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var PruefungsItemRepository */
    private $pruefungsItemRepository;

    /** @var ItemWertungsRepository */
    private $itemWertungsRepository;

    /** @var ClusterZuordnungsService */
    private $clusterZuordnungsService;

    /** @var ClusterRepository */
    private $clusterRepository;

    public function __construct(
        StudiPruefungsWertungRepository $studiPruefungsWertungRepository,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository,
        PruefungsItemRepository $pruefungsItemRepository,
        ItemWertungsRepository $itemWertungsRepository,
        ClusterZuordnungsService $clusterZuordnungsService,
        ClusterRepository $clusterRepository
    ) {
        $this->studiPruefungsWertungRepository = $studiPruefungsWertungRepository;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
        $this->pruefungsItemRepository = $pruefungsItemRepository;
        $this->itemWertungsRepository = $itemWertungsRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
        $this->clusterRepository = $clusterRepository;
    }

    public function getErgebnisAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());

        $gesamtErgebnis = $this->getStudiPruefungGesamtWertung($studiPruefung);
        $einzelErgebnisse = $this->getErgebnisDetailsAlsJsonArray($studiPruefung);
        $pruefungsPeriode = $pruefung->getPruefungsPeriode();
        $returnArray = [
            "name"     => $pruefung->getName(),
            "kurzName" => $pruefung->getKurzName(),
            "typ"      => $pruefung->getFormat()->getCode(),
            "format"   => $pruefung->getFormat()->getFormatAbstrakt(),
        ];

        $fortschrittsItem = FortschrittsItem::fromPruefung($pruefung, $studiPruefung->getId());
        if ($fortschrittsItem) {
            $returnArray["fachsemester"] = $fortschrittsItem->getFachsemester();
        }
        $returnArray += ["studiPruefungsId" => $studiPruefung->getId()->getValue(),
                         "zeitsemester"     => $pruefungsPeriode->getZeitsemester()->getStandardStringLesbar(),
                         "periodeCode"      => $pruefungsPeriode->toInt(),
                         "periodeText"      => $pruefungsPeriode->getPeriodeBeschreibung(),
                         "gesamtErgebnis"   => $gesamtErgebnis,
        ];
        $returnArray += $einzelErgebnisse;

        return $returnArray;
    }

    private function getErgebnisDetailsAlsJsonArray(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        if ($pruefung->getFormat()->isMc()) {
            return $this->getMCErgebnisDetailsAlsJsonArray($studiPruefung);
        } elseif ($pruefung->getFormat()->isStation()) {
            return $this->getStationsErgebnisDetailsAlsJsonArray($studiPruefung);
        } elseif ($pruefung->getFormat()->isPTM()) {
            return $this->getPTMErgebnisDetailsAlsJsonArray($studiPruefung);
        }

        return [];
    }

    private function getStudiPruefungGesamtWertung(StudiPruefung $studiPruefung): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $pruefungsWertung = $this->studiPruefungsWertungRepository->byStudiPruefungsId($studiPruefung->getId());
        if (!$pruefungsWertung) {
            return [];
        }
        if ($pruefung->getFormat()->isMc()) {
            $kohortenWertungen = [];
            $alleStudiPruefungen = $this->studiPruefungsRepository->allByPruefungsId($pruefung->getId());
            foreach ($alleStudiPruefungen as $kohortenStudiPruefung) {
                $kohortenStudiPruefungsWertung = $this->studiPruefungsWertungRepository
                    ->byStudiPruefungsId($kohortenStudiPruefung->getId());
                if (!$kohortenStudiPruefungsWertung) {
                    continue;
                }
                $kohortenWertungen[] = $kohortenStudiPruefungsWertung->getGesamtErgebnis()->getPunktWertung()
                    ->getPunktzahl()->getValue();
            }

            return [
                "ergebnisPunktzahl"        => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl"   => $pruefungsWertung->getKohortenWertung()
                    ? $pruefungsWertung->getKohortenWertung()->getPunktWertung()->getPunktzahl()->getValue()
                    : NULL,
                "maximalPunktzahl"         => $pruefungsWertung->getGesamtErgebnis()
                    ->getPunktWertung()->getSkala()->getMaxPunktzahl()->getValue(),
                "bestehensgrenzePunktzahl" => $pruefungsWertung->getBestehensGrenze()
                    ->getPunktWertung()->getPunktzahl()->getValue(),
                "kohortenPunktzahlen"      => $kohortenWertungen,
            ];
        } elseif ($pruefung->getFormat()->isStation()) {
            return [
                "ergebnisProzentzahl"     => $pruefungsWertung->getGesamtErgebnis()
                    ->getProzentWertung()->getProzentzahl()->getValue(),
                "durchschnittProzentzahl" => $pruefungsWertung->getKohortenWertung()
                    ? $pruefungsWertung->getKohortenWertung()->getProzentWertung()->getProzentzahl()->getValue()
                    : NULL,
            ];
        } elseif ($pruefung->getFormat()->isPTM()) {
            $returnArray = [
                "ergebnisRichtigPunktzahl"    => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlRichtig()->getValue(),
                "ergebnisFalschPunktzahl"     => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlFalsch()->getValue(),
                "ergebnisWeissnichtPunktzahl" => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue(),
                "maximalPunktzahl"            => $pruefungsWertung->getGesamtErgebnis()
                    ->getRichtigFalschWeissnichtWertung()->getGesamtPunktzahl()->getValue(),
            ];
            if ($pruefungsWertung->getKohortenWertung()->getRichtigFalschWeissnichtWertung()) {
                $returnArray += ["durchschnittRichtigPunktzahl"    => $pruefungsWertung->getKohortenWertung()
                    ->getRichtigFalschWeissnichtWertung()->getPunktzahlRichtig()->getValue(),
                                 "durchschnittFalschPunktzahl"     => $pruefungsWertung->getKohortenWertung()
                                     ->getRichtigFalschWeissnichtWertung()->getPunktzahlFalsch()->getValue(),
                                 "durchschnittWeissnichtPunktzahl" => $pruefungsWertung->getKohortenWertung()
                                     ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue(),
                ];
            }

            return $returnArray;
        } else {
            throw new \Exception("Unbekanntes Format: " . $pruefung->getFormat()->getTitel());
        }
    }

    private
    function getStationsErgebnisDetailsAlsJsonArray(
        StudiPruefung $studiPruefung
    ): array {
        /** @var Pruefung $pruefung */
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isStation()) {
            return [];
        }

        $clusteredItems = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getStationsFachTyp());
        if (!$clusteredItems) {
            $clusteredItems = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getStationsModulTyp());
        }
        $itemsNachWissensTyp = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getStationsWissensTyp());;

        $itemsNachWissenFakten = [];
        $itemsNachWissenZusammenhang = [];
        foreach ($itemsNachWissensTyp as $clusterId => $itemWertungen) {
            $cluster = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            if ($cluster->getCode()->getValue() == FachCodeKonstanten::STATION_WISSENS_TYP_FAKTEN) {
                $itemsNachWissenFakten = $itemWertungen;
            } elseif ($cluster->getCode()->getValue() == FachCodeKonstanten::STATION_WISSENS_TYP_ZUSAMMENHANG) {
                $itemsNachWissenZusammenhang = $itemWertungen;
            }
        }
        $clusteredItemsWissenMeine = [];
        $clusteredItemsZusammenhangMeine = [];
        $clusteredItemsWissenKohorte = [];
        $clusteredItemsZusammenhangKohorte = [];
        foreach ($clusteredItems as $clusterId => $itemWertungen) {
            foreach ($itemWertungen as $itemWertung) {
                /** @var $itemWertung ItemWertung */
                if (in_array($itemWertung, $itemsNachWissenFakten)) {
                    $clusteredItemsWissenMeine[$clusterId][] = $itemWertung->getWertung();
                    $clusteredItemsWissenKohorte[$clusterId][] = $itemWertung->getKohortenWertung();
                } elseif (in_array($itemWertung, $itemsNachWissenZusammenhang)) {
                    $clusteredItemsZusammenhangMeine[$clusterId][] = $itemWertung->getWertung();
                    $clusteredItemsZusammenhangKohorte[$clusterId][] = $itemWertung->getKohortenWertung();
                }
            }
        }
        //        dump($clusteredItemsWissenMeine);

        $returnArray = [];

        foreach ($clusteredItems as $clusterId => $itemWertungen) {
            $cluster = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));

            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);

            /** @var ProzentWertung $meinDurchschnitt */
            $meinDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleMeineWertungen);
            /** @var ProzentWertung $kohortenDurchschnitt */
            $kohortenDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);

            $addArray = [
                "code"                    => $cluster->getCode()->getValue(),
                "titel"                   => $cluster->getTitel()->getValue(),
                "ergebnisProzentzahl"     => $meinDurchschnitt->getProzentzahl()->getValue(),
                "durchschnittProzentzahl" => $kohortenDurchschnitt->getProzentzahl()->getValue(),
                "typ"                     => $pruefung->getFormat()->getStationsTyp(),
            ];

            if (isset($clusteredItemsWissenMeine[$clusterId])) {
                $addArray["details"][] = [
                    "code"                    => "fakten",
                    "titel"                   => "Faktenwissen",
                    "ergebnisProzentzahl"     => $itemWertungen[0]->getWertung()::getDurchschnittsWertung(
                        $clusteredItemsWissenMeine[$clusterId])->getProzentzahl()->getValue(),
                    "durchschnittProzentzahl" => $itemWertungen[0]->getWertung()::getDurchschnittsWertung(
                        $clusteredItemsWissenKohorte[$clusterId])->getProzentzahl()->getValue(),
                ];
                $addArray["details"][] = [
                    "code"                    => FachCodeKonstanten::STATION_WISSENS_TYP_ZUSAMMENHANG,
                    "titel"                   => FachCodeKonstanten::STATION_WISSENS_TYPEN[FachCodeKonstanten::STATION_WISSENS_TYP_ZUSAMMENHANG],
                    "ergebnisProzentzahl"     =>
                        isset($clusteredItemsZusammenhangMeine[$clusterId])
                            ? $itemWertungen[0]->getWertung()::getDurchschnittsWertung(
                            $clusteredItemsZusammenhangMeine[$clusterId])->getProzentzahl()->getValue()
                            : NULL,
                    "durchschnittProzentzahl" =>
                        isset($clusteredItemsZusammenhangKohorte[$clusterId])
                            ? $itemWertungen[0]->getWertung()::getDurchschnittsWertung(
                            $clusteredItemsZusammenhangKohorte[$clusterId])->getProzentzahl()->getValue()
                            : NULL,
                ];

            }

            $returnArray["stationen"][] = $addArray;
        }

        return $returnArray;

    }

    private
    function getPTMErgebnisDetailsAlsJsonArray(
        StudiPruefung $studiPruefung
    ): array {
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isPTM()) {
            return [];
        }

        $itemsNachFach = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getFachTyp());

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));

            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);

            /** @var RichtigFalschWeissnichtWertung $meinDurchschnitt */
            $meinDurchschnitt = $itemWertungen[0]->getWertung()::getSummenWertung($alleMeineWertungen);
            /** @var RichtigFalschWeissnichtWertung $kohortenDurchschnitt */
            $kohortenDurchschnitt = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);

            $gruppe = FachCodeKonstanten::getFachGruppeByFach($fach->getCode()->getValue());
            $fachAggregate[] = [
                "code"                        => $fach->getCode()->getValue(),
                "titel"                       => $fach->getTitel()->getValue(),
                "gruppe"                      => $gruppe,
                "ergebnisRichtigPunktzahl"    => $meinDurchschnitt->getPunktzahlRichtig()->getValue(),
                "ergebnisFalschPunktzahl"     => $meinDurchschnitt->getPunktzahlFalsch()->getValue(),
                "ergebnisWeissnichtPunktzahl" => $meinDurchschnitt->getPunktzahlWeissnicht()->getValue(),

                "durchschnittRichtigPunktzahl"    => $kohortenDurchschnitt->getPunktzahlRichtig()->getValue(),
                "durchschnittFalschPunktzahl"     => $kohortenDurchschnitt->getPunktzahlFalsch()->getValue(),
                "durchschnittWeissnichtPunktzahl" => $kohortenDurchschnitt->getPunktzahlWeissnicht()->getValue(),

                "maximalPunktzahl" => $meinDurchschnitt->getGesamtPunktzahl()->getValue(),
            ];
        }

        return [
            "faecher" => $fachAggregate,
        ];
    }

    private
    function getMCErgebnisDetailsAlsJsonArray(
        StudiPruefung $studiPruefung
    ): array {
        [$pruefung, $itemWertungen] = $this->getPruefungUndWertungen($studiPruefung);
        if (!$pruefung->getFormat()->isMc()) {
            return [];
        }

        $itemsNachFach = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getFachTyp());
        $itemsNachModul = $this->getItemsNachClusterTyp($itemWertungen, ClusterTyp::getModulTyp());

        $fachAggregate = [];
        foreach ($itemsNachFach as $clusterId => $itemWertungen) {
            $fach = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);
            $meineSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleMeineWertungen);
            $kohortenSumme = NULL;
            if ($alleKohortenWertungen) {
                $kohortenSumme = $itemWertungen[0]->getWertung()::getSummenWertung($alleKohortenWertungen);
            } else {
                $kohortenSumme = PunktWertung::fromPunktzahlUndSkala(Punktzahl::fromFloat(0),
                                                                     PunktSkala::fromMaxPunktzahl(
                                                                         Punktzahl::fromFloat(0)
                                                                     ));
            }

            $gruppe = FachCodeKonstanten::getFachGruppeByFach($fach->getCode()->getValue());

            $fachAggregate[] = [
                "code"                   => $fach->getCode()->getValue(),
                "titel"                  => $fach->getTitel()->getValue(),
                "gruppe"                 => $gruppe,
                "ergebnisPunktzahl"      => $meineSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl" => $kohortenSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "maximalPunktzahl"       => $meineSumme->getPunktWertung()
                    ->getSkala()
                    ->getMaxPunktzahl()
                    ->getValue(),
            ];
        }

        $modulAggregate = [];
        foreach ($itemsNachModul as $clusterId => $itemWertungen) {
            $modul = $this->clusterRepository->byId(ClusterId::fromInt($clusterId));
            [$alleMeineWertungen, $alleKohortenWertungen] = $this->getWertungen($itemWertungen);
            $meineSumme = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleMeineWertungen);
            if ($alleKohortenWertungen) {
                $kohortenSumme = $itemWertungen[0]->getWertung()::getDurchschnittsWertung($alleKohortenWertungen);
            } else {
                $kohortenSumme = PunktWertung::fromPunktzahlUndSkala(Punktzahl::fromFloat(0),
                                                                     PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(0)));
            }

            $modulAggregate[] = [
                "code"                   => $modul->getCode()->getValue(),
                "titel"                  => $modul->getTitel()->getValue(),
                "ergebnisPunktzahl"      => $meineSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "durchschnittsPunktzahl" => $kohortenSumme->getPunktWertung()->getPunktzahl()->getValue(),
                "maximalPunktzahl"       => $meineSumme->getPunktWertung()
                    ->getSkala()->getMaxPunktzahl()->getValue(),
            ];
        }

        return [
            "faecher" => $fachAggregate,
            "module"  => $modulAggregate,
        ];
    }

    private
    function getWertungen(
        $itemWertungen
    ): array {
        $alleMeineWertungen = [];
        $alleKohortenWertungen = [];
        foreach ($itemWertungen as $itemWertung) {
            $alleMeineWertungen[] = $itemWertung->getWertung();
            if ($itemWertung->getKohortenWertung()) {
                $alleKohortenWertungen[] = $itemWertung->getKohortenWertung();
            }
        }

        return [$alleMeineWertungen, $alleKohortenWertungen];
    }

    /** @return ItemWertung[] */
    private
    function getItemsNachClusterTyp(
        $itemWertungen,
        ClusterTyp $clusterTyp
    ): array {
        $itemsNachFach = [];
        foreach ($itemWertungen as $itemWertung) {
            $clusterIds = $this->clusterZuordnungsService->getVorhandeneClusterIdsNachTyp(
                $itemWertung->getPruefungsItemId(),
                $clusterTyp
            );
            if ($clusterIds) {
                $fachClusterId = $clusterIds[0];
                $itemsNachFach[$fachClusterId->getValue()][] = $itemWertung;
            }
        }

        return $itemsNachFach;
    }

    private
    function getPruefungUndWertungen(
        StudiPruefung $studiPruefung
    ): array {
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $itemWertungen = $this->itemWertungsRepository->allByStudiPruefungsId($studiPruefung->getId());

        return array($pruefung, $itemWertungen);
    }

}