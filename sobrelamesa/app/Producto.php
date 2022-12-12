<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table = "producto";

    protected $fillable = [
        'clave',
        'producto',
        'stock',
        'medidas',
        'categoria_producto_id',
        'precio_renta',
        'reparacion',
        'imagen',
        'precio_reposicion',
        'dias_mantenimiento'    
    ];
}
