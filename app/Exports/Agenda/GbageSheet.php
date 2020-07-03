<?php

namespace App\Exports\Agenda;

use App\Gbpersona;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class GbageSheet extends DefaultValueBinder implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle,WithCustomValueBinder
{   
    public function map($personas) : array { //COLUMNAS A EXPORTAR
        
        return [
            $personas->id,
            $personas->nombrecompleto,
            $personas->par_tipodoc,
            $personas->nrodoc,
            '',
            $personas->par_tipoper,
            $personas->fecha_nac,
            $personas->par_sexo,
            $personas->par_estadocivil,
            $personas->nacionalidad,
            76,
            $personas->calleavdom1,
            $personas->calleavdom2,
            $personas->calleavdom3,
            '',
            $personas->teldom,
            $personas->celular,
            '',
            '',
            '',
            75220,
            '',
            '',
            '', //Calificacion cliente
            $personas->fecha_inscripcion, //Fecha registro
            20,
            20,
            $personas->usuario_reg,
            $personas->hora_reg,
            $personas->fecha_reg,
            1,
            1, //Estado del cliente
            '',
            '',
            '',
            '',
            '', //usuario que modifico
            '',
            '',
            0,
            $personas->extci,
            $personas->destino,
            $personas->par_profesion,
            /*$personas->referencia_bancaria,
            $personas->numero_cta_bancaria,
            $personas->referencia_bancaria2,
            $personas->numero_cta_bancaria2,
            $personas->referencia_bancaria3,
            $personas->numero_cta_bancaria3*/
        ] ;
 
 
    }
    public function headings(): array  //ENCABEZADO DE EXCEL
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
            'GBAGEFREG',//Fecha registro
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
            'GBAGECOMP', //Complemento de CI(extension)
            'destino',
            'cargos',
            /*'referencia_bancaria',
            'numero_cta_bancaria',
            'referencia_bancaria2',
            'numero_cta_bancaria2',
            'referencia_bancaria3',
            'numero_cta_bancaria3'*/
        ];
    }

 

    public function collection()
    {
        // CONSULTA DE PERSONAS
        /*$personas = Gbpersona::Select(DB::raw("id_persona::numeric as id, nombrecompleto,
            CASE
            WHEN par_tipodoc = 'LMI' THEN 11
            WHEN par_tipodoc= 'CI' THEN 1
            ELSE 1
            end as par_tipodoc, replace(nrodoc,'-','') || par_lugarexp as nrodoc,
            case 
            when par_tipoper = 'NA' then 1
            else 2 
            end as par_tipoper,to_char(fecha_nac,'DD/MM/YYYY') as fecha_nac,
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
            to_char(fecha_inscripcion,'DD/MM/YYYY') as fecha_inscripcion,
            usuario_reg,
            fecha_reg::timestamp::time as hora_reg,
            to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,
            SPLIT_PART(nrodoc, '-', 2) as extci,destino,par_profesion"))
        ->whereRaw("exists(select id_persona from finanzas.ptm_prestamos where par_estado ='A' and par_estado_prestamo ='DESEM' and id_persona = global.gbpersona.id_persona)
        or exists (select id_persona from finanzas.aps_aportes where  id_persona = global.gbpersona.id_persona 
        and par_estado ='A' and (id_estado = 'VIGENTE' or id_estado = 'COMISION' or id_estado ='LICENCIA' or id_estado = 'RETENCION'))")
        ->orderByRaw('id_persona::numeric asc')->get();
    */
    //PREPARAR ARRAY DE OBJETOS PERSONAL
    
    $personas[] = importFuncionario();
    $personas = array_flatten($personas);
    return collect($personas);
    }

    public function title(): string
    {
        return 'gbage';
    }

    public function bindValue(Cell $cell, $value)
    {   
        
            if (is_string($value)) {
                $cell->setValueExplicit($value, DataType::TYPE_STRING);
    
                return true;
            }
            // else return default behavior
            return parent::bindValue($cell, $value);  
    }

}
