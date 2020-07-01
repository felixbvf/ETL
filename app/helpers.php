<?php
use App\Gbpersona;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FuniconarioImport;

    function CountClient()
	{	 
        $total = Gbpersona::Select(DB::raw("id_persona::numeric as id, nombrecompleto,
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
    ->orderByRaw('id_persona::numeric asc')->count();;

        /*
        $lista = [
            ['id' => 1, 'title' => 'tree'],
            ['id' => 2, 'title' => 'sun'],
            ['id' => 3, 'title' => 'cloud'],
        ];
        */
        return $total;
    }

    
    function importFuncionario()
    {
        $afi = Gbpersona::Select(DB::raw("id_persona::numeric as id, nombrecompleto,
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
    ->orderByRaw('id_persona::numeric asc')->first();;

        $rows = Excel::toCollection(new FuniconarioImport, storage_path('AGENDA.xlsx'));
        $i = 1;
        foreach ($rows as $item) {
            $cont = CountClient() + $i;
           // id	nombrecompleto	par_tipodoc	nrodoc	par_tipoper	fecha_nac	par_sexo	par_estadocivil	nacionalidad	calleavdom1	calleavdom2	calleavdom3	teldom	celular	fecha_inscripcion	usuario_reg	hora_reg	fecha_reg	extci	destino	par_profesion
            if($item->estado_civil ='CA')
            {
                $ec = 2;
            }
            else if($item->estado_civil ='SO')
            {
                $ec = 1;
            }
            else{
                $ec = 3;
            }
            //return $rows;
            return $item->domicilio;
            $calleavdom1 = substr($item->direccion,0,30 );
            $calleavdom2 = substr($item->direccion,31,30 );
            //$calleavdom3 = substr($item->direccion,61,30 );
            array_push($afi, array("id" => $cont,"nombrecompleto" => $item->nombrecompleto,"par_tipodoc" => 1,"nrodoc" => $item->ci,"par_tipoper" => 1,"fecha_nac" => $item->fecha_nac,"par_sexo" => $item->sexo,"par_estadocivil" => $ec,"nacionalidad" => "BOLIVIANO","calleavdom1" => $calleavdom1, "calleavdom2" => $calleavdom2,"calleavdom3" => "","teldom" =>"","celular" =>$item->telefono, "fecha_inscripcion" =>  $item->fecha_ingreso, "usuario_reg" => 'administrador', "hora_reg" => "12:52:33","fecha_reg" => "2020-07-01","extci" => $item->lugar_exp,"destino" => "","par_profesion" => $item->par_profesion));
            $i++;
        } 

        
        return $rows;
    }
    
?>
