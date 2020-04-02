<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prcgc extends Model
{
    protected $table = 'finanzas.ptm_prestamos_cargos_ad';

    protected $fillable = [
        'id_prestamo',
        'id_cargo_adicional',
        'monto',
        'par_estado',
        'usuario_reg',
        'fecha_reg'
    ];

    protected $guarded = ['id_prestamo'];
}
