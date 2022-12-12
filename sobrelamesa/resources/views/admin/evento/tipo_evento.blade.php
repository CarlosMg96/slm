@extends('admin.template.main')

@section('title','Sobre La Mesa | Tipo Evento')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
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

<div class="modal" id="modal_delete_tipo_evento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Tipo de Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente tipo de evento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_tipo_evento">Confirmar</button>
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
                        <h3 class="card-title">Tipos de Eventos</h3>
                        <h3 class="text-right">
                            <button class="btn btn-success btn-xs pull-right" onclick="modal_add_tipo_evento()"> 
                                <i class="fa fa-plus"></i> Evento (F1)
                            </button>
                            <button class="btn btn-warning btn-xs" onclick="edit_tipo_evento()">
                                <i class="fa fa-edit"></i> Editar (F2)
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_tipo_evento()">
                                <i class="fas fa-trash"></i> Eliminar (SUPR)
                            </button> 
                        </h3>      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_tipo_evento" class="display compact" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Evento</th>                                                     
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
<script type="text/javascript">
    $('#menu_tipo_evento').attr('class','nav-link active');
	var listTiposEvento = [];
    var focus_tipo_evento_id = 0;
    var focus_key = 0;
    var ban = false;
	var tblTipoEvento = $('#tbl_tipo_evento').DataTable({
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
    	get_tipos_eventos();
    });

    function get_tipos_eventos(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('evento.get_tipos_evento')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
                if(response.status){
                    tblTipoEvento.clear().draw();
                    var datos = [];
                    $.each(response.objectTipoEvento, function (key, evento) {                   
                        listTiposEvento.push(evento);                        
                        datos.push(                         
                            key,
                            evento.evento,                                                    
                            );
                        tblTipoEvento.row.add(datos);
                        datos = [];
                    });
                    tblTipoEvento.draw(false);
                }else{

                }    			
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
        var route = "";
        if (ban) {
            route = "{{route('evento.form_edit_tipo_evento')}}";
        } else {
            route = "{{route('evento.form_add_tipo_evento')}}";
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
                $("#form_add_tipo_evento")[0].reset();
                $('#modal_add_tipo_evento').modal('hide');
                get_tipos_eventos();
                if(ban){
                    toastr.success('Tipo de Evento Actualizado Con Exito');
                }else{
                    toastr.success('Tipo de Evento Registrado Con Exito');
                }                   
            }
        });
    });

    $('#tbl_tipo_evento tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblTipoEvento.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_producto_id = parseInt(tblProductos.row( this ).data()[0]);            
            focus_key = parseFloat(tblTipoEvento.row( this ).data()[0]);            
            temp_row = tblTipoEvento.row( this ).data();
            temp_row_index = tblTipoEvento.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            modal_add_tipo_evento();        
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_tipo_evento();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione una Categoria");
                toastr.warning('Seleccione un Tipo de Evento');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblTipoEvento.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_tipo_evento();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione una Categoria");
                toastr.warning('Seleccione un Tipo de Evento');
            }
        }
    });

    function edit_tipo_evento() {
        if (focus_key != null) {
            position = focus_key;        
            $('#evento').val(listTiposEvento[position]['evento']);            
            $('#tipo_evento_ID').val(listTiposEvento[position]['id']);
            $('#modal_add_tipo_evento').modal('show');
            $('#lbl_title_modal').text('Editar Tipo de Evento');
            $('#btn_confirm_modal').text('Guardar Cambios');
            ban = true;
        }else{
            toastr.warning('Seleccione un Tipo de Evento');
        }
    }

    function delete_tipo_evento() {
        position = focus_key;
        $('#btn_delete_tipo_evento').attr('onClick', 'confirm_delete_tipo_evento(' + position + ')');
        $('#modal_delete_tipo_evento').modal('show');
    }

    function confirm_delete_tipo_evento() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('tipo_evento_ID', listTiposEvento[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('evento.delete_tipo_evento')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_tipo_evento').modal('hide');
                get_tipos_eventos();              
            }
        });
    }
</script>
@endsection