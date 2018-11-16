<?php

namespace App\DatenImport\Infrastructure\Persistence;

class CSVImportService
{

    public function getCSVDataAsArray($inputfile){

        $PTMdataAsArray=null;
        if (($handle = fopen($inputfile, "r")) !== FALSE) {
            $data = fgetcsv($handle, null, ";");
            $headers = array_flip($data);

            $zeilenindex = 0;
            while (($data = fgetcsv($handle, null, ";")) !== FALSE && isset($data)) {

                $PTMdataAsArray[$zeilenindex]['Matrikelnummer'] = $data[$headers[" matnr"]];
                $PTMdataAsArray[$zeilenindex]['SummeRichtig'] = $data[$headers[" all_r"]];
                $PTMdataAsArray[$zeilenindex]['SummeFalsch'] = $data[$headers[" all_f"]];
                $PTMdataAsArray[$zeilenindex]['SummeWeissNicht'] = $data[$headers[" all_w"]];

                //alle einzelnen 200 Antworten
                for($i = 1;  $i <=200; $i++){
                    $PTMdataAsArray[$zeilenindex]['AntwortenEinzeln'][" f_".$i] = $data[$headers[" f_".$i]];
                    if($i == 200){
                        $antwortenEndeIndex = $headers[" f_".$i]+1;
                    }
                }
                //alle Organsysteme
                for($j = $antwortenEndeIndex; $j < count($headers)-1; $j++){
                    $aktOrgansys = array_search($j, $headers);
                    $organsysteme[$aktOrgansys] = $data[$headers[$aktOrgansys]];
                }
                ksort($organsysteme);
                $PTMdataAsArray[$zeilenindex]['Organsysteme']=$organsysteme;

                $zeilenindex++;
            }
        }
        return $PTMdataAsArray;
    }



}