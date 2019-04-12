<?php

namespace Common\Infrastructure\Export\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelExportService
{

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function createExportFile(array $inputData, array $headers, ?string $filename = NULL):
    StreamedResponse {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //Titel und Header vorbereiten
        $sheet->setTitle(substr($filename, 0, 30));
        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col++, 1, $header);
        }
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setBold(TRUE);

        // Automatische Breite
        foreach (range("A", $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension((string) $columnID)->setAutoSize(TRUE);
        }


        //Tabelle füllen
        $row = 2;
        foreach ($inputData as $zeile) {
            $col = 1;
            if (!is_array($zeile)) {
                continue;
            }
            foreach ($zeile as $zeilenWert) {
                $sheet->setCellValueByColumnAndRow($col++, $row, $zeilenWert);
            }
            $row++;
        }

        // AutoFilter einschalten
        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        $sheet->calculateColumnWidths();

        // Export
        $writer = new Writer\Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function() use ($writer) {
                $writer->save('php://output');
            }
        );
        if ($filename) {
            $filename = str_replace(" ", "_", $filename);
        }
        $filenameMitEndung = 'Export-' . $filename . '.xlsx';
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', "attachment;filename= $filenameMitEndung");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}