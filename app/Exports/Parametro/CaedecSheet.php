<?php

namespace App\Exports\Parametro;

use App\Caedec;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CaedecSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $caedec = Caedec::Select(DB::raw("id_caedec,descripcion,bandera,item,par_categoria_caedec,par_division_caedec,par_grupo_caedec,par_clase_caedec,par_estado"))
                        ->orderByRaw('par_categoria_caedec asc')->get();
        return $caedec;
    }

    public function map($caedec) : array { //Mapeo de Datos
        return [
            $caedec->id_caedec,
            $caedec->descripcion,
            $caedec->bandera,
            $caedec->item,
            $caedec->par_categoria_caedec,
            $caedec->par_division_caedec,
            $caedec->par_grupo_caedec,
            $caedec->par_clase_caedec,
            $caedec->par_estado
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_caedec',
            'descripcion',
            'bandera',
            'item',
            'par_categoria_caedec',
            'par_division_caedec',
            'par_grupo_caedec',
            'par_clase_caedec',
            'par_estado'
        ];
    }

    public function title(): string
    {
        return 'Caedec';
    }

}
