<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoEvento extends Model
{
    //
    protected $table = "ingreso_evento";

    protected $fillable = [
        'importe',
        'fecha',
        'forma_pago',
        'comprobante',
        'concepto',
        'evento_id'     
    ];
}
