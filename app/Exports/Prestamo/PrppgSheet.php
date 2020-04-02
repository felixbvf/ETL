<?php

namespace App\Exports\Prestamo;

use App\Prppg;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PrppgSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $prppg = Prppg::Select(DB::raw("id_prestamo,to_char(fecha_cuota::timestamp::date,'DD/MM/YYYY') as fecha_cuota,numero_cuota,importe_capital,importe_interes,importe_cargos,total_cuota"))->whereRaw("par_estado = 'A'")
                        ->offset(7000)->limit(70000)->get();
        return $prppg; //Plan de pagos
    }

    public function title(): string
    {
        return 'prppg';
    }

    public function map($prppg) : array { //Mapeo de datos plan de pagos
        return [
            $prppg->id_prestamo,        //Numero de prestamo
            $prppg->fecha_cuota,        //Fecha programada de pago
            $prppg->numero_cuota,       //Numero de pago
            $prppg->importe_capital,    //Importe programado de pago a Capital
            $prppg->importe_insteres,   //Importe programado de pago a Interes
            $prppg->importe_cargos,     //Importe programado de pago por Cargos Generales
            '0',                    //Importe programado de pago por Seguro
            '0',                    //Importe programado de pago por Otros Cargos
            '0',                    //Importe programado de pago por Cargos con forma de aplicacion 15 y/o 16
            $prppg->total_cuota,    //Importe Total Programado
            '0',                    //Importe programado de pago por Ahorro
            '0'                     //Marca Pagado (9: Pagado; 0: No pagado), si no se tiene pasa con 0
        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'prppgnpre', //Numero de Prestamo
            'prppgfech', //Fecha programada de pago
            'prppgnpag', //Numero de pago
            'prppgcapi', //Importe programado de pago a Capital
            'prppginte', //Importe programado de pago a Interes
            'prppggral', //Importe programado de pago por Cargos Generales
            'prppgsegu', //Importe programado de pago por Seguro
            'prppgotro', //Importe programado de pago por Otros Cargos
            'prppgcarg', //Importe programado de pago por Cargos con forma de aplicacion 15 y/o 16
            'prppgtota', //Importe Total Programado
            'prppgahor', //Importe programado de pago por Ahorro
            'prppgmpag'  //Marca Pagado (9: Pagado; 0: No pagado), si no se tiene pasa con 0
        ];
    }

}
