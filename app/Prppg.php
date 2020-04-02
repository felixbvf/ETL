<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prppg extends Model
{
    protected $table = 'finanzas.ptm_plan_pagos';

    protected $fillable = [
        'id_prestamo',
        'fecha_cuota',
        'numero_cuota',
        'importe_capital',
        'importe_interes',
        'importe_cargos',
        'total_cuota',
    ];

    protected $guarded = ['id_prestamo'];
}
