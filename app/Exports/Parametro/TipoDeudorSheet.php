<?php

namespace App\Exports\Parametro;

use App\Parametro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TipoDeudorSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $deudores = Parametro::Select(DB::raw("id_param,item,detalle,par_estado"))->where('tipoparam','=','PAR_TIPO_RELACION')->orderByRaw('item asc')->get();
        return $deudores;
    }
    
    public function map($deudores) : array { //Mapeo de Datos
        return [
            $deudores->id_param,
            $deudores->item,
            $deudores->detalle,
            $deudores->par_estado
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_param',
            'item',
            'detalle',
            'par_estado'
        ];
    }

    public function title(): string
    {
        return 'Tipos Deudores';
    }
}
