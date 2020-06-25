<?php

namespace App\Http\Controllers;

use App\DetalleIngreso;
use App\DetalleVenta;
use App\Http\Requests\VentaFormRequest;
use App\Ingreso;
use App\Venta;
use App\Persona;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get('searchText'));
            $ventas = DB::table('venta as v')
                ->join('persona as p','v.idcliente','=','p.idpersona')
                ->join('detalle_venta as dv', 'v.idventa','=','dv.id_venta')
                ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //v.total_venta es el campo de la tabla de venta para mostrar el total de la venta
                ->where('v.num_comprobante','LIKE','%'.$query.'%')
                ->orderBy('v.idventa','desc')
                ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
                ->paginate(7);

            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]); /*envio por parámetro ventas que es un array todas las $ventas*/
        }
    }


    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona','=','Cliente')->get(); //en este caso el tipo de persona que queremos traer son los clientes de la tabla persona
        $articulos = DB::table('articulo as art') //en la var articulo quyiero traer todos los articulos
            ->join('detalle_ingreso as di', 'art.idarticulo','=','di.idarticulo') //junto las dos tablas, articulo y detalle de ingreso a traves del id articulo
            ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) as articulo'),'art.idarticulo','art.stock',DB::raw('avg(di.precio_venta) as precio_promedio')) //en este caso lo que hacemos es calcular un promedio de todos los precios de venta para establecer a ese precio la venta del articulo
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0')
            ->groupBy('articulo','art.idarticulo','art.stock') //reagrupamos
            ->get();

        return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos]);
    }


    public function store(VentaFormRequest $request)
    {
      /*  try {*/
            DB::beginTransaction();//inicio la transaccion   ----   almacenamos primero en la base de datos primero el ingreso y dsp el detalle de ingreso, pero los dos deben almacenarse*/
            //tabla ingreso
            $venta = new Venta();
            $venta->idcliente=$request->get('idcliente');
            $venta->tipo_comprobante=$request->get('tipo_comprobante');
            $venta->serie_comprobante=$request->get('serie_comprobante');
            $venta->num_comprobante= $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta'); //esto se tomará desde una funcion en js

            $mytime = Carbon::now('America/Argentina/Cordoba');
            $venta->fecha_hora=$mytime->toDateString();
            $venta->impuesto='18';
            $venta->estado='A'; //aceptada
            $venta->save();

            //variables que reciben el valor de los detalles
            $idarticulo= $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento'); //desc es un objeto del formulario, un input con un array de valores
            $precio_venta = $request->get('precio_venta');

            //esto hago porque se va a enviar un array de detalles
            $cont = 0; //esto me va a controlar los articulos
            while ($cont < count($idarticulo)){
                $detalle=new DetalleVenta();
                $detalle->id_venta=$venta->idventa;
                $detalle->id_articulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }


            DB::commit();;//finalizo la transaccion
     /*   }catch (\Exception $e){
            DB::rollback(); //si ocurre un error cancelo la transacción
        }*/

        return redirect('ventas/venta'); //redirigime al index
    }


    public function show($id)
    {
        $venta = DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.id_venta')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where('v.idventa','=',$id)
            /*->groupBy('v.idingreso', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante',
                'v.num_comprobante', 'v.impuesto', 'v.estado')*/
            ->first(); //solo mostrame el primer ingreso q cumpla, porque solo va a cumplir un ingreso

        $detalles = DB::table('detalle_venta as d')
            ->join('articulo as a','d.id_articulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
            ->where('d.id_venta','=',$id)
            ->get(); //de ese detalle ingreso especifico, hacer el filtro de articulo y detalle ingreso y mostrame el nombre el articulo la cantidad el precio de compra y venta
        return view('ventas.venta.show',['venta'=>$venta,'detalles'=>$detalles]);//le mando el array ingreso con todos los valores y tmb el detalle*/

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->estado='C';
        $venta->update();
        return redirect('ventas/venta');
    }
}
