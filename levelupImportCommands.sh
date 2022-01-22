#!/bin/bash
if [ -z "$BASE_LEVELUP_IMPORT_DIR" ]; then
  export BASE_LEVELUP_IMPORT_DIR=~/prfg/
fi;

cd `dirname $0`

echo "--- START ---"
date;

bin/console levelup:importFile:lernzielFaecher $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Fach.csv

### STUDIS ###

#bin/console levelup:importFile:studi $BASE_LEVELUP_IMPORT_DIR/StudisStammdaten.csv
#bin/console levelup:importFile:StudiMeilenstein $BASE_LEVELUP_IMPORT_DIR/StudisStammdaten.csv

### STATIONEN ###

# SoSe2016
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM\ nur\ Teil\ 1\ im\ SoSe\ 16HAUPT/ergebnisse_GrundlagenSose16HAUPT.xlsx.csv 201611 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM\ nur\ Teil\ 1\ im\ SoSe\ 16HAUPT/ergebnisse_clSose16HAUPT.xlsx.csv 201611 Teil1K -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM\ nur\ Teil\ 1\ im\ SoSe16WDH/Teil1_Grundlagen_SoSe16WDH.xlsx.csv 201612 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM\ nur\ Teil\ 1\ im\ SoSe16WDH/Teil1_OSCE2_SoSe16WDH\ FINAL.xlsx.csv 201612 Teil1K -vvv

# WiSe2016
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe16_17_HAUPT/Teil\ 1\ WiSe1617HAUPT/Teil\ 1\ Grundlagen\ WiSe1617\ Haupt\ FINAL.xlsx.csv 201621 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe16_17_HAUPT/Teil\ 1\ WiSe1617HAUPT/Teil\ 1\ OSCE2\ WiSe1617\ Haupt\ FINAL.xlsx.csv  201621 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe16_17_HAUPT/Teil\ 2\ WiSe1617HAUPT/Teil\ 2\ Grundlagen\ WiSe1617\ Haupt\ FINAL.xlsx.csv 201621 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe16_17_HAUPT/Teil\ 3\ WiSe1617HAUPT/Teil\ 3\ OSCE\ 4\ WiSe1617\ Haupt\ FINAL.xlsx.csv 201621 Teil3 -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe\ 16_17_WDH/Teil\ 1\ WiSe1617\ FINAL/Teil\ 1_Grundlagen_WiSe1617WDH\ FINAL.xlsx.csv 201622 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe\ 16_17_WDH/Teil\ 1\ WiSe1617\ FINAL/Teil\ 1_OSCE2_WiSe1617WDH\ FINAL.xlsx.csv 201622 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe\ 16_17_WDH/Teil\ 2\ WiSe1617\ FINAL/Teil\ 2_Grundlagen_WiSe1617WDH\ FNAL.xlsx.csv 201622 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe\ 16_17_WDH/Teil\ 3\ WiSe1617\ FINAL/Teil\ 3_OSCE4_WiSe1617WDH\ FINAL.xlsx.csv 201622 Teil3 -vvv

#SoSe2017
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_SoSe2017/Teil1/Vorklinik/VK_teil1SoSe17_Haupt_Final.xlsx.csv 201711 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_SoSe2017/Teil1/Klinik/KLINIK_Teil1SoSe17_Haupt_Final.xlsx.csv 201711 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_SoSe2017/Teil2/VK_teil2_SoSe17_Haupt_Final.xlsx.csv 201711 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_SoSe2017/Teil3/Teil3_SoSe17_Haupt_Final.xlsx.csv 201711 Teil3 -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2017_WDH/Teil\ 1\ FINAL\ SoSe\ 17\ WDH/ergebnisse_GrundlagenT1_WDHSoSe17_FINAL.xlsx.csv 201712 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2017_WDH/Teil\ 1\ FINAL\ SoSe\ 17\ WDH/ergebnisse_OSCE2_T1_WDHSoSe17_FINAL.xlsx.csv 201712 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2017_WDH/Teil\ 2\ FINAL\ SoSe\ 17\ WDH/ergebnisse_GrundlagenT2_WDHSoSe17_FINAL.xlsx.csv 201712 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2017_WDH/Teil\ 3\ FINAL\ SoSe\ 17\ WDH/ergebnisse_OSCE4_T3_WDH_FINAL.xlsx.csv  201712 Teil3 -vvv

# WiSe2017
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_WiSe17Haupt/StatPrüfuT1VORKLINIK/StatPrüfT1VORKLINK_FINAL_.xlsx.csv 201721 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_WiSe17Haupt/StatPrüfT1KLINIK/OSCE-TEIL\ 1\ KLINIK_.xlsx.csv 201721 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_WiSe17Haupt/StatPrüfT2\ VORKLINIK/VK\ StaPrüTeil\ 2.xlsx.csv 201721 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/Daten_StatPr_1_2_3_WiSe17Haupt/StatPrüfT3\ KLINIK/OSCE-StatPrüT3_Final_.xlsx.csv  201721 Teil3 -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe17_18WDH/Teil\ 1\ WiSe\ 17_18\ WDH\ FINAL/Teil1\ Grundlagen\ WiSe\ 1718\ WDH_FINAL.xlsx.csv 201722 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe17_18WDH/Teil\ 1\ WiSe\ 17_18\ WDH\ FINAL/Teil1\ OSCE2\ WiSe\ 1718\ WDH\ FINAL.xlsx.csv 201722 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe17_18WDH/Teil\ 2\ WiSe\ 17_18\ WDH\ FINAL/Teil2\ Grundlagen\ WiSe\ 1718\ WDH\ FINAL.xlsx.csv 201722 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe17_18WDH/Teil\ 3\ WiSe\ 17_18\ WDH\ FINAL/Teil3\ OSCE4\ WiSe\ 1718\ WDH\ FINAL.xlsx.csv 201722 Teil3 -vvv

# SoSe2018
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2018_HAUPT/Teil1\ VK/Teil1VK_SoSe2018HAUPT.xlsx.csv 201811 Teil1VK -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2018_HAUPT/Teil1\ KLINIK/Teil1KLINIkSoSe2018.xlsx.csv 201811 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2018_HAUPT/Teil2/Teil2SoSe2018HAUPT.xlsx.csv 201811 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2018_HAUPT/Teil3/Teil3SoSe2018HAUPT.xlsx.csv 201811 Teil3 -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSo2018_WDH/Teil1\ VORKLINIK/Teil1VK_SoSe2018WDH.csv 201812 Teil1VK ";" -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSo2018_WDH/Teil1\ KLINIK/Teil1_KLINIK\ SoSe2018WDH.xlsx.csv 201812 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSo2018_WDH/Teil2/Teil2_SoSe2018WDH.xlsx.csv 201812 Teil2 -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSo2018_WDH/Teil3/Teil3SoSe2018WDH.xlsx.csv 201812 Teil3 -vvv

# WiSe2018
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19HAUPT/Teil1\ VK/Teil1\ VK\ WiSe1819\ HAUPT.csv 201821 Teil1VK ";" -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19HAUPT/Teil1\ KLINIK/Teil1WiSe1819HAUPT_KLINIK.xlsx.csv 201821 Teil1K -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19HAUPT/Teil2/Teil2WiSe1819HAUPT.csv 201821 Teil2 ";" -vvv
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19HAUPT/Teil3/Teil3WiSe1819_HAUPT.xlsx.csv 201821 Teil3 -vvv
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19WDH/Teil\ 1\ Grundlagenfächer/Ergebnis_Teil1_GrundlaWiSe1819WDH_FINAL.xlsx.csv 201822 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19WDH/Teil\ 1\ OSCE/OSCE-Teil1\ WiSe1819WDH_FINAL.xlsx.csv 201822 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19WDH/Teil\ 2\ Grundlagenfächer/Ergebnis_Teil2_GrundlaWiSe1819WDH_FINAL.xlsx.csv 201822 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_WiSe18_19WDH/Teil\ 3\ OSCE/OSCE-Teil3\ WiSe1819WDH_FINAL.xlsx.csv 201822 Teil3

# SoSe2019
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2019_HAUPT/Teil\ 1\ Grundlagen/Teil\ 1\ Grundlagen\ SoSe2019\ HAUPT_FINAL.xlsx.csv 201911 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2019_HAUPT/Teil\ 1\ OSCE2/Teil\ 1\ OSCE2\ SoSe\ 2019\ HAUPT_FINAL.xlsx.csv 201911 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2019_HAUPT/Teil\ 2\ Grundlagen/Teil\ 2\ Grundlagen\ SoSe2019\ HAUPT_FINAL.xlsx.csv 201911 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe2019_HAUPT/Teil\ 3\ OSCE4/Teil\ 3\ OSCE4\ SoSe\ 2019\ HAUPT_FINAL.xlsx.csv 201911 Teil3

bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/OSCE9_MSM\ 2.0_SoSe19HZ/OSCE\ 9\ SoSe\ 2019\ HAUPT.xlsx.csv 201911 Sem9
  # WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe_19_WDH/Teil1_GrundlagenSoSe\ 19\ WDH\ FINAL.xlsx.csv 201912 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe_19_WDH/Teil\ 1_\ OSCE-2_SoSe\ WDH\ FINAL.xlsx.csv 201912 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe_19_WDH/Teil2_GrundlagenSoSe\ 19\ WDH\ FINAL.xlsx.csv 201912 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_SoSe_19_WDH/Teil\ 3_\ OSCE-4_SoSe\ WDH\ FINAL.xlsx.csv 201912 Teil3
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/OSCE9_MSM\ 2.0_SoSe19WDH/OSCE\ 9\ SoSe\ 2019\ WDH.xlsx.csv 201912 Sem9

# WiSe2019
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_OSCE_StaPrü\ WiSe\ 1920/Teil1_2.FS_Grundlagenf_LevelUp/Teil_1_Grundlagen_WiSe1920_QM.xlsx.csv 201921 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_OSCE_StaPrü\ WiSe\ 1920/OSCE2_LevelUp/OSCE2_WiSe1920_QM.xlsx.csv 201921 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_OSCE_StaPrü\ WiSe\ 1920/Teil2_4.FS_Grundlagenf_LevelUp/Teil_2_Grundlagen_WiSe1920_QM.xlsx.csv 201921 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_OSCE_StaPrü\ WiSe\ 1920/OSCE4_LevelUp/OSCE4_WiSe1920_QM.xlsx.csv 201921 Teil3
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/QM_OSCE_StaPrü\ WiSe\ 1920/OSCE9_LevelUp/OSCE\ 9\ für\ Level\ Up\ HZ.xlsx.csv 201921 Sem9

# SoSe2020
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_1.Termin/Teil_1_Grundlagen_SoSe2020T1_QM.csv 202011 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_1.Termin/Teil_2_Grundlagen_SoSe2020T1_QM.csv 202011 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_1.Termin/OSCE2_SoSe2020T1_QM.csv 202011 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_1.Termin/OSCE4_SoSe2020T1_QM.csv 202011 Teil3
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_1.Termin/OSCE9_SoSe2020T1_QM.csv 202011 Sem9

  #WDH
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_2.Termin/Teil_1_Grundlagen_SoSe2020T2_QM.csv 202012 Teil1VK
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_2.Termin/Teil_2_Grundlagen_SoSe2020T2_QM.csv 202012 Teil2
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_2.Termin/OSCE2_SoSe2020T2_QM.csv 202012 Teil1K
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_2.Termin/OSCE4_SoSe2020T2_QM.csv 202012 Teil3
bin/console levelup:importFile:stationen $BASE_LEVELUP_IMPORT_DIR/Stationenprüfung\ und\ OSCE\ 9\ FS/SoSe_2020_2.Termin/OSCE9_SoSe2020T2_QM.csv 202012 Sem9


# WiSe2020
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 HZ/grundlagen staprü  t1/Teil_1_Grundlagen_wise2021T1_QM.csv" 202021 Teil1VK
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 HZ/grundlagen staprü  t2/Teil_2_Grundlagen_wise2021T1_QM.csv" 202021 Teil2
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 HZ/osce2 staprü t1/OSCE2_WiSe2021T1_QM.csv" 202021 Teil1K
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 HZ/osce4 staprü t3/OSCE4_wise2021T1_QM.csv" 202021 Teil3
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 HZ/osce 9 msm2/OSCE9_wise2021_T1_QM.csv" 202021 Sem9

# WDH
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 WDH/grundlagen staprü  t1/Teil_1_Grundlagen_wise2021T2_QM.csv" 202022 Teil1VK
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 WDH/grundlagen staprü  t2/Teil_2_Grundlagen_wise2021T2_QM.csv" 202022 Teil2
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 WDH/osce2 staprü t1/OSCE2_WiSe2021T2_QM.csv" 202022 Teil1K
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 WDH/osce4 staprü t3/OSCE4_wise2021T2_QM.csv" 202022 Teil3
bin/console levelup:importFile:stationen "$BASE_LEVELUP_IMPORT_DIR/Stationenprüfung und OSCE 9 FS/WiSe20_21 WDH/osce 9 msm2/OSCE9_wise2021_T2_QM.csv" 202022 Sem9

### PTM ###

bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT33\ 2015-11-17.csv 20152 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT34\ 2016-05-26.csv 20161 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT35\ 2016-11-24.csv 20162 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT36\ 2017-06-07.csv 20171 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT37\ 2017-11-29.csv 20172 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT38\(gesamt\).csv 20181 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT39_ws_1819.csv 20182 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT40\ 2019-06-03.csv 20191 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT40\ 2019-08-16.csv 20191 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT41\ 2020-03-02.csv 20192 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/PT42_Berlin.csv 20201 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/PT43_Berlin.csv 20202 -vvv
bin/console levelup:importFile:ptm $BASE_LEVELUP_IMPORT_DIR/PTM/Einzeldaten\ Berlin\ PT44\ 2021.csv 20211 -vvv

### MC ###

### MC-Fragentexte ###

bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe21_Fragentexte_T1.csv 202111 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe21_Fragentexte_T2.csv 202112 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe2021_T1_Fragentexte.xlsx.csv 202021 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe20_21_T2_Fragentexte.xlsx.csv 202022 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2020_T1*.csv 202011 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2020_T2*.csv 202012 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe19_20_T1*.csv 201921 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe19_20_T2*.csv 201922 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2019_1*.csv 201911 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2019_2*.csv 201912 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe2018_19_1*.csv 201821 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe2018_19_2*.csv 201822 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2018_T1*.csv 201811 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2018_T2*.csv 201812 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe1718_T1*.csv 201721 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/WiSe1718_T2*.csv 201722 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2017_T1*.csv 201711 -vvv
bin/console levelup:importFile:mcFragenTexte $BASE_LEVELUP_IMPORT_DIR/MC/Fragentexte/SoSe2017_T2*.csv 201712 -vvv

### MC-Ergebnisse ###
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_21_T1_qs.csv 202111 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_21_T2_qs.csv 202112 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_20_21_T1_qs.xlsx.csv 202021 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_20_21_T2_qs.xlsx.csv 202022 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe20_T1_qs.xlsx.csv 202011 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe20_T2_qs.xlsx.csv 202012 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_19_20_T1_qs.csv 201921 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_19_20_T2_qs.csv 201922 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T2_qs.xlsx.csv  201912 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T1_qs-korrigiert.xlsx.csv 201911 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_Wise18_19_T1_qs.xlsx.csv 201821 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe1819_T2_qs.xlsx.csv 201822 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe18_T1_qs.xlsx.csv 201811 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe18_T2_qs.xlsx.csv 201812 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe17_18_T1_qs.xlsx.csv 201721 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_Wise17_18_T2_qs.xlsx.csv 201722 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe17_T1_qs.xlsx.csv 201711 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe17_T2_qs.xlsx.csv 201712 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe16_17_T1_qs.xlsx.csv 201621 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe16_17_T2_qs.xlsx.csv 201622 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe16_T1_qs.xlsx.csv 201611 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe16_T2_qs.xlsx.csv 201612 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe15_16_T1_qs.xlsx.csv 201521 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe15_16_T2_qs.xlsx.csv 201522 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe15_T1_qs.xlsx.csv 201511 -vvv
bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe15_T2_qs.xlsx.csv 201512 -vvv

### MC-Lernziele ###
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_21_T1_qs.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202111 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_21_T2_qs.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202112 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_20_21_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202021 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_20_21_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202022 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe20_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202011 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe20_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 202012 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_19_20_T1_qs.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201921 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe_19_20_T2_qs.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201922 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201912 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201911 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_Wise18_19_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201821 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe1819_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201822 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe18_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201811 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe18_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201812 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe17_18_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201721 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_Wise17_18_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201722 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe17_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201711 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe17_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201712 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe16_17_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201621 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe16_17_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201622 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe16_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201611 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe16_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201612 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe15_16_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201521 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_WiSe15_16_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201522 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe15_T1_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201511 -vvv
bin/console levelup:importFile:mcCSVFachUndModule $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe15_T2_qs.xlsx.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv 201512 -vvv

date;
echo "--- ENDE ---"
