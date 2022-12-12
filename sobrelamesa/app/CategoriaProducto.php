<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    //
    protected $table = "categoria_producto";

    protected $fillable = [
        'categoria'   
    ];
}
