<?php

namespace App\Exports;

use App\Gbpersona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PersonasExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'GBAGECAGE',
            'GBAGENOMB',
            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:R1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function collection()
    {
        return Gbpersona::all();
    }

}
