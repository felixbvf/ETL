<?php

namespace App\Exports\Prestamo;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GarantiasExport implements WithMultipleSheets
{   use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        $sheets = [];
        $sheets[] = new GagarSheet();  //Maestro Garantias
        $sheets[] = new GagopSheet();  //Garantia Operacion
        return $sheets;
    }
}
