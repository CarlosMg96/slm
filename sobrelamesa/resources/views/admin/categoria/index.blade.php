@extends('admin.template.main')

@section('title','Sobre La Mesa | Categoria')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
<div class="modal" id="modal_add_categoria" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal">Nueva Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_categoria">
                <div class="modal-body">
                    <div class="row">
                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Categoria</label>
                                <input type="text" class="form-control" name="categoria" id="categoria">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="categoriaID" id="categoriaID">                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_delete_categoria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente categoria?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_categoria">Confirmar</button>
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
                        <h3 class="card-title">Categorias de Productos</h3>
                        <h3 class="text-right">
                            <button class="btn btn-success btn-xs pull-right" onclick="modal_add_categoria()"> 
                                <i class="fa fa-plus"></i> Categoria (F1)
                            </button>
                            <button class="btn btn-warning btn-xs" onclick="edit_categoria()">
                                <i class="fa fa-edit"></i> Editar (F2)
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_categoria()">
                                <i class="fas fa-trash"></i> Eliminar (SUPR)
                            </button> 
                        </h3>      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_categorias" class="display compact" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Categoria</th>                                                     
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
    $('#menu_categoria_producto').attr('class','nav-link active');
	var listCategorias = [];
    var focus_categoria_id = 0;
    var focus_key = 0;
    var ban = false;
	var tblCategorias = $('#tbl_categorias').DataTable({
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
    	get_categorias();
    });

    function get_categorias(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('producto.get_categorias')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
    		},
    		success: function (response){
                if(response.status){
                    tblCategorias.clear().draw();
                    var datos = [];
                    $.each(response.objectCategoria, function (key, categoria) {                   
                        listCategorias.push(categoria);                        
                        datos.push(                         
                            key,
                            categoria.categoria,                                                    
                            );
                        tblCategorias.row.add(datos);
                        datos = [];
                    });
                    tblCategorias.draw(false);
                }else{

                }    			
    		}
    	});
    }

    function modal_add_categoria(){
        $("#form_add_categoria")[0].reset();
        $('#modal_add_categoria').modal('show');
        $('#lbl_title_modal').text('Nuevo Categoria');
        $('#btn_confirm_modal').text('Registrar');        
    }

    $("#form_add_categoria").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        var route = "";
        if (ban) {
            route = "{{route('producto.form_edit_categoria')}}";
        } else {
            route = "{{route('producto.form_add_categoria')}}";
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
                $("#form_add_categoria")[0].reset();
                $('#modal_add_categoria').modal('hide');
                get_categorias();
                if(ban){
                    toastr.success('Categoria Actualizado Con Exito');
                }else{
                    toastr.success('Categoria Registrado Con Exito');
                }               
            }
        });
    });

    $('#tbl_categorias tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblCategorias.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_producto_id = parseInt(tblProductos.row( this ).data()[0]);            
            focus_key = parseFloat(tblCategorias.row( this ).data()[0]);            
            temp_row = tblCategorias.row( this ).data();
            temp_row_index = tblCategorias.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            modal_add_categoria();        
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_categoria();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione una Categoria");
                toastr.warning('Seleccione un Categoria');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            $('div.dataTables_filter input', tblProductos.table().container()).focus();
            e.originalEvent.keyCode = 0;
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_categoria();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione una Categoria");
                toastr.warning('Seleccione un Categoria');
            }
        }
    });

    function edit_categoria() {
        if (focus_key != null) {
            position = focus_key;        
            $('#categoria').val(listCategorias[position]['categoria']);            
            $('#categoriaID').val(listCategorias[position]['id']);
            $('#modal_add_categoria').modal('show');
            $('#lbl_title_modal').text('Editar Categoria');
            $('#btn_confirm_modal').text('Guardar Cambios');
            ban = true;
        }else{
            toastr.warning('Seleccione un Categoria');
        }
    }

    function delete_categoria() {
        if (focus_key != null) {
        position = focus_key;
        $('#btn_delete_categoria').attr('onClick', 'confirm_delete_categoria(' + position + ')');
        $('#modal_delete_categoria').modal('show');
        }else{
            toastr.warning('Seleccione un Categoria');
        }
    }

    function confirm_delete_categoria() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('categoriaID', listCategorias[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('producto.delete_categoria')}}",
            data: Data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (response)
            {
                $('#modal_delete_categoria').modal('hide');
                get_categorias();
                toastr.success('Categoria Eliminada Con Exito');              
            }
        });
    }
</script>
@endsection