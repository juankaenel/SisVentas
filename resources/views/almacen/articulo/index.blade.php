@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Articulos</h3>
            <a href="../../almacen/articulo/create" class="btn btn-success">Nueva Articulo</a>
            <hr>

            @include('almacen.articulo.search')
        </div>
    </div>

    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                    </thead>
                    <!--recibo articulos que viaja desde el controlador @index-->
                    @foreach($articulos as $arti)
                    <tr>
                        <td>{{$arti->idarticulo}}</td>
                        <td>{{$arti->nombre}}</td>
                        <td>{{$arti->codigo}}</td>
                        <td>{{$arti->categoria}}</td>
                        <td>{{$arti->stock}}</td>
                        <td>{{$arti->descripcion}}</td>
                        <td>
                            <img src="{{asset('imagenes/articulos/'.$arti->imagen)}}" alt="{{$arti->nombre}}" height="100px" width="100px" class="img-thumbnail">

                        </td>
                        <td>{{$arti->estado}}</td>
                        <td>
                            <a href="{{route('articulo.edit', $arti->idarticulo)}}" class="btn btn-warning btn-sm">Editar</a>

                            <a href="" data-target="#modal-delete-{{$arti->idarticulo}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </a>
                        </td>
                    </tr>
                        @include('almacen.articulo.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$articulos->render()}}

        </div>
    </div>


@endsection
