<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Aporte\AportesExport;
class AporteController extends Controller
{
    public function ExportAporte()
    {  
        return Excel::download(new AportesExport,'Aportes.xlsx');     
    }
}
