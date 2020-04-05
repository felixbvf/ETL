<?php

namespace App\Exports\Prestamo;

use App\Prestamo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PrestamoExport implements WithMultipleSheets
{
    use Exportable;
    /*protected $num1;
    protected $num2;
    public function __construct(int $num1, int $num2)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }*/

    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        /*$sheets = [];
        $sheets[] = new PrmprSheet();  //Maestro Prestamos
        $sheets[] = new PrcgcSheet();  //Cargos-Seguros
        $sheets[] = new PrdeuSheet();  //Deudores
        $sheets[] = new PrtsaSheet();  // Tasas*/
        $sheets[] = new PrppgSheet();  // Plan de Pagos
        return $sheets;
    }
   
}
