<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = "cliente";

    protected $fillable = [
        'nombre_completo',
        'empresa',
        'celular1',
        'celular2',
        'correo_electronico',
        'tipo_cliente',
        'rfc',
        'cp',
        'descuento',
        'forma_pago_autorizada',
        'constancia_fiscal',
        'ine_front',
        'ine_back',
        'comprobante_domicilio',
        'agente_id',
        'status'     
    ];

}
