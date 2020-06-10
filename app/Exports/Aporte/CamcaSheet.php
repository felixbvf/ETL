<?php

namespace App\Exports\Aporte;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CamcaSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $camca = DB::select(DB::raw("select apr.id_persona,ap.id_aporte,
        ap.fecha_apertura,ap.id_estado,ap.fecha_estado_aporte,apr.saldo,ap.ultfecha,ap.hora_reg,ap.permite_aportes
        FROM (select a.id_persona, sum(am.importe ) as saldo
        from finanzas.aps_tr_maestro am left join finanzas.aps_aportes a on (am.id_aporte = a.id_aporte)
        where a.id_estado <> 'LIQUIDADO' and am.eliminado ='N' and a.par_estado = 'A'
        group by a.id_persona
        order by a.id_persona::numeric asc) apr,
        (select id_persona,id_aporte, to_char(a.fecha_apertura::timestamp::date,'DD/MM/YYYY') as fecha_apertura,id_producto,id_estado,
        ( SELECT max(to_char(aps_tr_maestro.fecha_transaccion::timestamp::date,'DD/MM/YYYY')) AS fecha_transaccion 
                   FROM finanzas.aps_tr_maestro
                  WHERE aps_tr_maestro.par_estado::text = 'A'::text AND aps_tr_maestro.eliminado::text = 'N'::text AND aps_tr_maestro.id_aporte::text = a.id_aporte::text) AS ultfecha,
        case 
            when (a.fecha_estado_aporte is null) then a.fecha_apertura
            else a.fecha_estado_aporte
            end as fecha_estado_aporte, a.fecha_reg::timestamp::time as hora_reg,a.permite_aportes
        from finanzas.aps_aportes a
        where a.id_producto = 'AP_REGULAR_MN' and a.id_estado <> 'LIQUIDADO' and a.par_estado ='A'
        order by id_persona asc) ap
        where apr.id_persona = ap.id_persona
        order by apr.id_persona::numeric asc;"));   

        return collect($camca); //APORTES 
    }

    public function map($camca) : array { //Datos a exportar
        return [
            $camca->id_aporte, //Numero de Cuenta
            $camca->id_persona, //Codigo de cliente titular
            1,                  //Tipo Caja de Ahorro
            1,                  //Moneda
            1,                  //Manejo (individual,Colectivo)
            'N',                //Retencion IVA
            0,                  //Tasa Referencial
            '',                 //Instruciones para Firmas
            $camca->fecha_apertura,     //Fecha de Apertura
            0,                  //Saldo Anterior
            $camca->saldo,      //Saldo actual
            0,                  //Depositos no Confirmados
            '',                 //Fondos Pignorados
            $camca->ultfecha,   //Fecha Ultimo Movimiento
            $camca->id_estado,  //Status de la Cuenta
            $camca->fecha_estado_aporte,    //Fecha Cambio Status
            0,                              //Saldo Ultimo Dia Cerrado
            0,                  //Saldo Acumulado
            0,                  //Saldo Acumulado Anterior
            20,                 //Plaza
            20,                 //Agencia
            'MIG',              //Usuario
            $camca->hora_reg,       //Hora
            '',                     //Fecha de Proceso
            $camca->permite_aportes, //Uso de la Cuenta
            1,                       //Tipo de Tasa
            1,                      //Tipo de Capitalizacion
            '',                     //Fecha de capitalizacion
            0,                      //Interes mensual acumulado
            0                       //Interes diario
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'camcancta',    //Numero de Cuenta
            'camcacage',    //Codigo de cliente titular
            'camcatpca',     //Tipo Caja de Ahorro
            'camcacmon',     //Moneda
            'camcamane',    //Manejo (individual,Colectivo)
            'camcariva',    //Retencion IVA
            'camcatasa',    //Tasa Referencial
            'camcainst',    //Instruciones para Firmas
            'camcafapt',    //Fecha de Apertura
            'camcasant',    //Saldo Anterior
            'camcasact',    //Saldo actual
            'camcadncf',    //Depositos no Confirmados
            'camcafpig',    //Fondos Pignorados
            'camcafumv',    //Fecha Ultimo Movimiento
            'camcastat',    //Status de la Cuenta
            'camcafcbl',    //Fecha Cambio Status
            'camcasdia',    //Saldo Ultimo Dia Cerrado  
            'camcaacum',    //Saldo Acumulado
            'camcaacan',    //Saldo Acumulado Anterior
            'camcaplaz',    //Plaza
            'camcaagen',    //Agencia
            'camcauser',    //Usuario
            'camcahora',    //Hora
            'camcafpro',    //Fecha de Proceso
            'camcastus',    //Uso de la Cuenta
            'camcattas',    //Tipo de Tasa
            'camcatcap',    //Tipo de Capitalizacion
            'camcafcap',    //Fecha de capitalizacion
            'camcaiacu',    //Interes mensual acumulado
            'camcaidia'     //Interes diario
        ];

    }

    public function title(): string
    {
        return 'camca';
    }
}
