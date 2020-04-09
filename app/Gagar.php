<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gagar extends Model
{
    protected $table = 'finanzas.ptm_garantias';

    protected $fillable = [
        'id_prestamo',
        'preferencia',
        'id_tipo_garantia',
        'descripcion',           
        'no_garantia',
        'fecha_inscripcion_garantia',
        'no_libro',
        'no_partida',
        'no_folio_inscripcion',
        'no_registro_garantia',
        'fecha_registro_garantia',
        'valor_garantia',
        'valor_garantia_favor_entidad',
        'valor_garantia_otras_entidades',
        'par_moneda',
        'par_estado',                 
        'usuario_reg',
        'fecha_reg',
        'usuario_mod',
        'fecha_mod',
        'id_oficina'
    ];
    protected $guarded = ['id_prestamo'];
}
