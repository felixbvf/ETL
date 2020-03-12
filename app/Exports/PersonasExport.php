<?php

namespace App\Exports;

use App\Gbpersona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonasExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'GBAGECAGE',
            'GBAGENOMB',
            
        ];
    }
    public function collection()
    {
        return Gbpersona::all();
    }
}
