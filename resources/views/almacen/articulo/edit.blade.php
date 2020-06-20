@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <h3>Editar Articulo {{$articulo->nombre}}</h3>



            @if(count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        <!--los errores los vamos a recibir desde el request categoriaformrequest-->

                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!--recibo una categoria del controlador
            cuando se ejecute el form, envia el formulario al controlador y recibe el metodo patch el id q le envio
            -->

            <form action="{{ route('articulo.update', $articulo->idarticulo) }}" method="POST">
                @method('PUT')
                @csrf

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{$articulo->nombre}}" placeholder="Nombre..">
            </div>

            <div class="form-group">
                <label for="nombre">Descripción</label>
                <input type="text" name="descripcion" class="form-control" value="{{$articulo->descripcion}}" placeholder="Descripcion..">
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Borrar</button>
            </div>
            </form>

        </div>
    </div>

@endsection
