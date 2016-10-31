<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\TfacVenta;
use App\Models\StockProducto;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\PorcentajeCliente;
use App\Models\Producto;
use App\Models\CreditosVentas;
use App\Models\DescuentosVentas;
use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;


class ReporteVentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reportes.reporteventas');
    }

      public function indexventasmes()
    {

          $ventas = Ventas::join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today()->startOfMonth())
          ->select(
            'sucursales.nombre as name',
            \DB::raw('sum(ventas.total) as y')
               )
          ->groupBy('sucursales.id')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }

         return response()->json(['data' =>  $ventas],200);
    }


     public function totalventas()
    {
         $ventas = Ventas::leftjoin('producto_venta', 'producto_venta.id_ventas', '=', 'ventas.id')
         ->leftjoin('producto', 'producto_venta.id_producto', '=', 'producto.id')
          ->leftjoin('descuentos_ventas', 'descuentos_ventas.id_ventas', '=', 'ventas.id')
         ->where('ventas.estado_ventas',2)
           ->where('ventas.fecha_factura','>=',Carbon::today()->startOfMonth())
         ->select(
            \DB::raw('sum(ventas.total) as mitotal'),
             \DB::raw('sum(producto.preciop * producto_venta.cantidad) as totalp'),
               \DB::raw('sum(descuentos_ventas.descuento) as descuentos'),
                 \DB::raw('sum(producto.costo * producto_venta.cantidad) as costo')
               )
         ->first();  

          if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }

         return response()->json(['data' =>  $ventas],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
