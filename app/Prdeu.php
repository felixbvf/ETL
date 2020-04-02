<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prdeu extends Model
{
    protected $table = 'finanzas.ptm_obligados';

    protected $fillable = [
        'id_prestamo',
        'id_cliente',
        'par_tipo_relacion',
        'usuario_reg',
        'fecha_reg'
    ];

    protected $guarded = ['id_prestamo'];
}
