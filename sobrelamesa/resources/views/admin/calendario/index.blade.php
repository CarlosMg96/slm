@extends('admin.template.main')

@section('title','Sobre La Mesa | Calendario')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
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
                                <input type="text" class="form-control" name="tipo_cliente" id="tipo_cliente">
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
                                <label for="name">Agente</label>
                                <input type="text" class="form-control" name="agente_id" id="agente_id">
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

<!--<div class="row no-print">
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
</div>-->
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
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-12">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Status de Eventos</h4>
                </div>
                <div class="card-body">
                
                  <div id="external-events">
                    <div class="row">
                    
                    <!--<div class="external-event bg-warning">Go home</div>-->
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(1)" class="external-event bg-light col-md-2">Cotizando</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(3)" class="external-event bg-primary col-md-2">Autorizado</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(2)" class="external-event bg-success col-md-2">Pagado</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(0)" class="external-event bg-danger col-md-2">Cancelado</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(4)" class="external-event bg-warning col-md-2">C/ Abonos</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(5)" class="external-event bg-secondary col-md-2">C/ Firmados</div>
                    <div style="cursor: pointer; margin: 5px;" onclick="filter_events(100)" class="external-event bg-dark col-md-2">Todos</div>
                    <!--<div class="external-event bg-primary">Work on UI design</div>
                    <div class="external-event bg-danger">Sleep tight</div>
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>-->
                  </div>
                </div>
                </div>
           
              </div>
          
              
            </div>
          </div>

          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body p-0">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script type="text/javascript">
  $('#menu_calendario').attr('class','nav-link active');
	var listclientes = [];
  var focus_cliente_id = 0;
  var focus_key = 0;
  var ban = false;
  var datos = [];
  var listEventos = [];
  var calendar;

  $(document).ready(function () {
   console.log('document ready');
   //get_clientes();
   get_eventos();


   moment.lang('es', {
          months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
          monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
          weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
          weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
          weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
      }
      );
 });

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

        $.each(response.objectEvento, function (key, evento) {
          listEventos.push(evento);
          var status = '';
          if(evento.estatus == 1){
            status = '#c3c3c3';
          }else if(evento.estatus == 2){
            status = '#28A745';
          }
          else if(evento.estatus == 3){
            status = '#007BFF';
          }
          else if(evento.estatus == 4){
            status = '#FFC107';
          }
          else if(evento.estatus == 5){
            status = '#6c757d';
          }
          else if(evento.estatus == 0){
            status = '#DC3545';
          }
          let event = {
            title: "Evento "+'00'+evento.id+" "+evento.cliente, 
            start:evento.fecha_evento, 
            end:evento.fecha_recoleccion, 
            backgroundColor:status, 
            borderColor:status,
            id: key
          };                          
          datos.push(event);        
        });

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        calendar = new Calendar(calendarEl, {
          headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          themeSystem: 'bootstrap',
          locale: 'es',

          events: datos,
          eventClick: function(info) {
            details_event(info.event.id);
            /*alert('Event: ' + info.event.title);
            alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            alert('View: ' + info.view.type);
            // change the border color just for fun
            info.el.style.borderColor = 'red';*/
          },
          editable  : true,
          droppable : true, 
          drop      : function(info) {

            if (checkbox.checked) {

              info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
          }
        });
        calendar.render();
      }
    });
  }

  $(function () {

    /* initialize the external events
    -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }
        $(this).data('eventObject', eventObject)
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    var date = new Date()
    var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });


        

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
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
                   /* var table = document.getElementById("list_products");
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

    function filter_events(status_filter){
      var listEvent = calendar.getEvents();
      listEvent.forEach(event => { 
       event.remove()
     });
      //console.log('filter_events '+status_filter);
      /*var eventSources = calendar.getEventSources(); 
      var len = eventSources.length;
      for (var i = 0; i < len; i++) { 
        eventSources[i].remove();
      }*/        
      $.each(listEventos, function (key, evento) {
        console.log("Evento "+'00'+evento.id+" "+evento.cliente+" "+evento.estatus);
        var status = '';
        if(evento.estatus == 1){
          status = '#c3c3c3';          
        }else if(evento.estatus == 2){
          status = '#28A745';          
        }
        else if(evento.estatus == 3){
          status = '#007BFF';          
        }
        else if(evento.estatus == 4){
          status = '#FFC107';          
        }
        else if(evento.estatus == 5){
          status = '#808080';          
        }
        else if(evento.estatus == 0){
          status = '#DC3545';          
        }
        if(evento.estatus == status_filter){
          //var event = calendar.getEventById(key);
          //event.remove();
          console.log("IF ADD EVENTO "+"Evento "+'00'+evento.id+" "+evento.cliente);
          calendar.addEvent({
            title: "Evento "+'00'+evento.id+" "+evento.cliente, 
            start:evento.fecha_evento, 
            end:evento.fecha_recoleccion, 
            backgroundColor:status, 
            borderColor:status,
            id: key
          });
        }else if(status_filter == 100){
          /*var event = calendar.getEventById(key);
          event.remove();*/
          calendar.addEvent({
            title: "Evento "+'00'+evento.id+" "+evento.cliente, 
            start:evento.fecha_evento, 
            end:evento.fecha_recoleccion, 
            backgroundColor:status, 
            borderColor:status,
            id: key
          });
        }        
          /*$('#calendar').fullCalendar('removeEventSource', event);
          $('#calendar').fullCalendar('addEventSource', event);
          $('#calendar').fullCalendar('refetchEvents');*/
        });      
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

    function compartir_whatsapp(key){
        window.open('https://api.whatsapp.com/send?phone=52'+listEventos[key].celular1+'&text=Buen día '+listEventos[key].cliente+' anexamos la siguiente cotización mediante la siguiente URL: '+listEventos[key].url_seguimiento+'');
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