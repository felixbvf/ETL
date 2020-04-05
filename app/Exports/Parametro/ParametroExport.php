<?php

namespace App\Exports\Parametro;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ParametroExport implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        $sheets = [];
        $sheets[] = new FuerzaSheet();  //Fuerza
        $sheets[] = new CargoSheet();  //Cargos
        $sheets[] = new DestinoSheet();  //Destino-Prestamo
        $sheets[] = new ProductoSheet();  //Productos
        $sheets[] = new CaedecSheet();  //Productos
        $sheets[] = new CalificacionAsfiSheet();  //Categoria Calificacion ASFI
        $sheets[] = new TipoDeudorSheet();  //Tipos de Deudores
        $sheets[] = new CargoSeguroSheet();  //Tipos de Cargos y Seguros
        return $sheets;
    }
}
