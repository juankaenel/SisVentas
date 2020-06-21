@extends('layouts.admin')

@section('contenido')
   <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <h3>Editar Proveedor {{$persona->nombre}}</h3>

            @if(count($errors)>0)
                <div class="alert alert-danger">
                    <ul>

                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('proveedor.update', $persona->idpersona) }}" method="POST">
                @method('PUT')
                @csrf

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{$persona->nombre}}" placeholder="Nombre..">
            </div>

                <div class="form-group">
                    <label for="tipo_documento">Tipo de documento</label>
                    <select type="text" name="tipo_documento" class="form-control" >
                        @if($persona->tipo_documento=='DNI')
                            <option value="DNI">DNI </option>
                            <option value="RUC">RUC </option>
                            <option value="PASS">PASS </option>
                        @endif
                        @if($persona->tipo_documento=='RUC')
                            <option value="RUC">RUC </option>
                            <option value="DNI">DNI </option>
                            <option value="PASS">PASS </option>
                        @endif
                        @if($persona->tipo_documento=='PASS')
                            <option value="PASS">PASS </option>
                            <option value="DNI">DNI </option>
                            <option value="RUC">RUC </option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="num_documento">Num. de documento</label>
                    <input type="text" name="num_documento" class="form-control" required value="{{$persona->num_documento}}" placeholder="Nro documento..">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required value="{{$persona->telefono}}" placeholder="Teléfono..">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" required value="{{$persona->email}}" placeholder="Email..">
                </div>
                <div class="form-group">
                    <label for="email">Direccion</label>
                    <input type="text" name="direccion" class="form-control" required value="{{$persona->direccion}}" placeholder="Direccion..">
                </div>



                <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Borrar</button>
            </div>
            </form>

        </div>
    </div>

@endsection
