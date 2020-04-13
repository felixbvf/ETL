<?php

namespace App\Exports\Agenda;
use DB;
use App\Gbpersona;
use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
class GbdocSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    
    public function map($gbdoc) : array { //Datos a exportar
        return [
            $gbdoc->id_persona,
            $gbdoc->nrodoc,
            $gbdoc->fecha_exp,
            '',
            '',
            $gbdoc->fecha_reg,
            '20',
            '20',
            $gbdoc->usuario_reg,
            $gbdoc->hora_reg,
            '',
            ''
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'gbdoccage', //codigo agenda
            'gbdocndid', //numero de identidad
            'gbdocfvid', // fecha vencimiento CI
            'gbdocnruc', //Numero de RUC
            'gbdocfvru', //Fecha de Vencimiento de RUC
            'gbdocfreg', //fecha de registro
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
        $gbdoc = Gbpersona::Select(DB::raw("id_persona, replace(nrodoc,'-','') || par_lugarexp as nrodoc,to_char(fecha_exp,'DD/MM/YYYY') as fecha_exp,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,usuario_reg,fecha_reg::timestamp::time as hora_reg"))->orderByRaw('id_persona::numeric asc')->get();
        return $gbdoc;
    }

    public function title(): string
    {
        return 'gbdoc';
    }

}
