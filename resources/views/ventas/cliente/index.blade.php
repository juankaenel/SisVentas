@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Clientes</h3>
            <a href="../../ventas/cliente/create" class="btn btn-success">Nuevo cliente</a>
            <hr>

            @include('ventas.cliente.search')
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
                    <th>Tipo Doc.</th>
                    <th>Nro de Doc.</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Opciones</th>
                    </thead>

                    @foreach($personas as $per)
                    <tr>
                        <td>{{$per->idpersona}}</td>
                        <td>{{$per->nombre}}</td>
                        <td>{{$per->tipo_documento}}</td>
                        <td>{{$per->num_documento}}</td>
                        <td>{{$per->telefono}}</td>
                        <td>{{$per->email}}</td>
                        <td>{{$per->direccion}}</td>
                        <td>
                            <a href="{{route('cliente.edit', $per->idpersona)}}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="" data-target="#modal-delete-{{$per->idpersona}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </a>
                        </td>
                    </tr>
                        @include('ventas.cliente.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$personas->render()}}
        </div>
    </div>

@endsection
