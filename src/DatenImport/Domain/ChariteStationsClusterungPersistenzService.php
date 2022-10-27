<?php

namespace DatenImport\Domain;

use Cluster\Domain\Cluster;
use Cluster\Domain\ClusterCode;
use Cluster\Domain\ClusterId;
use Cluster\Domain\ClusterRepository;
use Cluster\Domain\ClusterTitel;
use Cluster\Domain\ClusterTyp;
use Cluster\Domain\ClusterZuordnungsService;
use Pruefung\Domain\FachCodeKonstanten;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;

class ChariteStationsClusterungPersistenzService
{
    private ClusterRepository $clusterRepository;

    private ClusterZuordnungsService $clusterZuordnungsService;

    public function __construct(
        ClusterRepository $clusterRepository,
        ClusterZuordnungsService $clusterZuordnungsService
    ) {
        $this->clusterRepository = $clusterRepository;
        $this->clusterZuordnungsService = $clusterZuordnungsService;
    }

    /**
     * @param array<int, array<string, mixed>> $pruefungsDaten
     */
    public function persistiereClusterZuordnungen(array $pruefungsDaten, PruefungsId $pruefungsId): void {
        $counter = 0;
        $lineCount = count($pruefungsDaten);
        $einProzent = round($lineCount / 10);

        foreach ($pruefungsDaten as $key => $dataLine) {
            $counter++;
            if ($counter % $einProzent == 0) {
                echo "\n" . round($counter / $lineCount * 100) . "% fertig";
            }

            $ergebnisse = $dataLine["ergebnisse"];
            $fachCodeString = $dataLine["fach"];

            foreach ($ergebnisse as $ergebnisKey => $ergebnis) {
                $pruefungsKey = NULL;
                if (strstr($ergebnisKey, "#") !== FALSE || str_starts_with($ergebnisKey, "X")) {
                    $pruefungsKey = $ergebnisKey;
                    $pruefungsKey = str_replace(".", "#", $pruefungsKey);
                    $pruefungsKey = ltrim($pruefungsKey, "X");
                }
                $wissensTypConst = NULL;
                if ($ergebnisKey == "Sk1") {
                    $wissensTypConst = FachCodeKonstanten::STATION_WISSENS_TYP_FAKTEN;
                } elseif ($ergebnisKey == "Sk2") {
                    $wissensTypConst = FachCodeKonstanten::STATION_WISSENS_TYP_ZUSAMMENHANG;
                }

                $pruefungsItemId =
                    ChariteStationenPruefungPersistenzService::getPruefungsItemId($pruefungsId, $fachCodeString,
                                                                                  $ergebnisKey);

                if ($fachCodeString) {
                    $this->pruefeClusterZuordnung(
                        ClusterCode::fromString($fachCodeString),
                        ClusterTitel::fromString(FachCodeKonstanten::STATION_VK_TITEL[$fachCodeString]),
                        $pruefungsItemId,
                        ClusterTyp::getStationsFachTyp()
                    );
                } elseif ($pruefungsKey) {
                    $this->pruefeClusterZuordnung(
                        ClusterCode::fromString($ergebnisKey),
                        ClusterTitel::fromString(FachCodeKonstanten::STATIONS_BEZEICHNUNGEN[$pruefungsKey]),
                        $pruefungsItemId,
                        ClusterTyp::getStationsModulTyp()
                    );
                }
                if ($wissensTypConst) {
                    $this->pruefeClusterZuordnung(
                        ClusterCode::fromString($wissensTypConst),
                        ClusterTitel::fromString(
                            FachCodeKonstanten::STATION_WISSENS_TYPEN[$wissensTypConst]
                        ),
                        $pruefungsItemId,
                        ClusterTyp::getStationsWissensTyp()
                    );
                }

            }

        }

    }

    private function pruefeClusterZuordnung(
        ClusterCode $clusterCode,
        ClusterTitel $clusterTitel,
        PruefungsItemId $pruefungsItemId,
        ClusterTyp $clusterTyp
    ): void {
        $cluster = $this->clusterRepository->byClusterTypUndCode($clusterTyp, $clusterCode);

        if (!$cluster) {
            $clusterId = $this->clusterHinzufuegen($clusterCode, $clusterTitel, $clusterTyp);
        } else {
            $clusterId = $cluster->getId();
        }
        $this->clusterZuordnungsService->setzeZuordnungenFuerClusterTypId(
            $pruefungsItemId,
            $clusterTyp,
            [$clusterId]
        );
    }

    private function clusterHinzufuegen(
        ClusterCode $clusterCode,
        ClusterTitel $clusterTitel,
        ClusterTyp $clusterTyp
    ): ClusterId {
        $clusterId = $this->clusterRepository->nextIdentity();
        $this->clusterRepository->add(
            Cluster::create(
                $clusterId,
                $clusterTyp,
                $clusterTitel,
                NULL,
                $clusterCode
            )
        );
        $this->clusterRepository->flush();
        echo "C";

        return $clusterId;
    }

}