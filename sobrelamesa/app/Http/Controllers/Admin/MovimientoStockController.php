<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MovimientoStock;
use App\Producto;
use App\Evento;
use Illuminate\Support\Facades\DB;

//VARIABLES PARA EL CIFRADO Y DESCIFRADO DE DATOS
define('METHOD','AES-256-CBC');
//PW: Itos Tecnología
define('SECRET_KEY','1To5!!2019*123');
//NC: Juan Alberto Esteban Pablo
define('SECRET_IV','11670059');

class MovimientoStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  return view('admin.inventario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function inventarios(){
       $fecha = time();
       date_default_timezone_set('America/Mexico_City');
       $fecha_actual = date('d-m-Y', $fecha);

          $objectProducto = DB::table('producto')
        ->join('categoria_producto','producto.categoria_producto_id','=','categoria_producto.id')            
        ->where('producto.status',1)        
        ->select(
          'producto.*',
          'categoria_producto.categoria'      
        )
        ->whereNotNull('clave')
        ->orderBy('producto.id','DESC')
        ->get();

       $objetoIventario = DB::table('movimiento_stock')
       ->get();
    }
}
