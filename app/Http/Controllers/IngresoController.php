<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaFormRequest;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p','i.proveedor','=','p.idpersona')
                ->join('detalle_ingreso as di', 'i.idingreso','=','di.idingreso')
                ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->where('i.num_comprobante','LIKE','%'.$query.'%')
                ->orderBy('i.idingreso','desc')
                ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
                ->paginate(7);

            return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
        $articulos = DB::table('articulos as art')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) as articulo'),'idarticulo')
            ->where('art.estado','=','Activo')
            ->get();

        return view("compras.ingreso.create",["personas"=>"$personas","articulos"=>"$articulos"]);
    }

    //SI EL METODO DE ENVIO DEL FORMULARIO ES POST LLAMA A LA FUNCION STORE
    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->tipo_persona= 'Proveedor';
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->direccion = $request->get('direccion');

        $persona->save();

        return redirect('compras/proveedor');
    }

    public function show($id)
    {
        return view('compras.proveedor.show',['persona'=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('compras.proveedor.edit',['persona'=>Persona::findOrFail($id)]);
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

        return redirect('compras/proveedor')->with('mensaje', '¡Persona editada!');
    }

    //SI EL METODO DE ENVIO DEL FORMULARIO ES DELETE LLAMA A LA FUNCION UPDATE
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo'; /*cuando borro que pase a cero la condicion*/
        $persona->update();
        return redirect('compras/proveedor')->with('mensaje', 'Persona Eliminada');
    }
}
