<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gbpersona extends Model
{
    protected $table = 'global.gbpersona';

    protected $fillable = [

        'id_persona',
        'par_tipoper',
        'nombre1',
        'nombre2',
        'appaterno',
        'apmaterno',
        'apesposo',
        'nombrecompleto',
        'par_tipodoc',
        'nrodoc',
        'par_lugarexp',
        'fecha_exp',
        'nronit',
        'fecha_vto_nit',
        'par_sexo',
        'fecha_nac',
        'nacionalidad',
        'par_estadocivil',
        'calleavdom',
        'calleavofi',
        'teldom',
        'telofi',
        'email',
        'celular',
        'caedec',
        'par_fuerza',
        'par_profesion',
        'ref_personal',
        'mensaje',
        'par_fuente_ingresos',
        'numero_papeleta',
        'fecha_inscripcion',
        'par_estado',
        'usuario_reg',
        'fecha_reg',
        'usuario_mod',
        'fecha_mod',
        'referencia_bancaria',
        'numero_cta_bancaria'

    ];

    protected $guarded = ['id_persona'];
}
