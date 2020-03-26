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
    
    public function collection()
    {
        $gbdac = Gbpersona::Select(DB::raw("id_persona, concat_ws(' ',nombre1, nombre2) as nombres,nombre1,nombre2,appaterno,apmaterno,apesposo,email"))->orderByRaw('id_persona::numeric asc')->get();
        return $gbdac;
    }
    public function map($gbdac) : array { //Datos a exportar
        return [
            $gbdac->id_persona,
            $gbdac->nombres,
            $gbdac->appaterno,
            $gbdac->apmaterno,
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Ref. Ubic. Domicilio
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Fecha de Ingreso al trabajo
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Fecha Cambio Estado
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Fecha de Evaluacion
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Fecha ultima actualizacion
            '||',
            '||',
            $gbdac->nombre1,
            $gbdac->nombre2,
            $gbdac->apesposo,
            '||',
            '||', //Codigo Nacionalidad (gbconpfij=95)
            '||',
            '||',
            '||',
            '||',
            '||', //Actividad (gbconpfij=48)
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Ambito Geografico (Pref=17)
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', // Nro de Familiares
            '||',
            '||',
            '||',
            '||',
            '||',
            '||',
            '||', //Sin Uso
            '||'          
           
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'GBDACCAGE', // Codigo de agenda
            'GBDACNOMB', // Nombre del cliente
            'GBDACAPE1', // Apellido apterno
            'GBDACAPE2', //Apellido materno
            'GBDACNOCO',
            'GBDACCOCL',
            'GBDACREFP',
            'GBDACMAIL',
            'GBDACCIUD',
            'GBDACUBID',
            'GBDACREFD', //Ref. Ubic. Domicilio
            'GBDACNEMP',
            'GBDACCCAR',
            'GBDACNINT',
            'GBDACCIUO',
            'GBDACUBIO',
            'GBDACREFO',
            'GBDACFING', //Fecha de Ingreso al trabajo
            'GBDACRSEG',
            'GBDACTRES',
            'GBDACNORI',
            'GBDACFCNA',
            'GBDACFLLE',
            'GBDACSTAT',
            'GBDACFSTA', //Fecha Cambio Estado
            'GBDACSANT',
            'GBDACFANT',
            'GBDACCNAC',
            'GBDACMENS',
            'GBDACTMEN',
            'GBDACNEVA',
            'GBDACFEVA', //Fecha de Evaluacion
            'GBDACCONY',
            'GBDACNIVE',
            'GBDACCAND',
            'GBDACCLFA',
            'GBDACFCAA',
            'GBDACFCAL',
            'GBDACFUAD', //Fecha ultima actualizacion
            'GBDACCELU',
            'GBDACCLAS',
            'GBDACNOM1', // Primer nombre
            'GBDACNOM2', // Segundo nombre
            'GBDACAPE3', // Apellido de esposo
            'GBDACTMTO',
            'GBDACCNCN', //Codigo Nacionalidad (gbconpfij=95)
            'GBDACCNCO',
            'GBDACPAIP',
            'GBDACRUBR',
            'GBDACSECT',
            'GBDACACTV', //Actividad (gbconpfij=48)
            'GBDACCLSC',
            'GBDACTIPO',
            'GBDACPWEB',
            'GBDACOBSV',
            'GBDACREPR',
            'GBDACCICL',
            'GBDACAMBG', //Ambito Geografico (Pref=17)
            'GBDACIDIP',
            'GBDACIDIS',
            'GBDACCIUN',
            'GBDACPESO',
            'GBDACESTT',
            'GBDACFMAT',
            'GBDACNFAM', // Nro de Familiares
            'GBDACCALP',
            'GBDACLACT',
            'GBDACFIAC',
            'GBDACTAAC',
            'GBDACTMAC',
            'GBDACTDAC',
            'GBDACIDAC', //Sin Uso
            'GBDACDISC',
        ];
    }


    public function title(): string
    {
        return 'Gbdac';
    }
}
