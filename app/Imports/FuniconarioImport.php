<?php

namespace App\Imports;

//use Illuminate\Support\Facades\Hash;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FuniconarioImport implements ToCollection,WithHeadingRow
{
    use Importable;
        
  /*  public function collection(Collection $collection)
    {
        //return $collection;
        return response()->json(["collection"=>$collection]);
    }*/
    public function collection(Collection $rows)
    {
       return $rows;
      //$lista=  array();
     //  return (object)$rows;
     /*$i = 0;
       foreach ($rows as $row) {
        $pages_array[] = array("nro" => $row[$i][0], 'nombre1' => $row[$i][1],'nombre2' => $row[$i][2],'paterno' => $row[$i][3],'materno' => $row[$i][4],
        'nombrecompleto' => $row[$i][5],'domicilio' => $row[$i][6],'telefono' => $row[$i][7],'ci' => $row[$i][8],'lugar_exp' => $row[$i][9],'fecha_nac' => $row[$i][10],'sexo' =>$row[$i][11]);
        $i++;
       }
        return $pages_array;*/
        
    }
}
