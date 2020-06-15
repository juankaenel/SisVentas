@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Categorías <a href="categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
            @include('almacen.categoria.search')
        </div>
    </div>

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
                            <a href="">
                                <button class="btn btn-info">Editar</button>
                            </a>
                            <a href="">
                                <button class="btn btn-danger">Eliminar</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$categorias->render()}}
        </div>
    </div>

@endsection
