<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\FromCollection;

class ColocacionExport implements FromView, withEvents
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $headerArray = [
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => [
                            'argb' => 'FFFFFFFF'
                        ]
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'color' => [
                            'argb' => '337286',
                        ],
                    ],
                ];
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->getStyle('A1:N1')->applyFromArray($headerArray);// Color magenta de titulo y letras blancas
                $sizeOfQueryData = sizeof($this->data) + 1;
                $startToFinishBorders = 'A1' . ':' . 'N' . $sizeOfQueryData;
                $totalColor = 'A' . $sizeOfQueryData . ':' . 'N' . $sizeOfQueryData;
                $event->sheet->getStyle($startToFinishBorders)->applyFromArray($styleArray); // Poner bordes a la tabla
                $event->sheet->getStyle($startToFinishBorders)->getAlignment()->setWrapText(true); // Adjuntar texto
                $event->sheet->getColumnDimension('A')->setWidth(25);//Tamaño de la columna Nombre cliente
                $event->sheet->getColumnDimension('B')->setWidth(55);//Tamaño de la columna Nombre cliente
                $event->sheet->getColumnDimension('C')->setWidth(55);//Tamaño de la columna Nombre cliente
                $event->sheet->getColumnDimension('D')->setWidth(20);//Tamaño de la columna Fecha desembolso
                $event->sheet->getColumnDimension('E')->setWidth(20);//Tamaño de la columna Fecha desembolso
                $event->sheet->getColumnDimension('F')->setWidth(20);//Tamaño de la columna Fecha desembolso
                $event->sheet->getColumnDimension('G')->setWidth(20);//Tamaño de la columna Fecha desembolso
                $event->sheet->getColumnDimension('H')->setWidth(20);//Tamaño de la columna de TotalCapital
                $event->sheet->getColumnDimension('I')->setWidth(20);//Tamaño de la columna del Total interes
                $event->sheet->getColumnDimension('J')->setWidth(20);//Tamaño de la columna del Total interes
                $event->sheet->getColumnDimension('K')->setWidth(20);//Tamaño de la columna del Total interes
                $event->sheet->getColumnDimension('L')->setWidth(15);//Tamaño de la columna del Total interes
                $event->sheet->getColumnDimension('M')->setWidth(15);//Tamaño de la columna del Total interes
                $event->sheet->getColumnDimension('N')->setWidth(15);//Tamaño de la columna del Total interes
                $event->sheet->setAutoFilter($event->sheet->calculateWorksheetDimension()); // Aplicar filtros
            },
        ];
    }

    public function view(): View
    {
        return view('analisis.colocacionexport', [
            'data' => $this->data
        ]);
    }
}
