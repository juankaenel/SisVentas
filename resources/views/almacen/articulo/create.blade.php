@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <h3>Nuevo Articulo</h3>

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


            <form method="POST" action="{{ route('articulo.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control"  required value="{{old('nombre')}}">
                </div>

                <div class="form-group">
                    <label for="nombre">Categoría</label>
                    <select name="idcategoria" class="form-control">
                        @foreach($categorias as $cat)
                            <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="nombre">Codigo</label>
                    <input type="number" name="codigo" class="form-control"  required value="{{old('codigo')}}">
                </div>

                <div class="form-group">
                    <label for="nombre">Stock</label>
                    <input type="number" name="stock" class="form-control" required value="{{old('stock')}}">
                </div>

                <div class="form-group">
                <table>
                    <label for="imagen">Imágen</label>
                    <tr>
                        <td>
                            <input accept="image/*" type="file" name="imagen">
                        </td>
                    </tr>
                </table>
                </div>
                <div class="form-group">
                    <label for="nombre">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required value="{{old('nombre')}}">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Borrar</button>
                </div>


            </form>

        </div>
    </div>

@endsection
