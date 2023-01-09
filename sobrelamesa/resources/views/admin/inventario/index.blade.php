@extends('admin.template.main')

@section('title','Sobre La Mesa | Inventario')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet"  href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
{{-- <style type="text/css">
    div.dataTables_wrapper {
        width: 900px;
        margin: 0 auto;
    }
</style> --}}
@endsection

@section('content')
<div>
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
                            <h3 class="card-title">Inventario de Productos</h3>
                            <!--<h3 class="text-right">
                                <button class="btn btn-success btn-xs pull-right" onclick="modal_add_categoria()"> 
                                    <i class="fa fa-plus"></i> Categoria (F1)
                                </button>
                                <button class="btn btn-warning btn-xs" onclick="edit_categoria()">
                                    <i class="fa fa-edit"></i> Editar (F2)
                                </button>
                                <button class="btn btn-danger btn-xs" onclick="delete_categoria()">
                                    <i class="fas fa-trash"></i> Eliminar (SUPR)
                                </button> 
                            </h3>-->      
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_inventario" style="width:100%" class="table table-striped table-bordered display responsive nowrap" style="width:70%">
                                <thead>
                                    <tr>
                                        <th>No° Evento</th>
                                        <th>Cliente</th>
                                        <th>Nombre Producto</th>
                                        <th>Fecha Entrega</th>
                                        <th>Fecha Recolección</th>
                                        <th>Cantidad Ocupada</th>
                                        <th>Stock</th>                                  
                                    </tr>
                                </thead>
                                <tbody>
                    
                                @foreach ($objectStockMove as $item)
                              <tr>
                                <td>{{ $item->id_evento}} </td>  
                                <td>{{ $item->nombre_completo}}</td>
                                <td>{{ $item->id_producto }} -> {{ $item->producto}}</td>                               
                                <td>{{$item->fecha_entrega}} </td>
                                <td>{{$item->fecha_recoleccion}}</td>
                                <td>{{ $item->cantidad}}</td>
                                <td>{{ $item->stock}} </td>
                              </tr>
                                
                            @endforeach
                           
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
console.log("Hola Mundo");
//   console.log(objectStockMov);
    $(document).ready(function(){
        $('#tbl_inventario').DataTable( {
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
} );
    });
//     $('#tbl_inventario').DataTable( {
//     responsive: true
// } );
</script>
@endsection

