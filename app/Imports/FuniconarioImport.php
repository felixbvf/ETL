<?php

namespace App\Imports;

//use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FuniconarioImport implements ToCollection,WithHeadingRow
{
    use Importable;
    public function collection(Collection $rows)
    {
       return $rows;
        
    }
}
