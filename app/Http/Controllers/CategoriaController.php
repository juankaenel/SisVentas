<?php

namespace App\Http\Controllers;
use App;
use App\Categoria;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get('searchText')); /*para filtrar una busqueda*/
            /*Serach text es un objeto en el formulario para buscar categorias. trim es para quitar espacio al inicio y al final*/
            $categorias = DB::table('categoria')->where('nombre','LIKE','%'.$query.'%')
                ->where('condicion','=','1')
                ->orderBy('idcategoria','desc')
                ->paginate(7);

            return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
     return view("almacen.categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //SI EL METODO DE ENVIO DEL FORMULARIO ES POST LLAMA A LA FUNCION STORE
    public function store(CategoriaFormRequest $request)
    {
        /*validaciones*/

        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required'
        ]);

        /*almacena el objeto del modelo categoria en nuestra tabla categoria de la bd*/
        $categoria = new Categoria; /*categoria es el modelo*/
        $categoria->nombre = $request->get('nombre'); /*el 'nombre' es lo q viaja por el formulario*/
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion='1'; /*en un primer inicio va a ser a 1, cuando elimine va a ser 0*/
        $categoria->save(); //almaceno el objeto categoria en la tabla categoria de la bd

        return redirect('almacen/categoria')->with('mensaje', '¡Categoría creada!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*la categoria que voy a mostrar va a ser igual al modelo categoria y le paso el id de la categoria q le quiero pasar*/
      return view('almacen.categoria.show',['categoria'=>Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       /*$categoria = App\Categoria::findOrFail($id);
        return view('categoria.edit', compact('categoria'));*/

        return view('almacen.categoria.edit',['categoria'=>Categoria::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //SI EL METODO DE ENVIO DEL FORMULARIO ES PATCH LLAMA A LA FUNCION UPDATE
    public function update(CategoriaFormRequest $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->update();

        return Redirect::to('almacen/categoria')->with('mensaje', '¡Categoría editada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //SI EL METODO DE ENVIO DEL FORMULARIO ES DELETE LLAMA A LA FUNCION UPDATE
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->condicion = '0'; /*cuando borro que pase a cero la condicion*/
        $categoria->update();
        return Redirect::to('almacen/categoria')->with('mensaje', 'Categoria Eliminada');


    }
}
