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
        $prdeu = Prdeu::Select(DB::raw("case 
        when (strpos(id_prestamo,'-') = '0') then id_prestamo 
        else LTRIM(SPLIT_PART(id_prestamo, '-', 2),'0')
        end as id_prestamo,id_cliente,
                case 
                    when par_tipo_relacion = 'GARAN' then '2'
                    else 1
                    end as par_tipo_relacion,
                usuario_reg,fecha_reg::timestamp::time as hora_reg,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg"))->whereRaw("par_estado = 'A'")
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
