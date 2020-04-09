<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Prestamo\PrestamoExport;
use App\Exports\Prestamo\PlanpagosExport;
use App\Exports\Prestamo\GarantiasExport;

class PrestamoController extends Controller
{
    public function ExportPrestamo()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        return Excel::download(new PrestamoExport(),'Prestamos.xlsx'); 
        //return (new PrestamoExport(7,13))->download('Prestamos.xlsx');  
    }

    public function ExportPlanpagos()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        return Excel::download(new PlanpagosExport(),'Plandepagos.xlsx'); 
        //return (new PrestamoExport(7,13))->download('Prestamos.xlsx');  
    }

    public function ExportGarantias()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        return Excel::download(new GarantiasExport(),'Garantias.xlsx');   
    }

}
