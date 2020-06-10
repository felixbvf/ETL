<?php

namespace App\Exports\Aporte;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AportesExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');

        $sheets = [];
        $sheets[] = new CamcaSheet();  //Data Aportes
       
        return $sheets;
    }
}
