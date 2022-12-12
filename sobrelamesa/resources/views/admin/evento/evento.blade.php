@extends('admin.template.main')

@section('title','Sobre La Mesa | Evento')

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
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
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

                    <form method="POST" action="{{ route('evento.imprimir_reporte_cotizacion') }}" accept-charset="UTF-8" target="_blank">
                        {!! Form::token() !!}
                        <!--<button type="submit" class="btn btn-app bg-teal" id="btn_print"><i class="fas fa-print"></i> Imprimir Factura</button>-->
                        <button id="btn_generate_pdf" type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generar PDF
                        </button>
                        <input type="hidden" id="evento_id_reporte" name="evento_id_reporte">        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_add_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_cliente">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo">
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Empresa</label>
                                <input type="text" class="form-control" name="empresa" id="empresa">
                            </div>
                        </div>

                        

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Celular</label>
                                <input type="text" class="form-control" name="celular1" id="celular1">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Celular</label>
                                <input type="text" class="form-control" name="celular2" id="celular2">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Correo Electronico</label>
                                <input type="text" class="form-control" name="correo_electronico" id="correo_electronico">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Tipo Cliente</label>                                
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_tipo_cliente" name="tipo_cliente" required="required">
                                    <option value="1">Empresa</option>
                                    <option value="2">Wedding Planner / Planner</option>
                                    <option value="3">Privado</option>
                                    <option value="4">Venue / Hotel</option>
                                    <option value="5">Banquetera</option>                                    
                                </select> 
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">RFC</label>
                                <input type="text" class="form-control" name="rfc" id="rfc">
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">C.P.</label>
                                <input type="text" class="form-control" name="cp" id="cp">
                            </div>
                        </div>


                        
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Table Solver</label>                                
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_agente_id_2" name="agente_id" required="required">
                                                                      
                                </select> 
                            </div>
                        </div>




                    </div>
                </div>
                <input type="hidden" name="clienteID" id="clienteID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                </div>
            </form>
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
                    <form id="form_add_evento">

                        <div id="idCard" class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Datos del Evento</h3>

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
                                        <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" value="{{date('Y-m-d')}}"/>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <label for="name">Cliente</label>
                                    <div class="input-group">                                        
                                        <!--<input type="text" class="form-control" name="cliente_id" id="cliente_id">-->
                                        <select class="form-control form-control-sm form-reg-paso1 " id="select_cliente_id" name="cliente_id" required="required">                                            
                                        </select>
                                        <div class="input-group-append"><button onclick="modal_add_cliente()" class="btn btn-outline-success btn-sm" type="button"><i class="fa fa-plus"></i></button></div>
                                    </div>
                                </div>                                


                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="name">Table Solver</label>
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
                                        <input type="number" class="form-control" name="flete" id="flete" value="0">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Montaje</label>
                                        <input type="number" class="form-control" name="montaje" id="montaje" value="0">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4" style="display: none;">
                                    <div class="form-group">
                                        <label for="name">Lavado Desinfección</label>
                                        <input type="number" class="form-control" name="lavado_desinfeccion" id="lavado_desinfeccion" value="0">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer clearfix">                
                                <!--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Registrar</a>-->
                                <button type="submit" class="btn btn-success float-right btn-sm" id="btn_add_evento">Registrar</button>
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
                                                <option value="2">RENTA DIRECTA</option>  
                                                <option value="3">NOTA DE PÉRDIDA</option>
                                            </select>
                                        </div>
                                    </div>

                                    

                                    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3" style="margin-top: 8px;">
                                      <span><!-- style="padding: 2px 2px;background-color: #f1f1f1;width: 200px;text-align: center;border: 1px #d8d9e2 solid; font-size: 16px; height: 50px;" --><!--<img src="{{asset('icons/icon-date.png')}}" alt="FOLIO-IMG" style="width: 25px;">--><img src="https://img.icons8.com/office/20/000000/calendar--v1.png"/> <b id="folio_">{{date('d-m-Y')}}</b></span>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-3" style="margin-top: 8px;">
                                      <button class="btn btn-success btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar una Sección o Nota</button>

                                          <!--<button class="btn btn-primary btn-xs" onclick="agregar_producto(0,2)"> <i class="fas
                                          fa-plus"></i> Agregar Nota </button>-->
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
                                                <td style="width: 100px;"><input tabindex="3" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" value="0" style="width: 100px"></td>
                                                <td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>
                                                <td><!--button class="btn btn-danger btn-sm" onclick="btn_eliminar(0)"><i class="fa fa-trash"></i></button--></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!--<ul id="sortable">
                                        <li id="fila-Uno">Fila Uno</li>
                                        <li id="fila-Dos">Fila Dos</li>
                                    </ul>
                                    Query string: <span></span>-->

                                    <!--<ul id="sortable"> 
                                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li> 
                                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li> 
                                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li> 
                                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li> 
                                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>     
                                    </ul> 
                                    <span>index</span>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_flete" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; color: black; display: none;"></button>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_montaje" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; color: black; display: none;"></button>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                          <button id="costo_lavado" class="btn btn-sm btn-default" disabled="disabled" style="width: 100%; color: black; display: none;"></button>
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
                            <button class="btn btn-lg btn-info" style="border-radius: 0px;" onclick="efectuar_pago()" id="btn_pagar" disabled="disabled">F12 REGISTRAR <!--<img src="{{asset('icons/icon-dollar.png')}}" alt="Icon x" style="width: 23px">--></button>
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
    var list_seccions = [];
    var ban = false;
    var isEdit = false;
    var temp_cantidad = 0;
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

                    $('#select_agente_id_2').empty();
                    $.each( response.objectAgente, function( key, agente ) {                        
                        $('#select_agente_id_2').append(
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
                            '<img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail">',
                            '<button type="button" class="btn btn-success btn-sm" onclick="agregar_producto('+key+',1)">Agregar</button>');
                        tbl_inventario.row.add(datos);
                        datos = [];
                    });
                    tbl_inventario.draw(false);
                    $('#btn_modal_inventario').text(response.objectProducto.length + " Productos (F2)");
                    //get_eventos();
                }else{
                    toastr.error('¡Ocurrio un error inesperado intentelo nueva mente!');                    
                }
            }
        });
    }

    $("#form_add_evento").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");

        $.ajax({
            method:'POST',
            url: "{{route('evento.form_add_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
            },
            success: function(response)
            {    
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
                $('#cantidadX').focus();
    
                $('#total_venta').attr('total', total_venta);
                $('#total_venta').text(formato_moneda(total_venta));
                $('#cantidadX').focus();
                /*$("#form_add_evento")[0].reset();
                $('#modal_add_evento').modal('hide');
                get_eventos();*/
            }
        });
    });

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

    $("#tbl_venta").disableSelection();

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

function efectuar_pago() {
    list_venta.reverse();
    $.each(list_venta, function (key, venta) {
        venta.row_position = key;
    });

  var cliente_id = $('#select_cliente_id').val();
  var checkBox = document.getElementById("myCheck");
  var Data = new FormData();
  let tipo = $('#select_tipo_venta').val();
  var evento_id = $('#evento_id').val();
  Data.append('productos', JSON.stringify(list_venta));
  Data.append('tipo', tipo);
  Data.append('cliente_id', cliente_id);
  Data.append('evento_id', evento_id);
  Data.append('iva', true);
  //Data.append('descuento', $('#descuento').val());
  Data.append('_token', '{{ csrf_token() }}');
  $.ajax({
      method: 'POST',
      url: "{{route('evento.insert_detalle_evento')}}",
      data: Data,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function () {
          //$().toastmessage('showNoticeToast', "<br>Procesando venta");
      },
      success: function (response) {
          if (response.status) {
              //window.location.href("https://sobre-la-mesa.com/evento");
              window.location.href = "https://sobre-la-mesa.com/evento";
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  })
}

function reiniciar_venta() {
  list_venta = [];
  reset_table_products();
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
  list_venta.splice(key, 1);
  $('#row'+key).remove();
  pos_list_venta --;
  //var total_venta = 0;
  reset_table_products();
  $.each(list_venta, function (key, venta) {
      //venta.key = venta.key - 1;
      venta.key = key;
      add_lista_venta_(venta);
  });
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

function change_cantidad(key) {
    key = list_venta.map(e => e.key).indexOf(key);
    var cantidad = parseInt($('#cantidad' + key).val());//Asignamos la nueva cantidad a variable
    console.log(" change_cantidad "+list_venta[key].stock+" "+list_productos[key]['stock']+" cantidad "+cantidad);
    if(cantidad > list_venta[key].stock || cantidad > parseInt(list_venta[key]['stock'])){
        $('#key').val(key);
        isEdit = true;
        temp_cantidad = cantidad;
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
}

function change_descuento(key) {
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
}

function change_dias(key){
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
    //console.log('total_productos '+total_productos);
    total_venta = parseInt(total_productos) + parseInt(flete) + parseInt(montaje) + parseInt(lavado_desinfeccion);
    //console.log('total_venta '+total_venta);  
    if (config_iva == 1){
        var iva = total_venta * 0.16;
        //console.log('iva '+iva);
        total_venta = total_venta + iva;
        //console.log('total_venta '+total_venta);
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

function modal_add_cliente(){       
    $("#form_add_cliente")[0].reset();
    $('#modal_add_cliente').modal('show');
    $('#lbl_title_modal').text('Nuevo Cliente');
    $('#btn_confirm_modal').text('Registrar');
}

$("#form_add_cliente").submit(function(e){
    e.preventDefault();
    var Data = new FormData(this);
    Data.append('_token',"{{ csrf_token() }}");
    var route = "";
    if (ban) {
        route = "{{route('cliente.form_edit_cliente')}}";
    } else {
        route = "{{route('cliente.form_add_cliente')}}";
    }

    $.ajax({
        method:'POST',
        url: route,
        data: Data,
        dataType : 'json',
        processData : false,
        contentType : false,
        beforeSend : function(){
        },
        success: function(response)
        {        
            $("#form_add_cliente")[0].reset();
            $('#modal_add_cliente').modal('hide');
            list_clientes.push(response.responseCliente);
            $('#select_cliente_id').append(
                '<option value="'+response.responseCliente.id+'">'+response.responseCliente.nombre_completo+'</option>'
                );
            $("#select_cliente_id option[value="+ response.responseCliente.id +"]").attr("selected",true);
            //get_clientes();
            if(ban){
                toastr.success('Cliente Actualizado Con Exito');
            }else{
                toastr.success('Cliente Registrado Con Exito');
            }
        }
    });
});




var pos_list_venta = 0;
function agregar_producto(key, row_type) {
    console.log(list_venta);
        if (row_type == 1) {//Tipo Producto
            if (parseInt(list_productos[key]['stock']) == 0 || parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])) {
                $('#key').val(key);
                $('#modal_confirm_sobre_vender').modal('show');
            } else {
                var id = parseInt(list_productos[key]['id']);
                if (parseInt($('#cantidadX').val()) > 0 && parseInt($('#cantidadX').val()) <= parseInt(list_productos[key]['stock'])) {
                    var cantidad = $('#cantidadX').val();
                    var descuento = $('#descuentoX').val();
                    var dias = $('#diasX').val();
                    list_venta.push({
                        'id': id,
                        'key': pos_list_venta,
                        'cantidad': cantidad,
                        'descuento': descuento,
                        'producto': list_productos[key]['producto'],
                        'precio_publico': list_productos[key]['precio_renta'],
                        'stock': list_productos[key]['stock'],
                        'dias': dias,
                        'row_type': row_type,
                        'row_position': pos_list_venta,
                        'content_seccion': '',
                        'status_autorizado': false
                    });
                    pos_list_venta++;        
                    reset_table_products();

                    console.log(list_venta);
                    $.each(list_venta, function (key, venta) {
                        add_lista_venta_(venta);
                    });
                } else {
                    if (parseInt($('#cantidadX').val()) == 0) {
                        toastr.warning('Ingrese una cantidad válida')
                    } else if (parseInt($('#cantidadX').val()) > parseInt(list_productos[key]['stock'])) {
                        toastr.warning('La sucursal no cuenta con suficientes, estan ' + parseInt(list_productos[key]['stock']) + ' en existencia')
                    }
                }
                $('#modal_inventario').modal('hide');
                status_modal_cantidad = 0;
                btn_act_desac();
                setTimeout(function () {
                    $('#cantidad_add_venta').val(1)
                }, 500);
            }
        } else if (row_type == 2) {
            list_venta.push({
                'id': 0,
                'key': pos_list_venta,
                'cantidad': 0,
                'descuento': 0,
                'producto': '',
                'precio_publico': 0,
                'stock': 0,
                'dias': 0,
                'row_type': row_type,
                'row_position': pos_list_venta,
                'content_seccion': '',
                'status_autorizado': false
            });
            pos_list_venta++;
            reset_table_products();
            $.each(list_venta, function (key, venta) {
                add_lista_venta_(venta);
                
            });     
        }
    }

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
        $('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="' + producto.cantidad + '" style="width:70px;"></td>'
                + '<td style="background-color: #f1f3b7"> ' + producto.producto + '</td>'
                + '<td style="background-color: #b7f3b7"><span>' + formato_moneda(producto.precio_publico) + '</span></td>'
                + '<td style="width: 90px;"><input tabindex="2" type="number" id="dias' + (producto.key) + '" onchange="change_dias(' + (producto.key) + ')"  class="form-control form-control-sm" min="1" value="' + producto.dias + '" style="width:70px;"></td>'
                + '<td><input type="number" id="descuento' + (producto.key) + '" onchange="change_descuento(' + (producto.key) + ')" class="form-control form-control-sm" value="' + descuento + '" style="width:100px;"></td>'
                + '<td style="background-color: #b7f3b7"><span id="total' + (producto.key) + '">' + formato_moneda(precio_final) + '</span></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );
        $('#tbl_venta').append(contenido_tbl);
        $('#cantidadX').focus();
        calcular();
    } else if (producto.row_type == 2) {
        var contenido_tbl = $('#tbl_venta').html();
        $('#tbl_venta').empty();
        if(producto.content_seccion != ''){

            $('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td></td>'
                + '<td style="background-color: #87CEFA;" id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
                + '<td style="background-color: #87CEFA"></td>'
                + '<td style="width: 90px;background-color: #87CEFA"></td>'
                + '<td style="background-color: #87CEFA"></td>'
                + '<td style="background-color: #87CEFA"></td>'
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
                + '<td style="background-color: #87CEFA" id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
                + '<td style="background-color: #87CEFA"></td>'
                + '<td style="width: 90px;background-color: #87CEFA"></td>'
                + '<td style="background-color: #87CEFA"></td>'
                + '<td style="background-color: #87CEFA"></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );
        }
        /*$('#tbl_venta').append(
                '<tr id="row-' + (producto.key) + '">'
                + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
                + '<td></td>'
                + '<td style="background-color: #28a745" id="lbl_content_secccion_' + (producto.key) + '"><div class="input-group" id="div_content_seccion_' + (producto.key) + '"><input tabindex="1" type="text" id="content_seccion_' + (producto.key) + '" class="form-control form-control-sm" autofocus="autofocus" value="' + (producto.content_seccion) + '"><div class="input-group-append"><button onclick="save_content_seccion(' + (producto.key) + ')" class="btn btn-outline-success btn-sm" type="button"><i class="fa fa-check"></i></button></div></td>'
                + '<td style="background-color: #28a745"></td>'
                + '<td style="width: 90px;background-color: #28a745"></td>'
                + '<td style="background-color: #28a745"></td>'
                + '<td style="background-color: #28a745"></td>'
                + '<td><button class="btn btn-danger btn-sm" onclick="btn_eliminar(' + (producto.key) + ')"><i class="fa fa-trash"></i></button></td>'
                + '</tr>'
                );*/
        $('#tbl_venta').append(contenido_tbl);
    }
}


$('#tbl_venta').sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        var result = $(this).sortable("toArray");
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
        $.each(list_venta, function (key, venta) {
            venta.key = key;
            add_lista_venta_(venta);
        });
    }
});


$("#form_confirm_sobre_vender").submit(function (e) {
    e.preventDefault();
    var pwds = "{{Auth::user()->pwds}}";
    if ($('#contrasena').val() == pwds) {
        if (isEdit) {
            list_venta[$('#key').val()].cantidad = temp_cantidad;
            list_venta[$('#key').val()].status_autorizado = true;
            if (list_venta[$('#key').val()].descuento === null || list_venta[$('#key').val()].descuento === 'null' || list_venta[$('#key').val()].descuento === '' || list_venta[$('#key').val()].descuento === 0) {
                $('#total' + $('#key').val()).text(formato_moneda((temp_cantidad * list_venta[$('#key').val()].precio_publico) * list_venta[$('#key').val()].dias));
            } else {
                var porcentaje = parseInt(list_venta[$('#key').val()].descuento) / 100;
                var resta = parseInt(((temp_cantidad * parseInt(list_venta[$('#key').val()].precio_publico)) * list_venta[$('#key').val()].dias)) * porcentaje;
                var precio_final = ((temp_cantidad * parseInt(list_venta[$('#key').val()].precio_publico)) * list_venta[$('#key').val()].dias) - resta;
                $('#total' + $('#key').val()).text(formato_moneda(precio_final));
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
        }
    } else {
        toastr.error('¡La contraseña es incorrecta!');
    }

});


function save_content_seccion(key){
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
    $('#lbl_content_secccion_'+key).text($('#content_seccion_'+key).val());
}



function reset_table_products(){
    $('#tbl_venta').empty();
    $('#tbl_venta').append(
        '<tr id="0">'
        + '<td><span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span></td>'
        + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
        + '<td style="background-color: #f1f3b7; opacity: .5;"></td>'
        + '<td style="background-color: #b7f3b7; opacity: .5;"></td>'
        + '<td style="width: 90px;"><input tabindex="2" type="number" id="diasX" class="form-control form-control-sm focusNext" min="1" value="1" style="width:70px;"></td>'
        + '<td style="width: 100px;"><input tabindex="2" type="numer" id="descuentoX" class="form-control form-control-sm focusNext" style="width: 100px" value="0"></td>'
        + '<td style="background-color: #b7f3b7; opacity: .5;"><span id="total0"></span></td>'
        + '<td></td>'
        + '</tr>'
        );
}

</script>
@endsection