<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoStock extends Model
{
    protected $table = 'movimiento_stock';

    // protected $fillable = [
    //     'stock',
        
    // ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
    
    public function evento_detalle()
    {
        return $this->belongsTo(DetalleEvento::class);
    }

}
