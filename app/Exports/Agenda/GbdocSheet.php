<?php

namespace App\Exports\Agenda;
use DB;
use App\Gbpersona;
use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
class GbdocSheet implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle
{
    
    public function map($gbdoc) : array { //Datos a exportar
        return [
            $gbdoc->id_persona,
            $gbdoc->nrodoc,
            $gbdoc->fecha_exp,
            '',
            '',
            $gbdoc->fecha_reg,
            '20',
            '20',
            $gbdoc->usuario_reg,
            $gbdoc->hora_reg,
            '',
            ''
        ] ;
    }

    public function headings(): array  //Encabezado de excel
    {
        return [
            'gbdoccage', //codigo agenda
            'gbdocndid', //numero de identidad
            'gbdocfvid', // fecha vencimiento CI
            'gbdocnruc', //Numero de RUC
            'gbdocfvru', //Fecha de Vencimiento de RUC
            'gbdocfreg', //fecha de registro
            'gbdocplaz', //Plaza = 20
            'gbdocagen', //Agencia
            'gbdocuser',
            'gbdochora',
            'gbdocfpro',
            'gbdocfemi',
        ];
    }
    public function collection()
    {
        $gbdoc = Gbpersona::Select(DB::raw("id_persona, replace(nrodoc,'-','') || par_lugarexp as nrodoc,to_char(fecha_exp,'DD/MM/YYYY') as fecha_exp,to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,usuario_reg,fecha_reg::timestamp::time as hora_reg"))
                ->whereRaw("exists(select id_persona from finanzas.ptm_prestamos where par_estado ='A' and par_estado_prestamo ='DESEM' and id_persona = global.gbpersona.id_persona)
                or exists (select id_persona from finanzas.aps_aportes where  id_persona = global.gbpersona.id_persona 
                and par_estado ='A' and (id_estado = 'VIGENTE' or id_estado = 'COMISION' or id_estado ='LICENCIA' or id_estado = 'RETENCION'))")
                ->orderByRaw('id_persona::numeric asc')->get();
        
        $gbdoc = json_decode(json_encode($gbdoc));
        $gbdoc = array_flatten($gbdoc);
        $i=1;
        foreach (getExcel() as $item1) 
        {
                        $cont = (int)CountClient() + (int)$i;
                        $list[] = json_decode(json_encode(array("id_persona" => $cont,"nrodoc" => $item1->nrodoc,"fecha_exp" => $item1->fecha_exp,"fecha_reg" => $item1->fecha_reg,"usuario_reg" => $item1->usuario_reg,"hora_reg" => $item1->hora_reg)));
                        $i++;
        }
                
        array_push($gbdoc,$list);
        return collect(array_flatten($gbdoc));

    }

    public function title(): string
    {
        return 'gbdoc';
    }

}
