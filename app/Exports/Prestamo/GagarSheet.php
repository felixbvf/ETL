<?php

namespace App\Exports\Prestamo;

use App\Gagar;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class GagarSheet extends DefaultValueBinder implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle,WithCustomValueBinder
{
    public function collection()
    {
        $gagar = Gagar::Select(DB::raw("case 
        when (strpos(id_prestamo,'-') = '0') then id_prestamo 
        else LTRIM(SPLIT_PART(id_prestamo, '-', 2),'0')
        end as id_prestamo,
        case 
        when id_tipo_garantia = '000047' then 'HC1'
        when id_tipo_garantia = '000064' then 'HO1'
        else 'HV1'
        end as id_tipo_garantia,
        (select id_persona from finanzas.ptm_prestamos where id_prestamo = finanzas.ptm_garantias.id_prestamo) as id_persona,
        to_char(fecha_reg::timestamp::date,'DD/MM/YYYY') as fecha_reg,fecha_reg::timestamp::time as hora_reg,valor_garantia,par_moneda,usuario_mod,valor_garantia_otras_entidades,valor_garantia_favor_entidad,
        (select max(to_char(fecha_cuota::timestamp::date,'DD/MM/YYYY') )from finanzas.ptm_plan_pagos where id_prestamo = finanzas.ptm_garantias.id_prestamo) as fecha_ultima_cuota,
        no_garantia,to_char(fecha_inscripcion_garantia::timestamp::date,'DD/MM/YYYY') as fecha_inscripcion_garantia,
        case 
        when id_tipo_garantia = '000079' then ''
        else substring(no_garantia,1,1)
        end as departamento, descripcion,fecha_reg::timestamp::time as hora_reg"))->get();
        return $gagar; //Maestro Garantias
    }

    public function map($gagar) : array { //Mapeo datos de garantias
        return [
            $gagar->id_prestamo,        //Numero de Garantia
            $gagar->id_tipo_garantia,   //Tipo de Garantia, ver tabla gbtga
            $gagar->id_persona,         //Codigo de Cliente Agenda
            $gagar->fecha_reg,          //Fecha de Registro
            $gagar->valor_garantia,     //Monto de la Garantia
            $gagar->par_moneda,         //Codigo de Moneda
            0,                          //Estado de la garantia (0: Activo; 9: No Activo)
            $gagar->fecha_reg,          //Fecha de cambio de estado
            $gagar->usuario_mod,        //Usuario que cambio de estado
            $gagar->valor_garantia_otras_entidades, //Gravamen anterior
            $gagar->valor_garantia_favor_entidad,   //Gravamen en favor de la entidad
            $gagar->fecha_ultima_cuota,         //Fecha de vencimiento
            $gagar->no_garantia,                //Nro. Partida inscrip derechos reales
            $gagar->fecha_inscripcion_garantia,  //Fecha registro inscrip derechos reales
            0,              //Nro. letra DPF, Warrant, Letras, etc
            '',             //Fecha de letra DPF, Warrant, Letras, etc
            'N',            //Garantía suficientemente liquida s/n
            '',             //Zona donde esta la garantia
            '',             //UV donde esta la garantia
            '',             //Manzano donde esta la garantia
            '',             //Lote donde esta la garantia
            '',             //Superficie de la garantia, si corresponde
            '',             //Área terreno metros cuadrados, si corresponde
            '',             //Total área constr. Metros cuadrados
            '',             //Valor comercial p/metro cuadrado
            '',             //Valor actual p/metro cuadrado
            '',             //Valor comercial del terreno
            '',             //Valor total superficie construida
            '',             //Valor comercial actual
            '',             //Valor neto de realización
            '',             //Valor catastral
            '',             //Valor de reposición
            '',             //Valor de venta rápida
            '',             //Valor mejoras
            $gagar->descripcion, //Descripcion de la garantia Semoviente, Prendaria, etc.
            'S',        //Marca Pro-rateo (S/N)
            17,         //Numero de Modulo origen
            0,          //Marca Baja (0: Dado de alta; 9: Dado de baja)
            20,         //Agencia
            20,         //Plaza
            $gagar->usuario_reg,    //Usuario que creo el registro
            $gagar->hora_reg,   //Hora
            $gagar->fecha_reg,    //Fecha de Proceso
            1,                    //Cantidad de garantias
            '',                   //Unidad
            '',                   //Precio Unitario
            '',                   //Tipo Especie (Semoviente)
            1,                    //Pais donde esta la garantia
            $gagar->departamento,  //Departamento
            '',                    //Provincia
            '',                    //Ciudad
            '',               //Municipio
            1,              //Ambito Geografico (1: Urbano; 2:Rural)
            1,              //Unidad GPS (1: UTM; 2: Grados)
            0,              //Longitud
            0,              //Latitud
           '',              //Codigo tipo Warrant
           '',              //Nro. correlativo entidad Warrant
           '',              //Valor de Venta
           '',              //Precio Avaluó del terreno
           '',              //Precio Avaluó de la construcción
           '',              //Precio total avaluó
           $gagar->descripcion,  //Direccion
           '',              //Fecha último avalúo
           '',              //Cantidad avalúos
           '',              //Indice dirección
           '',              //Abreviación uno
           ''               //Abreviación dos        
        ];
    }

    public function headings(): array  //ENCABEZADO DE EXCEL
    {
        return [
            'gagarngar', ////Numero de Garantia
            'gagartgar', //Tipo de Garantia, ver tabla gbtga
            'gagarcage', //Codigo de Cliente Agenda
            'gagarfreg', //Fecha de Registro
            'gagarmont', //Monto de la Garantia
            'gagarcmon', //Codigo de Moneda
            'gagarstat', //Estado de la garantia (0: Activo; 9: No Activo)
            'gagarfsta', //Fecha de cambio de estado
            'gagarusec', //Usuario que cambio de estado
            'gagargrav', //Gravamen anterior
            'gagargfin', //Gravamen en favor de la entidad
            'gagarfvto', //Fecha de vencimiento
            'gagarnpar', //Nro. Partida inscrip derechos reales
            'gagarfpar', //Fecha registro inscrip derechos reales
            'gagarnlet', //Nro. letra DPF, Warrant, Letras, etc
            'gagarflet', //Fecha de letra DPF, Warrant, Letras, etc
            'gagarsufl', //Garantía suficientemente liquida s/n
            'gagarzona', //Zona donde esta la garantia
            'gagarnouv', //UV donde esta la garantia
            'gagarmanz', //Manzano donde esta la garantia
            'gagarlote', //Lote donde esta la garantia
            'gagarcsup', //Superficie de la garantia, si corresponde
            'gagararea', //Área terreno metros cuadrados, si corresponde
            'gagartoac', //Total área constr. Metros cuadrados
            'gagarvcom', //Valor comercial p/metro cuadrado
            'gagarvact', //Valor actual p/metro cuadrado
            'gagarvcte', //Valor comercial del terreno
            'gagarvtsc', //Valor total superficie construida
            'gagarvcoa', //Valor comercial actual
            'gagarvnet', //Valor neto de realización
            'gagarvcat', //Valor catastral
            'gagarvrep', //Valor de reposición
            'gagarvvrp', //Valor de venta rápida
            'gagarvmej', //Valor mejoras
            'gagardesc', //Descripcion de la garantia Semoviente, Prendaria, etc.
            'gagarmpro', //Marca Pro-rateo (S/N)
            'gagarnmod', //Numero de Modulo origen
            'gagarmrcb', //Marca Baja (0: Dado de alta; 9: Dado de baja)
            'gagaragen', //Agencia
            'gagarplaz', //Plaza
            'gagaruser', //Usuario que creo el registro
            'gagarhora', //Hora
            'gagarfpro', //Fecha de Proceso
            'gagarcant', //Cantidad de garantias
            'gagarunid', //Unidad
            'gagarpuni', //Precio Unitario
            'gagartsem', //Tipo Especie (Semoviente)
            'gagarpais', //Pais donde esta la garantia
            'gagardpto', //Departamento
            'gagarcprv', //Provincia
            'gagarciud', //Ciudad
            'gagarcmun', //Municipio
            'gagarambg', //Ambito Geografico (1: Urbano; 2:Rural)
            'gagarugps', //Unidad GPS (1: UTM; 2: Grados)
            'gagarlong', //Longitud
            'gagarlati', //Latitud
            'gagarctew', //Codigo tipo Warrant
            'gagarccow', //Nro. correlativo entidad Warrant
            'gagarvven', //Valor de Venta
            'gagarpate', //Precio Avaluó del terreno
            'gagarpaco', //Precio Avaluó de la construcción
            'gagarpato', //Precio total avaluó
            'gagardire', //Direccion
            'gagarfuav', //Fecha último avalúo
            'gagarcaav', //Cantidad avalúos
            'gagaridir', //Indice dirección
            'gagarcad1', //Abreviación uno
            'gagarcad2'  //Abreviación dos
        ];
    }

    public function title(): string
    {
        return 'gagar';
    }

    public function bindValue(Cell $cell, $value)
    {   
        
            if (is_string($value)) {
                $cell->setValueExplicit($value, DataType::TYPE_STRING);
    
                return true;
            }
            // else return default behavior
            return parent::bindValue($cell, $value);  
    }

}
