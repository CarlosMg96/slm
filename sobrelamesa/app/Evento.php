<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    //
    protected $table = "evento";

    protected $fillable = [
        'fecha_cotizacion',
        'cliente_id',
        'agente_id',
        'estatus',
        'tipo_evento',
        'no_personas',
        'iva',
        'fecha_evento',
        'hora_evento',
        'fecha_entrega',
        'hora_entrega',
        'fecha_recoleccion',
        'hora_recoleccion',
        'domicilio_entrega',
        'status_entrega',
        'flete',
        'montaje',
        'lavado_desinfeccion',
        'descuento',
        'url_seguimiento'    
    ];
}
