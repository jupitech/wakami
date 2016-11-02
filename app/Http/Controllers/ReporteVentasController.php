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


     public function totalneto()
    {
         $ventas = Ventas::leftjoin('producto_venta', 'producto_venta.id_ventas', '=', 'ventas.id')
         ->leftjoin('producto', 'producto_venta.id_producto', '=', 'producto.id')
         ->where('ventas.estado_ventas',2)
           ->where('ventas.fecha_factura','>=',Carbon::today()->startOfMonth())
         ->select(
             \DB::raw('sum(producto.preciop * producto_venta.cantidad) as totalp'),
                 \DB::raw('sum(producto.costo * producto_venta.cantidad) as costo')
               )
         ->first();  

          if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }

         return response()->json(['data' =>  $ventas],200);
    }



     public function total()
    {
         $ventas = Ventas::where('estado_ventas',2)
           ->where('fecha_factura','>=',Carbon::today()->startOfMonth())
         ->select(
            \DB::raw('sum(total) as mitotal')
               )
         ->first();  

          if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }

         return response()->json(['data' =>  $ventas],200);
    }


      public function descuentos()
    {
         $ventas = Ventas::leftjoin('descuentos_ventas', 'descuentos_ventas.id_ventas', '=', 'ventas.id')
         ->where('ventas.estado_ventas',2)
           ->where('ventas.fecha_factura','>=',Carbon::today()->startOfMonth())
         ->select(
               \DB::raw('sum(descuentos_ventas.descuento) as descuentos')
               )
         ->first();  

          if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }

         return response()->json(['data' =>  $ventas],200);
    }



}
