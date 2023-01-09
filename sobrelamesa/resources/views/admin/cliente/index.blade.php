@extends('admin.template.main')

@section('title','Sobre La Mesa | Clientes')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endsection

@section('modal')
<div class="modal" id="modal_add_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <img id="img_profile" data-action="zoom" src=""  alt="" class="img-thumbnail" width="100" style="margin-left: 5px;">
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
                                <input type="number" class="form-control" name="celular1" id="celular1" pattern="[0-9]{10}" minlength="10" maxlength="10" placeholder="Solo 10 digitos">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Tel. de Empresa</label>
                                <input type="number" class="form-control" name="celular2" id="celular2" pattern="[0-9]{10}" minlength="10" maxlength="10" placeholder="Solo 10 digitos">
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
                                    <option value="3">Particular</option>
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
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_agente_id" name="agente_id" required="required">
                                                                      
                                </select> 
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Descuento</label>
                                <input type="text" class="form-control" name="descuento" id="descuento">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Forma de Pago Autorizada</label>                                
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_forma_pago_autorizada" name="forma_pago_autorizada" required="required">
                                    <option value="1">Muestra</option>
                                    <option value="2">Contra Entrega</option>
                                    <option value="3">Con Anticipo</option>
                                    <option value="4">Con Crédito</option>
                                    <option value="5">De Contado</option>
                                </select> 
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Constancia Fiscal</label>                                
                                <div class="custom-file">
                                    <input type="file" name="constancia_fiscal" id="constancia_fiscal" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Ine Frente</label>                                
                                <div class="custom-file">
                                    <input type="file" name="ine_front" id="ine_front" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Ine Atrás</label>                                
                                <div class="custom-file">
                                    <input type="file" name="ine_back" id="ine_back" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Comprobante de Domicilio</label>                                
                                <div class="custom-file">
                                    <input type="file" name="comprobante_domicilio" id="comprobante_domicilio" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
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
<div class="modal" id="modal_delete_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente cliente?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_cliente">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="modal_history_events" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tbl_eventos" class="display nowrap cell-border" style="width:50% !important; ">
                            <thead>
                                <tr>
                                    <th>key</th>
                                    <th></th>                                  
                                    <th>No. Cotización</th>
                                    <th>Status Productos</th>
                                    <th>Fecha Cotización</th>
                                    <!--<th>Cliente</th>
                                    <th>Celular</th>-->                                    
                                    <th>Table Solver</th>
                                    <th>Tipo Evento</th>
                                    <th>Número Personas</th>
                                    <th>Status</th>
                                    <th>Fecha Evento</th>
                                    <th>Fecha Entrega</th> 
                                    <th>Fecha Recolección</th>
                                    <th>Domicilio Entrega</th>
                                    <th>Email</th>
                                    <!--<th>Flete</th>     
                                    <th>Montaje</th>   
                                    <th>Lavado Desinfección</th>-->   
                                                                      
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!--<button type="button" class="btn btn-primary" id="btn_delete_cliente">Confirmar</button>-->
            </div>
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
      <div class="table-responsive">
    <table class="table">

        <tr>
        <th>Servicios</th>
        <td></td>
    </tr>
      
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
                        <h3 class="card-title">Clientes</h3>
                        <h3 class="text-right">
                            <button class="btn btn-success btn-xs pull-right" onclick="modal_add_cliente()"> 
                                <i class="fa fa-plus"></i> Cliente (F1)
                            </button>
                            <button class="btn btn-warning btn-xs" onclick="edit_cliente()">
                                <i class="fa fa-edit"></i> Editar (F2)
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_cliente()">
                                <i class="fas fa-trash"></i> Eliminar (SUPR)
                            </button> 
                        </h3>      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_clientes" class="display nowrap cell-border" style="width:70%">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Nombre Completo</th>
                                    <th>Empresa</th>
                                    <th>Celular</th>
                                    <th>Tel. de Empresa</th>
                                    <th>Correo Electronico</th>
                                    <th>Tipo Cliente</th>
                                    <th>RFC</th>
                                    <th>C.P.</th>
                                    <th>Descuento</th>
                                    <th>Forma de Pago Autorizada</th>
                                    <th>Table Solver</th> 
                                    <th>Constancia Fiscal</th>
                                    <th>Ine Frente</th>
                                    <th>Ine Atrás</th>
                                    <th>Comprobante de Domicilio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
    $('#menu_cliente').attr('class','nav-link active');
	var listclientes = [];
    var focus_cliente_id = null;
    var focus_key = null;
    var ban = false;
	var tblClientes = $('#tbl_clientes').DataTable({
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		"order": [[ 0, "asc" ]],
        "responsive": true,
        "columnDefs": [
            {
              "targets": [0,0],
              "visible": false,
              "searchable": false
            }
        ]
	});

    var listEventos = [];
    var tblEventos = $('#tbl_eventos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "order": [[ 0, "asc" ]],
        "pageLength": 100,
        "lengthMenu": [[200, 300, 500, -1], [200, 400, 500, "Todos"]],
        "responsive": true,
        //"fixedColumns": true,
        //"autoFill": true,
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
        get_personales();
    	get_clientes();

        moment.lang('es', {
          months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
          monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
          weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
          weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
          weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
            }
        );
    });

    $('#constancia_fiscal').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

    $('#ine_front').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

    $('#ine_back').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

    $('#comprobante_domicilio').on('change',function(){
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

    function get_personales(){
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        $.ajax({
            method: 'POST',
            url: "{{route('usuario.get_personales_type')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response){ 
                $('#select_agente_id').empty();               
                $.each(response.objectPersonal, function (key, personal) {                
                    $('#select_agente_id').append(
                        '<option value="'+personal.id+'">'+personal.name+'</option>'
                        );                    
                });                
            }
        });
    }

    function get_clientes(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('cliente.get_clientes')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
                if(response.status){
                    tblClientes.clear().draw();
                    var datos = [];
                    $.each(response.objectCliente, function (key, cliente) {                   
                        listclientes.push(cliente);
                        var tipo_cliente = "";
                        var forma_pago_autorizada = "";
                        if(cliente.tipo_cliente == 1){
                            tipo_cliente = 'Empresa';
                        }else if(cliente.tipo_cliente == 2){
                            tipo_cliente = 'Wedding Planner / Planner';
                        }else if(cliente.tipo_cliente == 3){
                            tipo_cliente = 'Particular';
                        }else if(cliente.tipo_cliente == 4){
                            tipo_cliente = 'Venue / Hotel';
                        }else if(cliente.tipo_cliente == 5){
                            tipo_cliente = 'Banquetera';
                        }else{
                            tipo_cliente = 'Sin Especificar';
                        }

                        if(cliente.forma_pago_autorizada == 1){
                            forma_pago_autorizada = 'Muestra';
                        }else if(cliente.forma_pago_autorizada == 2){
                            forma_pago_autorizada = 'Contra Entrega';
                        }else if(cliente.forma_pago_autorizada == 3){
                            forma_pago_autorizada = 'Con Anticipo';
                        }else if(cliente.forma_pago_autorizada == 4){
                            forma_pago_autorizada = 'Con Crédito';
                        }else if(cliente.forma_pago_autorizada == 5){
                            forma_pago_autorizada = 'De Contado';
                        }else{
                            forma_pago_autorizada = 'Sin Especificar';
                        }

                        datos.push(                         
                            key,
                            cliente.nombre_completo,
                            cliente.empresa,
                            cliente.celular1,
                            cliente.celular2,
                            cliente.correo_electronico,
                            tipo_cliente,
                            cliente.rfc,
                            cliente.cp,
                            cliente.descuento,
                            forma_pago_autorizada,
                            cliente.name,
                            '<img data-action="zoom" src="images/documentos/client_'+cliente.id+'/'+cliente.constancia_fiscal+'"  alt="" class="img-thumbnail" width="100">',
                            '<img data-action="zoom" src="images/documentos/client_'+cliente.id+'/'+cliente.ine_front+'"  alt="" class="img-thumbnail" width="100">',
                            '<img data-action="zoom" src="images/documentos/client_'+cliente.id+'/'+cliente.ine_back+'"  alt="" class="img-thumbnail" width="100">',
                            '<img data-action="zoom" src="images/documentos/client_'+cliente.id+'/'+cliente.comprobante_domicilio+'"  alt="" class="img-thumbnail" width="100">',
                            '<button type="button" class="btn btn-primary btn-sm" onclick="get_history_events('+key+')">Historial</button>'
                            );
                        tblClientes.row.add(datos);
                        datos = [];
                    });
                    tblClientes.draw(false);
                }else{

                }    			
    		}
    	});
    }

    function get_history_events(key){
        
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('clienteID', listclientes[key]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('cliente.get_history_events')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                tblEventos.clear().draw();
                var datos = [];
                $.each(response.objectEvento, function (key, evento) {
                        var status = '';
                        var status_sobrevendido = '';
                        if(evento.estatus == 1){
                            status = '<span class="badge badge-info">Cotizado</span>';//#17A2B8 -- 1
                        }else if(evento.estatus == 2){
                            status = '<span class="badge badge-success">Pagado</span>';//#28A745 -- 2
                        } else if(evento.estatus == 3){
                            status = '<span class="badge badge-primary">Autorizado</span>';//#007BFF -- 3
                        } else if(evento.estatus == 0){
                            status = '<span class="badge badge-danger">Cancelado</span>';//#DC3545 -- 0
                        } else if(evento.estatus == 4){
                            status = '<span class="badge badge-warning">Cuenta con Abonos</span>';//#FFC107 -- 4
                        }
                        listEventos.push(evento);

                        if(evento.status_sobrevendido){
                            status_sobrevendido = '<span class="badge badge-danger" onclick="get_products_autorizados('+key+')" style="cursor: pointer;">SobreVendido</span>';//#DC3545 -- 0
                        }else{
                            status_sobrevendido = '<span class="badge badge-success">Surtido</span>';//#28A745 -- 2
                        }

                        datos.push(
                            key,
                            '<button type="button" class="btn btn-primary btn-sm" onclick="details_event('+key+')">Detalle Evento</button>',
                            '00'+evento.id,  
                            status_sobrevendido,                                                    
                            moment(evento.fecha_cotizacion).format('LLLL'),
                            //evento.cliente,
                            //evento.celular1,                            
                            evento.agente,
                            evento.evento,
                            evento.no_personas,
                            status,
                            moment(evento.fecha_evento+' '+evento.hora_evento).format('LLLL'),
                            moment(evento.fecha_entrega+' '+evento.hora_entrega).format('LLLL'),
                            moment(evento.fecha_recoleccion+' '+evento.hora_recoleccion).format('LLLL'),
                            evento.domicilio_entrega,
                            evento.correo_electronico,
                            //formato_moneda(evento.flete),
                            //formato_moneda(evento.montaje),
                            //formato_moneda(evento.lavado_desinfeccion),
                            );
                    tblEventos.row.add(datos);
                    datos = [];
                });
                tblEventos.draw(false)
                $('#modal_history_events').modal('show');                                        
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
    			get_clientes();
                if(ban){
                    location.reload();
                    toastr.success('Cliente Actualizado Con Exito');
                }else{
                    toastr.success('Cliente Registrado Con Exito');
                }
    		}
    	});
    });

    $('#tbl_clientes tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblClientes.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_cliente_id = parseInt(tblClientes.row( this ).data()[0]);            
            focus_key = parseFloat(tblClientes.row( this ).data()[0]);            
            temp_row = tblClientes.row( this ).data();
            temp_row_index = tblClientes.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            modal_add_cliente();        
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_cliente();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Producto");
                toastr.warning('Seleccione un cliente');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblClientes.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_cliente();
            }else{
                toastr.warning('Seleccione un cliente');
            }
        }
    });

    function edit_cliente() {
        if (focus_key != null) {
            position = focus_key; 
            console.log('position '+position);       
            $('#nombre_completo').val(listclientes[position]['nombre_completo']);
            $('#empresa').val(listclientes[position]['empresa']);
            $('#celular1').val(listclientes[position]['celular1']);
            $('#celular2').val(listclientes[position]['celular2']);
            $('#correo_electronico').val(listclientes[position]['correo_electronico']);
            $("#select_tipo_cliente option[value="+ listclientes[position]['tipo_cliente'] +"]").attr("selected",true);        
            $('#rfc').val(listclientes[position]['rfc']);
            $('#cp').val(listclientes[position]['cp']);
            $('#descuento').val(listclientes[position]['descuento']);
            $("#select_forma_pago_autorizada option[value="+ listclientes[position]['forma_pago_autorizada'] +"]").attr("selected",true);
            $("#select_agente_id option[value="+ listclientes[position]['agente_id'] +"]").attr("selected",true);
            $('#clienteID').val(listclientes[position]['id']);
            $('#img_profile').attr("src", 'images/documentos/client_'+listclientes[position]['id']+'/'+listclientes[position]['ine_front']);
            $('#modal_add_cliente').modal('show');
            $('#lbl_title_modal').text('Editar Cliente');
            $('#btn_confirm_modal').text('Guardar Cliente');
            ban = true;
        }else{
            toastr.warning('Seleccione un cliente');
        }
    }

    function delete_cliente() {
        if (focus_key != null) {
            position = focus_key;
            $('#btn_delete_cliente').attr('onClick', 'confirm_delete_cliente(' + position + ')');
            $('#modal_delete_cliente').modal('show');
        }else{
            toastr.warning('Seleccione un cliente');
        }
    }

    function confirm_delete_cliente() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('clienteID', listclientes[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('cliente.delete_cliente')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_cliente').modal('hide');
                get_clientes();
                toastr.success('Cliente Eliminado Con Exito');              
            }
        });
    }

    function details_event(key){
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
                $('#evento_id_reporte').val(listEventos[key].id);                
                $('#lbl_info_client').empty();
                $('#lbl_dates_client').empty();
                $('#list_products').empty();
                $('#lbl_url_seguimiento').val(listEventos[key].url_seguimiento);
                $('#lbl_title_modal_details').text('Detalles No. de Evento: 00'+listEventos[key].id);
                $('#lbl_fecha_cotizacion').text('Fecha de Cotización: '+moment(listEventos[key].fecha_cotizacion).format('LLLL'));
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
                    +'<br><b>Fecha de Evento: </b> '+moment(listEventos[key].fecha_evento+' '+listEventos[key].hora_evento).format('LLLL')+'<br>'
                    +'<b>Fecha de Entrega:</b> '+moment(listEventos[key].fecha_entrega+' '+listEventos[key].hora_entrega).format('LLLL')+'<br>'
                    +'<b>Fecha de Recolección:</b> '+moment(listEventos[key].fecha_recoleccion+' '+listEventos[key].hora_recoleccion).format('LLLL'));
                // JavaScript program to illustrate 
                    // calculation of no. of days between two date 

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
                        +'<td>'+formato_moneda(multi)+'</td>';*/                          
                    $('#list_products').append(
                        '<tr>'
                        +'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"><br>Reposición c/u:<br>'+formato_moneda(producto.precio_reposicion)+'</td>'
                        +'<td>'+producto.producto+'</td>'
                        +'<td>'+producto.cantidad+'</td>'
                        +'<td>'+Difference_In_Days+'</td>'
                        +'<td>'+formato_moneda(producto.precio_renta)+'</td>'
                        +'<td>'+producto.dias+'</td>'
                        +'<td>'+producto.descuento+ '% ' +'</td>'
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