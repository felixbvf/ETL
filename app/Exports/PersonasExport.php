<?php

namespace App\Exports;

use App\Gbpersona;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class PersonasExport implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping
{

    public function map($personas) : array {
        return [
            $personas->id_persona,
            $personas->nombrecompleto,
            $personas->par_tipodoc,
            $personas->nrodoc,
            '||',
            $personas->par_tipoper,
            $personas->fecha_nac,
            $personas->par_sexo,
            $personas->par_estadocivil,
            $personas->nacionalidad,
            '76',
            $personas->calleavdom1,
            $personas->calleavdom2,
            $personas->calleavdom3,
            '||',
            $personas->teldom,
            $personas->celular,
            '||',
            '||',
            '||',
            '75220',
            '||',
            '||',
            '||', //Calificacion cliente
            $personas->fecha_inscripcion,
            '20',
            '20',
            $personas->usuario_reg,
            $personas->hora_reg,
            $personas->fecha_reg,
            '1',
            '1', //Estado del cliente
            '||',
            '||',
            '||',
            '||',
            '||', //usuario que modifico
            '||',
            '||',
            '0',
            $personas->extci
        
        ] ;
 
 
    }
    public function headings(): array
    {
        return [
            'GBAGECAGE',
            'GBAGENOMB',
            'GBAGETDID',
            'GBAGENDID',
            'GBAGENRUC',
            'GBAGETPER',
            'GBAGEFNAC',
            'GBAGESEXO',
            'GBAGEECIV',
            'GBAGENACI',
            'GBAGEPROF',
            'GBAGEDIR1',
            'GBAGEDIR2',
            'GBAGEDDO1',
            'GBAGEDDO2',
            'GBAGETLFD',
            'GBAGETLFO',
            'GBAGENCAS',
            'GBAGENFAX',
            'GBAGETLEX',
            'GBAGECIIU',
            'GBAGEACT1',
            'GBAGEACT2',
            'GBAGECALF',//Calificacion cliente
            'GBAGEFREG',
            'GBAGEPLAZ',
            'GBAGEAGEN',
            'GBAGEUSER',
            'GBAGEHORA',
            'GBAGEFPRO',
            'GBAGECLAS',
            'GBAGESTAT', //Estado del cliente
            'GBAGEFSTA',
            'GBAGESTAA',
            'GBAGEFSAA',
            'GBAGEUMRC',
            'GBAGEUMOD', //usuario que modifico
            'GBAGEFMOD',
            'GBAGEFMRC',
            'GBAGEMRCB', //Marca baja (0-->Activo, 9-->Dado de baja)
            'GBAGECOMP' //Complemento de CI(extension)
            
        ];
    }

    public function collection()
    {
        // CONSULTA DE PERSONAS
        $personas = Gbpersona::Select(DB::raw("id_persona, nombrecompleto,
        CASE
        WHEN par_tipodoc = 'LMI' THEN 11
        WHEN par_tipodoc= 'CI' THEN 1
        ELSE 1
        end as par_tipodoc, nrodoc,
        case 
        when par_tipoper = 'NA' then 1
        else 2 
        end as par_tipoper,fecha_nac,
        case 
        when par_sexo ='M' then 1
        else 2 end as par_sexo,
        case 
        when par_estadocivil='SO' then 1
        when par_estadocivil='CA' then 2
        when par_estadocivil= 'VI' then 3
        when par_estadocivil='DI' then 4
        else 5 end as par_estadocivil,
        case 
        when nacionalidad ='ARGENTINO' then 'ARGENTINO'
        else 'BOLIVIANO' end as nacionalidad ,
        substring(calleavdom,1,30 ) as calleavdom1,
        substring(calleavdom,31,30 ) as calleavdom2,
        substring(calleavdom,61,30 ) as calleavdom3,
        teldom,
        celular,
        fecha_inscripcion,
        usuario_reg,
        fecha_reg::timestamp::time as hora_reg,
        fecha_reg::timestamp::date,
        SPLIT_PART(nrodoc, '-', 2) as extci"))->orderByRaw('id_persona::numeric asc')->get();
    return $personas;
    }

   

}
