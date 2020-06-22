@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-6 col-md-6  col-sm-6 col-xs-12">
            <h3>Nuevo Ingreso</h3>

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

        </div>
    </div>
    <form method="POST" action="{{ route('ingreso.store') }}">

        @csrf

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="nombre">Proveedor</label>
                    <select name="idproveedor" id="idproveedor" class="form-control select-picker"
                            data-live-search="true">
                        @foreach($personas as $persona)
                            <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="tipo_documento">Tipo de comprobante</label>
                    <select type="text" name="tipo_comprobante" class="form-control">
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                        <option value="Ticket">Ticket</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Serie Comprobante</label>
                    <input type="number" name="serie_comprobante" class="form-control"
                           value="{{old('serie_comprobante')}}"
                           placeholder="Serie de comprobante..">
                </div>
            </div>

            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Número de Comprobante</label>
                    <input type="number" name="num_comprobante" class="form-control" required
                           value="{{old('num_comprobante')}}" placeholder="Número de comprobante..">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-body">
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="form-group">
                            <label>Artículo</label>
                            <!--pidarticulo es pq no es el del array sino que le tomamos como un objeto auxiliar para cargarlo al detalle-->
                            <select name="pidarticulo" id="pidarticulo" class="form-control select-picker"
                                    data-live-search="true">
                                @foreach($articulos as $articulo)
                                    <option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="pcantidad" name="pcantidad" class="form-control"
                                   placeholder="Cantidad..">
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="pprecio_compra">Precio de compra</label>
                            <input type="number" id="pprecio_compra" name="pprecio_compra" class="form-control"
                                   placeholder="Precio de compra..">
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="pprecio_venta">Precio de venta</label>
                            <input type="number" id="pprecio_venta" name="pprecio_venta" class="form-control"
                                   placeholder="Precio de venta..">
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="bt_add">Agregar</button>
                        </div>
                    </div>


                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #59aeee; color: white">
                            <th>Opciones</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Subtotal</th>
                            </thead>
                            <tfoot>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><h4 id="total">S/. 0.00</h4></th>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group"> <!--el token es para con transacciones-->
                    <input name="_token" value="{{csrf_token()}}" type="hidden">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Borrar</button>
                </div>
            </div>

        </div>

    </form>

@endsection
