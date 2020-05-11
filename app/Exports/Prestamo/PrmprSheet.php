<?php

namespace App\Exports\Prestamo;

use App\Prestamo;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;


class PrmprSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection() //Obteniendo datos de prestamos
    {
        $prestamos = Prestamo::Select(DB::raw("case 
        when (strpos(id_prestamo,'-') = '0') then id_prestamo 
        else LTRIM(SPLIT_PART(id_prestamo, '-', 2),'0')
        end as id_prestamo,id_persona,to_char(fecha_registro_prestamo::timestamp::date,'DD/MM/YYYY') as fecha_registro_prestamo,no_resolucion,id_producto,id_ejecutivo_aut,id_ejecutivo_res,
        par_destino,caedec,
         CASE
                WHEN par_moneda = 'Bs' then 1
                ELSE 2
                end as par_moneda,imp_desembolsado,(plazo*30) as plazo,
         CASE 
                 WHEN par_forma_pago = 'ALEM' then 3
                 else 2
                 end as par_forma_pago,
        periodo_pago_capital,periodo_pago_intereses,dia_pago,to_char(fecha_primera_cuota::timestamp::date,'DD/MM/YYYY') as fecha_primera_cuota,
        (SELECT COALESCE(sum(pd.importe), 0::numeric) AS importe
        FROM finanzas.ptm_tr_detalle pd
        WHERE pd.par_concepto_op::text = 'CAP'::text AND pd.par_estado::text = 'A'::text AND pd.id_prestamo::text = finanzas.ptm_prestamos.id_prestamo::text) AS saldo_actual,
        imp_desembolsado,
         case 
                 when id_estado = 'VIG' then 2
                 when id_estado = 'VEN' then 5
                 when id_estado = 'EJE' then 6
                 else 7
                 end as id_estado,
        to_char(fecha_cambio_estado::timestamp::date,'DD/MM/YYYY') as fecha_cambio_estado,to_char(fecha_desembolso::timestamp::date,'DD/MM/YYYY') as fecha_desembolso,to_char(fecha_ultimo_pago::timestamp::date,'DD/MM/YYYY') as fecha_ultimo_pago,
        no_reprogramacion,to_char(fecha_reprogramacion::timestamp::date,'DD/MM/YYYY') as fecha_reprogramacion,
        case 
                when par_estado = 'A' then 0
                else 9
                end as par_estado,
        usuario_reg,fecha_reg::timestamp::time as hora_reg,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,
        to_char(fecha_incumplimiento_pp::timestamp::date,'DD/MM/YYYY') as fecha_incumplimiento_pp,
        par_tipo_credito_asfi,calificacion_automatica"))
        ->whereRaw("par_estado::text = 'A'::text and par_estado_prestamo='DESEM'")->orderByRaw("id_persona::numeric asc")->get();
        
        return $prestamos;
    }

    public function title(): string
    {
        return 'prmpr';
    }

    public function map($prestamos) : array { //Mapeo de datos de prestamo
        return [
            $prestamos->id_prestamo,             //Numero de prestamo
            $prestamos->id_persona,              //Codigo de agenda
            $prestamos->fecha_registro_prestamo, //Fecha de registro de la operación
            '',
            '',
            $prestamos->no_resolucion,           //Numero de resolucion
            $prestamos->id_producto,             //Tipo de credito dependiendo la parametrizacion que se realice
            '1',                                 //Origen de recursos
            $prestamos->id_ejecutivo_aut,        //Codigo del funcionario que esta autorizando la operación crediticia
            $prestamos->id_ejecutivo_res,        //Codigo del funcionario responsable del seguimiento de la operación
            '',
            $prestamos->par_destino,             //Codigo del rubro destino de la operación
            $prestamos->caedec,                  //Actividad economica CAEDEC del destino de la operación
            $prestamos->par_destino,
            '',                             //Descripcion del destino de la operación
            $prestamos->par_moneda,         //Moneda de la operación 
            $prestamos->imp_desembolsado,   //Monto aprobado de la operación crediticia
            $prestamos->plazo,              //Plazo en dias de la operación (Dependiendo de la unidad de plazo)
            '2',                            //Unidad de plazo (1:ano, 2:mes, 3:dias)
            '',                             //Si es que usa tasa externa, en este campo se ingresa el codigo de la tasa externa que usa
            $prestamos->par_forma_pago,     //Forma de pago(1:Plazo fijo, 2:Amortizable, 3:Cuota fija)
            $prestamos->periodo_pago_capital, //Periodo de pago a capital (Expresado en la unidad de pago, para el ejemplo en dias)
            $prestamos->periodo_pago_intereses, //Periodo de pago a interes (Expresado en la unidad de pago, para el ejemplo en dias)
            '0',                                //Periodo de gracia (Expresado en la unidad de pago, para el ejemplo en dias)
            '3',                                //Unidad de periodo (1:ano, 2:mes, 3:dias)                   
            $prestamos->dia_pago,               //Dia de pago fijo
            $prestamos->fecha_primera_cuota,    //Fecha de primer pago
            '0',                                //Importe de la ultima cuota
            $prestamos->saldo_actual,           //Saldo del prestamo
            '0',                                //Capital vencido
            $prestamos->imp_desembolsado,       //Monto desembolsado
            '0',                                //Monto de seguro
            $prestamos->id_estado,              //Codigo de estado de la operación (2:Vigente, 5:Vencido, 6:Ejecucion, 7:Castigado)
            $prestamos->fecha_cambio_estado,    //Fecha en la que ingreso al estado actual
            $prestamos->fecha_cambio_estado,    //Fecha en la que ingreso al estado Vencido
            $prestamos->fecha_cambio_estado,    //Fecha de vencimiento actual de la operación
            $prestamos->fecha_cambio_estado,    //Fecha de vencimiento original de la operación
            $prestamos->id_estado,               //Estado anterior del prestamo
            $prestamos->fecha_cambio_estado,    //Fecha en la que ingreso al estado anterior
            $prestamos->fecha_desembolso,       //Fecha de desembolso de la 
            $prestamos->fecha_ultimo_pago,      //Fecha de ultimo pago de la operación
            '4',                                //Forma de calificacion(1:Calif y prev manual, 2:Calif manual prev aut,3:Calif aut prev manual, 4:Calif y prev auto)
            '',                                 //Calificacion de la operación
            '1',                                //Via de desembolso (Constante 1)
            '',                                 //Cuenta de desembolso (Constante vacio)
            '3',                                //Via de cobro (Constante 3)
            '',                                 //Cuenta cobro (Constante vacio)
            'N',                                //Debito automatico? (S o N)
            $prestamos->no_reprogramacion,      //Cantidad de reprogramaciones
            $prestamos->fecha_reprogramacion,   //Fecha de ultima reprogramacion
            '0',                                //Productos devengados
            '0',                                //Productos en suspenso
            '31/03/2020',                       //Fecha de ultimo devengamiento
            'N',                                //Marca Prod. (Constante N)
            'N',                                //Constante N
            '',                                 //Codigo de usuario que autoriza reversion (Constante vacio)
            $prestamos->par_estado,             //Marca baja (0:Activa, 9:dado de baja)
            '20',                               //Codigo de plaza donde se origino la operación crediticia
            '20',                               //Codigo de agencia donde se origino la operación crediticia
            $prestamos->usuario_reg,            //Codigo del usuario que registro la operación
            $prestamos->hora_reg,               //Hora en la que se registro la operación
            $prestamos->fecha_reg,              //Fecha del servidor en la que se registro la operación
            $prestamos->par_tipo_credito_asfi,  //Categoria de calificacion 
            $prestamos->par_tipo_credito_asfi,  //Categoria de calificacion en el proceso automatico
            '',                                 //Numero de linea externa relacionada a la operación
            '17',                               //Modulo (Constante 17)
            $prestamos->fecha_incumplimiento_pp, //Fecha de incumplimiento
            '0',                                //Naturaleza del Prestamo (0: Prestamo Institucional o Individual; 9:Prestamos clientes Banca Comunal)
            '',                                 //Prestamo Principal, si es banca comunal
            '',                                 //Cód. (producto) por tipo de credito
            '',                                 //Financiador - banquero
            '',                                 //Nro. programa línea externa
            '',                                 //Código país
            '',                                 //Código departamento
            '',                                 //Código provincia
            '',                                 //Ciudad
            '',                                 //Zona
            '',                                 //Codigo municipio
            '0',                                //Ámbito geográfico
            '',                                 //Tipo garantía operación
            '',                                 //Tipo GPS
            '0',                                //Longitud
            '0',                                //Latitud
            ''                                  //Nro. de familia

        ] ;
    }


    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'prmprnpre', //Numero de prestamo
            'prmprcage', //Codigo de agenda
            'prmprfreg', //Fecha de registro de la operación
            'prmprnctr',
            'prmprlncr',
            'prmprreso', //Numero de resolucion
            'prmprtcre', //Tipo de credito dependiendo la parametrizacion que se realice
            'prmprorgr', //Origen de recursos
            'prmprautp', //Codigo del funcionario que esta autorizando la operación crediticia
            'prmprrseg', //Codigo del funcionario responsable del seguimiento de la operación
            'prmprconv', //Campo libre
            'prmprrubr', //Codigo del rubro destino de la operación
            'prmprciiu', //Actividad economica CAEDEC del destino de la operación
            'prmprdest', //Codigo del destino de la operación
            'prmprddes', //Descripcion del destino de la operación
            'prmprcmon', //Moneda de la operación 
            'prmprmapt', //Monto aprobado de la operación crediticia
            'prmprplzo', //Plazo en dias de la operación (Dependiendo de la unidad de plazo)
            'prmpruplz', //Unidad de plazo (1:ano, 2:mes, 3:dias)
            'prmprtsex', //Si es que usa tasa externa, en este campo se ingresa el codigo de la tasa externa que usa
            'prmprfpag', //Forma de pago(1:Plazo fijo, 2:Amortizable, 3:Cuota fija)
            'prmprppgk', //Periodo de pago a capital (Expresado en la unidad de pago, para el ejemplo en dias)
            'prmprppgi', //Periodo de pago a interes (Expresado en la unidad de pago, para el ejemplo en dias)
            'prmprgrac', //Periodo de gracia (Expresado en la unidad de pago, para el ejemplo en dias)
            'prmpruppg', //Unidad de periodo (1:ano, 2:mes, 3:dias)
            'prmprdiap', //Dia de pago fijo
            'prmprfprp', //Fecha de primer pago
            'prmpriupg', //Importe de la ultima cuota
            'prmprsald', //Saldo del prestamo
            'prmprkven', //Capital vencido
            'prmprmdes', //Monto desembolsado
            'prmprmseg', //Monto de seguro
            'prmprstat', //Codigo de estado de la operación (2:Vigente, 5:Vencido, 6:Ejecucion, 7:Castigado)
            'prmprfsta', //Fecha en la que ingreso al estado actual
            'prmprfpvc', //Fecha en la que ingreso al estado Vencido
            'prmprfvac', //Fecha de vencimiento actual de la operación
            'prmprfvor', //Fecha de vencimiento original de la operación
            'prmprstan', //Estado anterior del prestamo
            'prmprfsan', //Fecha en la que ingreso al estado anterior
            'prmprfdes', //Fecha de desembolso de la operación
            'prmprfulp', //Fecha de ultimo pago de la operación
            'prmprfcal', //Forma de calificacion(1:Calif y prev manual, 2:Calif manual prev aut,3:Calif aut prev manual, 4:Calif y prev auto)
            'prmprcalf', //Calificacion de la operación
            'prmprviad', //Via de desembolso (Constante 1)
            'prmprctad', //Cuenta de desembolso (Constante vacio)
            'prmprviac', //Via de cobro (Constante 3)
            'prmprctac', //Cuenta cobro (Constante vacio)
            'prmprdeba', //Debito automatico? (S o N)
            'prmprcrpg', //Cantidad de reprogramaciones
            'prmprfrpg', //Fecha de ultima reprogramacion
            'prmprpdvg', //Productos devengados
            'prmprpsus', //Productos en suspenso
            'prmprfdev', //Fecha de ultimo devengamiento
            'prmprmcpd', //Marca Prod. (Constante N)
            'prmprreve', //Constante N
            'prmprusrr', //Codigo de usuario que autoriza reversion (Constante vacio)
            'prmprmrcb', //Marca baja (0:Activa, 9:dado de baja)
            'prmprplaz', //Codigo de plaza donde se origino la operación crediticia
            'prmpragen', //Codigo de agencia donde se origino la operación crediticia
            'prmpruser', //Codigo del usuario que registro la operación
            'prmprhora', //Hora en la que se registro la operación
            'prmprfpro', //Fecha del servidor en la que se registro la operación
            'prmprcclf', //Categoria de calificacion 
            'prmprcpac', //Categoria de calificacion en el proceso automatico
            'prmprnlex', //Numero de linea externa relacionada a la operación
            'prmprnmod', //Modulo (Constante 17)
            'prmprfinc', //Fecha de incumplimiento
            'prmprnatu', //Naturaleza del Prestamo (0: Prestamo Institucional o Individual; 9:Prestamos clientes Banca Comunal)
            'prmprnprp', //Prestamo Principal, si es banca comunal
            'prmprctpp', //Cód. (producto) por tipo de credito
            'prmprcbnq', //Financiador - banquero
            'prmprnrpg', //Nro. programa línea externa
            'prmprpais', //Código país
            'prmprdpto', //Código departamento
            'prmprcprv', //Código provincia
            'prmprciud', //Ciudad
            'prmprzona', //Zona
            'prmprcmun', //Codigo municipio
            'prmprambg', //Ámbito geográfico
            'prmprcgta', //Tipo garantía operación
            'prmprugps', //Tipo GPS
            'prmprlong', //Longitud
            'prmprlati', //Latitud
            'prmprnfam'  //Nro. de familia
        ];
    }
}
