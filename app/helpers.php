<?php
use App\Gbpersona;
//use Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FuniconarioImport;
use Illuminate\Support\Facades\Log;

    function CountClient()
	{	// return importFuncionario();
        $total = Gbpersona::Select(DB::raw("max(id_persona::numeric) as id"))
    ->whereRaw("exists(select id_persona from finanzas.ptm_prestamos where par_estado ='A' and par_estado_prestamo ='DESEM' and id_persona = global.gbpersona.id_persona)
    or exists (select id_persona from finanzas.aps_aportes where  id_persona = global.gbpersona.id_persona 
    and par_estado ='A' and (id_estado = 'VIGENTE' or id_estado = 'COMISION' or id_estado ='LICENCIA' or id_estado = 'RETENCION'))")
    ->first();

        return $total->id;
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
        case 
        when (usuario_reg = 'administrador' or usuario_reg is null) then 'MGB'
        else upper(usuario_reg)
        end as usuario_reg,
        fecha_reg::timestamp::time as hora_reg,
        to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,
        SPLIT_PART(nrodoc, '-', 2) as extci,destino,par_profesion"))
    ->whereRaw("exists(select id_persona from finanzas.ptm_prestamos where par_estado ='A' and par_estado_prestamo ='DESEM' and id_persona = global.gbpersona.id_persona)
    or exists (select id_persona from finanzas.aps_aportes where  id_persona = global.gbpersona.id_persona 
    and par_estado ='A' and (id_estado = 'VIGENTE' or id_estado = 'COMISION' or id_estado ='LICENCIA' or id_estado = 'RETENCION'))")
    ->orderByRaw('id_persona::numeric asc')->get();
    $afi = json_decode(json_encode($afi));
    $afi1 = array_flatten($afi);
    //return $afi;
    $rows = json_decode(json_encode(Excel::toArray(new FuniconarioImport, storage_path('AGENDA.xlsx'))));
    $rows = collect(array_flatten($rows));
    //array_push($afi1,$rows);
    // return $afi1; //original
    //return $rows;
    $i=1;
    foreach ($rows as $item1) 
    {
            $cont = (int)CountClient() + (int)$i;
            $calleavdom1 = substr($item1->domicilio,0,29 );
            $calleavdom2 = substr($item1->domicilio,31,60 );
            $calleavdom3 = substr($item1->domicilio,61,90 );
            $list[] = json_decode(json_encode(array("id" => $cont,"nombrecompleto" => $item1->nombrecompleto,"par_tipodoc" => $item1->par_tipodoc,"nrodoc" => $item1->nrodoc,"par_tipoper" => $item1->par_tipoper,"fecha_nac" => $item1->fecha_nac,"par_sexo" => $item1->par_sexo,"par_estadocivil" => $item1->par_estadocivil,"nacionalidad" => $item1->nacionalidad,"calleavdom1" => $calleavdom1, "calleavdom2" => $calleavdom2,"calleavdom3" => $calleavdom3,"teldom" => $item1->teldom,"celular" => $item1->celular, "fecha_inscripcion" =>  $item1->fecha_inscripcion, "usuario_reg" => $item1->usuario_reg, "hora_reg" => $item1->hora_reg,"fecha_reg" => $item1->fecha_reg,"extci" => $item1->extci,"destino" => $item1->destino,"par_profesion" => $item1->par_profesion)));
            $i++;
    }
    //return $list;
    array_push($afi,$list);
    return array_flatten($afi);
        
  }
    
    function array_flatten($array) { 
        if (!is_array($array)) { 
          return FALSE; 
        } 
        $result = array(); 
        foreach ($array as $key => $value) { 
          if (is_array($value)) { 
            $result = array_merge($result, array_flatten($value)); 
          } 
          else { 
            $result[$key] = $value; 
          } 
        } 
        return $result; 
      } 


    
?>
