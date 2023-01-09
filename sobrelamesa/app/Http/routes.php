<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses'  => 'LoginController@index',
    'as'    =>  'login.index'
]);
Route::get('cotizacion/{url}', [
    'uses'  => 'Admin\EventoController@view_cotizacion',
    'as'    =>  'cotizacion.view_cotizacion'
]);


Route::post('confirm_firma',[
    'uses'  => 'Admin\EventoController@confirm_firma',
    'as'    => 'evento.confirm_firma'
]);
/*Route::get('/', function () {
    return view('welcome');
});*/
Route::group(['prefix' => '', 'middleware'=>'auth'], function () {
    Route::resource('inicio', 'Admin\InicioController');

    Route::resource('calendario', 'Admin\CalendarioController');

    /* RUTAS CLIENTE */
    Route::resource('cliente', 'Admin\ClienteController');
    Route::post('form_add_cliente',[
        'uses'  => 'Admin\ClienteController@form_add_cliente',
        'as'    => 'cliente.form_add_cliente'
    ]);

    Route::post('form_edit_cliente',[
        'uses'  => 'Admin\ClienteController@form_edit_cliente',
        'as'    => 'cliente.form_edit_cliente'
    ]);

    Route::post('delete_cliente',[
        'uses'  => 'Admin\ClienteController@delete_cliente',
        'as'    => 'cliente.delete_cliente'
    ]);

    Route::post('get_clientes',[
        'uses'  => 'Admin\ClienteController@get_clientes',
        'as'    => 'cliente.get_clientes'
    ]);

    Route::post('delete_cliente',[
        'uses'  => 'Admin\ClienteController@delete_cliente',
        'as'    => 'cliente.delete_cliente'
    ]);

    Route::post('get_history_events',[
        'uses'  => 'Admin\ClienteController@get_history_events',
        'as'    => 'cliente.get_history_events'
    ]);
    
    
    /* RUTAS CLIENTE */

    /* RUTAS EVENTO */
    Route::resource('evento', 'Admin\EventoController');
    Route::post('form_add_evento',[
        'uses'  => 'Admin\EventoController@form_add_evento',
        'as'    => 'evento.form_add_evento'
    ]);

    Route::post('confirm_evento',[
        'uses'  => 'Admin\EventoController@confirm_evento',
        'as'    => 'evento.confirm_evento'
    ]);

    Route::post('form_edit_evento',[
        'uses'  => 'Admin\EventoController@form_edit_evento',
        'as'    => 'evento.form_edit_evento'
    ]);

    Route::post('delete_evento',[
        'uses'  => 'Admin\EventoController@delete_evento',
        'as'    => 'evento.delete_evento'
    ]);

    Route::post('get_eventos',[
        'uses'  => 'Admin\EventoController@get_eventos',
        'as'    => 'evento.get_eventos'
    ]);

    Route::get('tipo_evento',[
        'uses'  => 'Admin\EventoController@tipo_evento',
        'as'    => 'evento.tipo_evento'
    ]);

    Route::post('get_tipos_evento',[
        'uses'  => 'Admin\EventoController@get_tipos_evento',
        'as'    => 'evento.get_tipos_evento'
    ]);
    
    Route::post('form_add_tipo_evento',[
        'uses'  => 'Admin\EventoController@form_add_tipo_evento',
        'as'    => 'evento.form_add_tipo_evento'
    ]);

    Route::post('form_edit_tipo_evento',[
        'uses'  => 'Admin\EventoController@form_edit_tipo_evento',
        'as'    => 'evento.form_edit_tipo_evento'
    ]);

    Route::post('delete_tipo_evento',[
        'uses'  => 'Admin\EventoController@delete_tipo_evento',
        'as'    => 'evento.delete_tipo_evento'
    ]);

    Route::post('get_configuration',[
        'uses'  => 'Admin\EventoController@get_configuration',
        'as'    => 'evento.get_configuration'
    ]);

    Route::get('insert_new_evento',[
        'uses'  => 'Admin\EventoController@insert_new_evento',
        'as'    => 'evento.insert_new_evento'
    ]); 


    Route::post('insert_detalle_evento',[
        'uses'  => 'Admin\EventoController@insert_detalle_evento',
        'as'    => 'evento.insert_detalle_evento'
    ]);

    Route::post('send_email_client',[
        'uses'  => 'Admin\EventoController@send_email_client',
        'as'    => 'evento.send_email_client'
    ]);

    Route::post('details_orden',[
        'uses'  => 'Admin\EventoController@details_orden',
        'as'    => 'evento.details_orden'
    ]);

    Route::post('form_add_pago',[
        'uses'  => 'Admin\EventoController@form_add_pago',
        'as'    => 'evento.form_add_pago'
    ]);

    Route::post('get_ingresos',[
        'uses'  => 'Admin\EventoController@get_ingresos',
        'as'    => 'evento.get_ingresos'
    ]);

    Route::get('ingresos',[
        'uses'  => 'Admin\EventoController@ingresos',
        'as'    => 'evento.ingresos'
    ]);


    Route::post('delete_evento',[
        'uses'  => 'Admin\EventoController@delete_evento',
        'as'    => 'evento.delete_evento'
    ]);

    Route::get('edit_evento/{url}', [
        'uses'  => 'Admin\EventoController@edit_evento',
        'as'    =>  'evento.edit_evento'
    ]); 

    Route::post('insert_detalle_evento_edit',[
        'uses'  => 'Admin\EventoController@insert_detalle_evento_edit',
        'as'    => 'evento.insert_detalle_evento_edit'
    ]);

    Route::post('imprimir_reporte_cotizacion',[
        'uses'  => 'Admin\EventoController@imprimir_reporte_cotizacion',
        'as'    => 'evento.imprimir_reporte_cotizacion'
    ]);


    Route::post('get_eventos_range_date',[
        'uses'  => 'Admin\EventoController@get_eventos_range_date',
        'as'    => 'evento.get_eventos_range_date'
    ]);

    Route::post('imprimir_reporte_remision',[
        'uses'  => 'Admin\EventoController@imprimir_reporte_remision',
        'as'    => 'evento.imprimir_reporte_remision'
    ]);

    /*Route::post('form_confirm_sobre_vender',[
        'uses'  => 'Admin\EventoController@form_confirm_sobre_vender',
        'as'    => 'evento.form_confirm_sobre_vender'
    ]);*/ 

    Route::post('details_products_autorizado',[
        'uses'  => 'Admin\EventoController@details_products_autorizado',
        'as'    => 'evento.details_products_autorizado'
    ]);

    Route::get('almacen', [
        'uses'  => 'Admin\EventoController@get_event_almacen',
        'as'    =>  'evento.get_event_almacen'
    ]); 

    Route::post('get_list_event_almacen',[
        'uses'  => 'Admin\EventoController@get_list_event_almacen',
        'as'    => 'evento.get_list_event_almacen'
    ]);   


    Route::post('confirmar_products_recibido',[
        'uses'  => 'Admin\EventoController@confirmar_products_recibido',
        'as'    => 'evento.confirmar_products_recibido'
    ]);
    
    Route::post('imprimir_reporte_faltantes',[
        'uses'  => 'Admin\EventoController@imprimir_reporte_faltantes',
        'as'    => 'evento.imprimir_reporte_faltantes'
    ]);    
    

    /* RUTAS EVENTO */

    /* RUTAS PRODUCTO */
    Route::resource('producto', 'Admin\ProductoController');
    Route::post('form_add_producto',[
        'uses'  => 'Admin\ProductoController@form_add_producto',
        'as'    => 'producto.form_add_producto'
    ]);

    Route::post('form_edit_producto',[
        'uses'  => 'Admin\ProductoController@form_edit_producto',
        'as'    => 'producto.form_edit_producto'
    ]);

    Route::post('delete_producto',[
        'uses'  => 'Admin\ProductoController@delete_producto',
        'as'    => 'producto.delete_producto'
    ]);

    Route::post('get_productos',[
        'uses'  => 'Admin\ProductoController@get_productos',
        'as'    => 'producto.get_productos'
    ]);

    Route::post('form_add_categoria',[
        'uses'  => 'Admin\ProductoController@form_add_categoria',
        'as'    => 'producto.form_add_categoria'
    ]);

    Route::post('form_edit_categoria',[
        'uses'  => 'Admin\ProductoController@form_edit_categoria',
        'as'    => 'producto.form_edit_categoria'
    ]);

    Route::post('delete_categoria',[
        'uses'  => 'Admin\ProductoController@delete_categoria',
        'as'    => 'producto.delete_categoria'
    ]);

    Route::post('get_categorias',[
        'uses'  => 'Admin\ProductoController@get_categorias',
        'as'    => 'producto.get_categorias'
    ]);

    Route::get('categoria',[
        'uses'  => 'Admin\ProductoController@categoria',
        'as'    => 'producto.categoria'
    ]);

    Route::get('inventario',[
        'uses'  => 'Admin\ProductoController@inventario',
        'as'    => 'producto.inventario'
    ]);    
    /* RUTAS PRODUCTO */

    /* RUTAS USUARIO  */
    Route::resource('usuario', 'Admin\UsuarioController');
    Route::post('form_add_personal',[
        'uses'  => 'Admin\UsuarioController@form_add_personal',
        'as'    => 'usuario.form_add_personal'
    ]);

    Route::post('form_edit_personal',[
        'uses'  => 'Admin\UsuarioController@form_edit_personal',
        'as'    => 'usuario.form_edit_personal'
    ]);

    Route::post('delete_personal',[
        'uses'  => 'Admin\UsuarioController@delete_personal',
        'as'    => 'usuario.delete_personal'
    ]);

    Route::post('get_personales',[
        'uses'  => 'Admin\UsuarioController@get_personales',
        'as'    => 'usuario.get_personales'
    ]);

    Route::post('get_personales_type',[
        'uses'  => 'Admin\UsuarioController@get_personales_type',
        'as'    => 'usuario.get_personales_type'
    ]);    
    /* RUTAS USUARIO */   

    Route::resource('lugar', 'Admin\LugarController');

    Route::post('get_lugar',[
        'uses'  => 'Admin\LugarController@get_lugar',
        'as'    => 'lugar.get_lugar'
    ]);

    Route::post('form_add_lugar',[
        'uses'  => 'Admin\LugarController@form_add_lugar',
        'as'    => 'lugar.form_add_lugar'
    ]);

    Route::post('form_edit_lugar',[
        'uses'  => 'Admin\LugarController@form_edit_lugar',
        'as'    => 'lugar.form_edit_lugar'
    ]);

    Route::post('delete_lugar',[
        'uses'  => 'Admin\LugarController@delete_lugar',
        'as'    => 'lugar.delete_lugar'
    ]);



    //Configuración
    Route::get('config_productos',[
        'uses'  => 'Admin\ProductoController@config_productos',
        'as'    => 'config.config_productos'
    ]);
    
});
// AUTENTICACIÓN DE USUARIOS
Route::post('loginUser', [
    'uses' => 'Auth\AuthController@authenticate',
    'as' => 'admin.auth.login'
]);
Route::get('logout', [
    'uses'  =>  'Auth\AuthController@getLogout',
    'as'    =>  'admin.auth.logout'
]);

