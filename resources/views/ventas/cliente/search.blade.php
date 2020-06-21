{!! Form::open(array('url'=>'ventas/cliente','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="form-group">
    <div class="input-group">
        <!--El name es el q va a recibir el controlador CategoriaController para hacer el filtro. Por defecto en el value ponemos el search text que nos manda el controlador a través de la vista-->
        <input type="text" class="form-control" name="searchText" placeholder="Buscar.." value="{{$searchText}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Buscar</button> <!--Cuando le doy buscar, va hacia la ruta almacen categoria, donde esta va hacia el controlador y llama al metodo index y se realizará el filtro-->
        </span>
    </div>
</div>

{!!Form::close()!!}

