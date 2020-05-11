<?php

namespace App\Exports\Prestamo;

use App\Prdeu;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PrdeuSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    public function collection()
    {
        $prdeu = Prdeu::leftJoin('finanzas.ptm_prestamos','finanzas.ptm_obligados.id_prestamo','=','ptm_prestamos.id_prestamo')
        ->Select(DB::raw("case 
        when (strpos(ptm_obligados.id_prestamo,'-') = '0') then ptm_obligados.id_prestamo 
        else LTRIM(SPLIT_PART(ptm_obligados.id_prestamo, '-', 2),'0')
        end as id_prestamo,ptm_obligados.id_cliente,
                case 
                    when ptm_obligados.par_tipo_relacion = 'GARAN' then '2'
                    else 1
                    end as par_tipo_relacion,
                    ptm_obligados.usuario_reg,ptm_obligados.fecha_reg::timestamp::time as hora_reg,to_char(ptm_obligados.fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg"))
        ->where('ptm_obligados.par_estado','=','A')
        ->where('ptm_prestamos.par_estado','=','A')
        ->where('ptm_prestamos.par_estado_prestamo','=','DESEM')
        ->get();
        return $prdeu; //Deudores
    }

    public function title(): string
    {
        return 'prdeu';
    }

    public function map($prdeu) : array { //Mapeo de datos deudores
        return [
            $prdeu->id_prestamo,        //Numero de prestamo
            $prdeu->id_cliente,         //Codigo de Agenda
            $prdeu->par_tipo_relacion,  //Tipo de Responsabilidad (1: Deudor o Codeudor; 2: Garante)
            $prdeu->usuario_reg,        //Usuario que registro la transaccion
            $prdeu->hora_reg,           //Hora de la transaccion
            $prdeu->fecha_reg           //Fecha de Proceso

        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'prcgcnpre', //Numero de prestamo
            'prdeucage', //Codigo de Agenda
            'prdeutres', //Tipo de Responsabilidad (1: Deudor o Codeudor; 2: Garante)
            'prdeuuser', //Usuario que registro la transaccion
            'prdeuhora', //Hora de la transaccion
            'prdeufpro'  //Fecha de Proceso
        ];
    }

    
}
