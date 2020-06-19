@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Categorías</h3>
            <a href="../../almacen/categoria/create" class="btn btn-success">Nueva Categoría</a>
            <hr>

            @include('almacen.categoria.search')
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
                    <th>Descripción</th>
                    <th>Opciones</th>
                    </thead>

                    @foreach($categorias as $cat)
                    <tr>
                        <td>{{$cat->idcategoria}}</td>
                        <td>{{$cat->nombre}}</td>
                        <td>{{$cat->descripcion}}</td>
                        <td>


                            <a href="{{route('categoria.edit', $cat->idcategoria)}}" class="btn btn-warning btn-sm">Editar</a>

                            <a href="" data-target="#modal-delete-{{$cat->idcategoria}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </a>


                        </td>
                    </tr>
                        @include('almacen.categoria.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$categorias->render()}}
        </div>
    </div>

@endsection
