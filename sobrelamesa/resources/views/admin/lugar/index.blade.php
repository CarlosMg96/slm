@extends('admin.template.main')
@section('title','Sobre La Mesa | Lugares')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<style>

</style>
@endsection
@section('modal')
<div class="modal" id="modal_add_lugar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_lugar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre">
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
                <input type="hidden" name="lugarID" id="lugarID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_delete_lugar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Lugar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente lugar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_lugar">Confirmar</button>
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
        <h3 class="card-title">Listado de Lugares</h3>
        <div class="card-tools">
          <button class="btn btn-success btn-xs pull-right" onclick="modal_add_lugar()"> 
            <i class="fa fa-plus"></i> Lugar (F1)
          </button>
          <button class="btn btn-warning btn-xs" onclick="edit_lugar()">
            <i class="fa fa-edit"></i> Editar (F2)
          </button>
          <button class="btn btn-danger btn-xs" onclick="delete_lugar()">
            <i class="fas fa-trash"></i> Eliminar (SUPR)
          </button> 
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
        <table id="tbl_lugar" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Dirección</th>                                        
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
$('#menu_lugares').attr('class','nav-link active');
  var list_lugar = [];
  var list_colonos = [];
  var focus_lugar_id = null;
  var focus_key = null;
  var ban = false;
  var tbl_lugar = $('#tbl_lugar').DataTable({
    "language": 
    {
      "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    },
    "order": [[ 0, "asc" ]],
  });

  $( document ).ready(function() {
    get_lugar();
  });

  function get_lugar(){
    var Data = new FormData();
    Data.append('_token', "{{ csrf_token() }}");

    $.ajax({
      method: 'POST',
      url: "{{route('lugar.get_lugar')}}",
      data: Data,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function () {
      },
      success: function (response){

        $('#select_colono_id').empty();
        $('#select_colono_id').append(
          '<option value="0">Selecciona un Colono</option>'
          );        
        $.each( response.response_object_colono, function( key, colono ) {
          list_colonos.push(colono);
          $('#select_colono_id').append(
            '<option value="'+colono.id+'">'+colono.nombre+'</option>'
            );
        });

        if(response.status){
          tbl_lugar.clear().draw();
          var datos = [];
          $.each(response.response_object, function (key, lugar) {                   
            list_lugar.push(lugar);
            var result = $.grep(list_colonos, function(e){ return e.id == lugar.colono_id; });
            console.log(result);
            datos.push(                         
              key,
              lugar.nombre,              
              lugar.direccion
              );
            tbl_lugar.row.add(datos);
            datos = [];
          });
          tbl_lugar.draw(false);          
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

  function modal_add_lugar(){      
    $("#form_add_lugar")[0].reset();
    $('#modal_add_lugar').modal('show');
    $('#lbl_title_modal').text('Nuevo Lugar');
    $('#btn_confirm_modal').text('Registrar');
  }

  $("#form_add_lugar").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        var route = "";
        if (ban) {
            route = "{{route('lugar.form_edit_lugar')}}";
        } else {
            route = "{{route('lugar.form_add_lugar')}}";
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
                $("#form_add_lugar")[0].reset();
                $('#response_message').text(response.response_message);    
                $('#response_message').removeClass('alert alert-danger').addClass('alert alert-success');
                $('#response_message').css('visibility','visible');
                $('#modal_add_lugar').modal('hide');
                get_lugar();                
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

  $('#tbl_lugar tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
      focus_key = null;
      temp_row = null;
      temp_row_index = null;
      $(this).removeClass('selected');
    }
    else {
      tbl_lugar.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');        
      focus_key = parseFloat(tbl_lugar.row( this ).data()[0]);            
      temp_row = tbl_lugar.row( this ).data();
      temp_row_index = tbl_lugar.row( this ).index();
    }
  });

  $(document).keydown(function(e) {
    if (e.keyCode == 112) {            
      e.preventDefault();
      modal_add_lugar();        
    }
    if (e.keyCode == 113) {
      if (focus_key != null) {            
        e.preventDefault();
        edit_lugar();
      }else{
        $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
        $('#response_message').text("Selecciona un lugar");
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
      $('div.dataTables_filter input', tbl_lugar.table().container()).focus();
      e.originalEvent.keyCode = 0;
    }
    if (e.keyCode == 46) {
      if (focus_key != null) {            
        e.preventDefault();
        delete_lugar();
      }else{
        $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
        $('#response_message').text("Selecciona un lugar");
        $('#response_message').css('visibility','visible');

        setTimeout(function() 
        {
          $('#response_message').fadeOut('slow');
          $('#response_message').css('visibility','hidden');
        }, 30000); 
      }
    }
  });

  function edit_lugar() {
    if (focus_key != null) {
      position = focus_key;        
      $('#nombre').val(list_lugar[position]['nombre']);
      $('#direccion').val(list_lugar[position]['direccion']);            
      $('#lugarID').val(list_lugar[position]['id']);
      $('#modal_add_lugar').modal('show');
      $('#lbl_title_modal').text('Editar Lugar');
      $('#btn_confirm_modal').text('Guardar Cambios');
      ban = true;
    }else{
      //toastr.warning('Seleccione un Lugar');
      $('#response_message').removeClass('alert alert-success').addClass('alert alert-danger');
        $('#response_message').text("Selecciona un lugar");
        $('#response_message').css('visibility','visible');

        setTimeout(function() 
        {
          $('#response_message').fadeOut('slow');
          $('#response_message').css('visibility','hidden');
        }, 30000); 
    }
  }

  function delete_lugar() {
    position = focus_key;
    $('#btn_delete_lugar').attr('onClick', 'confirm_delete_lugar(' + position + ')');
    $('#modal_delete_lugar').modal('show');
  }

  function confirm_delete_lugar() {
    var Data = new FormData();
    Data.append('_token', "{{ csrf_token() }}");
    Data.append('lugarID', list_lugar[position]['id']);

    $.ajax({    
      method: 'POST',
      url: "{{route('lugar.delete_lugar')}}",
      data: Data,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function () {
      },
      success: function (response)
      {
        $('#modal_delete_lugar').modal('hide');
        get_lugar();              
      }
    });
  }
</script>
@endsection