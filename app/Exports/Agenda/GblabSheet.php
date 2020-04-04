<?php

namespace App\Exports\Agenda;

use App\Gbpersona;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GblabSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{

    public function collection()
    {
        $gblab = Gbpersona::Select(DB::raw("id_persona,par_fuerza,telofi,par_profesion,numero_papeleta,to_char(fecha_ingreso_trabajo,'DD/MM/YYYY') as fecha_ingreso_trabajo,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,usuario_reg,fecha_reg::timestamp::time as hora_reg"))->orderByRaw('id_persona::numeric asc')->get();
        return $gblab;
    }
    public function map($gblab) : array {  //MAPEO DE DATOS
        return [
            $gblab->id_persona,
            '',
            $gblab->par_fuerza,
            '',
            $gblab->telofi, //Telefono
            '',
            $gblab->par_profesion,
            '',
            $gblab->numero_papeleta,
            '',
            $gblab->fecha_ingreso_trabajo,
            $gblab->fecha_reg,
            '',
            '',
            '',
            $gblab->usuario_reg,
            $gblab->hora_reg,
            '',
            '',
            '',
            '',
            '',
            '',
            '', //Hora atención (8:00-12:00 14:30-18)
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '', //Hora atención (8:00-12:00 14:30-18)
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '', //Número de empleados temporales
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '', //Participación familiar
            '',
            '',
            '',
            '',
            '',
            ''
        ];
    
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
        'gblabcage', //Codigo de agenda
        'gblabitem',
        'gblabcemp', //Codigo empresa == par_fuerza
        'gblabnemp',
        'gblabtelf', //Telefono
        'gblabinte',
        'gblabtcar', //Tipo de cargo == par_profesion
        'gblabdcar',
        'gblabobsv', //Observaciones == nro_papeleta
        'gblabfcar',
        'gblabfing', //Fecha de ingreso == fecha_ingreso_trabajo
        'gblabfreg', //Fecha de registro == fecha_reg
        'gblabnsal', 
        'gblabmrcb',
        'gblabfmrc',
        'gblabuser', //Usuario  == usuario_reg
        'gblabhora', //Hora  == hora_reg
        'gblabfpro',
        'gblabcane',
        'gblabtneg',
        'gblabtten',
        'gblabidir',
        'gblabalun',
        'gblabhlun', //Hora atención (8:00-12:00 14:30-18)
        'gblabamar',
        'gblabhmar',
        'gblabamie',
        'gblabhmie',
        'gblabajue',
        'gblabhjue',
        'gblabavie',
        'gblabhvie', //Hora atención (8:00-12:00 14:30-18)
        'gblabasab',
        'gblabhsab',
        'gblabadom',
        'gblabhdom',
        'gblabcemh',
        'gblabcemm',
        'gblabcemr',
        'gblabcemt', //Número de empleados temporales
        'gblabecre',
        'gblabecrh',
        'gblabecrm',
        'gblabesos',
        'gblabesoh',
        'gblabesom',
        'gblabnimp',
        'gblabparf', //Participación familiar
        'gblabnsol',
        'gblabnpre',
        'gblabtani',
        'gblabtmes',
        'gblabpbol',
        'gblabfret'
        ];
    }

    public function title(): string //HOMBRE DE LA HOJA DE EXCEL
    {
        return 'gblab';
    }
}
