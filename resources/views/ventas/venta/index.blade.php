@extends('layouts.admin')

@section('contenido')
    {{--el contenido de lo q copie en la plantilla se va amostrar en la section de contenido renombrada como yield en admin --}}
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Ventas</h3>
            <a href="../../ventas/venta/create" class="btn btn-success">Nuevo venta</a>
            <hr>

            @include('ventas.venta.search')
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
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                    </thead>

                    @foreach($ventas as $ven)
                    <tr>
                        <td>{{$ven->fecha_hora}}</td>
                        <td>{{$ven->nombre}}</td>
                        <td>{{$ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
                        <td>{{$ven->impuesto}}</td>
                        <td>{{$ven->total_venta}}</td>
                        <td>{{$ven->estado}}</td>
                        <td>
                            <a href="{{route('venta.show', $ven->idventa)}}" class="btn btn-warning btn-sm">Detalles</a>

                            <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal">
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </a>

                        </td>
                    </tr>
                        @include('ventas.venta.modal')
                    @endforeach
                </table>
            </div>
            <!--Acá hacemos la paginacion-->
            {{$ventas->render()}}
        </div>
    </div>

@endsection
