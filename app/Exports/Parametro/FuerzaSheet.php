<?php

namespace App\Exports\Parametro;

use App\Parametro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class FuerzaSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $fuerzas = Parametro::Select(DB::raw("id_param,item,detalle,par_estado,cuenta"))->where('tipoparam','=','PAR_FUERZA')->orderByRaw('item asc')->get();
        return $fuerzas;
    }

    public function map($fuerzas) : array { //Mapeo de Datos
        return [
            $fuerzas->id_param,
            $fuerzas->item,
            $fuerzas->detalle,
            $fuerzas->par_estado,
            $fuerzas->cuenta
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_param',
            'item',
            'detalle',
            'par_estado',
            'cuenta'
        ];
    }

    public function title(): string
    {
        return 'Fuerza';
    }

}
