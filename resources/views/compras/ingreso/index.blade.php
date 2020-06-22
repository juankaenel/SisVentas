@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Ingresos</h3>
            <a href="../../compras/ingreso/create" class="btn btn-success">Nuevo Ingreso</a>
            <hr>

            @include('compras.ingreso.search')
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

                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    {{--<th>Serie comprobante</th>
                    <th>Número de comprobante</th>--}}
                    <th>Comprobante</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                    </thead>

                    @foreach($ingresos as $ing)
                    <tr>

                        <td>{{$ing->fecha_hora}}</td>
                        <td>{{$ing->proveedor}}</td>
                        <td>{{$ing->tipo_comprobante.': '.$ing->serie_comprobante. '-' .$ing->num_comprobante}}</td>
                        {{-- <td>{{$ing->serie_comprobante}}</td>
                        <td>{{$ing->num_comprobante}}</td>--}}
                        <td>{{$ing->impuesto}}</td>
                        <td>{{$ing->total}}</td>
                        <td>{{$ing->estado}}</td>
                        <td>
                            <a href="{{route('ingreso.show', $ing->idingreso)}}" class="btn btn-warning btn-sm">Detalles</a>
                            <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Anular</button>
                            </a>
                        </td>
                    </tr>
                        @include('compras.ingreso.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$ingresos->render()}}
        </div>
    </div>

@endsection
