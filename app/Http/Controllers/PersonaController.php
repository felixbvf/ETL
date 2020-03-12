<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PersonasExport;
use Maatwebsite\Excel\Facades\Excel;
class PersonaController extends Controller
{
    public function ExportPersona()
    {   ini_set('memory_limit','2048M');
        return Excel::download(new PersonasExport,'Agenda.xlsx');
    }
}
