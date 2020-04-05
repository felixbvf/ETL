<?php

namespace App\Exports\Parametro;

use App\Producto;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductoSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $productos = Producto::Select(DB::raw("id_producto,descripcion,par_moneda,par_estado,monto_minimo,monto_maximo,plazo_minimo,plazo_maximo"))
                            ->orderByRaw('id_producto::numeric asc')->get();
        return $productos;
    }

    public function map($productos) : array { //Mapeo de Datos
        return [
            $productos->id_producto,
            $productos->descripcion,
            $productos->par_moneda,
            $productos->par_estado,
            $productos->monto_minimo,
            $productos->monto_maximo,
            $productos->plazo_minimo,
            $productos->plazo_maximo
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_producto',
            'descripcion',
            'par_moneda',
            'par_estado',
            'monto_minimo',
            'monto_maximo',
            'plazo_minimo',
            'plazo_maximo'
        ];
    }

    public function title(): string
    {
        return 'Productos';
    }

}
