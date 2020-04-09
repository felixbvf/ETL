<?php

namespace App\Exports\Prestamo;

use App\Prppg;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlanpagosExport implements WithMultipleSheets
{   use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        $i=1;
        $n=6;
        $total = Prppg::count();
        $cantdiv = $total/$n;
        $restante = $total -(floor($cantdiv*$n));
        $sheets[] = new PrppgSheet($i,$cantdiv,1);  // Plan de Pagos1
        $ini2 = floor($cantdiv) + $i;
        $fin2 = floor($cantdiv)*2;
        $sheets[] = new PrppgSheet($ini2,$fin2,2);  // Plan de Pagos2
        $ini3 = (floor($cantdiv)*2) + $i;
        $fin3 = floor($cantdiv)*3;
        $sheets[] = new PrppgSheet($ini3,$fin3,3);  // Plan de Pagos3
        $ini4 = (floor($cantdiv)*3) + $i;
        $fin4 = floor($cantdiv)*4;
        $sheets[] = new PrppgSheet($ini4,$fin4,4);  // Plan de Pagos4
        $ini5 = (floor($cantdiv)*4) + $i;
        $fin5 = floor($cantdiv)*5;
        $sheets[] = new PrppgSheet($ini5,$fin5,5);  // Plan de Pagos5
        $ini6 = (floor($cantdiv)*5) + $i;
        $fin6 = (floor($cantdiv)*6) + $restante;
        $sheets[] = new PrppgSheet($ini6,$fin6,6);  // Plan de Pagos6
        return $sheets;
    }
}
