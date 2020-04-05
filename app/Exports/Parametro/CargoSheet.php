<?php

namespace App\Exports\Parametro;

use App\Parametro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CargoSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $cargos = Parametro::Select(DB::raw("id_param,detalle,par_estado"))
                            ->where('tipoparam','=','PAR_PROFESION')->get();
        return $cargos;
    }

    public function map($cargos) : array { //Mapeo de Datos
        return [
            $cargos->id_param,
            $cargos->detalle,
            $cargos->par_estado
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_param',
            'detalle',
            'par_estado'
        ];
    }

    public function title(): string
    {
        return 'Cargos';
    }

}
