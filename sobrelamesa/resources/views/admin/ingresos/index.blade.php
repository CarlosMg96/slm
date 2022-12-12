@extends('admin.template.main')

@section('title','Sobre La Mesa | Ingresos')

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
                                <label for="name">Fecha Evento</label>
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
        <th style="width:50%">Subtotal:</th>
        <td id="lbl_subtotal"></td>
    </tr>
    <tr>
        <th>Flete</th>
        <td id="lbl_flete"></td>
    </tr>
    <tr>
        <th>Montaje</th>
        <td id="lbl_montaje"></td>
    </tr>
</table>
</div>
</div>

<div class="col-6">  

  <div class="table-responsive">
    <table class="table">
    <tr>
        <th>Lavado Desinfección</th>
        <td id="lbl_lavado_desinfeccion"></td>
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
    <div class="col-12">
      <button id="printButton" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</button>
      <button id="btn_correo" type="button" class="btn btn-danger float-right" style="margin-right: 5px;"><i class="fas fa-envelope"></i> Enviar Correo
      </button>
      <button id="btn_whatsapp" type="button" class="btn btn-success float-right" style="margin-right: 5px;"><i class="fab fa-whatsapp"></i> Enviar WhatsApp
      </button>
      <button id="btn_generate_pdf" type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
        <i class="fas fa-download"></i> Generar PDF
    </button>
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

                <div class="card"> <!--<div class="card-header"> <h3
                class="card-title">Eventos</h3> <h3 class="text-right">
                <a class="btn btn-primary btn-xs pull-right" href="{{route('evento.insert_new_evento')}}"><i class="fa fa-plus"></i>
                Evento (F1) </a> <button class="btn btn-success btn-xs
                pull-right"> <i class="fa
                fa-plus"></i> Tipo Evento (F3) </button> <button class="btn
                btn-warning btn-xs" onclick="edit_proveedor()"> <i class="fa
                fa-edit"></i> Editar (F2) </button> <button class="btn
                btn-danger btn-xs" onclick="edit_proveedor()"> <i class="fas
                fa-trash"></i> Eliminar (SUPR) </button> </h3> </div>-->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_pagos" class="display nowrap cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha de Pago</th>
                                    <th>Recibo</th>
                                    <th>No. Cotización</th>
                                    <th>Cliente</th>                                    
                                    <th>Evento</th>
                                    <th>Concepto</th>
                                    <th>Table Solver</th>
                                    <th>Método de Pago</th>
                                    <th>Importe</th>                                    
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
    $('#menu_ingreso').attr('class','nav-link active');
	var listIngresos = [];
	var tblPagos = $('#tbl_pagos').DataTable({
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		"order": [[ 0, "asc" ]],
        "responsive": true,      
	});

    $(document).ready(function () {
    	console.log('document ready');
        //get_config();
    	get_ingresos();
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

    function get_ingresos(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('evento.get_ingresos')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
    			tblPagos.clear().draw();
    			var datos = [];
    			$.each(response.objectIngresos, function (key, ingreso) {
                        var tipo_pago = '';
                        if(ingreso.forma_pago == 1){
                            tipo_pago = '<span class="badge badge-info">Efectivo</span>';
                        }else if(ingreso.forma_pago == 2){
                            tipo_pago = '<span class="badge badge-success">Transferencia</span>';
                        }                                     
                        listIngresos.push(ingreso);
                        datos.push(
                            '00'+ingreso.id,
                        	ingreso.fecha,
                            '<img data-action="zoom" src="images/comprobantes/'+ingreso.comprobante+'"  alt="" class="img-thumbnail">',
                            '#00'+ingreso.evento_id,
                        	ingreso.cliente,	
                        	ingreso.evento,
                        	ingreso.concepto,
                            ingreso.agente,                        
                            tipo_pago,
                            formato_moneda(ingreso.importe),
                            ''                            
                            //'<button type="button" class="btn btn-primary btn-sm" onclick="details_event('+key+')">Detalle Evento</button>'+
                            //' <button type="button" class="btn btn-success btn-sm" onclick="add_pay_event('+key+')">Agregar Pago</button>'
                        	);
                    tblPagos.row.add(datos);
                    datos = [];
                });
    			tblPagos.draw(false);
    		}
    	});
    }

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
                $('#lbl_info_client').empty();
                $('#lbl_dates_client').empty();
                $('#list_products').empty();
                $('#lbl_url_seguimiento').val(listEventos[key].url_seguimiento);
                $('#lbl_title_modal_details').text('Detalles No. de Evento: 00'+listEventos[key].id);
                $('#lbl_fecha_cotizacion').text('Fecha de Cotización: '+listEventos[key].fecha_cotizacion);
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
                    +'<br><b>Fecha de Evento: </b> '+listEventos[key].fecha_evento+' '+listEventos[key].hora_evento+'<br>'
                    +'<b>Fecha de Entrega:</b> '+listEventos[key].fecha_entrega+' '+listEventos[key].hora_entrega+'<br>'
                    +'<b>Fecha de Recolección:</b> '+listEventos[key].fecha_recoleccion+' '+listEventos[key].hora_recoleccion);
                // JavaScript program to illustrate 
                    // calculation of no. of days between two date 

                    // To set two dates to two variables
                    var date1 = new Date(listEventos[key].fecha_evento);
                    var date2 = new Date(listEventos[key].fecha_recoleccion);

                    // To calculate the time difference of two dates
                    var Difference_In_Time = date2.getTime() - date1.getTime();

                    // To calculate the no. of days between two dates
                    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

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
                        var multi = parseInt(producto.cantidad) * parseInt(producto.precio_renta);
                        subtotal += multi;
                    }else{
                        var porcentaje = parseInt(producto.descuento)/100;
                        var resta = parseInt(producto.precio_renta)*porcentaje;
                        var multi = (parseInt(producto.cantidad) * parseInt(producto.precio_renta)) - resta;
                        subtotal += multi;
                    }                                
                    $('#list_products').append(
                        '<tr>'
                        +'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"></td>'
                        +'<td>'+producto.producto+'</td>'
                        +'<td>'+producto.cantidad+'</td>'
                        +'<td>'+Difference_In_Days+'</td>'
                        +'<td>'+formato_moneda(producto.precio_renta)+'</td>'
                        +'<td>'+producto.descuento+'</td>'
                        +'<td>'+formato_moneda(multi)+'</td>'
                        );
                });
                if(listEventos[key].iva == 'true' || listEventos[key].iva == true){
                    iva = (subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion)) * 0.16;
                    total = subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion) + iva;
                }else{
                    total = subtotal + parseInt(listEventos[key].flete) + parseInt(listEventos[key].montaje) +parseInt(listEventos[key].lavado_desinfeccion);
                }
                
                $('#lbl_subtotal').text(formato_moneda(subtotal));
                $('#lbl_flete').text(formato_moneda(listEventos[key].flete));
                $('#lbl_montaje').text(formato_moneda(listEventos[key].montaje));
                $('#lbl_lavado_desinfeccion').text(formato_moneda(listEventos[key].lavado_desinfeccion));
                $('#lbl_iva').text(formato_moneda(iva));
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
                $().toastmessage('showNoticeToast', "<br>Seleccione un Evento");
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblPagos.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_evento();
            }else{
                $().toastmessage('showNoticeToast', "<br>Seleccione un Evento");
            }
        }
    });

    function edit_evento() {
        position = focus_key;        
        $('#nombre').val(listProductos[position]['nombre']);
        $('#descripcion').val(listProductos[position]['descripcion']);
        $('#costo').val(listProductos[position]['costo']);
        $('#precio').val(listProductos[position]['precio']);
        $('#descuento').val(listProductos[position]['descuento']);
        $('#peso').val(listProductos[position]['peso']);
        $('#codigo').val(listProductos[position]['codigo']);
        $('#stock').val(listProductos[position]['stock']);
        $('#productoID').val(listProductos[position]['id']);
        $('#modal_add_producto').modal('show');
        $('#lbl_title_modal').text('Editar Producto');
        $('#btn_confirm_modal').text('Guardar Cambios');
        ban = true;
    }

    function delete_evento() {
        position = focus_key;
        $('#btn_delete_producto').attr('onClick', 'confirm_delete_producto(' + position + ')');
        $('#modal_delete_producto').modal('show');
    }

    function confirm_delete_producto() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', listProductos[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_producto').modal('hide');
                get_productos();              
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