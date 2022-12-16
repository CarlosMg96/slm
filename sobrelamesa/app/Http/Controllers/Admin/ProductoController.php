<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CategoriaProducto;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Hamcrest\Core\IsNull;
use Mockery\Matcher\Not;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.producto.index');
    }

    public function get_productos(Request $request){
        $fecha = time();
        date_default_timezone_set('America/Mexico_City');
        $fecha_actual = date('Y-m-d', $fecha);
        //$objectCliente = Cliente::where('status',1)->orderBy('id','DESC')->get();
        // $objectProducto = DB::table('producto')
        // ->join('categoria_producto','producto.categoria_producto_id','=','categoria_producto.id')            
        // ->where('producto.status',1)        
        // ->select(
        //   'producto.*',
        //   'categoria_producto.categoria'      
        // )
        // ->orderBy('producto.id','DESC')
        // ->get();


        //Aquí se filtran los resultados de la conversión
        $objectProducto = DB::table('producto')
        ->join('categoria_producto','producto.categoria_producto_id','=','categoria_producto.id')            
        ->where('producto.status',1)  
        ->select(
          'producto.*',
          'categoria_producto.categoria'      
        )
        ->orderBy('producto.id','DESC')
        ->get();
        
        // $objectProductoDB = $objectProducto::whereNotNull('costo')
        // ->join('categoria_producto','producto.categoria_producto_id','=','categoria_producto.id')            
        // ->where('producto.status',1)  
        // ->select(
        //   'producto.*',
        //   'categoria_producto.categoria'      
        // )
        // ->where(isNull('medidas'))
        // ->orderBy('producto.id','DESC')
        // ->get();

        // El foreach esta procesando los resultados de la tabla de proiductos
        foreach ($objectProducto as $key => $producto) {
            /*
                *AGREGAREMOS LOS DOS NUEVOS VALORES
                *NO DISPONIBLE QUE SON APARTADOS Y FUERA DE BODEGA
                *Y DISPONIBLE RESTA ENTRE NO DISPONIBLE Y STOCK
                *ESTO ES POR POR PRODUCTO
            */
            $objectApartados = DB::table('detalle_evento')
            ->join('evento','evento.id','=','detalle_evento.evento_id')            
            ->where('evento.estatus', 3)
            ->where('detalle_evento.producto_id', $producto->id)        
            ->select('detalle_evento.*')            
            ->get();

            $cant_prod_apartado = 0;

            foreach ($objectApartados as $key => $apartado) {
                // code...
                $cant_prod_apartado += $apartado->cantidad;
            }

            $producto->cant_apartado = $cant_prod_apartado;

            $objectFueraBodega = DB::table('detalle_evento')
            ->join('evento','evento.id','=','detalle_evento.evento_id')            
            ->where('evento.estatus', 2)
            ->where('detalle_evento.producto_id', $producto->id)        
            ->select('detalle_evento.*', 'evento.fecha_entrega', 'evento.fecha_recoleccion')
            ->get();

            $cant_prod_fuera_bodega = 0;

            foreach ($objectFueraBodega as $key => $fuera_bodega) {
                // code...
                //SI LA FECHA ACTUAL ESTA ENTRE LA FECHA DEL EVENTO Y LA RECOLECCION ES QUE NO ESTAN EN BODEGA
                $mod_date = strtotime($fuera_bodega->fecha_recoleccion."+ ".$producto->dias_mantenimiento." days");
                if(self::check_in_range($fuera_bodega->fecha_entrega, $mod_date, $fecha_actual)){
                    $cant_prod_fuera_bodega += $fuera_bodega->cantidad;
                }
            }

            $producto->cant_fuera_bodega = $cant_prod_fuera_bodega;

            $producto->disponible = $producto->stock - (($cant_prod_apartado + $cant_prod_fuera_bodega) + $producto->reparacion);

        }

        $objectCategoria = CategoriaProducto::where('status',1)->orderBy('id','DESC')->get();

        echo json_encode(array(
            'status'=>true,
            'objectProducto'=>$objectProducto,
            'objectCategoria'=>$objectCategoria
        ));
    }

    /* Función */
    public function check_in_range($fecha_inicio, $fecha_fin, $fecha){

         $fecha_inicio = strtotime($fecha_inicio);
         $fecha_fin = strtotime($fecha_fin);
         $fecha = strtotime($fecha);

         if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin)) {

             return true;

         } else {

             return false;

         }
     }

    public function get_categorias(Request $request){
        $objectCategoria = CategoriaProducto::where('status',1)->orderBy('id','DESC')->get();
        echo json_encode(array(
            'status'=>true,            
            'objectCategoria'=>$objectCategoria
        ));
    }

    public function form_add_categoria(Request $request){
        $objectCategoria = new CategoriaProducto($request->all());
        $objectCategoria->save();    
        echo json_encode(array(
            'status'=>true,
            'objectCategoria'=>$objectCategoria
        ));
    }

    public function form_edit_categoria(Request $request){
        $objectCategoria = CategoriaProducto::find($request->categoriaID);
        $objectCategoria->categoria = $request->categoria;                
        $objectCategoria->save();

        echo json_encode(array(
            'status'=>true,
            'responseCategoria'=>$objectCategoria
        ));
    }

    public function delete_categoria(Request $request){
        $objectCategoria = CategoriaProducto::find($request->categoriaID);
        $objectCategoria->status = 0;        
        $objectCategoria->save();

        echo json_encode(array(
            'status'=>true,
            'responseCategoria'=>$objectCategoria
        ));
    }

    public function form_add_producto(Request $request){
        $objectProducto = new Producto($request->all());
        $objectProducto->save();
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = $objectProducto->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/productos',$name);
            $objectProducto->imagen = $name;
            $objectProducto->save();
        }
        echo json_encode(array(
            'status'=>true,
            'responseProducto'=>$objectProducto
        ));
    }

    public function categoria(){
        return view('admin.categoria.index');
    }

    public function form_edit_producto(Request $request){
        $objectProducto = Producto::find($request->productoID);
        $objectProducto->producto = $request->producto;
        $objectProducto->stock = $request->stock;
        $objectProducto->medidas = $request->medidas;
        $objectProducto->categoria_producto_id = $request->categoria_producto_id;
        $objectProducto->precio_renta = $request->precio_renta;
        $objectProducto->reparacion = $request->reparacion;
        $objectProducto->dias_mantenimiento = $request->dias_mantenimiento;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = $objectProducto->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/productos',$name);
            $objectProducto->imagen = $name;
            $objectProducto->save();
        }
        $objectProducto->precio_reposicion = $request->precio_reposicion;            
        $objectProducto->save();

        echo json_encode(array(
            'status'=>true,
            'responseProducto'=>$objectProducto
        ));
    }

    public function delete_producto(Request $request){
        $objectProducto = Producto::find($request->productoID);
        $objectProducto->status = 0;        
        $objectProducto->save();

        echo json_encode(array(
            'status'=>true,
            'responseProducto'=>$objectProducto
        ));
    }

    public function inventario(){
        //dd(date( 't' ));
        /*$objectEventosPorMes = DB::table('evento')
        ->where('YEAR(evento.fecha_evento)', 'YEAR(CURRENT_DATE())')
        ->where('MONTH(evento.fecha_evento)', 'MONTH(CURRENT_DATE())')        
        ->select('evento.*')
        ->get();*/

        $fecha = time();
        date_default_timezone_set('America/Mexico_City');
        $fecha_actual = date('Y-m-d', $fecha);
        

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

        $objectEventosPorMes = DB::SELECT(
            'SELECT e.*
            FROM evento e
            WHERE YEAR(e.fecha_evento) = YEAR(CURRENT_DATE())
            AND MONTH(e.fecha_evento) = MONTH(CURRENT_DATE())'            
        );

        foreach ($objectEventosPorMes as $key => $value) {
            $objectDetalleEvento = DB::table('detalle_evento')
            ->where('detalle_evento.evento_id', $value->id)        
            ->select('detalle_evento.*')            
            ->get();

            $value->detalle_evento = $objectDetalleEvento;            
        }
        //dd($objectEventosPorMes);
        return view('admin.inventario.index')
        ->with('objectProducto',$objectProducto)
        ->with('objectEventosPorMes',$objectEventosPorMes)
        ->with('dias_mes', date( 't' ))
        ->with('mes_actual', date('m'))
        ->with('anio_actual', date('Y'))
        ->with('fecha_actual', $fecha_actual);
    }

    public function config_productos(Request $request){
        /*

        $objectCategoriasCatalog = DB::table('categorias')       
        ->select(
          'categorias.*'
        )
        ->get();


        foreach ($objectCategoriasCatalog as $key => $value) {
            $objectCategoria = new CategoriaProducto();
            $objectCategoria->categoria = $value->nombre;
            $objectCategoria->dias_mantenimiento = $value->dias_mantenimiento;
            $objectCategoria->save();
        }

        */

        $objectProductosCatalog = DB::table('hoja1')       
        ->select(
          'hoja1.*'
        )
        ->get();


        foreach ($objectProductosCatalog as $key => $value) {
            $objectCategoriaProducto = DB::table('categoria_producto')            
            ->where('categoria_producto.categoria',$value->categoria_producto)        
            ->select(
              'categoria_producto.*'  
            )
            ->get();

            //dd($objectCategoriaProducto);

            $objectProducto = new Producto();
            $objectProducto->clave = $value->clave;
            $objectProducto->producto = $value->producto;
            $objectProducto->stock = $value->stock;
            $objectProducto->medidas = $value->medidas;
            $objectProducto->categoria_producto_id = $objectCategoriaProducto[0]->id;
            $objectProducto->precio_renta = $value->precio_renta;
            $objectProducto->reparacion = $value->reparacion;
            $objectProducto->precio_reposicion = $value->precio_reposicion;
            $objectProducto->dias_mantenimiento = $objectCategoriaProducto[0]->dias_mantenimiento;
            $objectProducto->costo = $value->costo;
            $objectProducto->save();
        }


        


        echo json_encode(array(
            'status'=>true,
            'response'=>$objectProductosCatalog,
            'procesados'=>count($objectProductosCatalog),
            //'categoria'=>$objectCategoriaProducto
        ));
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
}
