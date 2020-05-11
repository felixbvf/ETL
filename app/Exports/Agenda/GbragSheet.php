<?php
namespace App\Exports\Agenda;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GbragSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $gbrag = DB::select(DB::raw("select id_persona, case
        when upper(ref1) is null then ref1 
        when (strpos(upper(ref1),'UN')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'B U')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'B. U.')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'B.U.')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'BU')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'UINO')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'U8NI')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'UMION')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'S/N')>0 ) then 'BANCO UNION'
        when (strpos(upper(ref1),'BCO')>0 ) then 'BANCO DE CREDITO'
        when (strpos(upper(ref1),'BCP') > 0) then 'BANCO DE CREDITO'
        when (strpos(upper(ref1),'PROD') > 0) then 'BANCO PRODEM'
        when (strpos(upper(ref1),'FIE') > 0) then 'BANCO FIE'
        when (strpos(upper(ref1),'MERCAN') > 0) then 'BANCO MERCANTIL SANTA CRUZ'
        when (strpos(upper(ref1),'ANDES') > 0) then 'BANCO LOS ANDES'
        when (strpos(upper(ref1),'GANADER') > 0) then 'BANCO GANADERO'
        when (strpos(upper(ref1),'CREDITO') > 0) then 'BANCO DE CREDITO'
        when (strpos(upper(ref1),'BNB') > 0) then 'BANCO NACIONAL DE BOLIVIA'
        else upper(ref1)
        end as ref1, NULLIF(regexp_replace(cuenta, '\D','','g'), '')::numeric AS cuenta,nro,usuario_reg,fecha_reg,hora_reg 
        from global.v_ref_cuenta_bancaria 
        where (NULLIF(regexp_replace(cuenta, '\D','','g'), '')::numeric) > 100 and 
        (exists(select id_persona from finanzas.ptm_prestamos where par_estado ='A' and par_estado_prestamo ='DESEM' and id_persona = global.v_ref_cuenta_bancaria.id_persona)
        or exists (select id_persona from finanzas.aps_aportes where  id_persona = global.v_ref_cuenta_bancaria.id_persona 
        and par_estado ='A' and (id_estado = 'VIGENTE' or id_estado = 'COMISION' or id_estado ='LICENCIA' or id_estado = 'RETENCION')))
        order by id_persona::numeric,nro asc;"));   

        return collect($gbrag); //REFERENCIAS BANCARIAS
    }

    public function map($gbrag) : array { //Datos a exportar
        return [
            $gbrag->id_persona, //Codigo de Agenda
            $gbrag->nro,        //Numero de Item
            3,                  //Tipo de Referencia (1: Personal, 2: Comercial, 3: Bancaria)
            '',                 //Codigo de Agenda de la referencia
            $gbrag->ref1." ".$gbrag->cuenta, //Nombre de la referencia
            '',                 //Tipo de documento de identidad de la referencia
            '',                 //Numero de documento de identidad de la referencia
            '',                 //Telefono de la referencia
            '',                 //Telefono celular de la referencia
            '',                 //Empresa donde trabaja la referencia
            '',                 //Pagina Web
            $gbrag->usuario_reg,    //Usuario que creo la referencia
            $gbrag->hora_reg,       //Hora del registro
            0,          //Marca baja (0: Activo; 9: Dado de baja)
            '',         //Primer Apellido
            '',         //Segundo Apellido
            '',         //Direccion de la referencia
            '',         //Resultado de Verificacion
            '',         //Tiempo en conocer a la referencia
            '',         //Hora de verificacion referencia
            $gbrag->fecha_reg //Fecha de registro
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'gbragcage', //Codigo de Agenda
            'gbragitem', //Numero de Item
            'gbragtrag', //Tipo de Referencia (1: Personal, 2: Comercial, 3: Bancaria)
            'gbragcref', //Codigo de Agenda de la referencia
            'gbragnomb', //Nombre de la referencia
            'gbragtdid', //Tipo de documento de identidad de la referencia
            'gbragndid', //Numero de documento de identidad de la referencia
            'gbragtelf', //Telefono de la referencia
            'gbragtcel', //Telefono celular de la referencia
            'gbragnemp', //Empresa donde trabaja la referencia
            'gbragspwb', //Pagina Web
            'gbraguser', //Usuario que creo la referencia
            'gbraghora', //Hora del registro
            'gbragmrcb', //Marca baja (0: Activo; 9: Dado de baja)
            'gbragape1', //Primer Apellido
            'gbragape2', //Segundo Apellido
            'gbragdire', //Direccion de la referencia
            'gbragrver', //Resultado de Verificacion
            'gbragtcon', //Tiempo en conocer a la referencia
            'gbraghver', //Hora de verificacion referencia
            'gbragfreg', //Fecha de registro
        ];

    }
    
    public function title(): string
    {
        return 'gbrag';
    }

}
