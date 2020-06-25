<?php

namespace App\Http\Controllers;

use App\DetalleIngreso;
use App\Http\Requests\IngresoFormRequest;
use App\Http\Requests\PersonaFormRequest;
use App\Ingreso;
use App\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p','i.idproveedor','=','p.idpersona')
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
        $articulos = DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) as articulo'),'art.idarticulo')
            ->where('art.estado','=','Activo')
            ->get();

        return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);


    }

    //nos permitirá guardar tanto los ingresos como los detalles de ingreso
    public function store(IngresoFormRequest $request)
    {
        try {
         DB::beginTransaction();//inicio la transaccion   ----   almacenamos primero en la base de datos primero el ingreso y dsp el detalle de ingreso, pero los dos deben almacenarse*/
            //tabla ingreso
            $ingreso = new Ingreso();
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->serie_comprobante=$request->get('serie_comprobante');
            $ingreso->num_comprobante= $request->get('num_comprobante');
            $mytime = Carbon::now('America/Argentina/Cordoba');
            $ingreso->fecha_hora=$mytime->toDateString();
            $ingreso->impuesto='18';
            $ingreso->estado='A';
            $ingreso->save();





            /*estos datos vienen del mismo formulario*/

            //Tabla detalle_ingreso
            $idarticulo= $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            //esto hago porque se va a enviar un array de detalles
            $cont = 0; //esto me va a controlar los articulos
            while ($cont < count($idarticulo)){
                $detalle=new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }


            DB::commit();;//finalizo la transaccion
        }catch (\Exception $e){
            DB::rollback(); //si ocurre un error cancelo la transacción
        }

        return redirect('compras/ingreso');
    }

    //Para mostrar los ingresos y los detalles en una vista
    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idingreso','=',$id)
            ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante',
                'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->first(); //solo mostrame el primer ingreso q cumpla, porque solo va a cumplir un ingreso

        $detalles = DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            ->where('d.idingreso','=',$id)
            ->get(); //de ese detalle ingreso especifico, hacer el filtro de articulo y detalle ingreso y mostrame el nombre el articulo la cantidad el precio de compra y venta
        return view('compras.ingreso.show',['ingreso'=>$ingreso,'detalles'=>$detalles]);//le mando el array ingreso con todos los valores y tmb el detalle*/
    }


    //SI EL METODO DE ENVIO DEL FORMULARIO ES DELETE LLAMA A LA FUNCION UPDATE
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C'; /*cuando borro que pase a cero la condicion*/
        $ingreso->update();
        return redirect('compras/ingreso')->with('mensaje', 'Ingreso Eliminado');
    }
}
