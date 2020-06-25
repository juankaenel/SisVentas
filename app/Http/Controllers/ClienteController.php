<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaFormRequest;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get('searchText')); /*para filtrar una busqueda*/
            /*Serach text es un objeto en el formulario para buscar categorias. trim es para quitar espacio al inicio y al final*/
            $personas = DB::table('persona')
                ->where('nombre','LIKE','%'.$query.'%')
                ->where('tipo_persona','=','Cliente') //o buscame por...
                ->orwhere('num_documento','LIKE','%'.$query.'%')
                ->where('tipo_persona','=','Cliente')
                ->orderBy('idpersona','desc')
                ->paginate(7);

            return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]);
        }
    }

    public function create()
    {
        return view("ventas.cliente.create");
    }

    //SI EL METODO DE ENVIO DEL FORMULARIO ES POST LLAMA A LA FUNCION STORE
    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->tipo_persona= 'Cliente';
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->direccion = $request->get('direccion');

        $persona->save();

        return redirect('ventas/cliente');
    }

    public function show($id)
    {
        return view('ventas.cliente.show',['persona'=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('ventas.cliente.edit',['persona'=>Persona::findOrFail($id)]);
    }

    //SI EL METODO DE ENVIO DEL FORMULARIO ES PATCH LLAMA A LA FUNCION UPDATE
    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);
        //el tipo de persona no porque si voy a editar va a seguir siendo un cliente
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->direccion = $request->get('direccion');
        $persona->update();

        return redirect('ventas/cliente')->with('mensaje', '¡Persona editada!');
    }

    //SI EL METODO DE ENVIO DEL FORMULARIO ES DELETE LLAMA A LA FUNCION UPDATE
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo'; /*cuando borro que pase a cero la condicion*/
        $persona->update();
        return redirect('ventas/cliente')->with('mensaje', 'Persona Eliminada');
    }
}

