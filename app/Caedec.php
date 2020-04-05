<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caedec extends Model
{
    protected $table = 'global.gbcaedec';

    protected $fillable = [
        'id_caedec',
        'descripcion',
        'bandera',
        'item',
        'par_categoria_caedec',
        'par_division_caedec',
        'par_grupo_caedec',
        'par_clase_caedec',
        'par_estado'
    ];

    protected $guarded = ['id_caedec'];
}
