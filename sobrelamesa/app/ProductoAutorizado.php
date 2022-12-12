<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoAutorizado extends Model
{
    //
    protected $table = "producto_autorizado";

    protected $fillable = [
        'cantidad',
        'producto_id',
        'agente_id',
        'evento_id'       
    ];
}
