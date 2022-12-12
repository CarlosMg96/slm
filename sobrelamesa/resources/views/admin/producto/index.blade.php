@extends('admin.template.main')

@section('title','Sobre La Mesa | Productos')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('modal')
<div class="modal" id="modal_add_producto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbl_title_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_producto">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Clave</label>
                                <input type="text" class="form-control" name="clave" id="clave">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Producto</label>
                                <input type="text" class="form-control" name="producto" id="producto">
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Stock</label>
                                <input type="text" class="form-control" name="stock" id="stock">
                            </div>
                        </div>

                        

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Medidas</label>
                                <input type="text" class="form-control" name="medidas" id="medidas">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Categoria Producto</label>                                
                                <select class="form-control form-control-sm form-reg-paso1 " id="select_producto_id" name="categoria_producto_id" required="required">

                                </select> 
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Precio Renta</label>
                                <input type="text" class="form-control" name="precio_renta" id="precio_renta">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Reparación</label>
                                <input type="text" class="form-control" name="reparacion" id="reparacion">
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Imagen</label>                                
                                <div class="custom-file">
                                    <input type="file" name="imagen" id="imagen" class="custom-file-input" id="customFileLang" lang="es">
                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                </div>
                            </div>
                        </div>


                         <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Precio Reposición</label>
                                <input type="text" class="form-control" name="precio_reposicion" id="precio_reposicion">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="name">Dias para Mantenimiento</label>
                                <input type="text" class="form-control" name="dias_mantenimiento" id="dias_mantenimiento">
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="productoID" id="productoID">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal"></button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_confirm_modal">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal_delete_producto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estas seguro de eliminar el siguiente producto?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_delete_producto">Confirmar</button>
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
                    <div class="card-header" style="display: block;">
                        <h3 class="card-title">Productos</h3>
                        <select class="form-control-sm selectpicker" id="select_producto_id_filtro" name="categoria_producto_filtro_id" style="margin-left: 10px;" onchange="filtrar_categoria();">

                        </select> 
                        <h3 class="text-right">                                                    
                            <button class="btn btn-primary btn-xs pull-right" onclick="modal_add_producto()">
                                <i class="fa fa-plus"></i> Producto (F1)
                            </button>
                            <button class="btn btn-success btn-xs pull-right" onclick="modal_add_categoria()">
                                <i class="fa fa-plus"></i> Categoria (F3)
                            </button>
                            <button class="btn btn-warning btn-xs" onclick="edit_producto()">
                                <i class="fa fa-edit"></i> Editar (F2)
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="delete_producto()">
                                <i class="fas fa-trash"></i> Eliminar (SUPR)
                            </button>
                        </h3>                                                                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_productos" class="display compact cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Clave</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Medidas</th>
                                    <th>Categoria Producto</th>
                                    <th>Precio Renta</th>
                                    <th>Reparación</th>
                                    <th>Imagen</th>
                                    <th>Precio Reposición</th>
                                    <th>Dias Mantenimiento</th>                                                                    
                                    <th>
                                        No Disponible<br>
                                        <span class="badge badge-light">Apartado | Fuera de Bodega</span>
                                    </th>
                                    <th>Disponible</th>
                                    <!--<th>Stock Apartado</th>
                                    <th>Stock Servicio</th>-->
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
    $('#menu_producto').attr('class','nav-link active');
	var listProductos = [];
    var focus_producto_id = null;
    var focus_key = null;
    var ban = false;
	var tblProductos = $('#tbl_productos').DataTable({
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		"order": [[ 0, "asc" ]],
        "pageLength": 100,
        "lengthMenu": [[200, 300, 500, -1], [200, 400, 500, "Todos"]],
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
    	get_productos();
    });

    function get_productos(){
    	var Data = new FormData();
    	Data.append('_token', "{{ csrf_token() }}");
    	$.ajax({
    		method: 'POST',
    		url: "{{route('producto.get_productos')}}",
    		data: Data,
    		dataType: 'json',
    		processData: false,
    		contentType: false,
    		beforeSend: function () {
                toastr.success('Consultando productos...');
    		},
    		success: function (response){
    			tblProductos.clear().draw();
    			var datos = [];
    			$.each(response.objectProducto, function (key, producto) {                   
                        listProductos.push(producto);
                        datos.push(                        	
                        	key,
                            producto.clave,
                        	producto.producto,
                        	producto.stock,
                        	producto.medidas,
                        	producto.categoria,
                        	formato_moneda(producto.precio_renta),
                        	producto.reparacion,                            
                        	'<img data-action="zoom" src="images/productos/'+producto.imagen+'"  alt="" class="img-thumbnail">',
                            formato_moneda(producto.precio_reposicion),
                            producto.dias_mantenimiento,
                            producto.cant_apartado+' | '+producto.cant_fuera_bodega,
                            producto.disponible
                        	);
                    tblProductos.row.add(datos);
                    datos = [];
                });
                tblProductos.draw(false);

                $('#select_producto_id').empty();
                $('#select_producto_id_filtro').empty();
                $('#select_producto_id_filtro').append(
                        '<option value="0">Seleccionar Categoria</option>'
                        ); 
                $.each(response.objectCategoria, function (key, categoria) {                   
                    $('#select_producto_id').append(
                        '<option value="'+categoria.id+'">'+categoria.categoria+'</option>'
                        ); 
                    $('#select_producto_id_filtro').append(
                        '<option value="'+categoria.id+'">'+categoria.categoria+'</option>'
                        ); 
                });    			
    		}
    	});
    }

    function modal_add_producto(){      
        $("#form_add_producto")[0].reset();
        $('#modal_add_producto').modal('show');
        $('#lbl_title_modal').text('Nuevo Producto');
        $('#btn_confirm_modal').text('Registrar');
    }

    $("#form_add_producto").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");
        var route = "";
        if (ban) {
            route = "{{route('producto.form_edit_producto')}}";
        } else {
            route = "{{route('producto.form_add_producto')}}";
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
                $("#form_add_producto")[0].reset();
                $('#modal_add_producto').modal('hide');
                if(ban){
                    toastr.success('Producto Actualizado Con Exito');
                }else{
                    toastr.success('Producto Registrado Con Exito');
                }
                get_productos();
            }
        });
    });

    $('#tbl_productos tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            focus_key = null;
            temp_row = null;
            temp_row_index = null;
            $(this).removeClass('selected');
        }
        else {
            tblProductos.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //focus_producto_id = parseInt(tblProductos.row( this ).data()[0]);            
            focus_key = parseFloat(tblProductos.row( this ).data()[0]);            
            temp_row = tblProductos.row( this ).data();
            temp_row_index = tblProductos.row( this ).index();
        }
    });

    $(document).keydown(function(e) {
        if (e.keyCode == 112) {            
            e.preventDefault();
            modal_add_producto();        
        }
        if (e.keyCode == 113) {
            if (focus_key != null) {            
                e.preventDefault();
                edit_producto();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Producto");
                toastr.warning('Seleccione un Producto');
            }
        }
        if (e.keyCode == 114) {            
            e.preventDefault();
            /*$('div.dataTables_filter input', tblProductos.table().container()).focus();
            e.originalEvent.keyCode = 0;*/
            modal_add_categoria();
        }
        if (e.keyCode == 46) {
            if (focus_key != null) {            
                e.preventDefault();
                delete_producto();
            }else{
                //$().toastmessage('showNoticeToast', "<br>Seleccione un Producto");
                toastr.warning('Seleccione un Producto');
            }
        }
    });

    function edit_producto() {
        if (focus_key != null) {
            position = focus_key;        
            $('#clave').val(listProductos[position]['clave']);
            $('#producto').val(listProductos[position]['producto']);
            $('#stock').val(listProductos[position]['stock']);
            $('#medidas').val(listProductos[position]['medidas']);
            $("#select_producto_id option[value="+ listProductos[position]['categoria_producto_id'] +"]").attr("selected",true);
            $('#precio_renta').val(listProductos[position]['precio_renta']);
            $('#reparacion').val(listProductos[position]['reparacion']);        
            //$('#codigo').val(listProductos[position]['codigo']);            
            $('#precio_reposicion').val(listProductos[position]['precio_reposicion']);
            $('#dias_mantenimiento').val(listProductos[position]['dias_mantenimiento']); 
            $('#productoID').val(listProductos[position]['id']);
            $('#modal_add_producto').modal('show');
            $('#lbl_title_modal').text('Editar Producto');
            $('#btn_confirm_modal').text('Guardar Cambios');
            ban = true;
        }else{
            toastr.warning('Seleccione un Producto');
        }
    }

    function delete_producto() {
        if (focus_key != null) {
            position = focus_key;
            $('#btn_delete_producto').attr('onClick', 'confirm_delete_producto(' + position + ')');
            $('#modal_delete_producto').modal('show');
        }else{
            toastr.warning('Seleccione un Producto');
        }
    }

    function confirm_delete_producto() {
        var Data = new FormData();
        Data.append('_token', "{{ csrf_token() }}");
        Data.append('productoID', listProductos[position]['id']);

        $.ajax({    
            method: 'POST',
            url: "{{route('producto.delete_producto')}}",
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
                toastr.success('Producto Eliminado Con Exito');               
            }
        });
    }

    function modal_add_categoria(){
        $("#form_add_categoria")[0].reset();
        $('#modal_add_categoria').modal('show');        
    }

    $("#form_add_categoria").submit(function(e){
        e.preventDefault();
        var Data = new FormData(this);
        Data.append('_token',"{{ csrf_token() }}");

        $.ajax({
            method:'POST',
            url: "{{route('producto.form_add_categoria')}}",
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
                $('#select_producto_id').append(
                    '<option value="'+response.objectCategoria.id+'">'+response.objectCategoria.categoria+'</option>'
                    );
            }
        });
    });

    function filtrar_categoria(){
        var filtro_id = $('#select_producto_id_filtro').val();
        //console.log($('select[name="categoria_producto_filtro_id"] option:selected').text());
        //$('div.dataTables_filter input', tblProductos).val($('select[name="categoria_producto_filtro_id"] option:selected').text());
        if(filtro_id > 0){
            var oTable = $('#tbl_productos').dataTable();
        oTable.fnFilter($('select[name="categoria_producto_filtro_id"] option:selected').text());
        }else{
            var oTable = $('#tbl_productos').dataTable();
        oTable.fnFilter('');
        }
        
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