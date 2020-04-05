<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'finanzas.ptm_productos';

    protected $fillable = [
        'id_producto',
        'descripcion',
        'par_moneda',
        'par_estado',
        'monto_minimo',
        'monto_maximo',
        'plazo_minimo',
        'plazo_maximo'
    ];

    protected $guarded = ['id_producto'];
}
