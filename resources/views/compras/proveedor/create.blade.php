@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <h3>Nuevo Proveedor</h3>

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


            <form method="POST" action="{{ route('proveedor.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{old('nombre')}}" placeholder="Nombre..">
                </div>

                <div class="form-group">
                    <label for="tipo_documento">Tipo de documento</label>
                    <select type="text" name="tipo_documento" class="form-control" >
                        <option value="DNI">DNI</option>
                        <option value="RUC">RUC</option>
                        <option value="PAS">PAS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="num_documento">Num. de documento</label>
                    <input type="text" name="num_documento" class="form-control" required value="{{old('num_documento')}}" placeholder="Nro documento..">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required value="{{old('telefono')}}" placeholder="Teléfono..">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" required value="{{old('email')}}" placeholder="Email..">
                </div>
                <div class="form-group">
                    <label for="email">Direccion</label>
                    <input type="text" name="direccion" class="form-control" required value="{{old('direccion')}}" placeholder="Direccion..">
                </div>


                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Borrar</button>
                </div>

            </form>

        </div>
    </div>

@endsection
