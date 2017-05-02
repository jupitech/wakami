<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\Gastos;
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

      public function indexlibro()
    {
        return view('admin.reportes.libroventas');
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
          ->whereIn('ventas.estado_ventas',[2,3])
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
           ->whereIn('ventas.estado_ventas',[2,3])
         ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
             \DB::raw('sum(producto_venta.precio_producto * producto_venta.cantidad) as totalp'),
                 \DB::raw('sum(producto.costo * producto_venta.cantidad) as costo')
               )
         ->first();  


         //Total Real
           $totalreal = Ventas::whereIn('ventas.estado_ventas',[2,3])
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
            \DB::raw('sum(total) as mitotal')
               )
         ->first(); 

          //Total Real
           $totalgasto = Gastos::where('gastos.estado_gasto',1)
          ->whereBetween('gastos.fecha_gasto', [$fini, $ffin])
         ->select(
            \DB::raw('sum(costo) as mitotal')
               )
         ->first(); 

         //Descuentos
           $descuentos = Ventas::leftjoin('descuentos_ventas', 'descuentos_ventas.id_ventas', '=', 'ventas.id')
         ->whereIn('ventas.estado_ventas',[2,3])
         ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
               \DB::raw('sum(descuentos_ventas.descuento) as descuentos')
               )
         ->first();  


            //Ordenes por dia
           $ordendia = Ventas::whereIn('ventas.estado_ventas',[2,3])
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
            \DB::raw('DATE_FORMAT(fecha_factura, "%d/%m") as name'),
            \DB::raw('count(id) as y')
               )
         ->groupBy(\DB::raw('DATE(fecha_factura)'))
         ->get(); 


            //Ordenes por hora
           $ordenhora = Ventas::whereIn('ventas.estado_ventas',[2,3])
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(
            \DB::raw('DATE_FORMAT(fecha_factura, "%H") as name'),
            \DB::raw('count(id) as y')
               )
         ->groupBy(\DB::raw('DATE_FORMAT(fecha_factura, "%H")'))
         ->orderBy(\DB::raw('DATE_FORMAT(fecha_factura, "%H")'), 'asc')
         ->get(); 


             if(!$ventas){
                 return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
            }

           return response()->json(['data' =>  $ventas,'tneto' =>  $totalneto,'tgasto' =>  $totalgasto,'treal' =>  $totalreal,'des' =>  $descuentos,'odia' =>  $ordendia,'ohora' =>  $ordenhora],200);

     


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
          ->whereIn('ventas.estado_ventas',[2,3])
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
          ->whereIn('ventas.estado_ventas',[2,3])
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
            'producto.codigo as codigo', 
             'producto.nombre as nombre', 
              'producto.preciop as preciop', 
              'producto.costo as precioi', 
            \DB::raw('sum(producto_venta.cantidad) as cantidad'),
            \DB::raw('sum(producto_venta.cantidad*producto_venta.precio_producto) as total'),
             \DB::raw('sum(producto_venta.cantidad*producto.costo) as costo')
               )
          ->groupBy('producto.id')
          ->orderBy(\DB::raw('sum(producto_venta.cantidad*producto_venta.precio_producto)'), 'desc')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

  public function ventaslinea(Request $request)
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
          ->leftJoin('linea_producto', 'linea_producto.id', '=', 'producto.linea')
          ->whereIn('ventas.estado_ventas',[2,3])
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
              'linea_producto.nombre as nombre', 
            \DB::raw('sum(producto_venta.cantidad) as cantidad'),
            \DB::raw('sum(producto_venta.cantidad*producto_venta.precio_producto) as total')
               )
          ->groupBy('linea_producto.id')
          ->orderBy(\DB::raw('sum(producto_venta.cantidad*producto_venta.precio_producto)'), 'desc')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

     public function indexlventas(Request $request)
    {

          $fechainicio= $request['fecha_inicio'];
          $fechafin= $request['fecha_fin'];
          $sucursal= $request['sucursal'];

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
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->whereIn('ventas.estado_ventas',[2,3])
         ->where('ventas.id_sucursal',$sucursal)
         ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->orderBy('id', 'desc')
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }




}
