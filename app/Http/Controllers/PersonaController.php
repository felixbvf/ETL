<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\Agenda\PersonasExport;
use App\Exports\Parametro\ParametroExport;
use Maatwebsite\Excel\Facades\Excel;
class PersonaController extends Controller
{
    public function ExportPersona()
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        return Excel::download(new PersonasExport,'Agenda.xlsx');

      
    }

    public function ExportParametro()
    {
        return Excel::download(new ParametroExport,'Parametros.xlsx');
    }


}
