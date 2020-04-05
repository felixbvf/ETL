<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCargoSeguro extends Model
{
    protected $table = 'finanzas.ptm_cargos_adicionales';

    protected $fillable = [
        'id_producto',
        'id_cargo_adicional',
        'descripcion',
        'monto',
        'porcentaje',
        'par_moneda',
        'cuenta',
        'par_estado'
    ];

    protected $guarded = ['id_cargo_adicional'];
}
