<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEvento extends Model
{
    //
    protected $table = "detalle_evento";

    protected $fillable = [
        'producto_id',
        'cantidad',
        'evento_id',
        'row_position'
    ];
}
