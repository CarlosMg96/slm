@extends('admin.template.main')
@section('title','Sobre La Mesa | Almacen')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<style>

</style>
@endsection
@section('modal')
<div class="modal" id="modal_add_event_terminado" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_event_terminado">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-2control" name="nombre" id="nombre">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Dirección</label>
                                <input type="text" class="form-control" name="direccion" id="direccion">
                            </div>
                        </div>                                                 
                        
                    </div>
                </div>
                <input type="hidden" name="event_terminadoID" id="event_terminadoID">
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
        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Imagen</th>
                    <th>Clave</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Cantidad Recibida</th>                    
                  </tr>
                </thead>
                <tbody id="list_products">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>      
      <div class="modal-footer">
        <button id="btn_cancelar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btn_confirmar_recibido" type="button" class="btn btn-success" onclick="confirmar_recibido()">Registrar Cantidades</button>                
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="content-wrapper">
  <!--<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blank Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div>
  </section>-->
  <br>
  <section class="content">
    <div id="response_message" class="" role="alert" style="visibility: hidden;"></div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Listado de Eventos Terminados</h3>
        <div class="card-tools">
          <button class="btn btn-success btn-xs pull-right" onclick="details_event(focus_key)"> 
            <i class="fa fa-plus"></i> Recibir Productos (F2)
          </button>
          <!--<button class="btn btn-warning btn-xs" onclick="modal_edit_event_terminado()">
            <i class="fa fa-edit"></i> Editar (F2)
          </button>
          <button class="btn btn-danger btn-xs" onclick="modal_delete_event_terminado()">
            <i class="fas fa-trash"></i> Eliminar (SUPR)
          </button> -->
        </div>
        <!--<div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>-->
      </div>
      <div class="card-body">
        <table id="tbl_event_terminado" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>No. Cotización</th>
                    <th>Fecha Recolección</th> 
                    <th>Cliente</th> 
                    <th>Evento</th> 
                    <th>Status</th>
                    <th></th>                                     
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <!--<tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>No. de Casa</th>
                    <th>QR</th>
                  </tr>
                  </tfoot>-->
                </table>
      </div>
      <!--<div class="card-footer">
        Footer
      </div>-->
    </div>
  </section>
</div>
@endsection
@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$('#menu_almacen').attr('class','nav-link active');
  var list_event_terminado = [];
  var list_products_cant_recibida = [];
  var focus_event_terminado_id = null;
  var focus_key = null;
  var ban = false;
  var tbl_event_terminado = $('#tbl_event_terminado').DataTable({
    "language": 
    {
      "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    },
    "order": [[ 0, "asc" ]],
  });

  $( document ).ready(function() {
    get_event_terminado();
  });

  function get_event_terminado(){
    var Data = new FormData();
    Data.append('_token', "{{ csrf_token() }}");

    $.ajax({
      method: 'POST',
      url: "{{route('evento.get_list_event_almacen')}}",
      data: Data,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function () {
      },
      success: function (response){

        if(response.status){
          tbl_event_terminado.clear().draw();
          var datos = [];
          $.each(response.objectEvento, function (key, event_terminado) { 
            var status_recibido = '';
            var btn_download = '';
            if(event_terminado.status_recibido == 0){
                  status_recibido = '<span class="badge badge-danger">En Espera de Registro</span>';
            }else if(event_terminado.status_recibido == 1){
                  status_recibido = '<span class="badge badge-warning">Registro Incompleto</span>';
                  btn_download = '<form method="POST" action="{{ route("evento.imprimir_reporte_faltantes") }}" accept-charset="UTF-8" target="_blank">{!! Form::token() !!}<button id="btn_generate_pdf_remision" type="submit" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> </button><input type="hidden" id="evento_id_reporte" name="evento_id_reporte" value="'+event_terminado.id+'"></form>';
            }else if(event_terminado.status_recibido == 2){                  
                  status_recibido = '<span class="badge badge-success">Registro Completo</span>';
            }
            list_event_terminado.push(event_terminado);            
            datos.push(                         
              key,
              '00'+event_terminado.id,              
              event_terminado.fecha_recoleccion,
              event_terminado.cliente,
              event_terminado.evento,
              status_recibido,
              btn_download
              );
            tbl_event_terminado.row.add(datos);
            datos = [];
          });
          tbl_event_terminado.draw(false);          
        }else{
          $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
          $('#response_message').text(response.response_message);
          $('#response_message').css('visibility','visible');
          setTimeout(function() 
          {
            $('#response_message').fadeOut('slow');
          }, 30000); 
        }        
      }
    });
  }

  function modal_add_event_terminado(){      
    $("#form_add_event_terminado")[0].reset();
    $('#modal_add_event_terminado').modal('show');
    $('#lbl_title_modal').text('Nuevo event_terminado');
    $('#btn_confirm_modal').text('Registrar');
  }

  $("#form_add_event_terminado").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        var route = "";
        if (ban) {
            route = "";
        } else {
            route = "";
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
            success: function(response){ 

              if(response.status){
                $("#form_add_event_terminado")[0].reset();
                $('#response_message').text(response.response_message);    
                $('#response_message').removeClass('alert alert-danger').addClass('alert alert-success');
                $('#response_message').css('visibility','visible');
                $('#modal_add_event_terminado').modal('hide');
                get_event_terminado();                
              }else{
                $('#response_message').text(response.response_message);
                $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
                $('#response_message').css('visibility','visible');
              }

              setTimeout(function() {
                $('#response_message').fadeOut('slow');
                $('#response_message').css('visibility','hidden');
              }, 30000);
            }
        });
    });

  $('#tbl_event_terminado tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
      focus_key = null;
      temp_row = null;
      temp_row_index = null;
      $(this).removeClass('selected');
    }
    else {
      tbl_event_terminado.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');        
      focus_key = parseFloat(tbl_event_terminado.row( this ).data()[0]);            
      temp_row = tbl_event_terminado.row( this ).data();
      temp_row_index = tbl_event_terminado.row( this ).index();
    }
  });

  $(document).keydown(function(e) {
    if (e.keyCode == 112) {            
      e.preventDefault();
      modal_add_event_terminado();        
    }
    if (e.keyCode == 113) {
      if (focus_key != null) {            
        e.preventDefault();
        details_event(focus_key);
        //edit_event_terminado();
      }else{
        $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
        $('#response_message').text("Selecciona un Evento");
        $('#response_message').css('visibility','visible');

        setTimeout(function() 
        {
          $('#response_message').fadeOut('slow');
          $('#response_message').css('visibility','hidden');
        }, 30000); 
      }
    }
    if (e.keyCode == 114) {            
      e.preventDefault();
      $('div.dataTables_filter input', tbl_event_terminado.table().container()).focus();
      e.originalEvent.keyCode = 0;
    }
    if (e.keyCode == 46) {
      if (focus_key != null) {            
        e.preventDefault();
        delete_event_terminado();
      }else{
        $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
        $('#response_message').text("Selecciona un event_terminado");
        $('#response_message').css('visibility','visible');

        setTimeout(function() 
        {
          $('#response_message').fadeOut('slow');
          $('#response_message').css('visibility','hidden');
        }, 30000); 
      }
    }
  });

  function details_event(key){
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', list_event_terminado[key].id);

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
              list_products_cant_recibida = [];
              $('#list_products').empty();
              $.each(response.responseDetalleEvento, function (key, producto) { 
                list_products_cant_recibida.push({
                  'key': key,
                  'detalle_evento_id': producto.detalle_evento_id,
                  'cantidad_recibida': producto.cantidad
                });                                                 
                $('#list_products').append(
                  '<tr>'
                  +'<td><img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail" width="100" height="100"></td>'
                  +'<td>'+producto.clave+'</td>'
                  +'<td>'+producto.producto+'</td>'
                  +'<td>'+producto.cantidad+'</td>'
                  +'<td><input class="form-control" onchange="change_cant('+key+')" type="number" name="'+producto.detalle_evento_id+'" id="'+producto.detalle_evento_id+'" value="'+producto.cantidad+'" /></td>'                        
                  );
              });
                /*$.each(response.responseDetalleEventoContent, function (key, row_header) {
                    //$("#tabla tr:first").after(tr);
                    var table = document.getElementById("list_products");
                    var row = table.insertRow(row_header.row_position);
                    //this adds row in 0 index i.e. first place
                    row.innerHTML = '<td></td><td><b>'+row_header.content_seccion+'</b></td><td></td><td></td><td></td><td></td><td></td><td></td>';
                });*/
                
                $('#modal_view_details').modal('show');
            }
        });        
    }

    function change_cant(key){
      var cantidad = parseInt($('#' + list_products_cant_recibida[key].detalle_evento_id).val());//Asignamos la nueva cantidad a variable
      list_products_cant_recibida[key].cantidad_recibida = cantidad;//A la lista le ponemos la nueva cantidad
      //toastr.success('Can');
    }

    function confirmar_recibido(){
      var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('id', list_event_terminado[focus_key].id);
        Data.append('list_cant_recibida', JSON.stringify(list_products_cant_recibida));

        $.ajax({    
            method: 'POST',
            url: "{{route('evento.confirmar_products_recibido')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response){              
              $('#modal_view_details').modal('hide');
              toastr.success('Información Registrada con Exito');
              get_event_terminado(); 
            }
        });
    }

  function edit_event_terminado() {
    if (focus_key != null) {
      position = focus_key;        
      $('#nombre').val(list_event_terminado[position]['nombre']);
      $('#direccion').val(list_event_terminado[position]['direccion']);            
      $('#event_terminadoID').val(list_event_terminado[position]['id']);
      $('#modal_add_event_terminado').modal('show');
      $('#lbl_title_modal').text('Editar event_terminado');
      $('#btn_confirm_modal').text('Guardar Cambios');
      ban = true;
    }else{
      toastr.warning('Seleccione un event_terminado');
    }
  }
</script>
@endsection