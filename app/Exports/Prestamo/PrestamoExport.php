<?php

namespace App\Exports\Prestamo;

use App\Prestamo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PrestamoExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        $sheets = [];
        //$sheets[] = new PrmprSheet();  //Maestro Prestamos
        //sheets[] = new PrcgcSheet();  //Cargos-Seguros
        //$sheets[] = new PrdeuSheet();  //Deudores
        //$sheets[] = new PrppgSheet();  // Plan de Pagos
        $sheets[] = new PrtsaSheet();  // Tasas
        return $sheets;
    }
   
}
