<?php

namespace App\Models;
namespace App\Models\ExportExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActionsDataExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(array $data=null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Link',
            'ParentId',
            'Weight',
            'Icon',
            'Type',
            'Description',
            'Type Item',

        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Fijar la fila 2 (la primera fila de datos) como encabezado
        $sheet->freezePane('A2');
        return [
            1    => ['font' => ['bold' => true]], // Estilo negrita para el encabezado
            2    => ['font' => ['size' => 14]],   // Estilo tamaño de fuente 14 para la segunda fila
            'A2:C2' => ['font' => ['italic' => true]], // Estilo cursiva para el rango de celdas A2 a C2
            'A1:C1' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'FFFF00']]], // Color de fondo amarillo para el rango A1:C1
        ];
    }
    public function generateExcel($dataCurrent)
    {

        $fileName = 'data-actions2.xlsx'; // Nombre del archivo
        $folderSet = 'downloads/excel/';
        $filePath = (($folderSet) . $fileName);
        $filePathAbsoluteResource = str_replace('/', '\\', $filePath);
        $folderStorageApp = app()->make('path.storage') . "\\app" . "\\";
        $filePathAbsoluteStorage = $folderStorageApp . $filePathAbsoluteResource;
        $generateExcel = Excel::store(new ActionsDataExport($dataCurrent), $filePath);
        if ($generateExcel) {
            $existData = file_exists($filePathAbsoluteStorage);
            if ($existData) {
                $resourceInit = $folderStorageApp . $filePath;
                $resourceMove = public_path("uploads/" . $filePath);
                $resourceFolderSet = public_path("uploads/".$folderSet);
                if (!file_exists($resourceFolderSet)) {
                    $createAllow=mkdir($resourceFolderSet, 0755, true);
                    if (!$createAllow) {
                    }
                }
                $moveResource = rename($resourceInit, $resourceMove);
                if ($moveResource) {
                    $url = asset("public/uploads/".$filePath);
                }

            }

        }
    }
}
