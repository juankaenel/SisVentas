@extends('layouts.admin')

@section('contenido')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de usuarios</h3>
            <a href="../../seguridad/usuario/create" class="btn btn-success">Nuevo usuario</a>
            <hr>

            @include('seguridad.usuario.search')
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
                    <th>Email</th>
                    <th>Opciones</th>
                    </thead>

                    @foreach($usuarios as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                        {{--    <a href="{{route('usario.edit', $user->id)}}" class="btn btn-warning btn-sm">Editar</a>--}}
                            <a href="{{URL::action('UsuarioController@edit', $user->id)}}" class="btn btn-warning btn-sm">Editar</a>

                            <a href="" data-target="#modal-delete-{{$user->id}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </a>


                        </td>
                    </tr>
                        @include('seguridad.usuario.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$usuarios->render()}}
        </div>
    </div>

@endsection
