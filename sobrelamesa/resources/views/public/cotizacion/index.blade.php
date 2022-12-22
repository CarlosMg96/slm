@extends('admin.template.main_public')

@section('title','Sobre La Mesa | Cotización')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
<div class="modal" id="modal_firma_cotizacion" tabindex="-1" role="dialog" style="overflow-y: auto;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Firmar Cotización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_aceptar_cotizacion">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-12" style="text-align:center">
              <div class="row" style="text-align:center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                  <button type="button"  class="btn btn-warning" id="clear">
                    <i class="fa fa-trash"></i> Limpiar
                  </button>
                  <div class="wrapper2">                    
                    <canvas id="signature-pad" class="signature-pad" style="margin:10px;border: 2px solid #c7c7c7 !important;" width=450 height=250></canvas>
                  </div>
                </div>
              </div>                                    
            </div>
          </div>          
        </div>
        <input type="hidden" id="evento_id" name="evento_id" value="{{$evento_id}}">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" >Aceptar Cotización</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('content')
<?php 
$fecha = time();
date_default_timezone_set('America/Mexico_City');
  //setlocale(LC_TIME, "spanish");
  //setlocale(LC_ALL,"es_MX");
  //echo $fecha_actual = date('d-m-Y', $fecha);
setlocale(LC_ALL,"es_CO.utf8");
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    Detalle de la Cotización
                    <!--<small class="float-right">Fecha de Cotización: 
                      <?php  
                            $newDateCoti = date("d-m-Y", strtotime($objectEvento[0]->fecha_cotizacion)); 
                            $mesDescCoti = strftime("%A, %d de %B de %Y", strtotime($newDateCoti)); 
                            echo $mesDescCoti; 
                          ?></small>-->
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-2 invoice-col">
                  <img src="{{asset('images/icons/icono_logo.jpeg')}}" alt="logo" style="width: 100px; height: 100px;">
              </div>
                <div class="col-sm-4 invoice-col">
                  Sobre la Mesa
                  <address>
                    <strong>BNM191003N42</strong><br>
                    Amacuzac #246, Col. Hermosillo<br>
                    Coyoacán<br>
                    México, Ciudad de México (MX)<br>
                    04240
                  </address>
                </div>
                <!-- /.col -->

                <div class="col-sm-3 invoice-col">
                  {{$objectEvento[0]->empresa}}
                  <address>
                    <strong>{{$objectEvento[0]->nombre_completo}}</strong><br>
                    {{$objectEvento[0]->domicilio_entrega}}<br>                    
                    <b>Telefono:</b> {{$objectEvento[0]->celular1}}<br>
                    <b>Email:</b> {{$objectEvento[0]->correo_electronico}}<br>
                    <b>Tipo de Evento:</b> {{$objectEvento[0]->evento}}<br>
                    <b>Forma de Pago:</b> {{$objectEvento[0]->metodo_pago}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                  <b>No. de Cotización #{{$no_cotizacion}}</b><br>
                  <br>
                  <b>Fecha de Evento: </b> <br>
                  <?php  
                            $newDateEvento = date("d-m-Y", strtotime($objectEvento[0]->fecha_evento)); 
                            $mesDescEvento = strftime("%A, %d de %B de %Y", strtotime($newDateEvento));
                          Log::info("message");
                         
                           echo $mesDescEvento.' '.$objectEvento[0]->hora_evento; 
                     //     $fecha_e = moment(listEventos[key].fecha_evento).format('LLLL');
                     //    echo  $newDateEvento;
                          ?>
                          <br>
                  <b>Fecha de Entrega:</b> <br>
                  <?php  
                            $newDateEntrega = date("d-m-Y", strtotime($objectEvento[0]->fecha_entrega)); 
                            $mesDescEntrega = strftime("%A, %d de %B de %Y", strtotime($newDateEntrega)); 
                            echo $mesDescEntrega.' '.$objectEvento[0]->hora_entrega; 
                          ?><br>
                  <b>Fecha de Recolección:</b> <br>
                  <?php  
                            $newDateReco = date("d-m-Y", strtotime($objectEvento[0]->fecha_recoleccion)); 
                            $mesDescReco = strftime("%A, %d de %B de %Y", strtotime($newDateReco)); 
                            echo $mesDescReco.' '.$objectEvento[0]->hora_recoleccion; 
                          ?>
                </div>
                <div  class="col-sm-3 invoice-col">
                      <b>FECHA DE LA COTIZACIÓN: </b><br> 
                      <?php  
                            $newDateCoti = date("d-m-Y", strtotime($objectEvento[0]->fecha_cotizacion)); 
                            $mesDescCoti = strftime("%A, %d de %B de %Y", strtotime($newDateCoti)); 
                            echo $mesDescCoti.' '.$objectEvento[0]->hora_recoleccion; 
                          ?> <br>                    
                      <b>PLAZO DE PAGO: </b><br> {{$objectEvento[0]->forma_pago}}<br>
                      <b>TABLE SOLVER: </b><br> {{$objectEvento[0]->name}}<br>
                  </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <br>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Número</th>
                      <th>Imagen</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <!--<th>Permanencia</th>-->
                      <th>Precio</th>
                      <th>Días</th>
                      <?php
                        if ($is_descuento > 0) {
                            echo '<th>Descuento</th>';
                        }
                      ?>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subtotal = 0;
                        ?>
                    @foreach($objectDetalleEvento as $key => $detailsEvent)
                    <?php 
                        //print_r($detailsEvent);
                        
                        if($detailsEvent->tipo == 2){
                            //echo "Entro if";
                            //exit();
                    ?>
                    <tr>
                        <td colspan="7" align="center" style="font-size: 16px; font-weight: bold; background-color: #D3D3D3">{{$detailsEvent->content_seccion}}</td>
                    </tr>
                    <?php
                        }else{
                            //echo $detailsEvent->imagen;
                        
                    ?>                       
                    <tr>
                      <td><?php echo $key + 1; ?></td>
                      <td><img src="https://sobre-la-mesa.com/images/productos/{{$detailsEvent->imagen}}"  alt="" class="img-thumbnail" width="100" height="100"><br>Reposición c/u:<br>
                        <?php 
                          if($detailsEvent->precio_reposicion != 0){
                            echo '$' . number_format($detailsEvent->precio_reposicion, 2);
                          }else{
                            echo '$' . $detailsEvent->precio_reposicion;
                          }
                        ?>
                      </td>
                      <td>{{$detailsEvent->producto}}</td>
                      <td>{{$detailsEvent->cantidad}}</td>
                      <!--<td>
                          <?php
                            $datetime1 = date_create($objectEvento[0]->fecha_evento.' '.$objectEvento[0]->hora_evento);
                            $datetime2 = date_create($objectEvento[0]->fecha_recoleccion.' '.$objectEvento[0]->hora_recoleccion);                            
                            $interval = date_diff($datetime1, $datetime2);            
                            echo $interval->format('%R%a días %H horas %I minutos %S segundos');
                          ?>
                      </td>-->
                      
                      <td>
                        <?php
                            if($detailsEvent->descuento > 0){
                                echo '<del>'.'$' . number_format($detailsEvent->precio_renta, 2).'</del>';
                            }else{
                                echo '$' . number_format($detailsEvent->precio_renta, 2);
                            }
                        ?>
                        </td>
                      
                      <td>{{$detailsEvent->dias}}</td>
                      <?php
                        if ($is_descuento > 0) {
                      ?>
                      <td>{{$detailsEvent->descuento.'%'}}</td>
                      <?php  
                        }
                      ?>
                      <td>
                        <?php
                            if($detailsEvent->descuento == null || $detailsEvent->descuento == 'null' || $detailsEvent->descuento == '' || $detailsEvent->descuento == 0){
                              $multi = (($detailsEvent->cantidad*$detailsEvent->precio_renta) * $detailsEvent->dias);
                              $subtotal += $multi;
                              echo '$' . number_format($multi, 2);
                            }else{
                              $porcentaje = $detailsEvent->descuento / 100;
                              $resta = (($detailsEvent->cantidad * $detailsEvent->precio_renta) * $detailsEvent->dias) * $porcentaje;
                              $multi = (($detailsEvent->cantidad * $detailsEvent->precio_renta) * $detailsEvent->dias) - $resta;
                              $subtotal += $multi;
                              echo '$' . number_format($multi, 2);                              
                            }                            
                        ?>
                      </td>
                    </tr>
                    <?php
                    //exit();
                        }
                    ?>
                    @endforeach 
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <?php

                $subtotal += $objectEvento[0]->flete;
                $subtotal += $objectEvento[0]->montaje;
                $subtotal += $objectEvento[0]->lavado_desinfeccion;

              ?>

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                  <p class="lead">Métodos de Pago:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <!--<p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>-->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                  <!--<p class="lead">Amount Due 2/22/2014</p>-->

                  <div class="table-responsive">
                    <table class="table">
                      <!--<tr>
                        <th>Servicios</th>
                        <td></td>
                      </tr>
                      <tr>
                        <th>Flete</th>
                        <td>{{'$' . number_format($objectEvento[0]->flete, 2)}}</td>
                      </tr>
                      <tr>
                        <th>Montaje</th>
                        <td>{{'$' . number_format($objectEvento[0]->montaje, 2)}}</td>
                      </tr>
                      <tr>
                        <th>Lavado Desinfección</th>
                        <td>{{'$' . number_format($objectEvento[0]->lavado_desinfeccion, 2)}}</td>
                      </tr>-->
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?php 
                        $iva = $subtotal / 1.16;
                            echo '$' . number_format($iva, 2);
                      ?></td>
                      </tr> 
                      <tr>
                        <th>Depósito en garantía:</th>
                        <td><?php 
                        $deposito = $iva * 0.35;
                            echo '$' . number_format($deposito, 2);
                      ?></td>
                      </tr>
                      <tr>
                        <th>Antes de impuestos:</th>
                        <td><?php 
                        $antes_impuestos = $iva + $deposito;
                            echo '$' . number_format($antes_impuestos, 2);
                      ?></td>
                      </tr>                     
                      <tr>
                        <th>Iva</th>
                        <td>
                          <?php
                            /*if($objectEvento[0]->iva == 'true'){
                              $iva = ($subtotal + $objectEvento[0]->flete + $objectEvento[0]->montaje + $objectEvento[0]->lavado_desinfeccion) * 0.16;                              
                              echo '$' . number_format($iva, 2);
                            }else{
                              $iva = 0;
                              echo '$' . number_format($iva, 2);
                            }*/
                            
                            $iva2 = $iva * 0.16;
                            echo '$' . number_format($iva2, 2);
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <th>Total</th>
                        <td>
                            <?php
                                $total = $antes_impuestos + $iva2;
                               //$total = $subtotal + $objectEvento[0]->flete + $objectEvento[0]->montaje + $objectEvento[0]->lavado_desinfeccion + $iva;                               
                               echo '$' . number_format($total, 2);
                            ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a onclick="window.print();" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</a>
                  <button id="btn_autoriza_cotizacion" type="button" class="btn btn-success float-right" onclick="modal_firma_cotizacion()"><i class="far fa-credit-card"></i> Firmar Cotización
                  </button>
                  <!--<button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generar PDF
                  </button>-->
                  <form method="POST" action="{{ route('evento.imprimir_reporte_cotizacion') }}" accept-charset="UTF-8" target="_blank">
                      {!! Form::token() !!}
                      <!--<button type="submit" class="btn btn-app bg-teal" id="btn_print"><i class="fas fa-print"></i> Imprimir Factura</button>-->
                      <button id="btn_generate_pdf" type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                          <i class="fas fa-download"></i> Generar PDF
                      </button>
                      <input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="{{$evento_id}}">        
                  </form>
                </div>
              </div>
            </div>
            <!-- /.invoice -->                   
        </div>
    </section>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        console.log('document ready');

        moment.lang('es', {
          months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
          monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
          weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
          weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
          weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
        }
        );
        
    });

    var cancelButton = document.getElementById('clear');

    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });

    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });

    function modal_firma_cotizacion() {
      $('#modal_firma_cotizacion').modal('show');  
    }
    
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

                    $('#btn_modal_inventario').text("Consultando Refacciones...");
                    tbl_inventario.clear().draw();
                    var datos = [];
                    $.each(response.objectProducto, function (key, producto) {                   
                        list_productos.push(producto);
                        datos.push(                         
                            key,
                            producto.producto,
                            producto.stock,
                            producto.medidas,
                            producto.categoria,
                            formato_moneda(producto.precio_renta),
                            formato_moneda(producto.precio_reposicion),
                            '<img src="https://sobre-la-mesa.com/images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail">',
                            '<button type="button" class="btn btn-success btn-sm" onclick="agregar_producto('+key+')">Agregar</button>');
                        tbl_inventario.row.add(datos);
                        datos = [];
                    });
                    tbl_inventario.draw(false);
                    $('#btn_modal_inventario').text(response.objectProducto.length + " Productos (F2)");
                    //get_eventos();
                }else{
                    swal("¡Ocurrio un error inesperado intentelo nueva mente!", "", "error");
                }
            }
        });
    }

    function form_aceptar_cotizacion(){
      const firma = signaturePad.toDataURL('image/png');
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        Data.append('firma', firma);   

      //  alert("Estas en el botton");

        $.ajax({
            method:'POST',
            url: "{{route('evento.confirm_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
            //  alert("beforeSend");
            },
            success: function(response)
            {    
              //alert("success");
        //      console.log("Quiero saber si aquí pasa?");
              if(response.status) {
                $("#form_aceptar_cotizacion")[0].reset();
                signaturePad.clear();
                signaturePad.on();
                $('#btn_autoriza_cotizacion').attr('disabled','disabled');

                toastr.success('La cotización fue autorizada con exito');
              }else{
                
              }
              $('#modal_firma_cotizacion').modal('hide');
            }
            
        });
    }

    $("#form_aceptar_cotizacion").submit(function(e){
        e.preventDefault();
        //alert("Estas en el botton");
      //  console.log("Entro a la función de la aceptación de la cotización");
        const firma = signaturePad.toDataURL();
     //   console.log(firma);
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        Data.append('firma', firma);  
 //     console.log("Se guardo la firma");
        //alert("Estas en el botton");
          //Si se hace el post pero al vizualizarlo en la base de datos no se muestra
        $.ajax({
            method:'POST',
            url: "{{route('evento.confirm_evento')}}",
            data: Data,
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
           //   alert("beforeSend");
            },
            success: function(response)
            {   
              if(response.status) {
                $("#form_aceptar_cotizacion")[0].reset();
                signaturePad.clear();
                signaturePad.on();
                toastr.success('La cotización fue autorizada con exito');
                $('#btn_autoriza_cotizacion').attr('disabled','disabled');
                //toastr.success('La cotización fue autorizada con exito');
           //     alert("La cotización fue autorizada con exito");
              }else{
                alert("Hubo un error intentelo de nuevo");
              }
              $('#modal_firma_cotizacion').modal('hide');
            },
            error: function(xhr, status, error) {
              console.log("Hubo un error en la petición");
              console.log(status);
              console.log(error);

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

  function agregar_producto(key){
    if (parseInt(list_productos[key]['stock']) == 0) {              
      $().toastmessage('showNoticeToast', '<br>Sin existencias');
  } else {
      var id = parseInt(list_productos[key]['id']);
      if (parseInt($('#cantidadX').val()) > 0 && parseInt($('#cantidadX').val()) <= parseInt(list_productos[key]['stock'])) {
          var cantidad = $('#cantidadX').val();        
          list_venta.push({
              'id': id,
              'cantidad': cantidad,
              'key': key,
              'producto':  list_productos[key]['producto'],
              'precio': list_productos[key]['precio_renta']
          });
          //$().toastmessage('showSuccessToast', "<br>Agregada a lista");
          add_lista_venta_(list_venta[list_venta.length - 1]);          
      } else {
          if (parseInt($('#cantidad_add_venta').val()) > parseInt(tbl_inventario.row(focus_key).data()['total'])) {
              $().toastmessage('showErrorToast', "<br>La sucursal no cuenta con refacciones suficientes, en encontraon " + parseInt(tbl_inventario.row(focus_key).data()['total']) + ' en existencia');
          }
          if (parseInt($('#cantidad_add_venta').val()) == 0) {
              $().toastmessage('showErrorToast', "<br>Ingrese una cantidad válida");
          }
      }
      $('#modal_inventario').modal('hide');
      status_modal_cantidad = 0;
      btn_act_desac();
      setTimeout(function () {
          $('#cantidad_add_venta').val(1)
      }, 500);
      //$('#modal_inventario').modal('hide');

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

function add_lista_venta_(producto) {
  var porcentaje = 0;
  var resta = 0;
  var precio_final = 0;
  var contenido_tbl = $('#tbl_venta').html();
  $('#tbl_venta').empty();
  precio_final = (producto.cantidad * parseInt(producto.precio));
  /*var descuento = '';
  if (producto.descuento === null || producto.descuento === 'null') {
      descuento = "0";
      precio_final = (producto.cantidad * parseInt(producto.precio_publico));
  } else {
      descuento = producto.descuento;
      porcentaje = parseInt(producto.descuento)/100;
      resta = parseInt(producto.precio_publico)*porcentaje;
      precio_final = (producto.cantidad * parseInt(producto.precio_publico)) - resta;
  }*/
  $('#tbl_venta').append(                                    
      '<tr id="' + (producto.key) + '">'
      + '<td><input type="number" id="cantidad' + (producto.key) + '" onchange="change_cantidad(' + (producto.key) + ')" class="form-control form-control-sm" min="1" value="' + producto.cantidad + '" style="width:70px;"></td>'
      //+ '<td><span class="badge badge-warning" style="width:100%">' + producto.producto + '</span></td>'
      + '<td style="background-color: #f1f3b7"> ' + producto.producto + '</td>'
      + '<td style="background-color: #b7f3b7"><span onclick="change_precio(' + (producto.key) + ')">' + formato_moneda(producto.precio) + '</span></td>'
      //+ '<td style="background-color: #b7f3b7">' + descuento + '%</td>'
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
}

function efectuar_pago() {
  var cliente_id = $('#select_cliente').val();
  var Data = new FormData();
  let tipo = $('#select_tipo_venta').val();
  var evento_id = $('#evento_id').val();
  Data.append('productos', JSON.stringify(list_venta));
  Data.append('tipo', tipo);
  Data.append('cliente_id', cliente_id);
  Data.append('evento_id', evento_id);
  Data.append('descuento', $('#descuento').val());
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
              //$().toastmessage('showSuccessToast', "<br>Venta realizada");
              $('#rep_venta_id').val(evento_id);
              $('#btn_rep_venta').trigger('click');
              reiniciar_venta();
              btn_act_desac();
              $('#modal_enviar_url').modal('show');
          } else {
              //$().toastmessage('showNoticeToast', '<br>Se requiere abrir caja para realizar la venta');
          }
      }
  })
}

function reiniciar_venta() {
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
              //$('#modal_inventario').modal('show');
          } else {
              $().toastmessage('showNoticeToast', '<br>No se encontraron productos por vender');
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

function btn_eliminar(key) {
  list_venta.splice(key, 1);
  var total_venta = 0;
  $('#tbl_venta').empty();
  $('#tbl_venta').append(
      '<tr id="0">'
      + '<td style="width: 90px;"><input tabindex="1" type="number" id="cantidadX" class="form-control form-control-sm focusNext" min="1" value="" style="width:70px;" autofocus="autofocus"></td>'
      + '<td style="width: 120px;"><input tabindex="2" type="text" class="form-control form-control-sm focusNext" style="width: 100%"></td>'
      + '<td style="background-color: #f1f3b7"></td>'
      + '<td style="background-color: #b7f3b7"></td>'
      + '<td style="background-color: #b7f3b7"></td>'
      + '<td style="background-color: #b7f3b7"><span id="total0"></span></td>'
      + '</tr>'
      );
  $.each(list_venta, function (key, venta) {
      venta.key = key;
      add_lista_venta_(venta);
      total_venta += venta.cantidad * venta.precio_publico;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));
  btn_act_desac();
}

function change_cantidad(key) {
  var cantidad = parseInt($('#cantidad' + key).val());
  list_venta[key].cantidad = cantidad;
  $('#total' + key).text(formato_moneda(cantidad * list_venta[key].precio));
  var total_venta = parseFloat($('#total_venta').attr('total'));
  $.each(list_venta, function (key, venta) {
      total_venta += venta.cantidad * venta.precio;
  });
  $('#total_venta').attr('total', total_venta);
  $('#total_venta').text(formato_moneda(total_venta));
  //$().toastmessage('showSuccessToast', '<br>Cantidad modificada');
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
</script>
@endsection