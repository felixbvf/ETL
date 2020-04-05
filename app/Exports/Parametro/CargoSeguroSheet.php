<?php

namespace App\Exports\Parametro;

use App\TipoCargoSeguro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CargoSeguroSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $cargosSeguros = TipoCargoSeguro::Select(DB::raw("id_producto,id_cargo_adicional,descripcion,monto,porcentaje,par_moneda,cuenta,par_estado"))->orderByRaw('id_producto asc')->get();
        return $cargosSeguros;
    }

    public function map($cargosSeguros) : array { //Mapeo de Datos
        return [
            $cargosSeguros->id_producto,
            $cargosSeguros->id_cargo_adicional,
            $cargosSeguros->descripcion,
            $cargosSeguros->monto,
            $cargosSeguros->porcentaje,
            $cargosSeguros->par_moneda,
            $cargosSeguros->cuenta,
            $cargosSeguros->par_estado
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'id_producto',
            'id_cargo_adicional',
            'descripcion',
            'monto',
            'porcentaje',
            'par_moneda',
            'cuenta',
            'par_estado'
        ];
    }

    public function title(): string
    {
        return 'Cargos Seguros';
    }

}
