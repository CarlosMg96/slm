<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEventoContent extends Model
{
    //
    protected $table = "detalle_evento_content";

    protected $fillable = [
        'content_seccion',        
        'evento_id',
        'row_position'
    ];
}
