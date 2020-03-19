<?php

namespace App\Exports;
use DB;
use App\Gbpersona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GbdacSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    

    public function map($gbdac) : array { //Datos a exportar
        return [
            $gbdac->id_persona,
            $gbdac->nrodoc,
            $gbdac->fecha_exp,
            '||',
            $gbdac->fecha_reg,
            '20',
            '20',
            $gbdac->usuario_reg,
            $gbdac->hora_reg,
            '||',
            '||'
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'gbdoccage', //codigo agenda
            'gbdocndid', //numero de identidad
            'gbdocfvid', // fecha vencimiento CI
            'gbdocnruc',
            'gbdocfreg',  //fecha de registro
            'gbdocplaz', //Plaza = 20
            'gbdocagen', //Agencia
            'gbdocuser',
            'gbdochora',
            'gbdocfpro',
            'gbdocfemi',
        ];
    }
    public function collection()
    {
        $gbdac = Gbpersona::Select(DB::raw("id_persona, nombre1+' '+ nombre2 ,appaterno,apmaterno,email::timestamp::date,usuario_reg,fecha_reg::timestamp::time as hora_reg"))->orderByRaw('id_persona::numeric asc')->get();
        return $gbdac;
    }

    public function title(): string
    {
        return 'Gbdac';
    }
}
