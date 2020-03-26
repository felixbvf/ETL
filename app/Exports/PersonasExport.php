<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PersonasExport implements WithMultipleSheets
{  
    use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        $sheets = [];
        $sheets[] = new GbageSheet();  //Agenda
        $sheets[] = new GbdacSheet();  //Datos adicionales
        $sheets[] = new GbdocSheet(); 
        $sheets[] = new GblabSheet();
        return $sheets;
    }
   

}
