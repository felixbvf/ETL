<?php
use App\Gbpersona;
use DB;

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


        $lista = [
            ['id' => 1, 'title' => 'tree'],
            ['id' => 2, 'title' => 'sun'],
            ['id' => 3, 'title' => 'cloud'],
        ];
        return $total;
    }

    
?>