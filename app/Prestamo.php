<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'finanzas.ptm_prestamos';

    protected $fillable = [

       'id_prestamo',
       'id_producto',
       'id_persona',
       'no_resolucion',
       'id_ejecutivo_aut',
       'id_ejecutivo_res',
       'caedec',
       'par_destino',
       'par_moneda',
       'imp_desembolsado',
       'fecha_desembolso',
       'saldo_actual',
       'plazo',
       'par_tipo_plazo',
       'par_tipo_taza',
       'tasa_base',
       'tre',
       'par_forma_pago',
       'dia_pago',
       'periodo_gracia',
       'periodo_pago_capital',
       'periodo_pago_intereses',
       'par_tipo_periodo',
       'fecha_primera_cuota',
       'fecha_cambio_estado',
       'id_estado',
       'fecha_incumplimiento_pp',
       'fecha_ultimo_pago',
       'fecha_reprogramacion',
       'no_reprogramacion',
       'fecha_devengamiento',
       'productos_devengados',
       'productos_suspenso',
       'par_tipo_credito_asfi',
       'par_categoria_calificacion',
       'par_estado_prestamo',
       'par_estado',
       'id_autorizacion_rev',
       'fecha_rev',
       'id_transaccion_rev',
       'eliminado',
       'usuario_reg',
       'fecha_reg',
       'usuario_mod',
       'fecha_mod',
       'id_oficina',
       'par_tipo_obligado',
       'estado_manual',
       'calificacion_automatica',
       'detalle_desembolso',
       'debito_automatico',
       'id_cuenta_debito',
       'id_modulo_debito',
       'fecha_registro_prestamo'

    ];

    protected $guarded = ['id_prestamo'];
}
