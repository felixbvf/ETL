<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PersonasExport;
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


}
