<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PersonasExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new GbageSheet();
      //  $sheets[] = new GbdacSheet(); 
        $sheets[] = new GbdocSheet(); 
        return $sheets;
    }
   

}
