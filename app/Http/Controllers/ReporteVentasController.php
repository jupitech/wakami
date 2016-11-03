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

      public function indexventas(Request $request)
    {

         $fechainicio= $request['fecha_inicio'];
         $fechafin= $request['fecha_fin'];

          $fi =new \DateTime($fechainicio);
          $carbon = Carbon::instance($fi); 
          $a_fi=$carbon->year;
          $m_fi=$carbon->month;
          $d_fi=$carbon->day;

          $ff =new \DateTime($fechafin);
          $carbon2 = Carbon::instance($ff); 
          $a_ff=$carbon2->year;
          $m_ff=$carbon2->month;
          $d_ff=$carbon2->day;


          $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
          $ffin=Carbon::create($a_ff, $m_ff, $d_ff, 23,59,59);

          //Total por sucursal
          $ventas = Ventas::join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
          ->where('ventas.estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
            'sucursales.nombre as name',
            \DB::raw('sum(ventas.total) as y')
               )
          ->groupBy('sucursales.id')
          ->get();   


          //Total neto
           $totalneto = Ventas::leftjoin('producto_venta', 'producto_venta.id_ventas', '=', 'ventas.id')
         ->leftjoin('producto', 'producto_venta.id_producto', '=', 'producto.id')
         ->where('ventas.estado_ventas',2)
         ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
             \DB::raw('sum(producto.preciop * producto_venta.cantidad) as totalp'),
                 \DB::raw('sum(producto.costo * producto_venta.cantidad) as costo')
               )
         ->first();  


         //Total Real
           $totalreal = Ventas::where('estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
            \DB::raw('sum(total) as mitotal')
               )
         ->first(); 

         //Descuentos
           $descuentos = Ventas::leftjoin('descuentos_ventas', 'descuentos_ventas.id_ventas', '=', 'ventas.id')
         ->where('ventas.estado_ventas',2)
         ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
               \DB::raw('sum(descuentos_ventas.descuento) as descuentos')
               )
         ->first();  


            //Ordenes por dia
           $ordendia = Ventas::where('estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
            \DB::raw('DATE_FORMAT(fecha_factura, "%d/%m") as name'),
            \DB::raw('count(id) as y')
               )
         ->groupBy(\DB::raw('DATE(fecha_factura)'))
         ->get(); 


             if(!$ventas){
                 return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
            }

           return response()->json(['data' =>  $ventas,'tneto' =>  $totalneto,'treal' =>  $totalreal,'des' =>  $descuentos,'odia' =>  $ordendia],200);




    }

   
      public function ventaspago(Request $request)
    {

          $fechainicio= $request['fecha_inicio'];
         $fechafin= $request['fecha_fin'];

          $fi =new \DateTime($fechainicio);
          $carbon = Carbon::instance($fi); 
          $a_fi=$carbon->year;
          $m_fi=$carbon->month;
          $d_fi=$carbon->day;

          $ff =new \DateTime($fechafin);
          $carbon2 = Carbon::instance($ff); 
          $a_ff=$carbon2->year;
          $m_ff=$carbon2->month;
          $d_ff=$carbon2->day;


          $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
          $ffin=Carbon::create($a_ff, $m_ff, $d_ff, 23,59,59);

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->leftJoin('sucursales', 'ventas.id_sucursal', '=', 'sucursales.id')
          ->where('ventas.estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
            'tpago_venta.tipo_pago as name', 
            \DB::raw('sum(ventas.total) as y')
               )
          ->groupBy('tpago_venta.tipo_pago')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['data' =>  $ventas],200);
    }


     public function ventasproducto(Request $request)
    {

         $fechainicio= $request['fecha_inicio'];
         $fechafin= $request['fecha_fin'];

          $fi =new \DateTime($fechainicio);
          $carbon = Carbon::instance($fi); 
          $a_fi=$carbon->year;
          $m_fi=$carbon->month;
          $d_fi=$carbon->day;

          $ff =new \DateTime($fechafin);
          $carbon2 = Carbon::instance($ff); 
          $a_ff=$carbon2->year;
          $m_ff=$carbon2->month;
          $d_ff=$carbon2->day;


          $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
          $ffin=Carbon::create($a_ff, $m_ff, $d_ff, 23,59,59);

          $ventas = Ventas::join('producto_venta', 'producto_venta.id_ventas', '=', 'ventas.id')
          ->leftJoin('producto', 'producto_venta.id_producto', '=', 'producto.id')
          ->where('ventas.estado_ventas',2)
        //  ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
            'producto.codigo as codigo', 
             'producto.nombre as nombre', 
              'producto.preciop as preciop', 
              'producto.costo as precioi', 
            \DB::raw('sum(producto_venta.cantidad) as cantidad'),
            \DB::raw('sum(producto_venta.cantidad*producto.preciop) as total'),
             \DB::raw('sum(producto_venta.cantidad*producto.costo) as costo')
               )
          ->groupBy('producto.id')
          ->orderBy(\DB::raw('sum(producto_venta.cantidad*producto.preciop)'), 'desc')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }





}
