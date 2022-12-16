<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TipoEvento;
use App\Cliente;
use App\User;
use App\Evento;
use App\DetalleEvento;
use App\IngresoEvento;
use App\ProductoAutorizado;
use App\DetalleEventoContent;
use App\Producto;
use App\Lugar;
use Illuminate\Support\Facades\DB;
use Auth;

//VARIABLES PARA EL CIFRADO Y DESCIFRADO DE DATOS
define('METHOD','AES-256-CBC');
//PW: Itos Tecnología
define('SECRET_KEY','1To5!!2019*123');
//NC: Juan Alberto Esteban Pablo
define('SECRET_IV','11670059');

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.evento.index');
    }

    public function insert_new_evento(){
        return view('admin.evento.evento');
    }

    public function tipo_evento(){
        return view('admin.evento.tipo_evento');
    }

    public function get_tipos_evento(){
        $objectTipoEvento = TipoEvento::where('status',1)->orderBy('id','DESC')->get();
        echo json_encode(array(
            'status'=>true,
            'objectTipoEvento'=>$objectTipoEvento
        ));
    }

    public function form_add_tipo_evento(Request $request){
        $objectTipoEvento = new TipoEvento($request->all());
        $objectTipoEvento->save();
        echo json_encode(array(
            'status'=>true,
            'objectTipoEvento'=>$objectTipoEvento
        ));
    }

    public function form_edit_tipo_evento(Request $request){
        $objectTipoEvento = TipoEvento::find($request->tipo_evento_ID);
        $objectTipoEvento->evento = $request->evento;                
        $objectTipoEvento->save();

        echo json_encode(array(
            'status'=>true,
            'responseTipoEvento'=>$objectTipoEvento
        ));
    }

    public function delete_tipo_evento(Request $request){
        $objectTipoEvento = TipoEvento::find($request->tipo_evento_ID);
        $objectTipoEvento->status = 0;        
        $objectTipoEvento->save();

        echo json_encode(array(
            'status'=>true,
            'responseTipoEvento'=>$objectTipoEvento
        ));
    }

    public function get_configuration(){
        $objectCliente = Cliente::orderBy('nombre_completo','ASC')->get();
        $objectAgente = User::where("tipo_usuario", 3)->orderBy('name','ASC')->get();
        $objectTipoEvento = TipoEvento::orderBy('evento','ASC')->get();
        $objectProducto = DB::table('producto')
        ->join('categoria_producto','producto.categoria_producto_id','=','categoria_producto.id')            
        ->where('producto.status',1)        
        ->select(
          'producto.*',
          'categoria_producto.categoria'        
        )
     //   ->whereNotNull('medidas')
        ->whereNotNull('costo')
        ->whereNotNull('precio_reposicion')
        ->whereNotNull('precio_renta')
        ->orderBy('producto.id','DESC')
        ->get();

        $objectLugar = Lugar::where('status', 1)->get();
        echo json_encode(array(
            'status'=>true,
            'objectCliente'=>$objectCliente,
            'objectAgente'=>$objectAgente,
            'objectTipoEvento'=>$objectTipoEvento,
            'objectProducto'=>$objectProducto,
            'objectLugar'=>$objectLugar
        ));
    }

    public function form_add_evento(Request $request){
        $objectEvento = new Evento($request->all());
        $objectEvento->save();    
        echo json_encode(array(
            'status'=>true,
            'responseEvento'=>$objectEvento
        ));
    }

    public function get_eventos(){
        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('users','users.id','=','evento.agente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->where('evento.estatus','!=',0)
        ->select(
          'evento.*',
          'cliente.nombre_completo AS cliente',
          'cliente.celular1',
          'cliente.correo_electronico',
          'cliente.empresa',
          'users.name AS agente',
          'tipo_evento.evento AS evento')
        ->orderBy('evento.id', 'DESC')
        ->get();

        foreach ($objectEvento as $key => $object) {
            // code...
            $objectProductAutorizado = DB::table('producto_autorizado')            
            ->where('evento_id', $object->id)
            ->select(
              'producto_autorizado.*')
            ->get();

            if(count($objectProductAutorizado) > 0){
                $object->status_sobrevendido = true;
            }else{
                $object->status_sobrevendido = false;
            }
        }

        echo json_encode(array(
            'status'=>true,
            'objectEvento'=>$objectEvento            
        ));
    }

    public function get_eventos_range_date(Request $request){

        $from = date($request->startDate);
        $to = date($request->endDate);

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('users','users.id','=','evento.agente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->where('evento.estatus','!=',0)
        ->whereBetween('fecha_evento', [$from, $to])
        ->select(
          'evento.*',
          'cliente.nombre_completo AS cliente',
          'cliente.celular1',
          'cliente.correo_electronico',
          'cliente.empresa',
          'users.name AS agente',
          'tipo_evento.evento AS evento')
        ->get();

        foreach ($objectEvento as $key => $object) {
            // code...
            $objectProductAutorizado = DB::table('producto_autorizado')            
            ->where('evento_id', $object->id)
            ->select(
              'producto_autorizado.*')
            ->get();

            if(count($objectProductAutorizado) > 0){
                $object->status_sobrevendido = true;
            }else{
                $object->status_sobrevendido = false;
            }
        }

        echo json_encode(array(
            'status'=>true,
            'objectEvento'=>$objectEvento            
        ));

    }

    public function insert_detalle_evento(Request $request){
        //Validaremos las cabeceras y los productos        
        foreach (json_decode($request->productos) as $key => $producto) {
            if($producto->row_type == 1){            
                $objectDetalleEvento = new DetalleEvento();
                $objectDetalleEvento->producto_id = $producto->id;
                $objectDetalleEvento->cantidad = $producto->cantidad;
                $objectDetalleEvento->evento_id = $request->evento_id;
                $objectDetalleEvento->descuento = $producto->descuento;
                $objectDetalleEvento->dias = $producto->dias;
                $objectDetalleEvento->row_position = $producto->row_position;
                $objectDetalleEvento->save();
                if($producto->status_autorizado == true){
                    $objectProductoAutorizado = new ProductoAutorizado();
                    $objectProductoAutorizado->cantidad = $producto->cantidad;
                    $objectProductoAutorizado->producto_id = $producto->id;
                    $objectProductoAutorizado->agente_id = Auth::user()->id;
                    $objectProductoAutorizado->evento_id = $request->evento_id;                
                    $objectProductoAutorizado->save();
                }
            }else if($producto->row_type == 2){
                $objectDetalleEventoContent = new DetalleEventoContent();
                $objectDetalleEventoContent->content_seccion = $producto->content_seccion;
                $objectDetalleEventoContent->evento_id = $request->evento_id;
                $objectDetalleEventoContent->row_position = $producto->row_position;
                $objectDetalleEventoContent->save();
            }            
        }

        $evento_id_cifrado = self::encryption($request->evento_id);
        $short_url = 'https://sobre-la-mesa.com/cotizacion/'.$evento_id_cifrado;

        $objectEvento = Evento::find($request->evento_id);
        //$objectEvento->descuento = $request->descuento;
        $objectEvento->url_seguimiento = $short_url;
        $objectEvento->iva = $request->iva;
        $objectEvento->estatus = $request->tipo;
        $objectEvento->save();

        echo json_encode(array(
            'status'=>true,
            'short_url'=>$short_url
        ));        
    }

    public function view_cotizacion($url){
        $decryption = self::decryption($url);
        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->join('users','users.id','=','evento.agente_id')            
        ->where('evento.id',$decryption)
        ->where('users.tipo_usuario',3)     
        ->select(
          'cliente.*',
          'evento.*',
          'tipo_evento.evento',
          'users.name'      
        )        
        ->get();

        if($objectEvento[0]->forma_pago_autorizada === '1'){
            $objectEvento[0]->forma_pago = 'Muestra';
        }else if($objectEvento[0]->forma_pago_autorizada === '2'){
            $objectEvento[0]->forma_pago = 'Contra Entrega';
        }else if($objectEvento[0]->forma_pago_autorizada === '3'){
            $objectEvento[0]->forma_pago = 'Con Anticipo';
        }else if($objectEvento[0]->forma_pago_autorizada === '4'){
            $objectEvento[0]->forma_pago = 'Con Credito';
        }else if($objectEvento[0]->forma_pago_autorizada === '5'){
            $objectEvento[0]->forma_pago = 'De Contado';
        }else{
            $objectEvento[0]->forma_pago = 'No Configurada';
        }

        if($objectEvento[0]->estatus === '1'){
            $objectEvento[0]->metodo_pago = 'Cancelado';
        }else if($objectEvento[0]->estatus === '2'){
            $objectEvento[0]->metodo_pago = 'Cotizando';
        }else if($objectEvento[0]->estatus === '3'){
            $objectEvento[0]->metodo_pago = 'Pagado';
        }else if($objectEvento[0]->estatus === '4'){
            $objectEvento[0]->metodo_pago = 'Autorizado';
        }else if($objectEvento[0]->estatus === '5'){
            $objectEvento[0]->metodo_pago = 'Con Abonos';
        }else{
            $objectEvento[0]->metodo_pago = 'No Especificado';
        }


        $objectDetalleEvento = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$decryption)        
        ->select(
          'producto.*',
          'detalle_evento.*'          
        )        
        ->get();

        foreach ($objectDetalleEvento as $key => $value) {
            // code...
            $value->tipo = 1;
        }

        $objectDetalleEventoContent = DB::table('detalle_evento_content')            
        ->where('detalle_evento_content.evento_id',$decryption)        
        ->select(
          'detalle_evento_content.content_seccion',
          'detalle_evento_content.row_position'                
        )        
        ->get();

        foreach ($objectDetalleEventoContent as $key => $value) {
            // code...
            array_push($objectDetalleEvento, (object)[
                'content_seccion' => $value->content_seccion,
                'row_position' => $value->row_position,
                'tipo' => 2,
            ]);
        }

        self::array_sort_by($objectDetalleEvento, 'row_position', $order = SORT_ASC);

        $objectDetalleEvento2 = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$decryption)
        ->where('detalle_evento.descuento','!=',0)        
        ->select(
          'producto.*',
          'detalle_evento.*'          
        )        
        ->get();


        return view('public.cotizacion.index')
        ->with('objectEvento', $objectEvento)
        ->with('objectDetalleEvento', $objectDetalleEvento)
        ->with('no_cotizacion', '00'.$decryption)
        ->with('evento_id', $decryption)
        ->with('is_descuento', count($objectDetalleEvento2));
    }

    public function details_orden(Request $request){
        $objectEvento = Evento::find($request->id);
        $objectDetalleEvento = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$request->id)        
        ->select(
          'producto.*',
          'detalle_evento.id AS detalle_evento_id',
          'detalle_evento.producto_id',
          'detalle_evento.cantidad',
          'detalle_evento.evento_id',
          'detalle_evento.descuento',
          'detalle_evento.dias',
          'detalle_evento.row_position'  
        ) 
        //->orderBy('detalle_evento.id','DESC')       
        ->get();

        $objectDetalleEventoContent = DB::table('detalle_evento_content')            
        ->where('detalle_evento_content.evento_id',$request->id)        
        ->select(    
            'detalle_evento_content.id',      
          'detalle_evento_content.content_seccion',
          'detalle_evento_content.row_position'                
        )        
        ->get();

        echo json_encode(array(
            'status'=>true,
            'responseDetalleEvento'=>$objectDetalleEvento,
            'responseEvento'=>$objectEvento,
            'responseDetalleEventoContent'=>$objectDetalleEventoContent
        ));
    }

    public function send_email_client(Request $request){
        $decryption = self::decryption(str_replace('https://sobre-la-mesa.com/cotizacion/', '', $request->url_seguimiento));
        //dd($request->all());
        $destinatario = $request->correo; 
        $asunto = 'Cotizacion 00'.$decryption; 
        /*$cuerpo = ' 
        <html> 
        <head> 
        <title>Cotizacion 00'.$decryption.'</title> 
        </head> 
        <body> 
        <h1>Buen Dia</h1> 
        <p> 
        Buen día '.$request->nombre_cliente.' anexamos la siguiente cotización mediante la siguiente URL: '.$request->url_seguimiento.' 
        </p> 
        </body> 
        </html> 
        ';*/

        $cuerpo = '
        <!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: "Lato";
                font-style: normal;
                font-weight: 400;
                src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
            }

            @font-face {
                font-family: "Lato";
                font-style: normal;
                font-weight: 700;
                src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
            }

            @font-face {
                font-family: "Lato";
                font-style: italic;
                font-weight: 400;
                src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
            }

            @font-face {
                font-family: "Lato";
                font-style: italic;
                font-weight: 700;
                src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <!--<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: "Lato", Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We"re thrilled to have you here! Get ready to dive into your new account.
    </div>-->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Bienvenido!</h1> <img src=" https://sobre-la-mesa.com/images/icons/icono_logo.jpeg" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Buen día '.$request->nombre_cliente.' anexamos la siguiente cotización mediante el siguiente enlace</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><a href="'.$request->url_seguimiento.'" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">Ver Cotización</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Si eso no funciona, copie y pegue el siguiente enlace en su navegador:</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">'.$request->url_seguimiento.'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Si tiene alguna pregunta, simplemente responda a este correo electrónico; siempre estaremos encantados de ayudarle</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><br>ventas@sobrelamesa.com</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">¿Necesitas más ayuda?</h2>
                            <p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">Estamos aquí para ayudarte.</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <!--<td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"> <br>
                            <p style="margin: 0;">If these emails get annoying, please feel free to <a href="#" target="_blank" style="color: #111111; font-weight: 700;">unsubscribe</a>.</p>
                        </td>-->
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
        '; 

        //para el envío en formato HTML 
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

        //dirección del remitente 
        $headers .= "From: Sobre La Mesa <ventas@sobrelamesa.com>\r\n"; 

        //dirección de respuesta, si queremos que sea distinta que la del remitente 
        //$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

        //ruta del mensaje desde origen a destino 
        //$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

        //direcciones que recibián copia 
        //$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

        //direcciones que recibirán copia oculta 
        //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

        mail($destinatario,$asunto,$cuerpo,$headers);

        echo json_encode(array(
            'status'=>true
        ));
    }

    public function form_add_pago(Request $request){
        $objectPago = new IngresoEvento($request->all());
        $objectPago->save();
        if ($request->hasFile('comprobante')) {
            $file = $request->file('comprobante');
            $name = $objectPago->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/comprobantes',$name);
            $objectPago->comprobante = $name;
            $objectPago->save();
        }
        echo json_encode(array(
            'status'=>true,
            'responsePago'=>$objectPago
        ));
    }

    public function get_ingresos(Request $request){

        $objectIngresos = DB::table('ingreso_evento')
        ->join('evento','evento.id','=','ingreso_evento.evento_id')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('users','users.id','=','evento.agente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->select(
          'evento.*',
          'cliente.nombre_completo AS cliente',
          'cliente.celular1',
          'cliente.correo_electronico',
          'cliente.empresa',
          'users.name AS agente',
          'tipo_evento.evento AS evento',
          'ingreso_evento.*')
        ->get();

        echo json_encode(array(
            'status'=>true,
            'objectIngresos'=>$objectIngresos            
        ));

    }

    public function ingresos(){
        return view('admin.ingresos.index');
    }

    public function delete_evento(Request $request){
        $objectEvento = Evento::find($request->evento_id);
        $objectEvento->estatus = 0;
        $objectEvento->save();


        echo json_encode(array(
            'status'=>true,
            //'objectEvento'=>$objectEvento
        ));
    }

    public function confirm_evento(Request $request){
        //dd($request->all());
        //print_r($request->all());

        $objectEvento = Evento::find($request->evento_id);
        $objectEvento->estatus = 3;
        $objectEvento->save();


        echo json_encode(array(
            'status'=>true,
            //'objectEvento'=>$objectEvento
        ));






        /*$objectEvento = Evento::find($request->evento_id);

        $imgData = base64_decode(substr($request->firma,22)); 
        $image_name= $request->evento_id.'-'.time();
        // URL EN DONDE SE GUARDARA LA IMAGEN DE LA FIRMA
        $filePath = 'images/firmas/'.$image_name.'.png';
        // Write $imgData into the image file
        $file = fopen($filePath, 'wb');
        fwrite($file, $imgData);
        fclose($file); 

        $objectEvento->firma = $image_name.'.png';
        $objectEvento->estatus = 3;
        $objectEvento->save();       

        echo json_encode(array(
            'status'=>true,
            'objectEvento'=>$objectEvento
        ));*/
    }

    public function edit_evento($idCotizacion){
        //$objectEvento = Evento::find($idCotizacion);        
        return view('admin.evento.edit_evento')
        ->with('idCotizacion',$idCotizacion);
    }

    public function form_edit_evento(Request $request){
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $objectEvento = Evento::find($request->evento_id);
        $objectEvento->fecha_cotizacion = $request->fecha_cotizacion;
        $objectEvento->cliente_id = $request->cliente_id;
        $objectEvento->agente_id = $request->agente_id;
        $objectEvento->tipo_evento = $request->tipo_evento;
        $objectEvento->no_personas = $request->no_personas;
        $objectEvento->domicilio_entrega = $request->domicilio_entrega;
        $objectEvento->fecha_evento = $request->fecha_evento;
        $objectEvento->hora_evento = $request->hora_evento;
        $objectEvento->fecha_entrega = $request->fecha_entrega;  
        $objectEvento->hora_entrega = $request->hora_entrega;  
        $objectEvento->fecha_recoleccion = $request->fecha_recoleccion;  
        $objectEvento->hora_recoleccion = $request->hora_recoleccion;  
        $objectEvento->flete = $request->flete;
        $objectEvento->montaje = $request->montaje;
        $objectEvento->lavado_desinfeccion = $request->lavado_desinfeccion;      
        $objectEvento->save();

        echo json_encode(array(
            'status'=>true,
            'responseEvento'=>$objectEvento
        ));
        $out->writeln("Función accedida");
        
    }

    public function insert_detalle_evento_edit(Request $request){
        //dd($request->all());

        //Consultar las que estan registradas
        /*$objectDetalleEvento = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$request->id)        
        ->select(
          'producto.*',
          'detalle_evento.*'         
        )        
        ->get();*/

        foreach (json_decode($request->productos_eliminados)  as $key => $producto) {            
            DB::table('detalle_evento')->where('id', $producto)->delete();
        }

        foreach (json_decode($request->productos_eliminados_content)  as $key => $producto) {            
            DB::table('detalle_evento_content')->where('id', $producto)->delete();
        }

        foreach (json_decode($request->productos) as $key => $producto) {            
            if($producto->tipo == 1){
                if($producto->row_type == 1){
                    $objectDetalleEvento = new DetalleEvento();
                    $objectDetalleEvento->producto_id = $producto->id;
                    $objectDetalleEvento->cantidad = $producto->cantidad;
                    $objectDetalleEvento->evento_id = $request->evento_id;
                    $objectDetalleEvento->descuento = $producto->descuento;
                    $objectDetalleEvento->dias = $producto->dias;
                    $objectDetalleEvento->row_position = $producto->row_position;
                    $objectDetalleEvento->save();
                    if($producto->status_autorizado == true){
                        $objectProductoAutorizado = new ProductoAutorizado();
                        $objectProductoAutorizado->cantidad = $producto->cantidad;
                        $objectProductoAutorizado->producto_id = $producto->id;
                        $objectProductoAutorizado->agente_id = Auth::user()->id;
                        $objectProductoAutorizado->evento_id = $request->evento_id;                
                        $objectProductoAutorizado->save();
                    }
                }else if($producto->row_type == 2){
                    $objectDetalleEventoContent = new DetalleEventoContent();
                    $objectDetalleEventoContent->content_seccion = $producto->content_seccion;
                    $objectDetalleEventoContent->evento_id = $request->evento_id;
                    $objectDetalleEventoContent->row_position = $producto->row_position;
                    $objectDetalleEventoContent->save();
                }
            }else if($producto->tipo == 2){
                if($producto->row_type == 1){
                    $objectDetalleEvento = DetalleEvento::find($producto->detalle_id);
                    $objectDetalleEvento->producto_id = $producto->id;
                    $objectDetalleEvento->cantidad = $producto->cantidad;
                    $objectDetalleEvento->evento_id = $request->evento_id;
                    $objectDetalleEvento->descuento = $producto->descuento;
                    $objectDetalleEvento->dias = $producto->dias;
                    $objectDetalleEvento->row_position = $producto->row_position;
                    $objectDetalleEvento->save();
                    if($producto->status_autorizado == true){
                        $objectProductoAutorizado = new ProductoAutorizado();
                        $objectProductoAutorizado->cantidad = $producto->cantidad;
                        $objectProductoAutorizado->producto_id = $producto->id;
                        $objectProductoAutorizado->agente_id = Auth::user()->id;
                        $objectProductoAutorizado->evento_id = $request->evento_id;                
                        $objectProductoAutorizado->save();
                    }
                }else if($producto->row_type == 2){
                    $objectDetalleEventoContent = DetalleEventoContent::find($producto->detalle_id);
                    $objectDetalleEventoContent->content_seccion = $producto->content_seccion;
                    $objectDetalleEventoContent->evento_id = $request->evento_id;
                    $objectDetalleEventoContent->row_position = $producto->row_position;
                    $objectDetalleEventoContent->save();
                }
            }
        }

        $evento_id_cifrado = self::encryption($request->evento_id);
        $short_url = 'https://sobre-la-mesa.com/cotizacion/'.$evento_id_cifrado;

        $objectEvento = Evento::find($request->evento_id);
        //$objectEvento->descuento = $request->descuento;
        $objectEvento->url_seguimiento = $short_url;
        $objectEvento->iva = $request->iva;
        $objectEvento->estatus = $request->tipo;
        $objectEvento->save();

        echo json_encode(array(
            'status'=>true,
            'short_url'=>$short_url
        )); 

    }

    public function imprimir_reporte_cotizacion(Request $request){

        //dd($request->all());
        //$data['evento_id'] = $request->evento_id_reporte;

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->join('users','users.id','=','evento.agente_id')
        ->where('evento.id',$request->evento_id_reporte)
        ->where('users.tipo_usuario',3)        
        ->select(
          'cliente.*',
          'evento.*',
          'tipo_evento.evento',
          'users.name'
        )        
        ->get();

        //dd($objectEvento[0]->forma_pago_autorizada);

        if($objectEvento[0]->forma_pago_autorizada === '1'){
            $objectEvento[0]->forma_pago = 'Muestra';
        }else if($objectEvento[0]->forma_pago_autorizada === '2'){
            $objectEvento[0]->forma_pago = 'Contra Entrega';
        }else if($objectEvento[0]->forma_pago_autorizada === '3'){
            $objectEvento[0]->forma_pago = 'Con Anticipo';
        }else if($objectEvento[0]->forma_pago_autorizada === '4'){
            $objectEvento[0]->forma_pago = 'Con Credito';
        }else if($objectEvento[0]->forma_pago_autorizada === '5'){
            $objectEvento[0]->forma_pago = 'De Contado';
        }else{
            $objectEvento[0]->forma_pago = 'No Configurada';
        }

        if($objectEvento[0]->estatus === '1'){
            $objectEvento[0]->metodo_pago = 'Cancelado';
        }else if($objectEvento[0]->estatus === '2'){
            $objectEvento[0]->metodo_pago = 'Cotizando';
        }else if($objectEvento[0]->estatus === '3'){
            $objectEvento[0]->metodo_pago = 'Pagado';
        }else if($objectEvento[0]->estatus === '4'){
            $objectEvento[0]->metodo_pago = 'Autorizado';
        }else if($objectEvento[0]->estatus === '5'){
            $objectEvento[0]->metodo_pago = 'Con Abonos';
        }else{
            $objectEvento[0]->metodo_pago = 'No Especificado';
        }

        $objectDetalleEvento = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$request->evento_id_reporte)        
        ->select(
          'producto.*',
          'detalle_evento.*'          
        )        
        ->get();

        foreach ($objectDetalleEvento as $key => $value) {
            // code...
            $value->tipo = 1;
        }

        $objectDetalleEvento2 = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$request->evento_id_reporte)
        ->where('detalle_evento.descuento','!=',0)        
        ->select(
          'producto.*',
          'detalle_evento.*'          
        )        
        ->get();

        $objectDetalleEventoContent = DB::table('detalle_evento_content')            
        ->where('detalle_evento_content.evento_id',$request->evento_id_reporte)        
        ->select(
          'detalle_evento_content.content_seccion',
          'detalle_evento_content.row_position'                
        )        
        ->get();

        foreach ($objectDetalleEventoContent as $key => $value) {
            // code...
            array_push($objectDetalleEvento, (object)[
                'content_seccion' => $value->content_seccion,
                'row_position' => $value->row_position,
                'tipo' => 2,
            ]);
        }

        /*usort($objectDetalleEvento, function( array $elem1, $elem2 ) {
            return $elem1['row_position'] <=> $elem2['row_position'];
        });*/

        self::array_sort_by($objectDetalleEvento, 'row_position', $order = SORT_ASC);

        //dd($objectDetalleEvento);

        $data['objectEvento'] = $objectEvento;
        $data['objectDetalleEvento'] = $objectDetalleEvento;
        $data['no_cotizacion'] = '00'.$request->evento_id_reporte;
        $data['evento_id'] = $request->evento_id_reporte;
        $data['is_descuento'] = count($objectDetalleEvento2);
        $data['objectDetalleEventoContent'] = $objectDetalleEventoContent;

        $view =  \View::make('admin.reportes.cotizacion', compact('data'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //return $pdf->download('Carta-Responsiva-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('Cotización-'.$request->evento_id_reporte.'.pdf');

    }

    function array_sort_by(&$arrIni, $col, $order = SORT_ASC){
        $arrAux = array();
        foreach ($arrIni as $key=> $row)
        {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux, $order, $arrIni);
    }

    public function imprimir_reporte_remision(Request $request){

        //$data['evento_id'] = $request->evento_id_reporte;

        /*$objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')            
        ->where('evento.id',$request->evento_id_reporte)        
        ->select(
          'cliente.*',
          'evento.*'       
        )
        ->get();   */

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->join('users','users.id','=','evento.agente_id')
        ->where('evento.id',$request->evento_id_reporte)
        ->where('users.tipo_usuario',3)        
        ->select(
          'cliente.*',
          'evento.*',
          'tipo_evento.evento',
          'users.name'
        )        
        ->get();

        //dd($objectEvento[0]->forma_pago_autorizada);

        if($objectEvento[0]->forma_pago_autorizada === '1'){
            $objectEvento[0]->forma_pago = 'Muestra';
        }else if($objectEvento[0]->forma_pago_autorizada === '2'){
            $objectEvento[0]->forma_pago = 'Contra Entrega';
        }else if($objectEvento[0]->forma_pago_autorizada === '3'){
            $objectEvento[0]->forma_pago = 'Con Anticipo';
        }else if($objectEvento[0]->forma_pago_autorizada === '4'){
            $objectEvento[0]->forma_pago = 'Con Credito';
        }else if($objectEvento[0]->forma_pago_autorizada === '5'){
            $objectEvento[0]->forma_pago = 'De Contado';
        }else{
            $objectEvento[0]->forma_pago = 'No Configurada';
        }

        if($objectEvento[0]->estatus === '1'){
            $objectEvento[0]->metodo_pago = 'Cancelado';
        }else if($objectEvento[0]->estatus === '2'){
            $objectEvento[0]->metodo_pago = 'Cotizando';
        }else if($objectEvento[0]->estatus === '3'){
            $objectEvento[0]->metodo_pago = 'Pagado';
        }else if($objectEvento[0]->estatus === '4'){
            $objectEvento[0]->metodo_pago = 'Autorizado';
        }else if($objectEvento[0]->estatus === '5'){
            $objectEvento[0]->metodo_pago = 'Con Abonos';
        }else{
            $objectEvento[0]->metodo_pago = 'No Especificado';
        }      

        $objectDetalleEvento = DB::table('detalle_evento')
        ->join('producto','producto.id','=','detalle_evento.producto_id')            
        ->where('detalle_evento.evento_id',$request->evento_id_reporte)        
        ->select(
          'producto.*',
          'detalle_evento.*'          
        )        
        ->get();

        foreach ($objectDetalleEvento as $key => $value) {
            // code...
            $value->tipo = 1;
        }

        $objectDetalleEventoContent = DB::table('detalle_evento_content')            
        ->where('detalle_evento_content.evento_id',$request->evento_id_reporte)        
        ->select(
          'detalle_evento_content.content_seccion',
          'detalle_evento_content.row_position'                
        )        
        ->get();

        foreach ($objectDetalleEventoContent as $key => $value) {
            // code...
            array_push($objectDetalleEvento, (object)[
                'content_seccion' => $value->content_seccion,
                'row_position' => $value->row_position,
                'tipo' => 2,
            ]);
        }

        self::array_sort_by($objectDetalleEvento, 'row_position', $order = SORT_ASC);

        $data['objectEvento'] = $objectEvento;
        $data['objectDetalleEvento'] = $objectDetalleEvento;
        $data['no_cotizacion'] = '00'.$request->evento_id_reporte;
        $data['evento_id'] = $request->evento_id_reporte;

        $view =  \View::make('admin.reportes.remision', compact('data'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //return $pdf->download('Carta-Responsiva-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('Remisión-'.$request->evento_id_reporte.'.pdf');

    }

    public function details_products_autorizado(Request $request){
            // code...
        $objectProductAutorizado = DB::table('producto_autorizado')
        ->join('producto', 'producto.id', '=', 'producto_autorizado.evento_id')            
        ->where('producto_autorizado.evento_id', $request->id)
        ->select(
          'producto_autorizado.*',
          'producto.clave',
          'producto.producto',
          'producto.id AS producto_id')
        ->get();

        echo json_encode(array(
            'status'=>true,
            'objectProductAutorizado'=>$objectProductAutorizado            
        ));

    }

    public function get_event_almacen(){
        return view('admin.almacen.index');
    }

    public function get_list_event_almacen(Request $request){

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('users','users.id','=','evento.agente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->where('fecha_recoleccion', '<', date("Y-m-d"))
        //->where('status_recibido', '=', 0)
        ->select(
          'evento.*',
          'cliente.nombre_completo AS cliente',
          'cliente.celular1',
          'cliente.correo_electronico',
          'cliente.empresa',
          'users.name AS agente',
          'tipo_evento.evento AS evento')
        ->orderBy('evento.id','DESC')
        ->get();

        echo json_encode(array(
            'status'=>true,
            'objectEvento'=>$objectEvento            
        ));
        
    }

    public function confirmar_products_recibido(Request $request){

        foreach (json_decode($request->list_cant_recibida) as $key => $product_cant) {
            // code...
            $objectdDetalleEvento = DetalleEvento::find($product_cant->detalle_evento_id);
            $objectdDetalleEvento->cantidad_recibida = $product_cant->cantidad_recibida;
            $objectdDetalleEvento->save();
        }

        $objectEvento = DB::select('SELECT * FROM `detalle_evento` where cantidad_recibida < cantidad and evento_id = '.$request->id); /*6DB::table('detalle_evento')        
        //->where('detalle_evento.cantidad_recibida', '<', 'detalle_evento.cantidad')
        ->where('detalle_evento.evento_id', '=', $request->id)
        ->where('detalle_evento.cantidad_recibida', '<', 'detalle_evento.cantidad')
        ->select(
          'detalle_evento.*')
        ->get(); */

        //dd($objectEvento);   

        if(count($objectEvento) > 0){

            foreach ($objectEvento as $key => $value) {
                $cant_perdida = $value->cantidad - $value->cantidad_recibida;
                $objectProducto = Producto::find($value->producto_id);
                $objectProducto->stock = $objectProducto->stock - $cant_perdida;
                $objectProducto->save();
            }

            $objectdEvento = Evento::find($request->id);
            $objectdEvento->status_recibido = 1;
            $objectdEvento->save();
            echo json_encode(array(
                'status'=>true        
            ));

            
        }else{

            $objectdEvento = Evento::find($request->id);
            $objectdEvento->status_recibido = 2;
            $objectdEvento->save();
            echo json_encode(array(
                'status'=>true          
            ));
            
        }
    }

    public function imprimir_reporte_faltantes(Request $request){

        /*$objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')            
        ->where('evento.id',$request->evento_id_reporte)        
        ->select(
          'cliente.*',
          'evento.*'       
        )
        ->get();*/

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->join('users','users.id','=','evento.agente_id')
        ->where('evento.id',$request->evento_id_reporte)
        ->where('users.tipo_usuario',3)        
        ->select(
          'cliente.*',
          'evento.*',
          'tipo_evento.evento',
          'users.name'
        )        
        ->get();

        //dd($objectEvento[0]->forma_pago_autorizada);

        if($objectEvento[0]->forma_pago_autorizada === '1'){
            $objectEvento[0]->forma_pago = 'Muestra';
        }else if($objectEvento[0]->forma_pago_autorizada === '2'){
            $objectEvento[0]->forma_pago = 'Contra Entrega';
        }else if($objectEvento[0]->forma_pago_autorizada === '3'){
            $objectEvento[0]->forma_pago = 'Con Anticipo';
        }else if($objectEvento[0]->forma_pago_autorizada === '4'){
            $objectEvento[0]->forma_pago = 'Con Credito';
        }else if($objectEvento[0]->forma_pago_autorizada === '5'){
            $objectEvento[0]->forma_pago = 'De Contado';
        }else{
            $objectEvento[0]->forma_pago = 'No Configurada';
        }

        if($objectEvento[0]->estatus === '1'){
            $objectEvento[0]->metodo_pago = 'Cancelado';
        }else if($objectEvento[0]->estatus === '2'){
            $objectEvento[0]->metodo_pago = 'Cotizando';
        }else if($objectEvento[0]->estatus === '3'){
            $objectEvento[0]->metodo_pago = 'Pagado';
        }else if($objectEvento[0]->estatus === '4'){
            $objectEvento[0]->metodo_pago = 'Autorizado';
        }else if($objectEvento[0]->estatus === '5'){
            $objectEvento[0]->metodo_pago = 'Con Abonos';
        }else{
            $objectEvento[0]->metodo_pago = 'No Especificado';
        } 


        $objectDetalleEvento = DB::select('SELECT p.*, d.* FROM detalle_evento d JOIN producto p ON p.id = d.producto_id where cantidad_recibida < cantidad and evento_id = '.$request->evento_id_reporte);

        foreach ($objectDetalleEvento as $key => $value) {
            // code...
            $value->tipo = 1;
        }

        $objectDetalleEventoContent = DB::table('detalle_evento_content')            
        ->where('detalle_evento_content.evento_id',$request->evento_id_reporte)        
        ->select(
          'detalle_evento_content.content_seccion',
          'detalle_evento_content.row_position'                
        )        
        ->get();

        foreach ($objectDetalleEventoContent as $key => $value) {
            // code...
            array_push($objectDetalleEvento, (object)[
                'content_seccion' => $value->content_seccion,
                'row_position' => $value->row_position,
                'tipo' => 2,
            ]);
        }

        self::array_sort_by($objectDetalleEvento, 'row_position', $order = SORT_ASC);

        $data['objectEvento'] = $objectEvento;
        $data['objectDetalleEvento'] = $objectDetalleEvento;
        $data['no_cotizacion'] = '00'.$request->evento_id_reporte;
        $data['evento_id'] = $request->evento_id_reporte;

        $view =  \View::make('admin.reportes.faltantes', compact('data'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //return $pdf->download('Carta-Responsiva-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('Faltantes-'.$request->evento_id_reporte.'.pdf');

    }

    public function encryption($string){
      $output=FALSE;
      $key=hash('sha256', SECRET_KEY);
      $iv=substr(hash('sha256', SECRET_IV), 0, 16);
      $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
      $output=base64_encode($output);
      return $output;
    }

    public function encryption4($string){
      $output=FALSE;
      $key=hash('sha256', SECRET_KEY);
      $iv=substr(hash('sha256', SECRET_IV), 0, 4);
      $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
      $output=base64_encode($output);
      return $output;
    }

    public function decryption($string){
      $key=hash('sha256', SECRET_KEY);
      $iv=substr(hash('sha256', SECRET_IV), 0, 16);
      $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
      return $output;
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
