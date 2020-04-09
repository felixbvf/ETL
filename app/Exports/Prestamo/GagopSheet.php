<?php

namespace App\Exports\Prestamo;

use App\Gagar;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GagopSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $gagop = Gagar::Select(DB::raw("case 
        when (strpos(id_prestamo,'-') = '0') then id_prestamo 
        else LTRIM(SPLIT_PART(id_prestamo, '-', 2),'0')
        end as id_prestamo,
        case 
        when id_tipo_garantia = '000047' then 'HC1'
        when id_tipo_garantia = '000064' then 'HO1'
        else 'HV1'
        end as id_tipo_garantia, par_moneda,
        (SELECT COALESCE(sum(ptm_tr_detalle.importe), 0::numeric) AS importe
          FROM finanzas.ptm_tr_detalle
         WHERE ptm_tr_detalle.par_concepto_op::text = 'CAP'::text AND ptm_tr_detalle.par_estado::text = 'A'::text AND ptm_tr_detalle.id_prestamo::text = finanzas.ptm_garantias.id_prestamo::text) AS saldo,
       valor_garantia,valor_garantia_favor_entidad,(valor_garantia/6.86) as importe,
        to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,usuario_mod,valor_garantia_otras_entidades,usuario_reg,fecha_reg::timestamp::time as hora_reg"))->get();
        
        return $gagop; //Garantia Operacion
    }

    public function map($gagop) : array { //Mapeo Garantia Operacion
        return [
            $gagop->id_prestamo, //Numero de Garantia            
            17,                  //Numero de Modulo (17: Prestamos Individuales; 55: Banca Comunal)
            $gagop->id_prestamo, //Numero de Operacion (Numero de Prestamo)
            $gagop->id_tipo_garantia, //Tipo de Garantia, ver tabla gbtga
            $gagop->par_moneda,     //Codigo de Moneda
            $gagop->saldo,          //Saldo
            $gagop->valor_garantia, //Monto de la garantia
            '0',                    //Monto del gravamen
            $gagop->valor_garantia_favor_entidad,   //Monto de la garantia gravado en la institucion para la operacion
            $gagop->importe,    //Importe
            6.86,               //Tipo de cambio
            0,                  //Porcentaje Prorrateo
            $gagop->fecha_reg,  //Fecha de registro de la relacion operacion garantia
            1,                  //Grado de Prelacion
            0,                  //Estado del registro (0: Activo; 9: No activo)
            $gagop->fecha_reg,  //Fecha de Cambio de Estado
            $gagop->usuario_mod, //Usuario que hizo el cambio de estado
            '',                  //Fecha de ultimo revaluo
            '0',                 //Marca Baja (0: Dado de alta; 9: Dado de baja)
            20,                 //Agencia
            20,                 //Plaza
            $gagop->usuario_reg,    //Usuario  
            $gagop->hora_reg,   //Hora
            $gagop->fecha_reg,  //Fecha de proceso
            '0',                //Numero de letra
            ''                  //Fecha de letra
        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'gagopngar', //Numero de Garantia
            'gagopnmod', //Numero de Modulo (17: Prestamos Individuales; 55: Banca Comunal)
            'gagopnopr', //Numero de Operacion (Numero de Prestamo)
            'gagoptgar', //Tipo de Garantia, ver tabla gbtga
            'gagopcmon', //Codigo de Moneda
            'gagopsald', //Saldo
            'gagopmont', //Monto de la garantia
            'gagopgrav', //Monto del gravamen
            'gagopgfin', //Monto de la garantia gravado en la institucion para la operacion
            'gagopimpc', //Importe
            'gagoptcam', //Tipo de cambio
            'gagopporc', //Porcentaje Prorrateo
            'gagopfreg', //Fecha de registro de la relacion operacion garantia
            'gagopgrad', //Grado de Prelacion
            'gagopstat', //Estado del registro (0: Activo; 9: No activo)
            'gagopfsta', //Fecha de Cambio de Estado
            'gagopusec', //Usuario que hizo el cambio de estado
            'gagopfupr', //Fecha de ultimo revaluo
            'gagopmrcb', //Marca Baja (0: Dado de alta; 9: Dado de baja)
            'gagopagen', //Agencia
            'gagopplaz', //Plaza
            'gagopuser', //Usuario  
            'gagophora', //Hora
            'gagopfpro', //Fecha de proceso
            'gagopnlet', //Numero de letra
            'gagopflet'  //Fecha de letra
        ];
    }

    public function title(): string
    {
        return 'gagop';
    }


}
