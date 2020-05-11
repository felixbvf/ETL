<?php

namespace App\Exports\Prestamo;
use App\Prcgc;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PrcgcSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    
    public function collection()
    {
        $prcgc = Prcgc::leftJoin('finanzas.ptm_prestamos','ptm_prestamos_cargos_ad.id_prestamo','=','ptm_prestamos.id_prestamo')
        ->Select(DB::raw("case 
        when (strpos(ptm_prestamos_cargos_ad.id_prestamo,'-') = '0') then ptm_prestamos_cargos_ad.id_prestamo 
        else LTRIM(SPLIT_PART(ptm_prestamos_cargos_ad.id_prestamo, '-', 2),'0')
        end as id_prestamo,ptm_prestamos_cargos_ad.id_cargo_adicional,ptm_prestamos_cargos_ad.monto,ptm_prestamos_cargos_ad.par_estado,ptm_prestamos_cargos_ad.usuario_reg,ptm_prestamos_cargos_ad.fecha_reg::timestamp::time as hora_reg, to_char(ptm_prestamos_cargos_ad.fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg"))
        ->where('ptm_prestamos_cargos_ad.par_estado','=','A')
        ->where('ptm_prestamos.par_estado','=','A')
        ->where('ptm_prestamos.par_estado_prestamo','=','DESEM')
        ->get();
        return $prcgc; //Cargos-Seguros
    }

    public function title(): string
    {
        return 'prcgc';
    }

    public function map($prcgc) : array { //Mapeo de datos de prestamo
        return [
            $prcgc->id_prestamo,        //Numero de prestamo
            $prcgc->id_cargo_adicional, //Codigo de cargo  (Ver tabla prcgp)
            $prcgc->monto,              //Importe del cargo
            '',                         //Numero de transaccion de cobro              
            $prcgc->par_estado,         //Marca baja (0: Activo, 9: Dado de baja)
            $prcgc->usuario_reg,        //Usuario
            $prcgc->hora_reg,           //Hora
            $prcgc->fecha_reg,           //Fecha de Proceso
            'N'                         //Marca de Bloqueo (Pasar con N)
        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'prcgcnpre', //Numero de prestamo
            'prcgccarg', //Codigo de cargo  (Ver tabla prcgp)
            'prcgcmont', //Importe del cargo
            'prcgcntra', //Numero de transaccion de cobro
            'prcgcmrcb', //Marca baja (0: Activo, 9: Dado de baja)
            'prcgcuser', //Usuario
            'prcgchora', //Hora
            'prcgcfpro', //Fecha de Proceso
            'prcgcmblq'  //Marca de Bloqueo (Pasar con N)
        ];
    }


}
