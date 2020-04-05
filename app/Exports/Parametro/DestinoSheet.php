<?php

namespace App\Exports\Parametro;

use App\Parametro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DestinoSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $destinos = Parametro::Select(DB::raw("id_param,item,detalle,par_estado"))
                            ->where('tipoparam','=','PAR_DESTINO')->orderByRaw('item asc')->get();
        return $destinos;
    }

    public function map($destinos) : array { //Mapeo de Datos
        return [
            $destinos->id_param,
            $destinos->item,
            $destinos->detalle,
            $destinos->par_estado
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
        return 'Detino-Prestamo';
    }

}
