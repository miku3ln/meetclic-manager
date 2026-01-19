<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MaritimeDeparturesExport implements FromArray, WithEvents, WithCustomStartCell
{
    public function __construct(private array $rows)
    {
    }

    /**
     * ✅ La data (filas) empieza aquí.
     * Dejamos 1–5 para el encabezado institucional
     * y 6–7 para el encabezado de tabla con merges.
     */
    public function startCell(): string
    {
        return 'A8';
    }

    /**
     * ✅ Filas numéricas (no asociativas) para que Excel las pinte bien.
     */
    public function array(): array
    {

        return array_map(function ($r) {

            $result= [
                (int)($r['codigo_embarcacion']),
                (string)($r['nombre_embarcacion'] ),
                (string)($r['dia'] ),
                (int)($r['cant_pasajeros'] ),
                ($r['national']==0?'0': $r['national']),
                (int)($r['local'] ),
                (string)($r['horario'] ),
            ];
            return $result;


        }, $this->rows);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // =========================
                // 1) Encabezado institucional
                // =========================
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A5:G5');

                $sheet->setCellValue('A1', 'ARMADA DEL ECUADOR');
                $sheet->setCellValue('A2', 'CAPITANÍA DE PUERTO DE ESMERALDAS');
                $sheet->setCellValue('A3', 'ESMERALDAS');
                $sheet->setCellValue('A5', 'MATRIZ DE ESTADÍSTICAS DE ZARPES EN SAN PABLO');

                $sheet->getStyle('A1:G5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:G3')->getFont()->setBold(true);
                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(13);

                // =========================
                // 2) Encabezado de tabla (2 filas: 6 y 7)
                // =========================
                // Textos principales (van en fila 6 porque A6 es la celda top-left del merge A6:A7)
                $sheet->setCellValue('A6', 'CODIGO');
                $sheet->setCellValue('B6', 'NOMBRE DE EMBARCACIÓN');
                $sheet->setCellValue('C6', 'DÍA');
                $sheet->setCellValue('D6', 'CANT. PASAJEROS');
                $sheet->setCellValue('G6', 'HORARIO');

                // Grupo Nacionalidad (fila 6)
                $sheet->mergeCells('E6:F6');
                $sheet->setCellValue('E6', 'NACIONALIDAD DE PASAJEROS');

                // Subheaders (fila 7)
                $sheet->setCellValue('E7', 'NATIONAL');
                $sheet->setCellValue('F7', 'LOCAL');

                // Merges verticales (columnas que NO tienen subheader)
                $sheet->mergeCells('A6:A7');
                $sheet->mergeCells('B6:B7');
                $sheet->mergeCells('C6:C7');
                $sheet->mergeCells('D6:D7');
                $sheet->mergeCells('G6:G7');

                // Estilos encabezado tabla
                $sheet->getStyle('A6:G7')->getFont()->setBold(true);
                $sheet->getStyle('A6:G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A6:G7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(6)->setRowHeight(18);
                $sheet->getRowDimension(7)->setRowHeight(18);

                // Fondo (opcional) del header de tabla
                $sheet->getStyle('A6:G7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFEFEFEF');

                // =========================
                // 3) Anchos de columnas
                // =========================
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setWidth(22);
                $sheet->getColumnDimension('D')->setWidth(16);
                $sheet->getColumnDimension('E')->setWidth(12);
                $sheet->getColumnDimension('F')->setWidth(12);
                $sheet->getColumnDimension('G')->setWidth(12);

                // =========================
                // 4) Bordes tipo tabla (desde A6 hasta G última fila)
                // =========================
                $dataCount = count($this->rows);
                $lastRow = 8 + max($dataCount, 1) - 1; // data empieza en fila 8

                $range = "A6:G{$lastRow}";

                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Opcional: alineación data
                $sheet->getStyle("A8:G{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A8:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // código
                $sheet->getStyle("D8:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // nums
                $sheet->getStyle("G8:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // hora
            }
        ];
    }
}


