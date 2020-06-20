<?php

namespace App\Http\Controllers;
use App;
use App\Articulo;
use App\Http\Requests\ArticuloFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if ($request) {

            $query = trim($request->input('searchText'));

            $articulos = Articulo::with('categoria')->get();

            return view('almacen.articulo.index', [
                'articulos' => $articulos,
                'searchText' => $query
            ]);
        }
    }


    public function create()
    {
        $categorias = App\Categoria::where('condicion','=', '1')->get();
        return view('almacen.articulo.create',compact('categorias'));

    }


    public
    function store(ArticuloFormRequest $request)
    {
        $articuloNuevo = new App\Articulo;
        $articuloNuevo->idcategoria=$request->idcategoria;
        $articuloNuevo->codigo=$request->codigo;
        $articuloNuevo->nombre = $request->nombre;
        $articuloNuevo->stock = $request->stock;
        $articuloNuevo->descripcion = $request->descripcion;
        $articuloNuevo->estado = 'Activo'; //cuando cree un articulo nuevo va a ser activo
        if($request->hasFile('imagen')){ //esta imagen es la q recibimos del formulario
            $file=$request->file('imagen');
            //movemos la imagen q está en file
            $file->move(public_patch().'/imagenes/articulos/',$file->getClientOriginalName());
            //guardamos la ruta de imagen en el articulo
            $articuloNuevo->imagen=$file->getClientOriginalName();
        }

        $articuloNuevo->save();

        return redirect('almacen/articulo')->with('mensaje', 'Artículo agregado');
    }


    public
    function show($id)
    {
        $articulo = App\Articulo::findOrFail($id);

        return view('almacen.articulo.show', compact('articulo'));
    }

    public
    function edit($id)
    {
        $articulo = App\Articulo::findOrFail($id);
        $categorias = App\Categoria::where('condicion','=', '1')->get();
        return view('almacen.articulo.edit', compact('articulo','categorias'));
    }


    public
    function update(ArticuloFormRequest $request, $id)
    {
        $articuloNuevo = App\Articulo::findOrFail($id);

        $articuloNuevo->idcategoria=$request->idcategoria;
        $articuloNuevo->codigo=$request->codigo;
        $articuloNuevo->nombre = $request->nombre;
        $articuloNuevo->stock = $request->stock;
        $articuloNuevo->descripcion = $request->descripcion;
        //$articuloNuevo->estado = 'Activo'; //cuando cree un articulo nuevo va a ser activo
        if($request->hasFile('imagen')){ //esta imagen es la q recibimos del formulario
            $file=$request->file('imagen');
            //movemos la imagen q está en file
            $file->move(public_patch().'/imagenes/articulos/',$file->getClientOriginalName());
            //guardamos la ruta de imagen en el articulo
            $articuloNuevo->imagen=$file->getClientOriginalName();
        }

        $articuloNuevo->save();

        return redirect('almacen/articulo');
    }

    public function destroy($id)
    {
        $articulo = App\Articulo::findOrFail($id);
        $articulo->estado = 'Inactivo';
        $articulo->update();

        redirect('almacen/articulo');
    }
}
