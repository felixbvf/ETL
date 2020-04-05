<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'global.parametros';

    protected $fillable = [
        'id_param',
        'item',
        'tipoparam',
        'detalle',
        'descripcionparam',
        'efecto',
        'cuenta',
        'analisis_auxiliar',
        'par_moneda',
        'monto',
        'porcentaje',
        'numero',
        'par_estado'
    ];

    protected $guarded = ['id_param'];
}
