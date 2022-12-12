@extends('admin.template.main')

@section('title','Sobre La Mesa | Personal')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
<div class="modal" id="modal_add_personal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_personal">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Correo Electronico</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                        </div>

                        

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Contraseña</label>
                                <input type="password" class="form-control" name="pwd" id="pwd">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Tipo Usuario</label>
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_tipo_usuario" name="tipo_usuario" required="required">
                                    <option value="1">Master</option>
                                    <option value="2">Administrador</option>
                                    <option value="3">Ventas</option>
                                    <option value="4">Almacen</option>
                                </select> 
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Contraseña de Autorización</label>
                                <input type="password" class="form-control" name="pwds" id="pwds">
                            </div>
                        </div>


                    </div>
                </div>
                <input type="hidden" name="personalID" id="personalID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_delete_personal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente personal?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_personal">Confirmar</button>
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
                        <h3 class="card-title">Personal</h3>
                        
                        <h3 class="text-right">
                            <button class="btn btn-primary btn-xs pull-right" onclick="modal_add_personal()"> 
                                <i class="fa fa-plus"></i> Personal (F1)
                            </button>
                            <button class="btn btn-warning btn-xs" onclick="edit_personal()">
                                <i class="fa fa-edit"></i> Editar (F2)
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_personal()">
                                <i class="fas fa-trash"></i> Eliminar (SUPR)
                            </button> 
                        </h3>             
                                  
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_personales" class="display compact cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Key </th>
                                    <th>Nombre </th>
                                    <th>Correo Electronico</th>                                    
                                    <th>Tipo Usuario</th>                                   
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
    $('#menu_personal').attr('class','nav-link active');
	var listPersonales = [];
    var focus_personal_id = 0;
    var focus_key = 0;
    var ban = false;
	var tblPersonales = $('#tbl_personales').DataTable({
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
    	get_personales();
    });

    function get_personales(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('usuario.get_personales')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
    			tblPersonales.clear().draw();
    			var datos = [];
    			$.each(response.objectPersonal, function (key, personal) {                
                        listPersonales.push(personal);
                        var tipo_usuario = "";
                        if(personal.tipo_usuario == 1){
                            tipo_usuario = 'Master';
                        }else if(personal.tipo_usuario == 2){
                            tipo_usuario = 'Administrador';
                        }else if(personal.tipo_usuario == 3){
                            tipo_usuario = 'Ventas';
                        }else if(personal.tipo_usuario == 4){
                            tipo_usuario = 'Almacen';
                        }else{
                            tipo_usuario = 'Sin Especificar';
                        }
                        datos.push(                        	
                        	key,
                        	personal.name,
                        	personal.email,
                        	tipo_usuario                        
                        	);
                    tblPersonales.row.add(datos);
                    datos = [];
                });
    			tblPersonales.draw(false);
    		}
    	});
    }

    function modal_add_personal(){      
        $("#form_add_personal")[0].reset();
        $('#modal_add_personal').modal('show');
        $('#lbl_title_modal').text('Nuevo Personal');
        $('#btn_confirm_modal').text('Registrar');
    }

    $("#form_add_personal").submit(function(e){
    	e.preventDefault();
    	var Data = new FormData(this);
    	Data.append('_token',"{{ csrf_token() }}");
        var route = "";
        if (ban) {
            route = "{{route('usuario.form_edit_personal')}}";
        } else {
            route = "{{route('usuario.form_add_personal')}}";
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
    			$("#form_add_personal")[0].reset();
    			$('#modal_add_personal').modal('hide');
    			get_personales();
                if(ban){
                    toastr.success('Personal Actualizado Con Exito');
                }else{
                    toastr.success('Personal Registrado Con Exito');
                }
    		}
    	});
    });

    $('#tbl_personales tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblPersonales.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_personal_id = parseInt(tblPersonales.row( this ).data()[0]);            
            focus_key = parseFloat(tblPersonales.row( this ).data()[0]);            
            temp_row = tblPersonales.row( this ).data();
            temp_row_index = tblPersonales.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            modal_add_personal();        
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_personal();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Personal");
                toastr.warning('Seleccione un Personal');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblPersonales.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_personal();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Personal");
                toastr.warning('Seleccione un Personal');
            }
        }
    });

    function edit_personal() {
        if (focus_key != null) {
            position = focus_key;        
            $('#name').val(listPersonales[position]['name']);
            $('#email').val(listPersonales[position]['email']);
            $('#pwd').val(listPersonales[position]['pwd']);
            $("#select_tipo_usuario option[value="+ listPersonales[position]['tipo_usuario'] +"]").attr("selected",true);
            $('#pwds').val(listPersonales[position]['pwds']);
            $('#personalID').val(listPersonales[position]['id']);
            $('#modal_add_personal').modal('show');
            $('#lbl_title_modal').text('Editar Personal');
            $('#btn_confirm_modal').text('Guardar Cambios');
            ban = true;
        }else{
            toastr.warning('Seleccione un Personal');
        }
    }

    function delete_personal() {
        if (focus_key != null) {
            position = focus_key;
            $('#btn_delete_personal').attr('onClick', 'confirm_delete_personal(' + position + ')');
            $('#modal_delete_personal').modal('show');
        }else{
            toastr.warning('Seleccione un Personal');
        }
    }

    function confirm_delete_personal() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('personalID', listPersonales[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('usuario.delete_personal')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_personal').modal('hide');
                get_personales();
                toastr.success('Personal Eliminado Con Exito');              
            }
        });
    }
</script>
@endsection