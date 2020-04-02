<?php

namespace App\Exports\Prestamo;

use App\Prestamo;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;


class PrtsaSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $prtsa = Prestamo::Select(DB::raw("id_prestamo,to_char(fecha_registro_prestamo::timestamp::date,'DD/MM/YYYY') as fecha_registro_prestamo,tasa_base,usuario_reg,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,fecha_reg::timestamp::time as hora_reg"))
                        ->whereRaw("par_estado = 'A'")->get();
        return $prtsa; //TASAS
    }

    public function title(): string
    {
        return 'prtsa';
    }

    public function map($prtsa) : array { //Mapeo de datos deudores
        return [
            $prtsa->id_prestamo,        //Numero de prestamo
            $prtsa->fecha_registro_prestamo, //Fecha de Vigencia de la Tasa
            $prtsa->tasa_base,               //Tasa base
            '0',                             //Spread
            $prtsa->usuario_reg,             //Usuario que realizo la transaccion
            $prtsa->hora_reg,                //Hora de la transaccion
            $prtsa->fecha_registro_prestamo, //Fecha de Proceso
            'N'                              //Marca de Bloqueo, Pasar en N
        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'prtsanpre', //Numero de Prestamo
            'prtsafvig', //Fecha de Vigencia de la Tasa
            'prtsatbas', //Tasa base
            'prtsasprd', //Spread
            'prtsauser', //Usuario que realizo la transaccion
            'prtsahora', //Hora de la transaccion
            'prtsafpro', //Fecha de Proceso
            'prtsamblq', //Marca de Bloqueo, Pasar en N
        ];
    }

}
