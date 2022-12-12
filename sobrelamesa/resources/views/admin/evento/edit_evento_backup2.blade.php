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
                            <th>CATEGORÍA</th>
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
                <h5 class="modal-title">Enviar Cotización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name">URL de Cotización</label>
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
                <h5 class="modal-title" id="lbl_title_modal">Se requiere contraseña para sobre vender este producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_confirm_sobre_vender">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Contraseña</label>
                                <input type="password" class="form-control" name="contrasena" id="contrasena">
                            </div>
                        </div>                    
                    </div>
                </div>
                <input type="hidden" name="key" id="key">                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                                    <div class="form-group">
                                        <label for="name">Fecha Cotización</label>
                                        <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" value="{{date('Y-m-d')}}" disabled />
                                    </div>
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
                                        <label for="name">Número Personas</label>
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
                                        <label for="name">Fecha Recolección</label>
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
                                        <label for="name">Lavado Desinfección</label>
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
                                                <option value="3">NOTA DE PÉRDIDA</option>
                                            </select>
                                        </div>
                                    </div>

                                    

                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3" style="margin-top: 8px;">
                                      <span><!-- style="padding: 2px 2px;background-color: #f1f1f1;width: 200px;text-align: center;border: 1px #d8d9e2 solid; font-size: 16px; height: 50px;" --><!--<img src="{{asset('icons/icon-date.png')}}" alt="FOLIO-IMG" style="width: 25px;">--><img src="https://img.icons8.com/office/20/000000/calendar--v1.png"/> <b id="folio_"></b></span>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3" style="margin-top: 8px;">
                                      <button class="btn btn-success btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar una Sección</button>

                                          <button class="btn btn-primary btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar Nota </button>
                                  </div>

                                    <input type="hidden" name="evento_id" id="evento_id">

                                    <!--<div class="col-xs-12 col-sm-6 col-md-8 col-lg-5">
                                      <br>
                                      
                                    </div>-->
                                </div>
                            </div>
                            <div class="card-body">  
                                <div class="row">                
                                    <table class="table table-hover table-sm" id="tbl_venta_productos">
                                        <thead>
                                            <tr style="background-color: #d8d9e2;">
                                                <th scope="col"></th>
                                                <th scope="col">Cantidad</th>
                                                <!--<th scope="col">Clave</th>-->
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Precio U.</th>
                                                <th scope="col">Días</th>
                                                <th scope="col">% Desc</th>
                                                <th scope="col">Total</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="todo-list" id="tbl_venta">
                                            <tr id="row-0">
                                                <td><span class="handle">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </span></td>
                                                <td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>
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
    var list_seccions = [];
    var ban = false;

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

                    $('#btn_modal_inventario').text("Consultando Refacciones...");
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
                    toastr.error('¡Ocurrio un error inesperado intentelo nueva mente!');                    
                }
            }
        });
    }

    function details_event(){
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
                $('#lbl_title').text('Editar Datos del No. de Evento: 00'+response.responseEvento.id);
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
                $.each(response.responseDetalleEvento, function (key, producto) {
                    console.log('Stock '+producto.stock);
                    console.log('Detalle Evento ID '+producto.detalle_evento_id);
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
                      'row_position': 0,
                      'content_seccion': '',
                      'status_autorizado': true,
                      'tipo': 2,
                      'detalle_id': producto.detalle_evento_id
                    });
                    pos_list_venta ++;
                    add_lista_venta_(list_venta[list_venta.length - 1]);                    
                });

                $.each(response.responseDetalleEventoContent, function (key, row_header) {
                    //$("#tabla tr:first").after(tr);
                   // var table = document.getElementById("tbl_venta");
                   // var row = table.insertRow(row_header.row_position);
                    //this adds row in 0 index i.e. first place
                   // row.innerHTML = '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td> <td></td> <td><b>'+row_header.content_seccion+'</b></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td>';

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
                      'detalle_id': row_header.detalle_evento_id
          });
            
            //const fromIndex = parseInt(pos_list_venta); // 0
        //const toIndex = row_header.row_position;
        //const element = list_venta.splice(fromIndex, 1)[0];
        //list_venta.splice(toIndex, 0, element);
        pos_list_venta ++;
             add_lista_venta_(list_venta[list_venta.length - 1]); 
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
            }
        });        
    }

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
                console.log("Total Global "+total_venta);
                console.log("Resta Global "+resta_global);
                console.log("Resta Iva Global "+resta_iva_global);
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
                console.log("Total Venta "+total_venta);
                total_venta += (parseFloat($('#flete').val()) + parseFloat($('#montaje').val()) + parseFloat($('#lavado_desinfeccion').val())) * 0.16;
                console.log("Total Venta 2 "+total_venta);
    
                $('#total_venta').attr('total', total_venta);
                $('#total_venta').text(formato_moneda(total_venta));
                $('#cantidadX').focus();
                /*$("#form_add_evento")[0].reset();
                $('#modal_add_evento').modal('hide');
                get_eventos();*/
            }
        });
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
                window.open('https://api.whatsapp.com/send?phone=52'+list_clientes[i].celular1+'&text=Buen día '+list_clientes[i].nombre_completo+' anexamos la siguiente cotización mediante la siguiente URL: '+$('#lbl_url_seguimiento').val()+'');
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
    var pos_list_venta = 0;
    /*function agregar_producto(key){
        if (parseInt(list_productos[key]['stock']) == 0) {
            toastr.warning('Sin existencias')            
        } else {
            var id = parseInt(list_productos[key]['id']);
            if (parseInt($('#cantidadX').val()) > 0 && parseInt($('#cantidadX').val()) <= parseInt(list_productos[key]['stock'])) {
              var cantidad = $('#cantidadX').val();
              var descuento = $('#descuentoX').val();        
              list_venta.push({
                  'id': id,
                  'key': pos_list_venta,
                  'cantidad': cantidad,
                  'descuento': descuento,                  
                  'producto':  list_productos[key]['producto'],
                  'precio_publico': list_productos[key]['precio_renta'],
                  'stock': list_productos[key]['stock'],
                  'tipo': 1,
                  'detalle_id': 0 
              });
              pos_list_venta ++;
              add_lista_venta_(list_venta[list_venta.length - 1]);          
            } else {
                if(parseInt($('#cantidadX').val()) == 0){
                    toastr.warning('Ingrese una cantidad válida')
                }else if(parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])){
                    toastr.warning('La sucursal no cuenta con suficientes, estan '+ parseInt(list_productos[key]['stock']) +' en existencia')                    
                }
            }
          $('#modal_inventario').modal('hide');
          status_modal_cantidad = 0;
          btn_act_desac();
          setTimeout(function () {
              $('#cantidad_add_venta').val(1)
          }, 500);
        } 
    }*/

    function onChangeDomicilio(){
        var domicilio_entrega_id = $('#select_domicilio_entrega').val();
        if (domicilio_entrega_id == 99999) {
            $('#domicilio_entrega').val('');
            $('#domicilio_entrega').hide();
            $('#domicilio_entrega').val('Amacuzac #246, Col. Hermosillo Coyoacán México, Ciudad de México (MX) México 04240');
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
                if (parseInt($('#cantidadX').val()) > 0 && parseInt($('#cantidadX').val()) <= parseInt(list_productos[key]['stock'])) {
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
                      'row_position': 0,
                      'content_seccion': '',
                      'status_autorizado': false,
                      'tipo': 1,
                  });


                  pos_list_venta ++;
                  //add_lista_venta_(list_venta[list_venta.length - 1]);          
                console.log(list_venta);
                  $('#tbl_venta').empty();
                  $('#tbl_venta').append(
                      '<tr id="0">'
                      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
                      + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
                      + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
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
                    toastr.warning('Ingrese una cantidad válida')
                }else if(parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])){
                    toastr.warning('La sucursal no cuenta con suficientes, estan '+ parseInt(list_productos[key]['stock']) +' en existencia')                    
                }
            }
            $('#modal_inventario').modal('hide');
            status_modal_cantidad = 0;
            btn_act_desac();
            setTimeout(function () {
              $('#cantidad_add_venta').val(1)
          }, 500);
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
              'row_position': 0,
              'content_seccion': '',
              'status_autorizado': false,
              'tipo': 1,
          });
            pos_list_venta ++;
            //add_lista_venta_(list_venta[list_venta.length - 1]);

            $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
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
    }

    

function change_descuento(){    
    if(parseInt($('#descuento').val()) == 0){
        console.log(total_venta_global);
        $('#total_venta').attr('total', total_venta_global);
        $('#total_venta').text(formato_moneda(total_venta_global));
    }else{
        var porcentaje = 0;
        var resta = 0;
        var precio_final = 0;
        var descuento = $('#descuento').val();
        console.log(descuento);
        var total_venta = parseFloat($('#total_venta').attr('total'));
        console.log(total_venta);
        porcentaje = parseInt(descuento)/100;
        console.log(porcentaje);
        resta = parseInt(total_venta)*porcentaje;
        console.log(resta);
        total_venta = total_venta - resta;
        console.log(precio_final);   
        //total_venta += precio_final;
        $('#total_venta').attr('total', total_venta);
        $('#total_venta').text(formato_moneda(total_venta));
    }   
}

/*function add_lista_venta_(producto) {
  var porcentaje = 0;
  var resta = 0;
  var precio_final = 0;
  var descuento = '';
  var contenido_tbl = $('#tbl_venta').html();
  $('#tbl_venta').empty();
  if (producto.descuento === null || producto.descuento === 'null' || producto.descuento === '') {
      descuento = "0";
      precio_final = (producto.cantidad * parseInt(producto.precio_publico));
      console.log('Precio Final'+precio_final);
  }else {
      descuento = producto.descuento;
      console.log('Descuento '+producto.descuento);
      porcentaje = parseInt(producto.descuento)/100;
      console.log('Porcentaje '+porcentaje);
      resta = parseInt(producto.precio_publico)*porcentaje;
      console.log('Resta '+resta);
      precio_final = (producto.cantidad * parseInt(producto.precio_publico)) - resta;
      console.log('Precio Final '+precio_final);
  }
  $('#tbl_venta').append(                                    
      '<tr id="row' + (producto.key) + '">'
      + '<td><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="' + producto.cantidad + '" style="width:70px;"></td>'
      //+ '<td><span class="badge badge-warning" style="width:100%">' + producto.producto + '</span></td>'
      + '<td style="background-color: #f1f3b7"> ' + producto.producto + '</td>'
      + '<td style="background-color: #b7f3b7"><span>' + formato_moneda(producto.precio_publico) + '</span></td>'
      + '<td><input type="number" id="descuento' + (producto.key) + '" onchange="change_descuento('+(producto.key)+')" class="form-control form-control-sm" value="' + descuento + '" style="width:100px;"></td>'
      //+'<td style="background-color: #b7f3b7"><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="0" style="width:70px;"></td>'
      + '<td style="background-color: #b7f3b7"><span id="total' + (producto.key) + '">' + formato_moneda(precio_final) + '</span></td>'
      + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
      + '</tr>'
      );
  $('#tbl_venta').append(contenido_tbl);
  var total_venta = parseFloat($('#total_venta').attr('total'));
  total_venta += precio_final;
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));
  total_venta_global = total_venta;
  $('#cantidadX').focus();
  calcular();
}*/

function add_lista_venta_(producto) {
    console.log("Key add_lista_venta_ "+producto.key);
    var table = document.getElementById("tbl_venta");
    var row = table.insertRow(producto.row_position);
  if(producto.row_type == 1){

    var porcentaje = 0;
  var resta = 0;
  var precio_final = 0;
  var descuento = '';
  //var contenido_tbl = $('#tbl_venta').html();
  //$('#tbl_venta').empty();
  if (producto.descuento === null || producto.descuento === 'null' || producto.descuento === '') {
      descuento = "0";
      console.log('cantidad '+producto.cantidad+" "+producto.precio_publico+" "+producto.dias);
      precio_final = ((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias);
      console.log('Precio Final'+precio_final);
  }else {
      descuento = producto.descuento;
      console.log('Descuento '+producto.descuento);
      porcentaje = parseInt(producto.descuento)/100;
      console.log('Porcentaje '+porcentaje);
      resta = parseInt(((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias))*porcentaje;
      console.log('Resta '+resta);
      precio_final = ((producto.cantidad * parseInt(producto.precio_publico)) * producto.dias) - resta;
      console.log('Precio Final '+precio_final);
  }
  //$('#tbl_venta').append(        
     row.innerHTML = '<tr id="row-' + (producto.key) + '">'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
      + '<td><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="' + producto.cantidad + '" style="width:70px;"></td>'
      //+ '<td><span class="badge badge-warning" style="width:100%">' + producto.producto + '</span></td>'
      + '<td style="background-color: #f1f3b7"> ' + producto.producto + '</td>'
      + '<td style="background-color: #b7f3b7"><span>' + formato_moneda(producto.precio_publico) + '</span></td>'
      + '<td style="width: 90px;"><input tabindex="2" type="number" id="dias' + (producto.key) + '" onchange="change_dias(' + (producto.key) + ')"  class="form-control form-control-sm" min="1" value="' + producto.dias + '" style="width:70px;"></td>'
      + '<td><input type="number" id="descuento' + (producto.key) + '" onchange="change_descuento('+(producto.key)+')" class="form-control form-control-sm" value="' + descuento + '" style="width:100px;"></td>'
      //+'<td style="background-color: #b7f3b7"><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="0" style="width:70px;"></td>'
      + '<td style="background-color: #b7f3b7"><span id="total' + (producto.key) + '">' + formato_moneda(precio_final) + '</span></td>'
      + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
      + '</tr>';
      //);
  //$('#tbl_venta').append(contenido_tbl);
  /*var total_venta = parseFloat($('#total_venta').attr('total'));
  total_venta += precio_final;
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));
  total_venta_global = total_venta;*/
  $('#cantidadX').focus();
  calcular();

  }else if(producto.row_type == 2){
    var number1 = $('#tbl_venta tbody tr').length;
    var indx = number1 - 1;
    //var contenido_tbl = $('#tbl_venta').html();
        //$('#tbl_venta').empty();
        //$('#tbl_venta > tbody > tr').eq(producto.row_position).after(
        //$('#tbl_venta').append(
          var newRow = $('<tr id="row-' + (producto.key) + '">'
          +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
          + '<td></td>'
          + '<td style="background-color: #f1f3b7" id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-outline-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
          + '<td style="background-color: #b7f3b7"></td>'
          + '<td style="width: 90px;"></td>'
          + '<td></td>'      
          + '<td style="background-color: #b7f3b7"></td>'
          + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
          + '</tr>'
          );

          newRow.insertBefore($('#tbl_venta tbody tr:nth(' + indx + ')'));
        //$('#tbl_venta').append(contenido_tbl);

  }
}

function save_content_seccion(key){
    list_venta[key].content_seccion = $('#content_seccion_'+key).val();    
    $('#content_seccion_'+key).attr('disabled','disabled');
    //$('#div_content_seccion_'+key);
    var x = document.getElementById("div_content_seccion_"+key);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    $('#lbl_content_secccion_'+key).text($('#content_seccion_'+key).val());
}


function efectuar_pago() {
  var cliente_id = $('#select_cliente_id').val();
  var checkBox = document.getElementById("myCheck");
  var Data = new FormData();
  let tipo = $('#select_tipo_venta').val();
  var evento_id = $('#evento_id').val();
  Data.append('productos', JSON.stringify(list_venta));
  Data.append('productos_eliminados', JSON.stringify(list_eliminados));
  Data.append('tipo', tipo);
  Data.append('cliente_id', cliente_id);
  Data.append('evento_id', <?php echo json_encode($idCotizacion) ?>);
  Data.append('iva', true);
  Data.append('idCotizacion', <?php echo json_encode($idCotizacion) ?>);
  //Data.append('descuento', $('#descuento').val());
  Data.append('_token', '{{ csrf_token() }}');
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
              //$().toastmessage('showSuccessToast', "<br>Venta realizada");
              
              /*$('#rep_venta_id').val(evento_id);
              $('#btn_rep_venta').trigger('click');
              reiniciar_venta();
              btn_act_desac();
              $('#lbl_url_seguimiento').val(response.short_url);
              $('#modal_enviar_url').modal('show');

              */

              //window.open("https://sobre-la-mesa.com/evento");
              window.location("https://sobre-la-mesa.com/evento");
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  })
}

/*function reiniciar_venta() {
  list_venta = [];
  $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="" style="width:70px;" autofocus="autofocus"></td>'
      //+ '<td style="width: 120px;"><input tabindex="2" type="text" class="form-control form-control-sm focusNext" style="width: 100%"></td>'
      + '<td style="background-color: #f1f3b7"></td>'
      + '<td style="background-color: #b7f3b7"></td>'
      //+ '<td style="background-color: #b7f3b7"></td>'
      + '<td style="background-color: #b7f3b7"><span id="total0"></span></td>'
      + '</tr>'
      );
  $('#total_venta').text(formato_moneda(0));
  $('#total_venta').attr('total', 0);
}*/

function reiniciar_venta() {
  list_venta = [];
  $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
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
  list_eliminados.push(list_venta[key]['detalle_id']);
  list_venta.splice(key, 1);
  $('#row'+key).remove();
  pos_list_venta --;
  //var total_venta = 0;
  /*$('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="" style="width:70px;"></td>'
      + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
      + '<td style="width: 100px;"><input tabindex="2" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
      + '<td></td>'
      + '</tr>'
      );*/
      $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
      + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
      +'<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
      + '<td style="width: 100px;"><input tabindex="3" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px"></td>'
      + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
      + '<td></td>'
      + '</tr>'
      );
  $.each(list_venta, function (key, venta) {
      venta.key = venta.key - 1;
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
    console.log(total_venta);
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

/*function change_cantidad(key) {
  var cantidad = parseInt($('#cantidad' + key).val());//Asignamos la nueva cantidad a variable
  if(cantidad > list_venta[key].stock){
    toastr.warning('La cantidad no puede ser mayor al stock existente');
  }else{

    list_venta[key].cantidad = cantidad;//A la lista le ponemos la nueva cantidad
  if (list_venta[key].descuento === null || list_venta[key].descuento === 'null' || list_venta[key].descuento === '' || list_venta[key].descuento === 0) {
      $('#total' + key).text(formato_moneda(cantidad * list_venta[key].precio_publico));//En vista colocamos el nuevo total      
  }else {
      var porcentaje = parseInt(list_venta[key].descuento)/100;      
      var resta = parseInt(list_venta[key].precio_publico) * porcentaje;      
      var precio_final = (cantidad * parseInt(list_venta[key].precio_publico)) - resta;
      $('#total' + key).text(formato_moneda(precio_final));//En vista colocamos el nuevo total
  }
  calcular();
    
  }
  
  var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));  
}*/


function change_cantidad(key) {
  var cantidad = parseInt($('#cantidad' + key).val());//Asignamos la nueva cantidad a variable
  if(cantidad > list_venta[key].stock || cantidad > parseInt(list_productos[key]['stock'])){
    //toastr.warning('La cantidad no puede ser mayor al stock existente');
    $('#key').val(key);
    $('#modal_confirm_sobre_vender').modal('show');
  }else{

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
  
  /*var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));  */
}


/*function change_descuento(key) {
  var descuento = parseInt($('#descuento' + key).val());//Asignamos la nueva descuento a variable
  list_venta[key].descuento = descuento;//A la lista le ponemos la nueva descuento
  if (list_venta[key].descuento === null || list_venta[key].descuento === 'null' || list_venta[key].descuento === '' || list_venta[key].descuento === 0) {
      $('#total' + key).text(formato_moneda(list_venta[key].cantidad * list_venta[key].precio_publico));//En vista colocamos el nuevo total      
  }else {
      var porcentaje = parseInt(list_venta[key].descuento)/100;      
      var resta = parseInt(list_venta[key].precio_publico) * porcentaje;      
      var precio_final = (list_venta[key].cantidad * parseInt(list_venta[key].precio_publico)) - resta;
      $('#total' + key).text(formato_moneda(precio_final));//En vista colocamos el nuevo total
  }
  calcular();
  var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));  
}*/

function change_descuento(key) {
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
    /*
    Recalcularemos todas las opciones
    Iteramos productos y se valida si trae descuento o no
    Se suman los 3 defaults
    se valida iva
    se muestra total
    */
    var total_productos = 0;
    var flete;
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
    console.log('flete '+flete+' montaje '+montaje+' lavado_desinfeccion '+lavado_desinfeccion);
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
    console.log('total_productos '+total_productos);
    total_venta = parseInt(total_productos) + parseInt(flete) + parseInt(montaje) + parseInt(lavado_desinfeccion);
    console.log('total_venta '+total_venta);  
    if (config_iva == 1){
        var iva = total_venta * 0.16;
        console.log('iva '+iva);
        total_venta = total_venta + iva;
        console.log('total_venta '+total_venta);
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
}

  /*function calcular(){
  
    Recalcularemos todas las opciones
    Iteramos productos y se valida si trae descuento o no
    Se suman los 3 defaults
    se valida iva
    se muestra total
    
    var total_productos = 0;
    var flete = parseInt($('#flete').val());
    var montaje = parseInt($('#montaje').val());
    var lavado_desinfeccion = parseInt($('#lavado_desinfeccion').val());
    var total_venta = 0;
    console.log('flete '+flete+' montaje '+montaje+' lavado_desinfeccion '+lavado_desinfeccion);
    $.each(list_venta, function (key, venta) { 
        if (venta.descuento === null || venta.descuento === 'null' || venta.descuento === '' || venta.descuento === 0) {
           total_productos += parseInt(venta.cantidad) * parseInt(venta.precio_publico);
        }else {
          var porcentaje = parseInt(venta.descuento)/100;      
          var resta = parseInt(venta.precio_publico) * porcentaje;      
          var precio_final = (venta.cantidad * parseInt(venta.precio_publico)) - resta;
          total_productos += precio_final;
        }
    });
    console.log('total_productos '+total_productos);
    total_venta = parseInt(total_productos) + parseInt(flete) + parseInt(montaje) + parseInt(lavado_desinfeccion);
    console.log('total_venta '+total_venta);  
    if (config_iva == 1){
        var iva = total_venta * 0.16;
        console.log('iva '+iva);
        total_venta = total_venta + iva;
        console.log('total_venta '+total_venta);
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
    $('#total_venta').text(formato_moneda(total_venta));
}*/

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

function add_seccion_table(){
    var contenido_tbl = $('#tbl_venta').html();
    $('#tbl_venta').empty();
    $('#tbl_venta').append(
      '<tr id="row-1">'
      +'<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
      + '<td></td>'
      + '<td style="background-color: #f1f3b7"><div class="input-group"><input tabindex="1" type="text" id="seccion1" class="form-control form-control-sm" autofocus="autofocus"><div class="input-group-append"><button onclick="save_seccion()" class="btn btn-outline-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
      + '<td style="background-color: #b7f3b7"></td>'
      + '<td style="width: 90px;"></td>'
      + '<td></td>'      
      + '<td style="background-color: #b7f3b7"></td>'
      + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(1)"><i class="fa fa-trash"></i></button></td>'
      + '</tr>'
      );
    $('#tbl_venta').append(contenido_tbl);

    list_seccions.push({
      'content': '',
      'position_list': 0,          
  });
}

$('#tbl_venta').sortable({
    axis: 'y',
    update: function (event, ui) {
        /*var data = $(this).sortable('serialize');
        console.log(data);*/
        //console.log(ui.item[0].id);
        //console.log('row_position en list_venta a modificar'+parseInt(ui.item[0].id.replace('row-', '')));
        //console.log('nueva row_position '+ui.item.index());
        //console.log(list_venta);
        //console.log("/////////////////////////////////////////////////////////////////////////");
        //list_venta[parseInt(ui.item[0].id.replace('row-', ''))].row_position = ui.item.index();
        //const fromIndex = parseInt(ui.item[0].id.replace('row-', '')); // 0
        //console.log(fromIndex);
        const toIndex = ui.item.index();
        //console.log(toIndex);
        //const element = list_venta.splice(fromIndex, 1)[0];
        //console.log(element);
        //list_venta.splice(toIndex, toIndex, element);
        //list_venta.splice(2, 0, "Lene");


        //move(list_venta, fromIndex, toIndex);
        //console.log(list_venta);

        var data = $(this).sortable('serialize');
        var result = $(this).sortable("toArray");
        console.log("result "+result[0]);
        //console.log("data"+data[0]);



        //console.log("data "+data);
        console.log("result "+result);

        for (var i = 0; i < result.length; i++) {
            list_venta[parseInt(result[i].replace('row-', ''))].row_position = i;
            console.log("result "+result[i]);
        }


        $('#tbl_venta').each(function() {
            ///$(this).children('td:first-child').html($(this).index())
            //console.log("each "+$(this).index());
        });



        console.log(list_venta);
    }
});

</script>
@endsection