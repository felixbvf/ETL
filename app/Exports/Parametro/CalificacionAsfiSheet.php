<?php

namespace App\Exports\Parametro;

use App\Parametro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CalificacionAsfiSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $calificacionAsfi = Parametro::Select(DB::raw("id_param,item,detalle,descripcionparam,par_estado"))
                            ->where('tipoparam','=','PAR_TIPO_CREDITO_ASF')->orderByRaw('item asc')->get();
        return $calificacionAsfi;
    }

    public function map($calificacionAsfi) : array { //Mapeo de Datos
        return [
            $calificacionAsfi->id_param,
            $calificacionAsfi->item,
            $calificacionAsfi->detalle,
            $calificacionAsfi->descripcionparam,
            $calificacionAsfi->par_estado
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_param',
            'item',
            'detalle',
            'descripcionparam',
            'par_estado'
        ];
    }

    public function title(): string
    {
        return 'Categoria Calificacion ASFI';
    }

}
