@extends('admin.template.main')

@section('title','Sobre La Mesa | Inventario')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<style type="text/css">
    div.dataTables_wrapper {
        width: 900px;
        margin: 0 auto;
    }
</style>
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
                            <table id="tbl_categorias" style="width:100%" class="table display nowrap table-bordered table-striped table-sm cell-borde">
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
                                    <td>{{ $item->id_evento}} </td>  
                                    <td>{{ $item->nombre_completo}}</td>
                                    <td>{{ $item->id_producto }} -> {{ $item->producto}}</td>                               
                                    <td>{{$item->fecha_entrega}} </td>
                                    <td>{{$item->fecha_recoleccion}}</td>
                                    <td>{{ $item->cantidad}}</td>
                                    <td>{{ $item->stock}} </td>
                                    <tr>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">
console.log("Hola Mundo");
  console.log(objectStockMov);
</script>
@endsection