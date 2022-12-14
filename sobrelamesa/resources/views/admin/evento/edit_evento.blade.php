@extends('admin.template.main')

@section('title','Sobre La Mesa | Editar Evento')

@section('css')
<style>
    .main-footer{
        display: none;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
           
        margin-left: 4.6rem;
        padding: 10px 20px;
    }
    .btn-span{
        border: 0px;
        background-color: transparent;
    }
    .btn-span>img{
        width: 37px;
    }
    .btn-span>b{
        font-size: 13px;
    }

    .table tbody tr.highlight td {
        background-color: #ddd;
    }
    #tbl_inventario>tbody tr td p{
        margin-bottom: 0px !important;
    }
    #cantidad_add_venta{
        height: 70px !important;
        font-size: 60px;
        font-weight: bold;
        text-align: center;
    }
    div.scroll_horizontal {
        width: 400px;
        overflow: auto;
        border: 1px solid #666;
        background-color: #ccc;
        padding: 8px;
    }
    div.scroll_vertical {
        height: 114px;
        width: 114px;
        overflow: auto;
        border: 1px solid #666;
        background-color: #ccc;
        padding: 8px;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: 850px;
    }
    .precio_publico, .total_prod{
        background-color: #EDF9FE;
        background-color: #F8F9DA;

        text-align:right;
        padding-right:0.5em !important;
    }
    .desc_producto {
        background-color: #FEFDF2;  /* #F8F9DA; #F9EAFE */
        padding-left:0.6em !important;
        min-width:300px;
    }
    .la_nota {
        background-color: #fdfdfd;
        color:#878059;
        padding-left:0.6em !important;
        font-size:1.15em;
    }
    .cerocero {
        opacity:0.2;
    }
    .stockDisp {
        width:70px;
        font-size:1em;
        text-align:center;
        border:0px;
        color:#878059;
        opacity:0.75;
        background-color: transparent;
    }
    #elEvento {
        width:80px;
        border:0px;
        font-size:1.2em;
        color:gray;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
<div class="modal fade" id="modal_inventario" tabindex="-1" role="dialog" style="overflow-y:auto;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbl_inventario" class="table table-bordered table-striped table-sm" style="width: 100%;">
                    <thead >
                        <tr>                            
                            <th>KEY</th>
                            <th>CLAVE</th>
                            <th>PRODUCTO</th>
                            <th>STOCK</th>
                            <th>MEDIDAS</th>
                            <th>CATEGOR??A</th>
                            <th>PRECIO RENTA</th>
                            <th>PRECIO REPOSICION</th>
                            <th>IMAGEN</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_enviar_url" tabindex="-1" role="dialog" style="overflow-y:auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar Cotizaci??n</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name">URL de Cotizaci??n</label>
                            <input type="text" class="form-control" name="lbl_url_seguimiento" id="lbl_url_seguimiento" autofocus="autofocus">
                        </div>
                    </div>                                       
                    <a onclick="compartir_correo()" class="btn btn-app elevation-1" style="padding: 10px 10px 60px 10px;">
                        <i><img src="https://img.icons8.com/office/40/000000/send-mass-email.png" style="margin: 5px; margin-right: 5px;" /></i> Enviar por Correo                    
                    </a>

                    <a onclick="compartir_whatsapp()" class="btn btn-app elevation-1" style="padding: 10px 10px 60px 10px;">
                        <i><img src="https://img.icons8.com/office/40/000000/whatsapp--v1.png" style="margin: 5px; margin-right: 5px;" /></i> Enviar por WhatsApp                    
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_confirm_sobre_vender" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal">Se requiere contrase??a para sobre vender este producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_confirm_sobre_vender">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Contrase??a</label>
                                <input type="password" class="form-control" name="contrasena" id="contrasena">
                            </div>
                        </div>                    
                    </div>
                </div>
                <input type="hidden" name="key" id="key">                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onmouseup="cancel_over();">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal">Autorizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <form id="form_edit_evento">

                        <div id="idCard" class="card">
                            <div class="card-header border-transparent">
                                <h3 id="lbl_title" class="card-title">Datos del Evento a Editar</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>                    
                                </div>
                            </div>        
                            <div class="card-body p-0">
                                <div class="row" style="margin: 10px;">
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    {{-- @if (empty($fecha_cotizacion)) --}}
                                    @if (isset($fecha_cotizacion))
                                    <div class="form-group">
                                      <label for="name">Fecha Cotizaci??n </label>
                                      <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" disabled />
                                  </div>
                                    @else
                                    <div class="form-group">
                                      <label for="name">Fecha de Actualizaci??n de la Cotizaci??n </label>
                                      <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" value="fecha_cotizacion"  />
                                  </div>
                                    @endif
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Cliente</label>
                                        <!--<input type="text" class="form-control" name="cliente_id" id="cliente_id">-->
                                        <select class="form-control form-control-sm form-reg-paso1 " id="select_cliente_id" name="cliente_id" required="required">                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Agente</label>
                                        <!--<input type="text" class="form-control" name="agente_id" id="aggente_id">-->
                                        <select class="form-control form-control-sm form-reg-paso1 " id="select_agente_id" name="agente_id" required="required">                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Tipo Evento</label>
                                        <!--<input type="text" class="form-control" name="tipo_evento" id="tipo_evento">-->
                                        <select class="form-control form-control-sm form-reg-paso1 " id="select_tipo_evento" name="tipo_evento" required="required">                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">N??mero Personas</label>
                                        <input type="text" class="form-control" name="no_personas" id="no_personas" autofocus="autofocus">
                                    </div>
                                </div>

                                <!--<div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Domicilio Entrega</label>
                                        <input type="text" class="form-control" name="domicilio_entrega" id="domicilio_entrega">
                                    </div>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Domicilio Entrega</label>
                                        <select class="form-control form-control-sm form-reg-paso1 " id="select_domicilio_entrega" name="domicilio_entrega_2" required="required" onchange="onChangeDomicilio()">                                            
                                        </select>
                                        <input type="text" class="form-control" name="domicilio_entrega" id="domicilio_entrega" style="display: none;">
                                    </div>
                                </div>

                                <!--<div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">IVA</label>
                                        <input type="text" class="form-control" name="iva" id="iva">
                                    </div>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Fecha Evento</label>
                                        
                                        <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" />
                                        <input type="time" class="form-control" id="hora_evento" name="hora_evento" >
                                    </div>
                                    <!--<div class="form-group">
                                      <label>Date and time:</label>
                                      <!--<input type="datetime-local" id="birthdaytime" name="birthdaytime">-->
                                      <!--<div class="input-group date" id="fecha_evento" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#fecha_evento" name="fecha_evento"/>
                                        <div class="input-group-append" data-target="#fecha_evento" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>-->

                                <!--</div>-->
                            </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Fecha Entrega</label>
                                        <!--<input type="text" class="form-control" name="fecha_entrega" id="fecha_entrega">-->
                                        <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" />
                                        <input type="time" class="form-control" id="hora_entrega" name="hora_entrega" >
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Fecha Recolecci??n</label>
                                        <!--<input type="text" class="form-control" name="fecha_recoleccion" id="fecha_recoleccion">-->
                                        <input type="date" class="form-control" id="fecha_recoleccion" name="fecha_recoleccion" />
                                        <input type="time" class="form-control" id="hora_recoleccion" name="hora_recoleccion" >
                                    </div>
                                </div>
                                

                                <div class="col-xs-12 col-sm-6 col-md-4" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Flete</label>
                                        <input type="text" class="form-control" name="flete" id="flete" value="0">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Montaje</label>
                                        <input type="text" class="form-control" name="montaje" id="montaje" value="0">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Lavado Desinfecci??n</label>
                                        <input type="text" class="form-control" name="lavado_desinfeccion" id="lavado_desinfeccion" value="0">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer clearfix">                
                                <!--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Registrar</a>-->
                                <button type="submit" class="btn btn-success float-right btn-sm" id="btn_add_evento">Guardar</button>
                            </div>
                            </div>                       
                        </div>
                    </form>
                </div>
                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                                      <button class="btn btn-default" style="border-radius: 0px;width:100%;color: blue;" id="btn_modal_inventario" onclick="modal_inventario()"><!--<img src="{{asset('icons/icon-search.png')}}" style="width: 18px;" />--><img src="https://img.icons8.com/offices/20/000000/search.png" /> Productos (F2)</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-5 col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text"><!--<img src="{{asset('icons/icon-ticket.png')}}" style="width: 21px;" />-->
                                                    <img src="https://img.icons8.com/color/20/000000/split-transaction.png" />
                                                </div>
                                            </div>
                                            <select class="form-control select2bs4" name="" id="select_tipo_venta" style="">
                                                <option value="1">COTIZACION</option>
                                                <option value="2">VENTA DIRECTA</option>
                                                <option value="3">NOTA DE P??RDIDA</option>
                                            </select>
                                        </div>
                                    </div>

                                    

                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3" style="margin-top: 8px;">
                                      <span><!-- style="padding: 2px 2px;background-color: #f1f1f1;width: 200px;text-align: center;border: 1px #d8d9e2 solid; font-size: 16px; height: 50px;" --><!--<img src="{{asset('icons/icon-date.png')}}" alt="FOLIO-IMG" style="width: 25px;">--><img src="https://img.icons8.com/office/20/000000/calendar--v1.png"/> <b id="folio_"></b></span>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3" style="margin-top: 8px;">
                                      <button class="btn btn-success btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar Nota o Secci??n</button>

                                          <!--<button class="btn btn-primary btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar Nota </button>-->
                                  </div>

                                    <input type="hidden" name="evento_id" id="evento_id">

                                    <!--<div class="col-xs-12 col-sm-6 col-md-8 col-lg-5">
                                      <br>
                                      
                                    </div>-->
                                </div>
                            </div>
                            <div id="testDiv" style="width:100%; border:1px dashed red; padding:2em; display:none">
                            </div>
                            <div class="card-body">  
                                <div class="row">                
                                    <table class="table table-hover table-sm" id="tbl_venta_productos">
                                        <thead>
                                            <tr style="background-color: #d8d9e2;">
                                                <th scope="col"></th>
                                                <th scope="col">Disp</th>
                                                <th scope="col">Cantidad</th>
                                                <!--<th scope="col">Clave</th>-->
                                                <th scope="col">Descripci??n</th>
                                                <th scope="col" style="text-align:right">Precio Unit.</th>
                                                <th scope="col">D??as</th>
                                                <th scope="col">% Desc</th>
                                                <th scope="col" style="text-align:right">Total</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="todo-list" id="tbl_venta">
                                            <tr id="row-0">
                                                <td><span class="handle">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </span></td>
                                              <td style="width: 70px;"><input  type="number" id="stock_dia" class="form-control form-control-sm focusNext"  value="stock_dia" style="width:70px;"></td>
                                                <td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" value="0" min="0" style="width:70px;"></td>
                                                <!--<td style="width: 200px;"><div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                        <input tabindex="2" type="text" class="form-control form-control-sm focusNext" style="width: 100%">
                                                        
                                                    </div>--><!--<div class="input-group-prepend">
                                                            <div class="input-group-text"><img src="https://img.icons8.com/material/20/000000/question-mark--v1.png"/></div>
                                                          </div><input tabindex="2" type="text" class="form-control form-control-sm focusNext" style="width: 100%"></td>-->
                                                <td style="background-color: #f1f3b7; opacity: .5;"></td>
                                                <td style="background-color: #b7f3b7; opacity: .5;"></td>
                                                <td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>
                                                <td style="width: 100px;"><input tabindex="3" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>
                                                <td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>
                                                <td><!--button class="btn btn-danger btn-sm" onclick="btn_eliminar(0)"><i class="fa fa-trash"></i></button--></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_flete" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; display: none; color: black;"></button>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_montaje" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; display: none; color: black;"></button>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_lavado" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; display: none; color: black;"></button>
                        </div>
                        <!--<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" style="width: 100px;" class="form-control" name="descuento" id="descuento" placeholder="%" onchange="change_descuento()">                                        
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <input type="checkbox" id="myCheck" onclick="myFunction()"> IVA
                                </div>
                            </div>                          
                        </div>-->
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                          <span class="btn btn-lg" style="width: 100%; font-size: 23px; border-radius: 0px; font-weight: bold; padding: 4px 2px;cursor: no-drop;" id="total_venta" total="0">$ 0.00</span>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                            <button class="btn btn-lg btn-info" style="border-radius: 0px;" onclick="efectuar_pago()" id="btn_pagar">F12 Guardar <!--<img src="{{asset('icons/icon-dollar.png')}}" alt="Icon x" style="width: 23px">--></button>
                        </div>
                    </div>
                         
            </div><!-- mayor -->                    
        </div>
    </section>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $('#menu_evento').attr('class','nav-link active');
    $('#fa fa-checko').attr('class','fa fa-check');
    var status_modal_inventario = 0;
    var focus_refaccion_id = 0;
    var status_modal = 0;
    var focus_key = null;
    var temp_row_index = null;
    var temp_row = null;
    var list_productos = [];
    var list_venta = [];
    var list_seleccionados = [];    
    var status_modal_cantidad = 0;
    var total_venta_global = 0;
    var list_clientes = [];
    var config_iva = 3;
    var resta_global = 0;
    var resta_iva_global  = 0;
    var list_eliminados = [];
    var list_eliminados_content = [];
    var list_seccions = [];
    var ban = false;
    var pos_list_venta = 0;
    var isEdit = false;
    var temp_cantidad = 0;
    var comparator_ava = false;
    var llave;
    


    function Fecha_de_Cotizacion(params) {
        var fechaW = date(); 
    var fechacoti = fechaW.getFullYear() + "-" + (fechaW.getMonth() + 1) + "-" + fechaW.getDate();
    return fechacoti;  
    }
   

    var tbl_inventario = $('#tbl_inventario').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "order": [[ 0, "asc" ]],
        "columnDefs": [
            {
              "targets": [0,0],
              "visible": false,
              "searchable": false
            }
        ]
    });

    $(document).ready(function () {
        console.log('document ready');
        get_config();
        $('#datetimepicker1').datetimepicker();
        $('#fecha_evento').datetimepicker({ icons: { time: 'far fa-clock' } });        
    });

    function get_config(){
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        $.ajax({
            method: 'POST',
            url: "{{route('evento.get_configuration')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response) {
                if(response.status){

                    $('#select_cliente_id').empty();
                    $.each( response.objectCliente, function( key, cliente ) {
                    list_clientes.push(cliente);
                        $('#select_cliente_id').append(
                            '<option value="'+cliente.id+'">'+cliente.nombre_completo+'</option>'
                        );
                    });
                                        

                    $('#select_agente_id').empty();
                    $.each( response.objectAgente, function( key, agente ) {                        
                        $('#select_agente_id').append(
                            '<option value="'+agente.id+'">'+agente.name+'</option>'
                        );
                    });

                    $('#select_tipo_evento').empty();
                    $.each( response.objectTipoEvento, function( key, tipoEvento ) {                        
                        $('#select_tipo_evento').append(
                            '<option value="'+tipoEvento.id+'">'+tipoEvento.evento+'</option>'
                        );
                    });

                    $('#select_domicilio_entrega').empty();
                    $.each( response.objectLugar, function( key, lugar ) {                     
                        $('#select_domicilio_entrega').append(
                            '<option value="'+lugar.id+'">'+lugar.direccion+' ('+lugar.nombre+')</option>'
                        );
                    });

                    $('#select_domicilio_entrega').append(
                        '<option value="99998">Domicilio Particular</option>'
                    );

                    $('#select_domicilio_entrega').append(
                        '<option value="99999">Bodega de SML</option>'
                    );

                    $('#btn_modal_inventario').text("Consultando Productos...");
                    tbl_inventario.clear().draw();
                    var datos = [];
                    $.each(response.objectProducto, function (key, producto) {                   
                        list_productos.push(producto);
                        datos.push(                         
                            key,
                            producto.clave,
                            producto.producto,
                            producto.stock,
                            producto.medidas,
                            producto.categoria,
                            formato_moneda(producto.precio_renta),
                            formato_moneda(producto.precio_reposicion),
                            '<img data-action="zoom" src="https://sobre-la-mesa.com/images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail">',
                            '<button type="button" class="btn btn-success btn-sm" onclick="agregar_producto('+key+',1)">Agregar</button>');
                        tbl_inventario.row.add(datos);
                        datos = [];
                    });
                    tbl_inventario.draw(false);
                    $('#btn_modal_inventario').text(response.objectProducto.length + " Productos (F2)");
                    details_event();
                }else{
                    toastr.error('??Ocurrio un error inesperado intentelo nueva mente!');                    
                }
            }
        });
    }

    function details_event() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', <?php echo json_encode($idCotizacion) ?>);

        $.ajax({    
            method: 'POST',
            url: "{{route('evento.details_orden')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response){                
                $('#lbl_title').text('Editar');
                $('#lbl_title').html('Editar Datos del Evento: <input type=text id=elEvento readonly value="'+response.responseEvento.id+'">');
                $('#fecha_cotizacion').val(response.responseEvento.fecha_cotizacion);
                $('#folio_').text(response.responseEvento.fecha_cotizacion);                
                $("#select_cliente_id option[value="+ response.responseEvento.cliente_id +"]").attr("selected",true);
                $("#select_agente_id option[value="+ response.responseEvento.agente_id +"]").attr("selected",true);
                $("#select_tipo_evento option[value="+ response.responseEvento.tipo_evento +"]").attr("selected",true);
                $("#select_tipo_venta option[value="+ response.responseEvento.status +"]").attr("selected",true);
                $('#no_personas').val(response.responseEvento.no_personas);
                $('#domicilio_entrega').val(response.responseEvento.domicilio_entrega);
                $('#fecha_recoleccion').val(response.responseEvento.fecha_recoleccion);
                $('#fecha_evento').val(response.responseEvento.fecha_evento);
                $('#hora_evento').val(response.responseEvento.hora_evento);
                $('#fecha_entrega').val(response.responseEvento.fecha_entrega);
                $('#hora_entrega').val(response.responseEvento.hora_entrega);
                $('#fecha_recoleccion').val(response.responseEvento.fecha_recoleccion);
                $('#hora_recoleccion').val(response.responseEvento.hora_recoleccion);
                $('#flete').val(response.responseEvento.flete);
                $('#montaje').val(response.responseEvento.montaje);
                $('#lavado_desinfeccion').val(response.responseEvento.lavado_desinfeccion);
                $('#costo_flete').text('Flete: '+formato_moneda(response.responseEvento.flete));
                $('#costo_montaje').text('Montaje: '+formato_moneda(response.responseEvento.montaje));
                $('#costo_lavado').text('Lavado: '+formato_moneda(response.responseEvento.lavado_desinfeccion));
            //    $('#btn_comparator').html('<i class="fa fa-check" aria-hidden="true"></i>');

                $.each(response.responseDetalleEvento, function (key, producto) {
                    //console.log('Stock '+producto.stock);
                    //console.log('Detalle Evento ID '+producto.detalle_evento_id);
                    list_venta.push({
                      'id': producto.id,
                      'key': pos_list_venta,
                      'cantidad': producto.cantidad,
                      'descuento': producto.descuento,                  
                      'producto':  producto.producto,
                      'precio_publico': producto.precio_renta,
                      'stock': producto.stock,
                      'dias': producto.dias,
                      'row_type': 1,
                      'row_position': producto.row_position,
                      'content_seccion': '',
                      'status_autorizado': false,
                      'tipo': 2,
                      'detalle_id': producto.detalle_evento_id
                    });
                    pos_list_venta ++;
                    //add_lista_venta_(list_venta[list_venta.length - 1]);                    
                });

                $.each(response.responseDetalleEventoContent, function (key, row_header) {
                    //$("#tabla tr:first").after(tr);
                    /*var table = document.getElementById("tbl_venta");
                    var row = table.insertRow(row_header.row_position);
                    //this adds row in 0 index i.e. first place
                    row.innerHTML = '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td> <td></td> <td><b>'+row_header.content_seccion+'</b></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>';*/

                   list_venta.push({
                        'id': 0,
                      'key': pos_list_venta,
                      'cantidad': 0,
                      'descuento': 0,                  
                      'producto':  '',
                      'precio_publico': 0,
                      'stock': 0,
                      'dias': 0,
                      'row_type': 2,
                      'row_position': row_header.row_position,
                      'content_seccion': row_header.content_seccion,
                      'status_autorizado': false,
                      'tipo': 2,
                    'detalle_id': row_header.id
                  });
            
                    //const fromIndex = parseInt(pos_list_venta); // 0
                    //const toIndex = row_header.row_position;
                    //const element = list_venta.splice(fromIndex, 1)[0];
                    //list_venta.splice(toIndex, 0, element);
                    pos_list_venta ++;
                    //add_lista_venta_(list_venta[list_venta.length - 1]); 
                });


                // -- get_avail_all:

                

/*
                $.ajax({
                    method: 'POST',
                    //url: "{{route('evento.get_configuration')}}",
                    url: "../xtra/test.php",
                    dataType: 'json',
                    //processData: false,
                    //contentType: false,
                    data: {'eID': response.responseEvento.id },
                    beforeSend: function () {
                        console.log('sending get_avail..');
                    },
                    success: function (response) {
                        console.log('ajax success!');
                        
                            console.log('ajax response status!');
                            $('#testDiv').html("Response...");
                            $('#testDiv').append("<hr>");

                            $.each(response, function (key, avail) {
                                $('#testDiv').append(key+' - '+avail+'<br>');
                            });

                            //get_eventos();
                    }
                    ,error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) { msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {  msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {  msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') { msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') { msg = 'Time out error.';
                        } else if (exception === 'abort') { msg = 'Ajax request aborted.';
                        } else { msg = 'Uncaught Error.\n' + jqXHR.responseText;}
                        console.log(msg);
                    }
                });// ajax
*/                

                list_venta.sort((a, b) => b.row_position - a.row_position);
                //list_venta.reverse();
                reset_table_products();
                $.each(list_venta, function (key, venta) {
                    venta.key = key;
                    add_lista_venta_(venta);
                });
            


                /*if(response.responseEvento.iva == 'true' || response.responseEvento.iva == true){
                    $('#myCheck').prop('checked', true);
                    myFunction();
                }else{
                    $('#myCheck').prop('checked', true);
                    myFunction();
                }   

                resta_global = parseFloat(response.responseEvento.flete) + parseFloat(response.responseEvento.montaje) + parseFloat(response.responseEvento.lavado_desinfeccion);

                resta_iva_global = resta_global * 0.16;*/
                setTimeout( function() { 
                    console.log('getting first avail..');
                    get_avail('doc ready');    
                }, 400);
            } // success
        });   // ajax     
        
    } // details_event

    $("#form_edit_evento").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        Data.append('evento_id',<?php echo json_encode($idCotizacion) ?>);

        $.ajax({
            method:'POST',
            url: "{{route('evento.form_edit_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
            },
            success: function(response)
            {    

                var total_venta = parseFloat($('#total_venta').attr('total'));
                // console.log("Total Global "+total_venta);
                // console.log("Resta Global "+resta_global);
                // console.log("Resta Iva Global "+resta_iva_global);
                var resta_servicios = (total_venta - resta_global) - resta_iva_global;
                $('#total_venta').attr('total', resta_servicios);
                $('#total_venta').text(formato_moneda(resta_servicios));                
                var total_venta = parseFloat($('#total_venta').attr('total'));
                $('#fecha_cotizacion').attr('disabled','disabled');
                $('#select_cliente_id').attr('disabled','disabled');
                $('#select_agente_id').attr('disabled','disabled');
                $('#select_tipo_evento').attr('disabled','disabled');
                $('#no_personas').attr('disabled','disabled');
                $('#iva').attr('disabled','disabled');
                $('#fecha_evento').attr('disabled','disabled');
                $('#fecha_entrega').attr('disabled','disabled');
                $('#fecha_recoleccion').attr('disabled','disabled');
                $('#hora_evento').attr('disabled','disabled');
                $('#hora_entrega').attr('disabled','disabled');
                $('#hora_recoleccion').attr('disabled','disabled');
                $('#domicilio_entrega').attr('disabled','disabled');
                $('#flete').attr('disabled','disabled');
                $('#costo_flete').text('Flete: '+formato_moneda($('#flete').val()));
                total_venta += parseInt($('#flete').val());
                $('#montaje').attr('disabled','disabled');
                $('#costo_montaje').text('Montaje: '+formato_moneda($('#montaje').val()));
                total_venta += parseInt($('#montaje').val());
                $('#lavado_desinfeccion').attr('disabled','disabled');
                $('#costo_lavado').text('Lavado: '+formato_moneda($('#lavado_desinfeccion').val()));
                total_venta += parseInt($('#lavado_desinfeccion').val());
                $('#btn_add_evento').attr('disabled','disabled'); 
                $('#evento_id').val(response.responseEvento.id);               
                $('#idCard').CardWidget('collapse');
                $('#idCard').CardWidget('collapse');
                //$('#cantidadX').focus();
                // console.log("Total Venta "+total_venta);
                total_venta += (parseFloat($('#flete').val()) + parseFloat($('#montaje').val()) + parseFloat($('#lavado_desinfeccion').val())) * 0.16;
                // console.log("Total Venta 2 "+total_venta);
    
                $('#total_venta').attr('total', total_venta);
                $('#total_venta').text(formato_moneda(total_venta));
                $('#cantidadX').focus();
              //  $('#btn_pagar').attr('enabled','enabled');
                /*$("#form_add_evento")[0].reset();
                $('#modal_add_evento').modal('hide');
                get_eventos();*/
            }
        });
    });

    $("#form_confirm_sobre_vender").submit(function (e) {
    e.preventDefault();
    var pwds = "{{Auth::user()->pwds}}";
    console.log('temp_cantidad 1 ='+ temp_cantidad);
    console.log(pwds);
    if ($('#contrasena').val() == pwds) {
        if (isEdit) {
            list_venta[$('#key').val()].cantidad = temp_cantidad;
            list_venta[$('#key').val()].status_autorizado = true;
            if (list_venta[$('#key').val()].descuento === null || list_venta[$('#key').val()].descuento === 'null' || list_venta[$('#key').val()].descuento === '' || list_venta[$('#key').val()].descuento === 0) {
                $('#total' + $('#key').val()).text(formato_moneda((temp_cantidad * list_venta[$('#key').val()].precio_publico) * list_venta[$('#key').val()].dias));
            } else {
                var porcentaje = parseInt(list_venta[$('#key').val()].descuento) / 100;
                console.log('porcentaje ='+ porcentaje);
                console.log('temp_cantidad ='+ temp_cantidad);
                console.log('precio_publico ='+ list_venta[$('#key').val()].precio_publico);

                var resta = parseInt(((temp_cantidad * parseInt(list_venta[$('#key').val()].precio_publico)) * list_venta[$('#key').val()].dias)) * porcentaje;
                console.log('resta ='+ resta);
                var precio_final = ((temp_cantidad * parseInt(list_venta[$('#key').val()].precio_publico)) * list_venta[$('#key').val()].dias) - resta;
                console.log('precio_final ='+ precio_final);
                $('#total' + $('#key').val()).text(formato_moneda(precio_final));
                console.log('tres');
            }
            calcular();
            $('#contrasena').val('');
            isEdit = false;
            temp_cantidad = 0;
            $('#modal_confirm_sobre_vender').modal('hide');
            $('#modal_inventario').modal('hide');
        } else {
            var id = parseInt(list_productos[$('#key').val()]['id']);
            var cantidad = $('#cantidadX').val();
            var descuento = $('#descuentoX').val();
            var dias = $('#diasX').val();
            list_venta.push({
                'id': id,
                'key': pos_list_venta,
                'cantidad': cantidad,
                'descuento': descuento,
                'producto': list_productos[$('#key').val()]['producto'],
                'precio_publico': list_productos[$('#key').val()]['precio_renta'],
                'stock': list_productos[$('#key').val()]['stock'],
                'dias': dias,
                'row_type': 1,
                'row_position': pos_list_venta,
                'content_seccion': '',
                'status_autorizado': true
            });
            pos_list_venta++;
            reset_table_products();
            $.each(list_venta, function (key, venta) {
                add_lista_venta_(venta);
            });
            $('#modal_confirm_sobre_vender').modal('hide');
            $('#modal_inventario').modal('hide');
         //   toastr.success("Se autorizo con exito");
        }
    } else {
        toastr.error('??La contrase??a es incorrecta!');
    }

});


    function modal_inventario() {
      $('#modal_inventario').modal('show');
      setTimeout(function () {
          $('div.dataTables_filter input').focus();
      }, 900);
      status_modal_inventario = 1;
    }

    $("#modal_inventario").on("hidden.bs.modal", function () {
      status_modal_inventario = 0;
      focus_refaccion_id = 0;
      focus_key = null;
    });

    function formato_moneda(total) {
      var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
      });
      return formatter.format(total);
    }


    function compartir_whatsapp(){
        var cliente_id = $('#select_cliente_id').val();
        console.log(cliente_id);
        //var results = list_clientes.filter(function (cliente) { return cliente.id == cliente_id; });
        //var firstObj = (results.length > 0) ? results[0] : null;
        for(var i = 0; i < list_clientes.length; i++){
            if(list_clientes[i].id == cliente_id){
                window.open('https://api.whatsapp.com/send?phone=52'+list_clientes[i].celular1+'&text=Buen d??a '+list_clientes[i].nombre_completo+' anexamos la siguiente cotizaci??n mediante la siguiente URL: '+$('#lbl_url_seguimiento').val()+'');
            }
        }
        /*console.log(list_clientes[0]);
        const resultado = list_clientes.find( cliente => cliente.id === cliente_id );
        console.log(resultado);*/
    }

    function compartir_correo(){        
        var Data = new FormData();
        var cliente_id = $('#select_cliente_id').val();
        var correo = '';
        var telefono = '';
        var nombre_cliente = '';
        for(var i = 0; i < list_clientes.length; i++){
            if(list_clientes[i].id == cliente_id){
                correo = list_clientes[i].correo_electronico;
                telefono = list_clientes[i].celular1;
                nombre_cliente = list_clientes[i].nombre_completo;                
            }
        }                
        Data.append('correo', correo);
        Data.append('telefono', telefono);
        Data.append('nombre_cliente', nombre_cliente);
        Data.append('url_seguimiento', $('#lbl_url_seguimiento').val());
        Data.append('_token', '{{ csrf_token() }}');
        $.ajax({
          method: 'POST',
          url: "{{route('evento.send_email_client')}}",
          data: Data,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function () {
          //$().toastmessage('showNoticeToast', "<br>Procesando venta");
      },
      success: function (response) {
          if (response.status) {
              //$().toastmessage('showSuccessToast', "<br>Venta realizada");
              $('#rep_venta_id').val(evento_id);
              $('#btn_rep_venta').trigger('click');
              reiniciar_venta();
              btn_act_desac();
              $('#lbl_url_seguimiento').val(response.short_url);
              $('#modal_enviar_url').modal('show');
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  })
    }
    

    function onChangeDomicilio(){
        var domicilio_entrega_id = $('#select_domicilio_entrega').val();
        if (domicilio_entrega_id == 99999) {
            $('#domicilio_entrega').val('');
            $('#domicilio_entrega').hide();
            $('#domicilio_entrega').val('Amacuzac #246, Col. Hermosillo Coyoac??n M??xico, Ciudad de M??xico (MX) M??xico 04240');
        }else if(domicilio_entrega_id == 99998){
            $('#domicilio_entrega').val('');
            $('#domicilio_entrega').show();            
        }else{
            $('#domicilio_entrega').val('');
            $('#domicilio_entrega').hide();
            $('#domicilio_entrega').val($( "#select_domicilio_entrega option:selected" ).text());
        }
    }

    function agregar_producto(key, row_type){
        console.log('Valor de key '+key+' valor de row_type '+row_type);

        if(row_type == 1){//Tipo Producto
            if (parseInt(list_productos[key]['stock']) == 0 || parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])) {
                //toastr.warning('Sin existencias')
                $('#key').val(key);
                $('#modal_confirm_sobre_vender').modal('show');            
            }else{
                console.log("Entro en el else");
                var id = parseInt(list_productos[key]['id']);
                if ( parseInt($('#cantidadX').val()) <= parseInt(list_productos[key]['stock'])) {
                    console.log("Entro en el if donde hay stock");
                  var cantidad = $('#cantidadX').val();
                  var descuento = $('#descuentoX').val();
                  var dias = $('#diasX').val();   

                  list_venta.push({
                      'id': id,
                      'key': pos_list_venta,
                      'cantidad': cantidad,
                      'descuento': descuento,                  
                      'producto':  list_productos[key]['producto'],
                      'precio_publico': list_productos[key]['precio_renta'],
                      'stock': list_productos[key]['stock'],
                      'dias': dias,
                      'row_type': row_type,
                      'row_position': pos_list_venta,
                      'content_seccion': '',
                      'status_autorizado': false,
                      'tipo': 1,
                  });

                  pos_list_venta ++;
                  //add_lista_venta_(list_venta[list_venta.length - 1]);          
                console.log('::: list_venta='+list_venta);
                console.log('::: pos_list_venta='+pos_list_venta);
                  $('#tbl_venta').empty();
                  $('#tbl_venta').append(
                      '<tr id="0" class=cerocero>'
                      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                 //     + '<td style="width: 70px;"><input tabindex="4" type="number" id="stock_dia" class="form-control form-control-sm focusNext"  value="stock_dia" style="width:70px;"></td>'
                      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext"  value="0" style="width:70px;"></td>'
                      + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
                      + '<td style="background-color: #bbbbff; opacity: .5;"></td>'
                      +'<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
                      + '<td style="width: 100px;"><input tabindex="2" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
                      + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
                      + '<td></td>'
                      + '</tr>'
                      );
                  $.each(list_venta, function (key, venta) {
                    //console.log("Entro Aqui");
                      add_lista_venta_(venta);
                      //total_venta += venta.cantidad * venta.precio_publico;
                  });
              } else {
                if(parseInt($('#cantidadX').val()) == 0){
                    toastr.warning('Ingresa una cantidad v??lida')
                }else if(parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])){
                    toastr.warning('No se cuenta con suficientes productos. Tenemos '+ parseInt(list_productos[key]['stock']) +' en existencia')                    
                }
            }
            $('#modal_inventario').modal('hide');
            status_modal_cantidad = 0;
            btn_act_desac();
            setTimeout(function () {
              $('#cantidad_add_venta').val(1)
            }, 500);
            setTimeout(function () {
                get_avail('agregado');
            }, 1000);


        } 

        }else if(row_type == 2){

            list_venta.push({
                'id': 0,
              'key': pos_list_venta,
              'cantidad': 0,
              'descuento': 0,                  
              'producto':  '',
              'precio_publico': 0,
              'stock': 0,
              'dias': 0,
              'row_type': row_type,
              'row_position': pos_list_venta,
              'content_seccion': '',
              'status_autorizado': false,
              'tipo': 1,
          });
            pos_list_venta ++;
            //add_lista_venta_(list_venta[list_venta.length - 1]);

            $('#tbl_venta').empty();

            $('#tbl_venta').append(
              '<tr id="0"  class=cerocero>'
              +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
              + '<td style="width: 90px;"><input tabindex="4" type="number" id="disponibi??idad" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;" autofocus="autofocus"></td>'
              + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext"  value="0" style="width:70px;"></td>'
              + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
              + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
              +'<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
              + '<td style="width: 100px;"><input tabindex="2" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
              + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
              + '<td></td>'
              + '</tr>'
            );
              $.each(list_venta, function (key, venta) {
                  add_lista_venta_(venta);
                  //total_venta += venta.cantidad * venta.precio_publico;
              });
        }

    } // agregar prod?




function save_content_seccion(key){
 //   $('#btn_pagar').attr('enabled','enabled');
    key = list_venta.map(e => e.key).indexOf(key);
    list_venta[key].content_seccion = $('#content_seccion_'+key).val();    
    $('#content_seccion_'+key).attr('disabled','disabled');
    //$('#div_content_seccion_'+key);
    var x = document.getElementById("div_content_seccion_"+key);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    // frank
    var text0 = $('#content_seccion_'+key).val();
    $('#lbl_content_secccion_'+key).text(text0);
    $('#lbl_content_secccion_'+key).parent().attr('test','prueba1');
    // $('#lbl_content_secccion_'+key).text($('#content_seccion_'+key).val());
}


function efectuar_pago() {
    //list_venta.sort((a, b) => b.key - a.key);
    //list_venta.reverse();
    /*$.each(list_venta, function (key, venta) {
        venta.row_position = key;
    });*/
  var cliente_id = $('#select_cliente_id').val();
  var checkBox = document.getElementById("myCheck");
  var Data = new FormData();

  let tipo = $('#select_tipo_venta').val();
  var evento_id = $('#evento_id').val();
  Data.append('productos', JSON.stringify(list_venta));
    console.log(' :: list venta:');
    console.log(list_venta);
  Data.append('productos_eliminados', JSON.stringify(list_eliminados));
  Data.append('productos_eliminados_content', JSON.stringify(list_eliminados_content));
  Data.append('tipo', tipo);
  Data.append('cliente_id', cliente_id);
  Data.append('evento_id', <?php echo json_encode($idCotizacion) ?>);
  Data.append('iva', true);
  Data.append('idCotizacion', <?php echo json_encode($idCotizacion) ?>);
//   $('#stock_dia').val($stock_dia);
//   Data.append('stock_dia', $('#stock_dia').val());
  Data.append('_token', '{{ csrf_token() }}');
  console.log("Productos eliminados" + list_eliminados);
  console.log("Productos eliminados contenido " + list_eliminados_content);


  $.ajax({
      method: 'POST',
      url: "{{route('evento.insert_detalle_evento_edit')}}",
      data: Data,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function () {
          //$().toastmessage('showNoticeToast', "<br>Procesando venta");
      },
      success: function (response) {
          if (response.status) {
            $('#btn_pagar').attr('disabled','disabled');

            toastr.success('La cotizaci??n fue editada con exito');
            setTimeout(() => {
                location.reload();
            }, 5000);
              //$().toastmessage('showSuccessToast', "<br>Venta realizada");
              
              // $('#rep_venta_id').val(evento_id);
              // $('#btn_rep_venta').trigger('click');
              // reiniciar_venta();
              // btn_act_desac();
              // $('#lbl_url_seguimiento').val(response.short_url);
              // $('#modal_enviar_url').modal('show');

              //window.open("https://sobre-la-mesa.com/evento");
        //  window.location.href = "../evento";
        //      window.location.href = "http://localhost/sobrelamesa/s/slm/evento";
              //window.location.replace
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  }) // -- ajax



}

function reiniciar_venta() {
  list_venta = [];
  $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0" class=cerocero>'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
  //    + '<td style="width: 70px;"><input tabindex="4" type="number" id="stock_dia" class="form-control form-control-sm focusNext"  value="stock_dia" style="width:70px;"></td>'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;" autofocus="autofocus"></td>'
      //+ '<td style="width: 120px;"><input tabindex="2" type="text" class="form-control form-control-sm focusNext" style="width: 100%"></td>'
      + '<td style="background-color: #f1f3b7"></td>'
      + '<td style="background-color: #b7f3b7"></td>'
      +'<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
      +'<td style="width: 100px;"><input tabindex="3" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
      //+ '<td style="background-color: #b7f3b7"></td>'
      + '<td style="background-color: #b7f3b7"><span id="total0"></span></td>'
      +'<td></td>'
      + '</tr>'
      );
  $('#total_venta').text(formato_moneda(0));
  $('#total_venta').attr('total', 0);
}

  function btn_act_desac() {
      if (list_venta.length > 0) {
          $('#btn_pagar').removeAttr('disabled');
      } else {
          $('#btn_pagar').attr('disabled', 'disabled');
      }
  }

  $(document).keydown(function (e) {
      var number_row = 0;
      if (e.keyCode == 112) {

      }
      if (e.keyCode == 113) {
          e.preventDefault();
          modal_inventario();
      }      
      if (e.keyCode == 115) {
          e.preventDefault();
          remover_productos();
      }
      if (e.keyCode == 123) {
          e.preventDefault();
          if (list_venta.length > 0) {
              efectuar_pago();
          } else {              
              toastr.warning('No se encontraron productos por vender')
          }
      }
      if (e.keyCode == 13 && status_modal_inventario == 1 && focus_refaccion_id != 0 && $('div.dataTables_filter input').is(":focus") != true) {
            console.log('focus_key '+focus_key);
      }
      if (e.keyCode == 13 && $('div.dataTables_filter input').is(":focus")) {          
          $("div.dataTables_filter input").blur();
          $('#tbl_inventario tbody tr:eq(0)').trigger('click');
      }
      if (e.keyCode == 38 && status_modal_inventario == 1 && $('div.dataTables_filter input').is(":focus") != true && focus_key != null && status_modal_cantidad == 0) {
          $('#tbl_inventario tbody tr:eq(' + (focus_key - 1) + ')').click();
      }
      if (e.keyCode == 40 && status_modal_inventario == 1 && $('div.dataTables_filter input').is(":focus") != true && focus_key != null && status_modal_cantidad == 0) {
          $('#tbl_inventario tbody tr:eq(' + (focus_key + 1) + ')').click();
      }
  });

function btn_eliminar(key) {
key = list_venta.map(e => e.key).indexOf(key);
console.log(list_venta[key]['row_type']+" "+list_venta[key]['detalle_id']);

if(list_venta[key]['tipo'] == 2){
    if(list_venta[key]['row_type'] == 1){
    list_eliminados.push(list_venta[key]['detalle_id']);
}else if(list_venta[key]['row_type'] == 2){
    list_eliminados_content.push(list_venta[key]['detalle_id']);
}
    setTimeout(function () {
        get_avail('eliminado');
    }, 600);
}

  
  list_venta.splice(key, 1);
  $('#row'+key).remove();
  pos_list_venta --;
      $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0"  class=cerocero>'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
  //    + '<td style="width: 70px;"><input tabindex="4" type="number" id="stock_dia" class="form-control form-control-sm focusNext"  value="stock_dia" style="width:70px;"></td>'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="0" value="0" style="width:70px;"></td>'
      + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
      +'<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
      + '<td style="width: 100px;"><input tabindex="3" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
      + '<td></td>'
      + '</tr>'
      );
  $.each(list_venta, function (key, venta) {
    venta.key = key;
      //venta.key = venta.key - 1;
      add_lista_venta_(venta);
      //total_venta += venta.cantidad * venta.precio_publico;
  });
  /*$('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));*/
  calcular();
  btn_act_desac();
}

function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var total_venta = parseFloat($('#total_venta').attr('total'));
    // console.log(total_venta);
    if(total_venta > 0){
        if (checkBox.checked == true){
            var iva = total_venta * 0.16;
            console.log(iva);
            total_venta = total_venta + iva;
            console.log(total_venta);
            $('#total_venta').attr('total', total_venta);
            $('#total_venta').text(formato_moneda(total_venta));
            config_iva = 1;
        }else{
            config_iva = 0;
            calcular();
        }
    }else{
        toastr.warning('Cantidad en 0, no se puede aplicar IVA');
    }  
}

function cancel_over(){
    var key=$('#key').val();
    var pID=$('#key_'+key).attr('keyid');
    var stockDisp =  $('#stockDisp_'+pID).val();
    $('#cantidad' + key).val(stockDisp);
}

function availability_comparator(key, row_position) {
console.log(llave);
console.log(key);

    if(comparator_ava){
    //    $('#mi_icono').attr('class','fa fa-check');
    if (key == llave) {
        $('#mi_icono').attr('class','fas fa-exclamation-triangle ');

        $('#key').val(key);
             $('#modal_confirm_sobre_vender').modal('show');
   
    }
    }
}


function change_cantidad(key) {
        //  $('#btn_pagar').attr('enabled','enabled');
//  console.log("key2: " + key);
key = list_venta.map(e => e.key).indexOf(key);
//  console.log("key2: " + key);
  var cantidad = parseInt($('#cantidad' + key).val());//Asignamos la nueva cantidad a variable
  isEdit = true;
  llave = key;

    var pID=$('#key_'+key).attr('keyid');
    var stockDisp =  $('#stockDisp_'+pID).val();
    
//    console.log( 'sobrevender key ('+key+') '+pID+' disp:'+stockDisp );
//    console.log('stock original:'+list_productos[key]['stock']);
//    console.log('stock original2:'+list_venta[key]['stock']);
    temp_cantidad = cantidad;
  //if(cantidad > list_venta[key].stock || cantidad > parseInt(list_productos[key]['stock'])){
    //<i class="fa fa-check" aria-hidden="true"></i><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
if (cantidad >= 0) {
    if(cantidad > stockDisp){
    //toastr.warning('La cantidad no puede ser mayor al stock existente');
  //  $('.mi_icono').addClass('fa fa-thumbs-o-up');
   // $('#btn_comparator').val('Warning');
   $('#mi_icono').attr('class','fas fa-exclamation-triangle ');
   comparator_ava = true;

  }else{
  //  $('#mi_icono').html('<i class="fa fa-check text-success" aria-hidden="true"></i>');
 //   $('mi_icono').addClass('fa fa-thumbs-o-up');
    
    list_venta[key].cantidad = cantidad;//A la lista le ponemos la nueva cantidad
  if (list_venta[key].descuento === null || list_venta[key].descuento === 'null' || list_venta[key].descuento === '' || list_venta[key].descuento === 0) {
      $('#total' + key).text(formato_moneda((cantidad * list_venta[key].precio_publico) * list_venta[key].dias));//En vista colocamos el nuevo total      
  }else {
      var porcentaje = parseInt(list_venta[key].descuento)/100;      
      var resta = parseInt(((cantidad * parseInt(list_venta[key].precio_publico)) * list_venta[key].dias)) * porcentaje;      
      var precio_final = ((cantidad * parseInt(list_venta[key].precio_publico)) * list_venta[key].dias) - resta;
      $('#total' + key).text(formato_moneda(precio_final));//En vista colocamos el nuevo total
  }
  
     calcular();
    
  }
} else {
    cantidad = 0;
    $('#cantidadX').val(0);
    toastr.warning('Ingrese una cantidad correcta');
}
  
  /*var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));  */
}



function change_descuento(key) {
 //   $('#btn_pagar').attr('enabled','enabled');
     key = list_venta.map(e => e.key).indexOf(key);
  var descuento = parseInt($('#descuento' + key).val());//Asignamos la nueva descuento a variable
  list_venta[key].descuento = descuento;//A la lista le ponemos la nueva descuento
  if (list_venta[key].descuento === null || list_venta[key].descuento === 'null' || list_venta[key].descuento === '' || list_venta[key].descuento === 0) {
      $('#total' + key).text(formato_moneda((list_venta[key].cantidad * list_venta[key].precio_publico) * list_venta[key].dias));//En vista colocamos el nuevo total      
  }else {
      var porcentaje = parseInt(list_venta[key].descuento)/100;      
      var resta = parseInt(((list_venta[key].cantidad * parseInt(list_venta[key].precio_publico)) * list_venta[key].dias)) * porcentaje;      
      var precio_final = ((list_venta[key].cantidad * parseInt(list_venta[key].precio_publico)) * list_venta[key].dias) - resta;
      $('#total' + key).text(formato_moneda(precio_final));//En vista colocamos el nuevo total
  }
  calcular();
  /*var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));  */
}

function change_dias(key){
  //  $('#btn_pagar').attr('enabled','enabled');
    key = list_venta.map(e => e.key).indexOf(key);
    var dias = parseInt($('#dias' + key).val());//Asignamos la nueva cantidad a variable
    if(dias == 0){
        toastr.warning('La cantidad no puede ser cero');
    }else{

    list_venta[key].dias = dias;//A la lista le ponemos la nueva cantidad
    if (list_venta[key].descuento === null || list_venta[key].descuento === 'null' || list_venta[key].descuento === '' || list_venta[key].descuento === 0) {
      $('#total' + key).text(formato_moneda((list_venta[key].cantidad * list_venta[key].precio_publico) * dias));//En vista colocamos el nuevo total      
  }else {
      var porcentaje = parseInt(list_venta[key].descuento)/100;      
      var resta = parseInt(((list_venta[key].cantidad * parseInt(list_venta[key].precio_publico)) * dias)) * porcentaje;      
      var precio_final = ((list_venta[key].cantidad * parseInt(list_venta[key].precio_publico)) * dias) - resta;
      $('#total' + key).text(formato_moneda(precio_final));//En vista colocamos el nuevo total
  }
  calcular();

}
}

function calcular(){
   // $('#btn_pagar').attr('enabled','enabled');
    /*
    Recalcularemos todas las opciones
    Iteramos productos y se valida si trae descuento o no
    Se suman los 3 defaults
    se valida iva
    se muestra total
    */
    var total_productos = 0;
    var flete;
   if (parseInt($('#cantidadX').val()) >= 0) {
    if (isNaN(parseInt($('#flete').val()))) {
        flete = 0;
    }else{
        flete = parseInt($('#flete').val());
    }
    var montaje;
    if(isNaN(parseInt($('#montaje').val()))){
        montaje = 0;
    }else{
        montaje = parseInt($('#montaje').val());
    }
    var lavado_desinfeccion;
    if(isNaN(parseInt($('#lavado_desinfeccion').val()))){
        lavado_desinfeccion = 0;
    }else{
        lavado_desinfeccion = parseInt($('#lavado_desinfeccion').val());
    }
    var total_venta = 0;
    //console.log('flete '+flete+' montaje '+montaje+' lavado_desinfeccion '+lavado_desinfeccion);
    $.each(list_venta, function (key, venta) { 
        if (venta.descuento === null || venta.descuento === 'null' || venta.descuento === '' || venta.descuento === 0) {
           total_productos += ((parseInt(venta.cantidad) * parseInt(venta.precio_publico)) * venta.dias);
        }else {
          var porcentaje = parseInt(venta.descuento)/100;      
          var resta = parseInt(((venta.cantidad * parseInt(venta.precio_publico)) * venta.dias)) * porcentaje;      
          var precio_final = ((venta.cantidad * parseInt(venta.precio_publico)) * venta.dias) - resta;
          total_productos += precio_final;
        }
    });
    // console.log('total_productos '+total_productos);
    total_venta = parseInt(total_productos) + parseInt(flete) + parseInt(montaje) + parseInt(lavado_desinfeccion);
    // console.log('total_venta '+total_venta);  
    if (config_iva == 1){
        var iva = total_venta * 0.16;
        // console.log('iva '+iva);
        total_venta = total_venta + iva;
        // console.log('total_venta '+total_venta);
        $('#total_venta').attr('total', total_venta);
        $('#total_venta').text(formato_moneda(total_venta));
    }else if(config_iva == 0){
        $('#total_venta').attr('total', total_venta);
        $('#total_venta').text(formato_moneda(total_venta));
    }else{
        $('#total_venta').attr('total', total_venta);
        $('#total_venta').text(formato_moneda(total_venta));
    }
    /*$('#total_venta').attr('total', total_venta);
    $('#total_venta').text(formato_moneda(total_venta));*/
   } else {
    toastr.warning('Ingrese una cantidad correcta');
   }
}

$('#tbl_inventario tbody').on('click', 'tr', function () {
  if ($(this).hasClass('selected')) {
      focus_key = null;
      temp_row = null;
      temp_row_index = null;
      $(this).removeClass('selected');
  } else {
      tbl_inventario.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
      focus_refaccion_id = parseInt(tbl_inventario.row(this).data()['id']);
      focus_key = parseFloat(tbl_inventario.row(this).data()['key']);
      temp_row = tbl_inventario.row(this).data();
      temp_row_index = tbl_inventario.row(this).index();
  }
});

document.addEventListener('keypress', function (evt) {
  if (evt.key !== 'Enter') {
      return;
  }
  let element = evt.target;
  if (!element.classList.contains('focusNext')) {
      return;
  }
  let tabIndex = element.tabIndex + 1;
  var next = document.querySelector('[tabindex="' + tabIndex + '"]');
  if (next) {                                    
    if(element.value != ''){
      next.focus();
      event.preventDefault();
    }                                    
  }
});

function add_lista_venta_(producto) {
    //console.log("add_lista_venta_ " + JSON.stringify(producto));
    if (producto.row_type == 1) {
        var porcentaje = 0;
        var resta = 0;
        var precio_final = 0;
        var descuento = '';
        var contenido_tbl = $('#tbl_venta').html();
        $('#tbl_venta').empty();
        if (producto.descuento === null || producto.descuento === 'null' || producto.descuento === '') {
            descuento = "0";
            precio_final = ((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias);
        } else {
            descuento = producto.descuento;
            porcentaje = parseInt(producto.descuento) / 100;
            resta = parseInt(((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias)) * porcentaje;
            precio_final = ((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias) - resta;
        }
        
        // frank: Aqu?? inicializa y dibuja la tabla

        $('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td class=total_prod><input readonly class="stockDisp" pid="'+ (producto.id) +'" id="stockDisp_'+ (producto.id) +'" value="1" maxlength=6 ><span keyid='+producto.id+' id=key_'+producto.key+'></span></td>'
                + '<td><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="0" value="' + producto.cantidad + '" style="width:70px;"><button type="button" id="btn_comparator" onclick="availability_comparator(' + (producto.key) +  ')" class="btn btn-light"><i class="fa fa-check" id="mi_icono"></i></button></td>'
                + '<td class=desc_producto> ' + producto.producto + '</td>'
                + '<td class=precio_publico><span>' + formato_moneda(producto.precio_publico) + '</span></td>'
                + '<td style="width: 90px;"><input tabindex="2" type="number" id="dias' + (producto.key) + '" onchange="change_dias(' + (producto.key) + ')"  class="form-control form-control-sm" min="1" value="' + producto.dias + '" style="width:70px;"></td>'
                + '<td><input type="number" id="descuento' + (producto.key) + '" onchange="change_descuento(' + (producto.key) + ')" class="form-control form-control-sm" value="' + descuento + '" style="width:100px;"></td>'
                + '<td class=total_prod><span id="total' + (producto.key) + '">' + formato_moneda(precio_final) + '</span></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );
        $('#tbl_venta').append(contenido_tbl);
      //  $('#disponibilidad').focus();
        $('#cantidadX').focus();
        calcular();
        
        

    } else if (producto.row_type == 2) {
        var contenido_tbl = $('#tbl_venta').html();
        $('#tbl_venta').empty();
        if(producto.content_seccion != ''){
            $('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td colspan=2></td>'
                + '<td colspan="2" class="la_nota" id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
                
                + '<td class=la_nota ></td>'
                + '<td class=la_nota ></td>'
                + '<td class=la_nota ></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );

            $('#content_seccion_'+producto.key).attr('disabled','disabled');
            //$('#div_content_seccion_'+key);
            var x = document.getElementById("div_content_seccion_"+producto.key);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            $('#lbl_content_secccion_'+producto.key).text($('#content_seccion_'+producto.key).val());
        }else{
            $('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td></td>'
                + '<td colspan=2 class=la_nota id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
                + '<td class=la_nota></td>'
                + '<td class=la_nota></td>'
                + '<td class=la_nota></td>'
                + '<td class=la_nota></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );
        }
        $('#tbl_venta').append(contenido_tbl);
    }
}

$('#tbl_venta').sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        var result = $(this).sortable("toArray");
        console.log(result);
        var new_array_tem = [];
        for (var i = 0; i < result.length; i++) {
            for (var j = 0; j < list_venta.length; j++) {
                if(result[i].includes('row-')){
                    if(list_venta[j].key == parseInt(result[i].replace('row-', ''))){
                        new_array_tem.push(list_venta[j]);
                    }
                }
            }            
        }
        list_venta = [];
        list_venta = new_array_tem;
        list_venta.reverse();
        reset_table_products();
        var lvlen =list_venta.length;
        $.each(list_venta, function (key, venta) {
            venta.key = key;
            var rpos = lvlen - key; rpos--;
            //console.log(':: key='+key+'. rpos='+rpos);
            venta.row_position = rpos;
            add_lista_venta_(venta);
        });
        console.log('sortable end.');
        get_avail('sortable');
        
    }
});




function reset_table_products(){
    $('#tbl_venta').empty();
    $('#tbl_venta').append(
        '<tr id="0" class=cerocero>'
        + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
     //   + '<td style="width: 90px;"><input tabindex="4" type="number" id="disponibilidad" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
        + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" value="0" min="0" style="width:70px;"></td>'
        + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
        + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
        + '<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
        + '<td style="width: 100px;"><input tabindex="2" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px" value="0"></td>'
        + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
        + '<td></td>'
        + '</tr>'
        );
}


// frank

function get_avail(something){
        console.log('this is one '+something);
        var eID = $('#elEvento').val();

        var myProds="";
        $( ".stockDisp" ).each(function( index ) {
            myProds = myProds+"|"+$( this ).attr('pid');
        });

        $.ajax({
            method: 'POST',
            url: "../xtra/test.php",
            dataType: 'json',
            data: {'eID': eID, 'myProds':myProds},
            beforeSend: function () {
                console.log('sending get_avail..'+eID);
            },
            success: function (response) {
                console.log('ajax response status!');

                    $.each(response, function (key, avail) {
                        $('#testDiv').append(key+' - '+avail+'<br>');
                        $('#stockDisp_'+key).val(avail);
                    });

            }
            ,error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) { msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {  msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {  msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') { msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') { msg = 'Time out error.';
                } else if (exception === 'abort') { msg = 'Ajax request aborted.';
                } else { msg = 'Uncaught Error.\n' + jqXHR.responseText;}
                console.log(msg);
            }
        });// ajax

        
    }


</script>
@endsection