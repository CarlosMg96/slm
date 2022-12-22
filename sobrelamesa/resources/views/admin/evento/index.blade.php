@extends('admin.template.main')

@section('title','Sobre La Mesa | Evento')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<style type="text/css">
    div.container { max-width: 1200px }
</style>
@endsection

@section('modal')
<div class="modal" id="modal_add_evento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_evento">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha Cotización</label>
                                <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion" value="{{date('Y-m-d')}}"/>
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
                                <input type="text" class="form-control" name="numero_personas" id="numero_personas">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">IVA</label>
                                <input type="text" class="form-control" name="iva" id="iva">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha Evento </label>
                                <!--<input type="text" class="form-control" name="fecha_evento" id="fecha_evento">-->
                                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha Entrega</label>
                                <!--<input type="text" class="form-control" name="fecha_entrega" id="fecha_entrega">-->
                                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>


                        
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha Recolección</label>
                                <!--<input type="text" class="form-control" name="fecha_recoleccion" id="fecha_recoleccion">-->
                                <input type="date" class="form-control" id="fecha_recoleccion" name="fecha_recoleccion" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Domicilio Entrega</label>
                                <input type="text" class="form-control" name="domicilio_entrega" id="domicilio_entrega">
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Flete</label>
                                <input type="text" class="form-control" name="flete" id="flete">
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Montaje</label>
                                <input type="text" class="form-control" name="montaje" id="montaje">
                            </div>
                        </div>



                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Lavado Desinfección</label>
                                <input type="text" class="form-control" name="lavado_desinfeccion" id="lavado_desinfeccion">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="proveedorID" id="proveedorID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                </div>
            </form>
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
            <form id="form_add_evento">
                <div class="modal-body">
                    <div class="row">
                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Evento</label>
                                <input type="text" class="form-control" name="evento" id="evento">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="proveedorID" id="proveedorID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                    <button type="button" class="btn btn-primary" id="btn_confirm_"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_add_tipo_evento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal">Nuevo Tipo de Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_tipo_evento">
                <div class="modal-body">
                    <div class="row">
                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Evento</label>
                                <input type="text" class="form-control" name="evento" id="evento">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tipo_evento_ID" id="tipo_evento_ID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_view_details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal_details"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name">URL de Cotización</label>
                            <input type="text" class="form-control" name="lbl_url_seguimiento" id="lbl_url_seguimiento" autofocus="autofocus">
                        </div>
                    </div> 
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-12">
                      <h4>
                        Detalle de la Cotización
                        <small class="float-right" id="lbl_fecha_cotizacion"></small>
                    </h4>
                </div>
                
            </div>
            
            <div class="row invoice-info">
                
            
            <div class="col-sm-6 invoice-col" id="lbl_info_client">
                  
                </div>
        
        <div class="col-sm-6 invoice-col" id="lbl_dates_client">
          
      </div>
      
  </div>

  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
            <tr>
              <th>Imagen</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Permanencia</th>
              <th>Precio</th>
              <th>Días</th>
              <th>Descuento</th>
              <th>Subtotal</th>
          </tr>
      </thead>
      <tbody id="list_products">
        
  </tbody>
</table>
</div>

</div>


<div class="row">

    <div class="col-6">
      <div class="table-responsive" style="display: none;">
        <table class="table">
            <tr>
                <th>Flete</th>
                <td id="lbl_flete"></td>
            </tr>
            <tr>
                <th>Montaje</th>
                <td id="lbl_montaje"></td>
            </tr>
            <tr>
                <th>Lavado Desinfección</th>
                <td id="lbl_lavado_desinfeccion"></td>
            </tr>
        </table>
    </div>
</div>

<div class="col-6">  

  <div class="table-responsive">
    <table class="table">
        <tr>
        <th style="width:50%">Subtotal:</th>
        <td id="lbl_subtotal"></td>
    </tr>

    <tr>
        <th style="width:50%">Depósito en garantía:</th>
        <td id="lbl_deposito"></td>
    </tr>

    <tr>
        <th style="width:50%">Antes de impuestos:</th>
        <td id="lbl_antes_impuestos"></td>
    </tr>
    
    <tr>
        <th>IVA</th>
        <td id="lbl_iva"></td>
    </tr>
    <tr>
        <th>Total</th>
        <td id="lbl_total"></td>
    </tr>
</table>
</div>
</div>

</div>

<div class="row no-print">
    <div class="col-10">
      <button id="printButton" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</button>
      <button id="btn_correo" type="button" class="btn btn-danger float-right" ><i class="fas fa-envelope"></i> Enviar Correo
      </button>
      <button id="btn_whatsapp" type="button" class="btn btn-success float-right" style="margin-right: 5px;"><i class="fab fa-whatsapp"></i> Enviar WhatsApp
      </button>

      <!--<form method="POST" action="{{ route('evento.imprimir_reporte_cotizacion') }}" accept-charset="UTF-8" target="_blank">
        {!! Form::token() !!}
        <!--<button type="submit" class="btn btn-app bg-teal" id="btn_print"><i class="fas fa-print"></i> Imprimir Factura</button>
        <button id="btn_generate_pdf" type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
            <i class="fas fa-download"></i> Generar PDF
        </button>
        <input type="hidden" id="evento_id_reporte" name="evento_id_reporte">        
    </form>-->
      <!--<button id="btn_generate_pdf" type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
        <i class="fas fa-download"></i> Generar PDF
    </button>-->
</div>

<div class="col-2">    
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
</div>
</div>
<div class="modal-footer">
    <button id="btn_cancelar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>                
</div>
</div>
</div>
</div>

<div class="modal" id="modal_add_pago" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal_2"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_pago">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha Pago</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{date('Y-m-d')}}"/>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Importe</label>
                                <input type="text" class="form-control" name="importe" id="importe">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Método de Pago</label>
                                <!--<input type="text" class="form-control" name="cliente_id" id="cliente_id">-->
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_forma_pago_id" name="forma_pago" required="required">
                                    <option value="1">Efectivo</option>
                                    <option value="2">Transferencia</option> 
                                    <option value="3">Cheque</option>                                         
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Concepto</label>
                                <input type="text" class="form-control" name="concepto" id="concepto">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Comprobante</label>                                
                                <div class="custom-file">
                                    <input type="file" name="comprobante" id="comprobante" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
                            </div>
                        </div>
                         
                    </div>
                </div>
                <input type="hidden" name="evento_id" id="evento_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal_2"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_view_firma_autorizacion" tabindex="-1" role="dialog" style="overflow-y: auto;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
           <img id="img_firma_autorizacion" class="img-thumbnail"> 
         </div>
       </div>          
     </div>      
   </div>
 </div>
</div>

<div class="modal" id="modal_view_details_autorizao" tabindex="-1" role="dialog" style="overflow-y: auto;">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 table-responsive">

              <table class="table table-striped">
                <thead>
                    <tr>
                      <th>Clave</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>Fecha Autorizado</th>                      
                  </tr>
              </thead>
              <tbody id="list_products_autorizados">

              </tbody>
          </table>
      </div>
       </div>          
     </div>      
   </div>
 </div>
</div>

<div class="modal" id="modal_delete_evento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente evento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_evento">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <!--div class="row">
                <button class="btn btn-app" onclick="modal_add_proveedor()">
                    <i class="fa fa-user-plus"></i> Nuevo Proveedor
                </button>
            </div-->
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="col-sm-12 col-md-12 col-lg-12">

                <div class="card"> 
                    <div class="card-header">
                        <h3 class="card-title">Eventos</h3>                    
                        <h3 class="text-right">
                            <a class="btn btn-primary btn-xs pull-right" href="{{route('evento.insert_new_evento')}}"><i class="fa fa-plus"></i>
                                Evento (F1) 
                            </a> 
                            <button class="btn btn-success btn-xs pull-right" onclick="modal_add_tipo_evento()"> <i class="fa fa-plus"></i> Tipo Evento (F3) 
                        </button> 
                        <button class="btn btn-warning btn-xs" onclick="edit_evento()"> <i class="fa fa-edit"></i> Editar (F2) 
                    </button> 
                    <button class="btn btn-danger btn-xs" onclick="delete_evento()"> <i class="fas fa-trash"></i> Cancelar (SUPR) 
                </button> 
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation">
                </div> 
                
            </div>
                
            </div>
            
            
        </div>
                    <div class="card-body">
                        <table id="tbl_eventos" class="display nowrap cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>key</th>
                                    <th>No. Cotización</th>
                                    <th>Status Productos</th>
                                    <th>Fecha Cotización</th>
                                    <th>Cliente</th>
                                    <th>Celular</th>                                    
                                    <th>Table Solver</th>
                                    <th>Tipo Evento</th>
                                    <th>Número Personas</th>
                                    <th>Status</th>
                                    <th>Fecha Evento </th>
                                    <th>Fecha Entrega</th> 
                                    <th>Fecha Recolección</th>
                                    <th>Domicilio Entrega</th>
                                    <th>Email</th>
                                    <!--<th>Flete</th>     
                                    <th>Montaje</th>   
                                    <th>Lavado Desinfección</th>-->   
                                    <th></th>
                                    <th></th>
                                    <th></th>                          
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<!--<script src="https://momentjs.com/downloads/moment.min.js"></script>-->
<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script type="text/javascript">
    $('#menu_evento').attr('class','nav-link active');
	var listEventos = [];
    var focus_evento_id = null;
    var focus_key = null;
    var ban = false;
	var tblEventos = $('#tbl_eventos').DataTable({
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		"order": [[ 0, "asc" ]],
        "pageLength": 100,
        "lengthMenu": [[200, 300, 500, -1], [200, 400, 500, "Todos"]],
        "responsive": true,
        "columnDefs": [
            {
              "targets": [0,0],
              "visible": false,
              "searchable": false
            }
        ]      
	});

    $(document).ready(function () {
    	console.log('documento listo'  );
        //get_config();
        //Date range picker
        $('#reservation').daterangepicker({
            "locale": {
                "format": "MM/DD/YYYY",
                "separator": " - ",
                "applyLabel": "Consultar",
                "cancelLabel": "Cancelar",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Jue",
                "Vi",
                "Sa",        
                ],
                "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
                ],
                "firstDay": 1,
            },
            function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            }
        });
    	get_eventos();
        console.log($('#reservation').val());

        moment.lang('es', {
          months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
          monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
          weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
          weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
          weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
      }
      );

    });

    $('#reservation').on('apply.daterangepicker', function (ev, picker) {
        //alert('apply clicked!');
        //CONSULTAR POR RANGO DE FECHAS

        var startDate = picker.startDate;
        var endDate = picker.endDate;
        //alert("New date range selected: '" + startDate.format('YYYY-MM-DD') + "' to '" + endDate.format('YYYY-MM-DD') + "'");

        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('startDate', startDate.format('YYYY-MM-DD'));
        Data.append('endDate', endDate.format('YYYY-MM-DD'));

        $.ajax({
            method: 'POST',
            url: "{{route('evento.get_eventos_range_date')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response){
                tblEventos.clear().draw();
                var datos = [];
                $.each(response.objectEvento, function (key, evento) {
                        var status = '';
                        var status_sobrevendido = '';
                        var btn_events = '<button type="button" class="btn btn-primary btn-sm" onclick="details_event('+key+')">Detalle Evento</button>'+
                            ' <button type="button" class="btn btn-success btn-sm" onclick="add_pay_event('+key+')">Agregar Pago</button>'+
                            ' <button type="button" class="btn btn-dark btn-sm" onclick="view_firma_autorizado('+key+')">Firma</button>'+
                            ' <button type="button" class="btn btn-info btn-sm" onclick="form_aceptar_cotizacion('+key+')">Confirmar Cotización</button>';
                        var btn_print_revision = '';
                        if(evento.estatus == 1){
                            status = '<span class="badge badge-info">Cotizado</span>';//#17A2B8 -- 1
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" disabled style="opacity: 0.3; margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        }else if(evento.estatus == 2){
                            status = '<span class="badge badge-success">Pagado</span>';//#28A745 -- 2
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 3){
                            status = '<span class="badge badge-primary">Autorizado</span>';//#007BFF -- 3
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 0){
                            status = '<span class="badge badge-danger">Cancelado</span>';//#DC3545 -- 0
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 4){
                            status = '<span class="badge badge-warning">Cuenta con Abonos</span>';//#FFC107 -- 4
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        }

                        if(evento.status_sobrevendido){
                            status_sobrevendido = '<span class="badge badge-danger" onclick="get_products_autorizados('+key+')" style="cursor: pointer;">SobreVendido</span>';//#DC3545 -- 0
                        }else{
                            status_sobrevendido = '<span class="badge badge-success">Surtido</span>';//#28A745 -- 2
                        }

                        var datatime_evento = "";
                        var datatime_entrega = "";
                        var datatime_recoleccion = "";

                        if(evento.fecha_evento != "" && evento.hora_evento != ""){
                            datatime_evento = moment(evento.fecha_evento+' '+evento.hora_evento).format('LLLL');
                        }else{
                            datatime_evento = "Sin fecha u Hora, favor de verificar";
                        }

                        if(evento.fecha_entrega != "" && evento.hora_entrega != ""){
                            datatime_entrega = moment(evento.fecha_entrega+' '+evento.hora_entrega).format('LLLL');
                        }else{
                            datatime_entrega = "Sin fecha u Hora, favor de verificar";
                        }

                        if(evento.fecha_recoleccion != "" && evento.hora_recoleccion != ""){
                            datatime_recoleccion = moment(evento.fecha_recoleccion+' '+evento.hora_recoleccion).format('LLLL');
                        }else{
                            datatime_recoleccion = "Sin fecha u Hora, favor de verificar";
                        }
                   

                        listEventos.push(evento);
                        console.log("Hola mundo");
                        datos.push(
                            key,
                            '00'+evento.id,
                            status_sobrevendido,                                                     
                            moment(evento.fecha_cotizacion).format('LLLL'),
                            evento.cliente,
                            evento.celular1,                            
                            evento.agente,
                            evento.evento,
                            evento.no_personas,
                            status,
                            datatime_evento,
                            datatime_entrega,
                            datatime_recoleccion,
                            evento.domicilio_entrega,
                            evento.correo_electronico,
                            //formato_moneda(evento.flete),
                            //formato_moneda(evento.montaje),
                            //formato_moneda(evento.lavado_desinfeccion),
                            btn_events,
                            btn_print_revision,
                            '<form method="POST" action="{{ route("evento.imprimir_reporte_cotizacion") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Generar PDF</button><input type="hidden" id="evento_id_reporte" value="'+evento.id+'" name="evento_id_reporte"></form>'
                            );
                    tblEventos.row.add(datos);
                    datos = [];
                });
                tblEventos.draw(false);
            }
        });

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
                    get_eventos();
                }else{
                    swal("¡Ocurrio un error inesperado intentelo nueva mente!", "", "error");
                }
            }
        });
    }

    function get_eventos(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('evento.get_eventos')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
    			tblEventos.clear().draw();
    			var datos = [];
    			$.each(response.objectEvento, function (key, evento) {
                        var status = '';
                        var status_sobrevendido = '';
                        var btn_print_revision = '';
                        if(evento.estatus == 1){
                            status = '<span class="badge badge-info">Cotizado</span>';//#17A2B8 -- 1
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" disabled style="opacity: 0.3; margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        }else if(evento.estatus == 2){
                            status = '<span class="badge badge-success">Pagado</span>';//#28A745 -- 2
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 3){
                            status = '<span class="badge badge-primary">Autorizado</span>';//#007BFF -- 3
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 0){
                            status = '<span class="badge badge-danger">Cancelado</span>';//#DC3545 -- 0
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        } else if(evento.estatus == 4){
                            status = '<span class="badge badge-warning">Cuenta con Abonos</span>';//#FFC107 -- 4
                            btn_print_revision = '<form method="POST" action="{{ route("evento.imprimir_reporte_remision") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Imprimir Remisión</button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+evento.id+'"></form>';
                        }
                        listEventos.push(evento);

                        if(evento.status_sobrevendido){
                            status_sobrevendido = '<span class="badge badge-danger" onclick="get_products_autorizados('+key+')" style="cursor: pointer;">SobreVendido</span>';//#DC3545 -- 0
                        }else{
                            status_sobrevendido = '<span class="badge badge-success">Surtido</span>';//#28A745 -- 2
                        }

                        var datatime_evento = "";
                        var datatime_entrega = "";
                        var datatime_recoleccion = "";

                        if(evento.fecha_evento != "" && evento.hora_evento != ""){
                            datatime_evento = moment(evento.fecha_evento+' '+evento.hora_evento).format('LLLL');
                        }else{
                            datatime_evento = "Sin fecha u Hora, favor de verificar";
                        }

                        if(evento.fecha_entrega != "" && evento.hora_entrega != ""){
                            datatime_entrega = moment(evento.fecha_entrega+' '+evento.hora_entrega).format('LLLL');
                        }else{
                            datatime_entrega = "Sin fecha u Hora, favor de verificar";
                        }

                        if(evento.fecha_recoleccion != "" && evento.hora_recoleccion != ""){
                            datatime_recoleccion = moment(evento.fecha_recoleccion+' '+evento.hora_recoleccion).format('LLLL');
                        }else{
                            datatime_recoleccion = "Sin fecha u Hora, favor de verificar";
                        }

                        datos.push(
                            key,
                            '00'+evento.id,  
                            status_sobrevendido,                      	                        	
                        	moment(evento.fecha_cotizacion).format('LLLL'),
                        	evento.cliente,
                            evento.celular1,                            
                        	evento.agente,
                        	evento.evento,
                        	evento.no_personas,
                        	status,
                            datatime_evento,
                            datatime_entrega,
                            datatime_recoleccion,
                            evento.domicilio_entrega,
                            evento.correo_electronico,
                            //formato_moneda(evento.flete),
                            //formato_moneda(evento.montaje),
                            //formato_moneda(evento.lavado_desinfeccion),
                            '<button type="button" class="btn btn-primary btn-sm" onclick="details_event('+key+')">Detalle Evento</button>'+
                            ' <button type="button" class="btn btn-success btn-sm" onclick="add_pay_event('+key+')">Agregar Pago</button>'+
                            ' <button type="button" class="btn btn-dark btn-sm" onclick="view_firma_autorizado('+key+')">Firma</button>'+
                            ' <button type="button" class="btn btn-info btn-sm" onclick="form_aceptar_cotizacion('+key+')">Confirmar Cotización</button>',
                            btn_print_revision,
                            '<form method="POST" action="{{ route("evento.imprimir_reporte_cotizacion") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf" type="submit" class="btn btn-primary btn-sm" style="margin-left: 75px;"><i class="fas fa-download"></i> Generar PDF</button><input type="hidden" id="evento_id_reporte" value="'+evento.id+'" name="evento_id_reporte"></form>'
                            
                        	);
                    tblEventos.row.add(datos);
                    datos = [];
                });
    			tblEventos.draw(false);
    		}
    	});
    }

    function modal_add_tipo_evento(){
        $("#form_add_tipo_evento")[0].reset();
        $('#modal_add_tipo_evento').modal('show');
        $('#lbl_title_modal').text('Nuevo Tipo de Evento');
        $('#btn_confirm_modal').text('Registrar');        
    }

    $("#form_add_tipo_evento").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");        

        $.ajax({
            method:'POST',
            url: "{{route('evento.form_add_tipo_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
            },
            success: function(response)
            {        
                $("#form_add_tipo_evento")[0].reset();
                $('#modal_add_tipo_evento').modal('hide');                
                toastr.success('Tipo de Evento Registrado Con Exito');                
            }
        });
    });

    function modal_add_evento(){    	
        $("#form_add_evento")[0].reset();
        $('#modal_add_evento').modal('show');
        $('#lbl_title_modal').text('Nuevo Evento');
        $('#btn_confirm_modal').text('Registrar');
    }

    function add_pay_event(key){        
        $("#form_add_pago")[0].reset();
        $('#evento_id').val(listEventos[key].id);
        $('#modal_add_pago').modal('show');
        $('#lbl_title_modal_2').text('Nuevo Pago');
        $('#btn_confirm_modal_2').text('Registrar');
    }

    //Esta función sirve para vizualizar la imagen de la firma que esta en un formato png.
    function view_firma_autorizado(key){
        $('#img_firma_autorizacion').attr("src", "images/firmas/"+listEventos[key].firma);
   //  $('#img_firma_autorizacion').attr("src", "data:"+sig.jSignature('getData'));
        $('#modal_view_firma_autorizacion').modal('show');
        console.log("Clic en la vizualización de la firma");
        console.log("src", "images/firmas/"+listEventos[key].firma);
        console.log(key);
    }

    $("#form_add_pago").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");

        $.ajax({
            method:'POST',
            url: "{{route('evento.form_add_pago')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
            },
            success: function(response)
            {        
                $("#form_add_pago")[0].reset();
                $('#modal_add_pago').modal('hide');
                toastr.success('Pago registrado exitosamente');
                //get_eventos();
            }
        });
    });

    function details_event(key){
        console.log("detalles del evento");
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', listEventos[key].id);

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
                var datatime_evento = "";
                var datatime_entrega = "";
                var datatime_recoleccion = "";

                if(listEventos[key].fecha_evento != "" && listEventos[key].hora_evento != ""){
                    datatime_evento = moment(evento.fecha_evento+' '+evento.hora_evento).format('LLLL');
                }else{
                    console.log('Vamos de nuevo');
                    datatime_evento = "Sin fecha u Hora, favor de verificar";
                }

                if(listEventos[key].fecha_entrega != "" && listEventos[key].hora_entrega != ""){
                    datatime_entrega = moment(evento.fecha_entrega+' '+evento.hora_entrega).format('LLLL');
                }else{
                    datatime_entrega = "Sin fecha u Hora, favor de verificar";
                }

                if(listEventos[key].fecha_recoleccion != "" && listEventos[key].hora_recoleccion != ""){
                    datatime_recoleccion = moment(evento.fecha_recoleccion+' '+evento.hora_recoleccion).format('LLLL');
                }else{
                    datatime_recoleccion = "Sin fecha u Hora, favor de verificar";
                }
                $('#evento_id_reporte').val(listEventos[key].id);                
                $('#lbl_info_client').empty();
                $('#lbl_dates_client').empty();
                $('#list_products').empty();
                $('#lbl_url_seguimiento').val(listEventos[key].url_seguimiento);
                $('#lbl_title_modal_details').text('Detalles No. de Evento: 00'+listEventos[key].id);
                $('#lbl_fecha_cotizacion').text('Fecha de Cotización: ' + moment(listEventos[key].fecha_cotizacion).format('LLLL'));
                $('#btn_whatsapp').attr('onclick','compartir_whatsapp('+key+')');
                $('#btn_correo').attr('onclick','compartir_correo('+key+')');
                $('#lbl_info_client').append(
                    listEventos[key].empresa
                    +'<address><strong>'+listEventos[key].cliente+'</strong><br>'
                    +listEventos[key].domicilio_entrega+'<br>'                    
                    +'Telefono: '+listEventos[key].celular1+'<br>'
                    +'Email: '+listEventos[key].correo_electronico+'</address>');
                $('#lbl_dates_client').append(
                    '<b>No. de Cotización #00'+listEventos[key].id+'</b><br>'
                    +'<br><b>Fecha de Evento: </b> '+moment(listEventos[key].fecha_evento).format('LLLL') +'<br>'
                    +'<b>Fecha de Entrega:</b> '+moment(listEventos[key].fecha_entrega).format('LLLL')+'<br>'
                    +'<b>Fecha de Recolección:</b> '+moment(listEventos[key].fecha_recoleccion).format('LLLL'));
                // JavaScript program to illustrate 
                    // calculation of no. of days between two date 
                        console.log("Fechas modal arriba");
                        console.log(fecha_evento.value);
                        console.log(fecha_cotizacion.value);
                    //    console.log(hora_evento);
                    //    console.log(moment(datatime_entrega.format('LLLL')));
                    // To set two dates to two variables
                    var date1 = new Date(listEventos[key].fecha_evento);
                    var date2 = new Date(listEventos[key].fecha_recoleccion);

                    // To calculate the time difference of two dates
                    var Difference_In_Time = date2.getTime() - date1.getTime();

                    // To calculate the no. of days between two dates
                    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                    if(isNaN(Difference_In_Days)){
                        Difference_In_Days = "Días no Calculados (Sin fecha de recolección)"
                    }
                    //To display the final no. of days (result)
                    /*document.write("Total number of days between dates  <br>"
                     + date1 + "<br> and <br>" 
                     + date2 + " is: <br> " 
                     + Difference_In_Days);*/
                var subtotal = 0;
                var iva = 0;
                var total = 0;
                $.each(response.responseDetalleEvento, function (key, producto) {
                    if (producto.descuento === null || producto.descuento === 'null' || producto.descuento === '' || producto.descuento === 0) {
                        var multi = (parseInt(producto.cantidad) * parseInt(producto.precio_renta) * producto.dias);
                        //var iva_producto = multi * 0.16;
                        //multi = multi + iva_producto;
                        subtotal += multi;
                    }else{
                        var porcentaje = parseInt(producto.descuento)/100;
                        var resta = ((parseInt(producto.cantidad) * parseInt(producto.precio_renta)) * producto.dias) * porcentaje;
                        var multi = ((parseInt(producto.cantidad) * parseInt(producto.precio_renta)) * producto.dias) - resta;
                        //var iva_producto = multi * 0.16;
                        //multi = multi + iva_producto;
                        subtotal += multi;
                    }      
                    /*var table = document.getElementById("list_products");
                    var row = table.insertRow(producto.row_position);
                    //this adds row in 0 index i.e. first place
                    row.innerHTML = '<tr>'
                        +'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"><br>Reposición c/u:<br>'+formato_moneda(producto.precio_reposicion)+'</td>'
                        +'<td>'+producto.producto+'</td>'
                        +'<td>'+producto.cantidad+'</td>'
                        +'<td>'+Difference_In_Days+'</td>'
                        +'<td>'+formato_moneda(producto.precio_renta)+'</td>'
                        +'<td>'+producto.dias+'</td>'
                        +'<td>'+producto.descuento+'</td>'
                        +'<td>'+formato_moneda(multi)+'</td>'; */                       
                    $('#list_products').append(
                        '<tr>'
                        +'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"><br>Reposición c/u:<br>'+formato_moneda(producto.precio_reposicion)+'</td>'
                        +'<td>'+producto.producto+'</td>'
                        +'<td>'+producto.cantidad+'</td>'
                        +'<td>'+Difference_In_Days+'</td>'
                        +'<td>'+formato_moneda(producto.precio_renta)+'</td>'
                        +'<td>'+producto.dias+'</td>'
                        +'<td>'+producto.descuento+'</td>'
                        +'<td>'+formato_moneda(multi)+'</td>'
                        );
                });
                $.each(response.responseDetalleEventoContent, function (key, row_header) {
                    //$("#tabla tr:first").after(tr);
                    var table = document.getElementById("list_products");
                    var row = table.insertRow(row_header.row_position);
                    //this adds row in 0 index i.e. first place
                    row.innerHTML = '<td></td><td><b>'+row_header.content_seccion+'</b></td><td></td><td></td><td></td><td></td><td></td><td></td>';
                });

                /*if(listEventos[key].iva == 'true' || listEventos[key].iva == true){
                    //iva = (subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion)) * 0.16;
                    total = subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion) + iva;
                }else{
                    total = subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion);
                }*/

                subtotal += parseInt(listEventos[key].flete);
                subtotal += parseInt(listEventos[key].montaje);
                subtotal += parseInt(listEventos[key].lavado_desinfeccion);

                var iva = subtotal / 1.16;
                var iva2 = iva * 0.16;

                var deposito = iva * 0.35;

                var antes_impuestos = iva + deposito;
                var total = antes_impuestos + iva2;
                
                $('#lbl_subtotal').text(formato_moneda(iva));
                $('#lbl_deposito').text(formato_moneda(deposito));
                $('#lbl_antes_impuestos').text(formato_moneda(antes_impuestos));
                $('#lbl_flete').text(formato_moneda(listEventos[key].flete));
                $('#lbl_montaje').text(formato_moneda(listEventos[key].montaje));
                $('#lbl_lavado_desinfeccion').text(formato_moneda(listEventos[key].lavado_desinfeccion));
                $('#lbl_iva').text(formato_moneda(iva2));
                $('#lbl_total').text(formato_moneda(total));

                $('#modal_view_details').modal('show');
            }
        });        
    }

    function compartir_whatsapp(key){
        window.open('https://api.whatsapp.com/send?phone=52'+listEventos[key].celular1+'&text=Buen día '+listEventos[key].cliente+' anexamos la siguiente cotización mediante la siguiente URL: '+listEventos[key].url_seguimiento+'');
    }

    function compartir_correo(key){        
        var Data = new FormData();               
        Data.append('correo', listEventos[key].correo_electronico);
        Data.append('telefono', listEventos[key].celular1);
        Data.append('nombre_cliente', listEventos[key].cliente);
        Data.append('url_seguimiento', listEventos[key].url_seguimiento);
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
              /*$('#rep_venta_id').val(evento_id);
              $('#btn_rep_venta').trigger('click');
              reiniciar_venta();
              btn_act_desac();
              $('#lbl_url_seguimiento').val(response.short_url);
              $('#modal_enviar_url').modal('show');*/
              toastr.success('Correo enviado correctamente');
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  })
    }

    $('#printButton').on('click', function () {
        if ($('.modal').is(':visible')) {
            var modalId = $(event.target).closest('.modal').attr('id');
            $('body').css('visibility', 'hidden');
            $('#btn_correo').css('visibility', 'hidden');
            $('#btn_whatsapp').css('visibility', 'hidden');
            $('#btn_generate_pdf').css('visibility', 'hidden');
            $('#printButton').css('visibility', 'hidden');
            $('#btn_cancelar').css('visibility', 'hidden');            
            $("#" + modalId).css('visibility', 'visible');
            $('#' + modalId).removeClass('modal');
            window.print();
            $('body').css('visibility', 'visible');
            $('#' + modalId).addClass('modal');
            $('#btn_correo').css('visibility', 'visible');
            $('#btn_whatsapp').css('visibility', 'visible');
            $('#btn_generate_pdf').css('visibility', 'visible');
            $('#printButton').css('visibility', 'visible');
            $('#btn_cancelar').css('visibility', 'visible');
        } else {
            window.print();
        }
    });

    $("#form_add_evento").submit(function(e){
    	e.preventDefault();
    	var Data = new FormData(this);
        console.log("Formulario de añadir evento");
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
    			$("#form_add_evento")[0].reset();
    			$('#modal_add_evento').modal('hide');
    			get_eventos();
    		}
    	});
    });

    $('#tbl_eventos tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblEventos.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_producto_id = parseInt(tblProductos.row( this ).data()[0]);            
            focus_key = parseFloat(tblEventos.row( this ).data()[0]);            
            temp_row = tblEventos.row( this ).data();
            temp_row_index = tblEventos.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            window.location.href = "{{route('evento.insert_new_evento')}}";                
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_evento();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Evento");
                toastr.warning('Seleccione un Evento');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblEventos.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_evento();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Evento");
                toastr.warning('Seleccione un Evento');
            }
        }
    });

    function edit_evento() {
        if (focus_key != null) {
            position = focus_key;
            window.location.href="edit_evento/"+listEventos[position]['id'];
            ban = true;
        }else{
            toastr.warning('Seleccione un Evento');
        }
    }

    function delete_evento() {
        if (focus_key != null) {            
            position = focus_key;
            $('#btn_delete_evento').attr('onClick', 'confirm_delete_evento(' + position + ')');
            $('#modal_delete_evento').modal('show');
        }else{
            toastr.warning('Seleccione un Evento');
        }
    }

    function confirm_delete_evento() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('evento_id', listEventos[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('evento.delete_evento')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_evento').modal('hide');
                get_eventos();
                toastr.success('El evento fue eliminado con exito');              
            }
        });
    }

    function get_products_autorizados(key){

        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', listEventos[key].id);

        $.ajax({    
            method: 'POST',
            url: "{{route('evento.details_products_autorizado')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response){ 
                $('#list_products_autorizados').empty(); 
                $.each(response.objectProductAutorizado, function (key, producto) { 
                    $('#list_products_autorizados').append(
                        '<tr>'
                        //+'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"><br>Reposición c/u:<br>'+formato_moneda(producto.precio_reposicion)+'</td>'
                        +'<td>'+producto.clave+'</td>'
                        +'<td>'+producto.producto+'</td>'
                        +'<td>'+producto.cantidad+'</td>'
                        +'<td>'+producto.created_at+'</td>'
                        +'</tr>'
                        //+'<td>'+Difference_In_Days+'</td>'
                        //+'<td>'+formato_moneda(producto.precio_renta)+'</td>'
                        //+'<td>'+producto.dias+'</td>'
                        //+'<td>'+producto.descuento+'</td>'
                        //+'<td>'+formato_moneda(multi)+'</td>'
                        );
                });
                $('#modal_view_details_autorizao').modal('show');
            }
        });
    }


    function form_aceptar_cotizacion(key){
        var Data = new FormData();
        Data.append('_token',"{{ csrf_token() }}");
        Data.append('evento_id', listEventos[key].id); 

        //alert("Estas en el botton");

        $.ajax({
            method:'POST',
            url: "{{route('evento.confirm_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
              //alert("beforeSend");
            },
            success: function(response)
            {    
              //alert("success");
              if(response.status) {
                get_eventos();
                toastr.success('La cotización fue autorizada con exito');
              }else{
                
              }
              $('#modal_firma_cotizacion').modal('hide');
            }
        });
    }

    function formato_moneda(total) {
        // Create our number formatter.
        var formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',

          // These options are needed to round to whole numbers if that's what you want.
          //minimumFractionDigits: 0,
          //maximumFractionDigits: 0,
        });

        return formatter.format(total); /* $2,500.00 */
    }
</script>
@endsection