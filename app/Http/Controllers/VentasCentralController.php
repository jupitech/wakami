<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\TfacVenta;
use App\Models\StockProducto;
use App\Models\StockConsignacion;
use App\Models\StockSucursal;
use App\Models\Consignacion;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\PorcentajeCliente;
use App\Models\Producto;
use App\Models\CreditosVentas;
use App\Models\DescuentosVentas;
use App\Models\NotaCredito;
use App\Models\NotaDebito;
use App\Models\Promociones;
use App\Models\PromocionesVentas;
use App\Models\EstadoPagina;
use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;

class VentasCentralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function __contruct(){
        $this->middleware('role:admin|operativo');
    }


    public function index()
    {
        return view('admin.ventas.ventas');
    }

     public function indexnueva()
    {
        return view('admin.ventas.nuevaventa');
    }

      public function indexeditar($id)
    {
        return view('admin.ventas.editarventa');
    }

     public function indexmiventa($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","DescuentosVentas","PromocionesVentas")->where('id',$id)->first();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

        public function indexventasdiaes($estado)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',Carbon::today())
         ->orderBy('id', 'desc')
         ->where('estado_ventas',$estado)
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


      public function indexventasdia($pago,$sucursal)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',Carbon::today())
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

     public function indexventasdiaf($pago,$sucursal, Request $request)
    {

        $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
           $ffin=Carbon::create($a_fi, $m_fi, $d_fi, 23,59,59);

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->whereBetween('fecha_factura', [$fini, $ffin])
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }




     public function indexventasmes($pago,$sucursal)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',Carbon::today()->startOfMonth())
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }



       public function indexventasmeses($estado)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
          ->where('fecha_factura','>=',Carbon::today()->startOfMonth())
         ->orderBy('id', 'desc')
         ->where('estado_ventas',$estado)
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

     public function indexventasmesf($pago,$sucursal, Request $request)
    {

        $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

            $fini=Carbon::create($a_fi, $mes, $d_fi, 0,0,0)->startOfMonth();
           $ffin=Carbon::create($a_fi, $mes, $d_fi, 23,59,59)->endOfMonth();

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',$fini)
         ->where('fecha_factura','<=',$ffin)
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }




    public function indexventasanio($pago,$sucursal)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
        ->where('fecha_factura','>=',Carbon::today()->startOfYear())
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }



       public function indexventasanioes($estado)
    {

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',Carbon::today()->startOfYear())
         ->orderBy('id', 'desc')
         ->where('estado_ventas',$estado)
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }



     public function indexventasaniof($pago,$sucursal, Request $request)
    {

        $anio= $request['anio'];
           $fi =new \DateTime($anio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($anio, $m_fi, $d_fi, 0,0,0)->startOfYear();
           $ffin=Carbon::create($anio, $m_fi, $d_fi, 23,59,59)->endOfYear();

           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")
         ->where('fecha_factura','>=',$fini)
         ->where('fecha_factura','<=',$ffin)
         ->orderBy('id', 'desc')
         ->where('id_sucursal',$sucursal)
         ->whereHas('PagoVenta', function ($query) use($pago) {
                  $query->where('tipo_pago',$pago);
              })
         ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }






      public function indexmiproducto($id)
    {
           //Trayendo Producto
         $productos=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$id)->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

     public function indexmiproductomin($id)
    {
        //Trayendo Producto
       $productos = ProductoVenta::leftjoin('producto', 'producto_venta.id_producto', '=', 'producto.id')
          ->where('producto_venta.id_ventas',$id)
          ->orderBy('producto.preciop', 'asc')
          ->limit(1)
          ->first();  
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

      public function indexmidescuento($id)
    {
           //Trayendo Producto
         $descuentos=DescuentosVentas::where('id_ventas',$id)->get();
         if(!$descuentos){
             return response()->json(['mensaje' =>  'No se encuentran descuentos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $descuentos],200);
    }

      public function indexmipromoventa($id)
    {
           //Trayendo Producto
         $promociones=PromocionesVentas::where('id_ventas',$id)->get();
         if(!$promociones){
             return response()->json(['mensaje' =>  'No se encuentran promociones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $promociones],200);
    }


      public function indexmipromocion()
    {

        $hoy = Carbon::now(); 

          $a_fi=$hoy->year;
          $m_fi=$hoy->month;
          $d_fi=$hoy->day;
           //Trayendo promocion
         $promociones=Promociones::where('fecha_inicio','<',$hoy)->where('fecha_fin','>',$hoy)->first();
         if(!$promociones){
             return response()->json(['mensaje' =>  'No se encuentran promociones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $promociones,'codigo'=>200],200);
    }


    
      public function indexmisucursal($id)
    {
           //Trayendo Producto
         $sucursales=Sucursales::where('id',$id)->first();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran sucursales actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
    }

       public function stockproducto($id)
    {
           //Trayendo Productos de Sucursales
         $stockproducto=StockProducto::where('id_producto',$id)->where('bodega_actual',1)->first();
         if(!$stockproducto){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockproducto],200);
    }


      public function ventaahorasucursal(Request $request)
    {

         

           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->whereIn('estado_ventas',[2,3])
                    ->where('fecha_factura','>=',Carbon::today())
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }




        public function ventadiasucursal(Request $request)
    {

           $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
           $ffin=Carbon::create($a_fi, $m_fi, $d_fi, 23,59,59);

           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->whereIn('estado_ventas',[2,3])
                  ->whereBetween('fecha_factura', [$fini, $ffin])
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

      public function ventamessucursal(Request $request)
    {

        $mes= $request['mes'];
        $anio= $request['anio'];
        $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $mes, $d_fi, 0,0,0)->startOfMonth();
           $ffin=Carbon::create($anio, $mes, $d_fi, 23,59,59)->endOfMonth();
           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->where('estado_ventas',2)
                  ->where('fecha_factura','>=',$fini)
                  ->where('fecha_factura','<=',$ffin)
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

     public function ventaaniosucursal(Request $request)
    {

       $anio= $request['anio'];
        $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $m_fi, $d_fi, 0,0,0)->startOfYear();
           $ffin=Carbon::create($anio, $m_fi, $d_fi, 23,59,59)->endOfYear();
           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->where('estado_ventas',2)
                  ->where('fecha_factura','>=',$fini)
                  ->where('fecha_factura','<=',$ffin)
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

      public function ventaahorapago(Request $request)
    {

         

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->leftjoin('sucursales', 'ventas.id_sucursal', '=', 'sucursales.id')
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today())
          ->select(
             \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(tpago_venta.monto) as total')
               )
          ->groupBy('tpago_venta.tipo_pago','ventas.id_sucursal')
          ->get();        
           
           $sucursales=Sucursales::join('ventas', 'ventas.id_sucursal', '=', 'sucursales.id')
           ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today())
           ->select(
            'sucursales.id as id',
            'sucursales.nombre as nombre',
            'sucursales.codigo_esta as codigo_esta',
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
            )
           ->groupBy('sucursales.codigo_esta')
            ->get(); 

            $tsucu=Sucursales::select('id','nombre','codigo_esta')->get();


         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas,'sucursales' =>  $sucursales,'tsucu' =>  $tsucu],200);
    }




      public function ventadiapago(Request $request)
    {

           $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
           $ffin=Carbon::create($a_fi, $m_fi, $d_fi, 23,59,59);

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->leftjoin('sucursales', 'ventas.id_sucursal', '=', 'sucursales.id')
          ->where('ventas.estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
          ->select(
             \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(tpago_venta.monto) as total')
               )
          ->groupBy('tpago_venta.tipo_pago','ventas.id_sucursal')
          ->get();        
           
           $sucursales=Sucursales::join('ventas', 'ventas.id_sucursal', '=', 'sucursales.id')
           ->where('ventas.estado_ventas',2)
            ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
           ->select(
            'sucursales.id as id',
            'sucursales.nombre as nombre',
            'sucursales.codigo_esta as codigo_esta',
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
            )
           ->groupBy('sucursales.codigo_esta')
            ->get(); 

                 $tsucu=Sucursales::select('id','nombre','codigo_esta')->get();


         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas,'sucursales' =>  $sucursales,'tsucu' =>  $tsucu],200);
    }

       public function ventamespago(Request $request)
    {


            $mes= $request['mes'];
            $anio= $request['anio'];
            $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $mes, $d_fi, 0,0,0)->startOfMonth();
           $ffin=Carbon::create($anio, $mes, $d_fi, 23,59,59)->endOfMonth();

          $ventas = Ventas::join('tpago_venta', 'ventas.id', '=', 'tpago_venta.id_ventas')
          ->leftJoin('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
          ->select(
            'sucursales.codigo_esta',
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(tpago_venta.monto) as total')
               )
          ->groupBy('tpago_venta.tipo_pago','sucursales.id')
          ->get();

           $sucursales=Sucursales::join('ventas', 'ventas.id_sucursal', '=', 'sucursales.id')
           ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
           ->select(
            'sucursales.id as id',
            'sucursales.nombre as nombre',
            'sucursales.codigo_esta as codigo_esta',
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
            )
           ->groupBy('sucursales.codigo_esta')
            ->get();     

                $tsucu=Sucursales::select('id','nombre','codigo_esta')->get();    

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas,'sucursales' =>  $sucursales,'tsucu' =>  $tsucu],200);
    }

   public function ventaaniopago(Request $request)
    {


           $anio= $request['anio'];
           $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $m_fi, $d_fi, 0,0,0)->startOfYear();
           $ffin=Carbon::create($anio, $m_fi, $d_fi, 23,59,59)->endOfYear();

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
          ->select(
            'sucursales.codigo_esta',
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(tpago_venta.monto) as total')
               )
          ->groupBy('tpago_venta.tipo_pago','ventas.id_sucursal')
          ->get();   

             $sucursales=Sucursales::join('ventas', 'ventas.id_sucursal', '=', 'sucursales.id')
           ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
           ->select(
            'sucursales.id as id',
            'sucursales.nombre as nombre',
            'sucursales.codigo_esta as codigo_esta',
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
            )
           ->groupBy('sucursales.codigo_esta')
            ->get();         
     
                $tsucu=Sucursales::select('id','nombre','codigo_esta')->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas,'sucursales' =>  $sucursales,'tsucu' =>  $tsucu],200);
    }


    public function ventaahorafac(Request $request)
    {

        

           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',Carbon::today())
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }



       public function ventadiafac(Request $request)
    {

         $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
           $ffin=Carbon::create($a_fi, $m_fi, $d_fi, 23,59,59);


           //Trayendo Producto
         $ventas=Ventas::whereBetween('fecha_factura', [$fini, $ffin])
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

    public function ventamesfac(Request $request)
    {

          $mes= $request['mes'];
           $anio= $request['anio'];
            $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $mes, $d_fi, 0,0,0)->startOfMonth();
           $ffin=Carbon::create( $anio, $mes, $d_fi, 23,59,59)->endOfMonth();
           
           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',$fini)
                  ->where('fecha_factura','<=',$ffin)
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

    
     public function ventaaniofac(Request $request)
    {

         $anio= $request['anio'];
           $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $m_fi, $d_fi)->startOfYear();
           $ffin=Carbon::create($anio, $m_fi, $d_fi)->endOfYear();
           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',$fini)
                  ->where('fecha_factura','<=',$ffin)
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }





      public function reportevendedor()
    {

           //Trayendo Producto
         $reporte=Ventas::join('user_profile', 'user_profile.user_id', '=', 'ventas.id_user')
         ->leftjoin('role_user','role_user.user_id','=','user_profile.user_id')
         ->where('role_user.role_id',3)
          ->where('ventas.estado_ventas',2)
         ->where('ventas.fecha_factura','>=',Carbon::today())
         ->select(\DB::raw('concat(user_profile.nombre," ",user_profile.apellido) as name'),\DB::raw('sum(ventas.total) as y'))
          ->groupBy('user_profile.user_id')
         ->get();
         if(!$reporte){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $reporte],200);
    }

     public function reportevendedordia(Request $request)
    {

        $fechainicio= $request['fecha'];
           $fi =new \DateTime($fechainicio);
           $carbon = Carbon::instance($fi); 
           $a_fi=$carbon->year;
           $m_fi=$carbon->month;
           $d_fi=$carbon->day;

           $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
           $ffin=Carbon::create($a_fi, $m_fi, $d_fi, 23,59,59);

             //Trayendo Producto
         $reporte=Ventas::join('user_profile', 'user_profile.user_id', '=', 'ventas.id_user')
              ->leftjoin('role_user','role_user.user_id','=','user_profile.user_id')
         ->where('role_user.role_id',3)
          ->where('ventas.estado_ventas',2)
          ->whereBetween('ventas.fecha_factura', [$fini, $ffin])
         ->select(\DB::raw('concat(user_profile.nombre," ",user_profile.apellido) as name'),\DB::raw('sum(ventas.total) as y'))
          ->groupBy('user_profile.user_id')
         ->get();
         if(!$reporte){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $reporte],200);
    }



      public function reportevendedormes(Request $request)
    {

         $mes= $request['mes'];
          $anio= $request['anio'];
            $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $mes, $d_fi, 0,0,0)->startOfMonth();
           $ffin=Carbon::create($anio, $mes, $d_fi, 23,59,59)->endOfMonth();

             //Trayendo Producto
         $reporte=Ventas::join('user_profile', 'user_profile.user_id', '=', 'ventas.id_user')
              ->leftjoin('role_user','role_user.user_id','=','user_profile.user_id')
         ->where('role_user.role_id',3)
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
         ->select(\DB::raw('concat(user_profile.nombre," ",user_profile.apellido) as name'),\DB::raw('sum(ventas.total) as y'))
          ->groupBy('user_profile.user_id')
         ->get();
         if(!$reporte){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $reporte],200);
    }


      public function reportevendedoranio(Request $request)
    {

         $anio= $request['anio'];
           $hoy=Carbon::today();
         
           $a_fi=$hoy->year;
           $m_fi=$hoy->month;
           $d_fi=$hoy->day;

           $fini=Carbon::create($anio, $m_fi, $d_fi)->startOfYear();
           $ffin=Carbon::create($anio, $m_fi, $d_fi)->endOfYear();

             //Trayendo Producto
         $reporte=Ventas::join('user_profile', 'user_profile.user_id', '=', 'ventas.id_user')
              ->leftjoin('role_user','role_user.user_id','=','user_profile.user_id')
         ->where('role_user.role_id',3)
          ->where('ventas.estado_ventas',2)
           ->where('ventas.fecha_factura','>=',$fini)
          ->where('ventas.fecha_factura','<=',$ffin)
         ->select(\DB::raw('concat(user_profile.nombre," ",user_profile.apellido) as name'),\DB::raw('sum(ventas.total) as y'))
          ->groupBy('user_profile.user_id')
         ->get();
         if(!$reporte){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $reporte],200);
    }






    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::User();     
          $userId = $user->id; 
        
              $ventas=Ventas::create([
                  'id_cliente' => $request['id_cliente'],
                  'id_sucursal' => 3,
                  'id_user' => $userId,
                  'estado_ventas' => 1,
                        ]);
          $ventas->save();
           return response()->json(['id_venta' => $ventas->id],200);
    }

    public function storeclie(Request $request)
    {
      $user = Auth::User();     
      $userId = $user->id; 
        
      $nit= $request['nit'];
      $celular= $request['celular'];
      $telefono= $request['telefono'];
      $empresa= $request['empresa'];
      $email= $request['email'];

      if($celular=''){
          $micel='';
      }else{
          $micel= $celular;
      }

      if($telefono=''){
          $mitelefono='';
      }else{
          $mitelefono= $telefono;
      }

      if($empresa=''){
          $miempresa='';
      }else{
          $miempresa= $empresa;
      }

      if($email=''){
          $miemail='';
      }else{
          $miemail= $email;
      }


      if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){
                 $clientes=Clientes::create([
                  'empresa' => $miempresa,
                  'nombre' => $request['nombre'],
                  'direccion' => $request['direccion'],
                  'telefono' => $mitelefono,
                  'celular' => $micel,
                  'email' =>  $miemail,
                  'tipo_cliente' => $request['tipo_cliente'],
                        ]);
                $clientes->save();

               $clientenit=Clientes::find($clientes->id);
               $minit='C/F-'.$clientes->id;

                $clientenit->fill([
                  'nit' => $minit,
                    ]);
                $clientenit->save();

            }else{
               $clientes=Clientes::create([
                          'empresa' => $miempresa,
                          'nombre' => $request['nombre'],
                          'nit' => $request['nit'],
                          'direccion' => $request['direccion'],
                          'telefono' => $mitelefono,
                          'celular' => $micel,
                          'email' => $miemail,
                          'tipo_cliente' => $request['tipo_cliente'],
                                ]);
                  $clientes->save();
            }
                 


              $ventas=Ventas::create([
                  'id_cliente' => $clientes->id,
                  'id_sucursal' => 3,
                  'id_user' => $userId,
                  'estado_ventas' => 1,
                        ]);
          $ventas->save();
           return response()->json(['id_venta' => $ventas->id],200);
    }



     public function storefac(Request $request)
    {
        $idventas =$request['id_ventas'];
        $tipopago =$request['id_tpago'];   
        $tipopago2 =$request['id_tpago2'];      
        $tipofac =$request['id_tfac'];  
        $referencia =$request['referencia'];  
        $referencia2 =$request['referencia2'];  
        $tarjeta =$request['tarjeta'];  
        $tarjeta2 =$request['tarjeta2'];  
        $elmonto =$request['elmonto'];  
        $diascredito =$request['dias_credito'];    

        $ahora=Carbon::now();
   
        if($referencia==''){
            $mirefe='';
        } else{
             $mirefe=$referencia;
        } 

        if($referencia2==''){
            $mirefe2='';
        } else{
             $mirefe2=$referencia2;
        } 

        if($tarjeta==''){
            $mitarjeta='';
        } else{
             $mitarjeta=$tarjeta;
        } 

        if($tarjeta2==''){
            $mitarjeta2='';
        } else{
             $mitarjeta2=$tarjeta2;
        } 

        if($tipopago2==''){
            $mitpago2='';
        } else{
             $mitpago2=$tipopago2;
        } 


        if($elmonto==''){
            $mimonto='';
        } else{
             $mimonto=$elmonto;
        } 

        $ventas=Ventas::find( $idventas );

        //Buscando productos en ventas agregados
         $productoventas=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$idventas)->get();


            //Analizando tipo de pago y actualizando factura 
                            if($tipopago==4){

                                  $ventas->fill([
                                          'fecha_factura' => $ahora,
                                          'estado_ventas' => 3,
                                      ]);
                                  $ventas->save();

                                  $fechalimite=Carbon::now()->addDays($diascredito);


                                   $creditoventa=CreditosVentas::create([
                                      'id_ventas' => $idventas,
                                      'dias_credito' => $diascredito,
                                      'fecha_limite' => $fechalimite,
                                      'estado_credito' => 1,
                                            ]);
                                   $creditoventa->save();

                            }else{

                                  $ventas->fill([
                                          'fecha_factura' => $ahora,
                                      ]);
                                  $ventas->save();

                            }



        //Enviando factura electronica
          $detalle=[];
          $dte=[];
            //Buscando información de la sucursal
            $idsucursal=$ventas->id_sucursal;
            $misucursal=Sucursales::where('id',$idsucursal)->first();
            
            //Buscando los productos y agregando a una variable array
             foreach ($productoventas as $productoventa) {

                  $codigoProducto=$productoventa->NombreProducto->codigo;
                  $descripcionProducto=$productoventa->NombreProducto->nombre;
                  $precioUni=$productoventa->NombreProducto->preciop;
                  $montoBruto=round((($precioUni*$productoventa->cantidad)),2);

                  $exisdescuento=$productoventa->Venta->DescuentosVentas;

                    if($exisdescuento){
               
                      $porcentaje=$productoventa->Venta->DescuentosVentas->porcentaje;
                      $descuentoUnitario=($precioUni*$porcentaje)/100;
                      $precioUnitario=round(($precioUni-$descuentoUnitario),2);
                      $montoDescuento=($montoBruto*$porcentaje)/100;
                      $restamonto=round(($montoBruto-$montoDescuento),2);
                      $importeNetoGravado=round(($restamonto),2);
                      $detalleImpuestosIva=round(($restamonto*0.12),2);
                      $importeTotalOperacion=round(($restamonto),2);
                      $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);

                    }else{
                       $precioUnitario=round((($productoventa->NombreProducto->preciop)),2);
                       $montoDescuento=0;
                       $importeNetoGravado=round(($montoBruto),2);
                       $detalleImpuestosIva= round(($montoBruto*0.12),2);
                       $importeTotalOperacion=round(($montoBruto),2);
                       $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);
                    }

                  $detalle[]=array(
                       'cantidad'=> $productoventa->cantidad,
                       'unidadMedida'=> 'UND',
                       'codigoProducto'=>  $codigoProducto,
                       'descripcionProducto'=> $descripcionProducto,
                       'precioUnitario'=> "$precioUnitario",
                       'montoBruto'=> "$montoBr",
                       'montoDescuento'=> "$montoDescuento",
                       'importeNetoGravado'=>  "$importeNetoGravado",
                       'detalleImpuestosIva'=> "$detalleImpuestosIva",
                       'importeExento'=> "0",
                       'otrosImpuestos'=> "0",
                       'importeOtrosImpuestos'=> "0",
                       'importeTotalOperacion'=>"$importeTotalOperacion",
                       'tipoProducto'=> 'B',
                       'personalizado_01'=> 'N/A',
                       'personalizado_02'=> 'N/A',
                       'personalizado_03'=> 'N/A',
                       'personalizado_04'=> 'N/A',
                       'personalizado_05'=> 'N/A',
                       'personalizado_06'=> 'N/A'
                  );
             }

             $importeBruto= round((($ventas->total)/1.12),2);
             $detalleImpuestosIvat=round((($ventas->total)*0.12),2);

             $micliente=Clientes::where('id',$ventas->id_cliente)->first();
             $exisempre=$micliente->empresa;
             $existelefono=$micliente->telefono;
             $exiscorreo=$micliente->email;

             //Buscando CF en nit
             $exisnit=$micliente->nit;
             $nitcf='C';
             $encuencf=substr($exisnit,0,1);

             if( $encuencf==$nitcf){
                $nitComprador='C/F';
                $nombreComercialComprador='Consumidor Final';
             }else{
                $nitComprador=str_replace("-", "", $exisnit);

                $nombreComercialComprador=$micliente->nombre;

             }


             if($existelefono!=''){
                $telefonoComprador=$micliente->telefono;
             }else{
                $telefonoComprador='N/A';
             }

            if($exiscorreo!=''){
                $correoComprador=$micliente->email;
             }else{
                $correoComprador='N/A';
             }

             //Formato fecha 
            $fechafactura=Carbon::parse($ventas->fecha_factura);
            $fanio=$fechafactura->year;
            $fmes=$fechafactura->month;
            $fdia=$fechafactura->day;

            $createfecha=Carbon::create($fanio, $fmes, $fdia);

            $fechaDocumento=$createfecha->toDateString();

            $fechaResolucion='2016-09-21';

             //Información de factura 
             $dte=array(
                  'usuario'=> 'FILUM',
                  'clave'=> 'BA67C270504DA22D0BA7E817D8A9A3C9BFB34077A9B899D924170E3F8016B432',
                  'validador'=> false,
                  'dte'=> array(
                          'codigoEstablecimiento'=> "$misucursal->codigo_esta",
                          'idDispositivo'=>'001',
                          'serieAutorizada'=>$misucursal->serie,
                          'numeroResolucion'=>"$misucursal->resolucion",
                          'fechaResolucion'=>$fechaResolucion,
                          'tipoDocumento'=>'FACE',
                          'serieDocumento'=>"$misucursal->codigo_sat",
                          'estadoDocumento'=>'ACTIVO',
                          'numeroDocumento'=>"$ventas->id",
                          'fechaDocumento'=>$fechaDocumento,
                          'codigoMoneda'=>'GTQ',
                          'tipoCambio'=>'1',
                          'nitComprador'=>$nitComprador,
                          'nombreComercialComprador'=> $nombreComercialComprador, 
                          'direccionComercialComprador'=>$micliente->direccion, 
                          'telefonoComprador'=>$telefonoComprador,
                          'correoComprador'=>$correoComprador,
                          'regimen2989'=>false, 
                          'departamentoComprador'=>'N/A', 
                          'municipioComprador'=>'N/A',               
                          'importeBruto'=>$importeBruto,
                          'importeDescuento'=>0, 
                          'importeTotalExento'=>0,
                          'importeOtrosImpuestos'=>0,                               
                          'importeNetoGravado'=>$ventas->total, 
                          'detalleImpuestosIva'=>$detalleImpuestosIvat,
                          'montoTotalOperacion'=>$ventas->total, 
                          'descripcionOtroImpuesto'=>'N/A',
                          'observaciones'=>'N/A',
                          'nitVendedor'=>str_replace("-", "","8150406-3"),
                          'departamentoVendedor'=>'GUATEMALA', 
                          'municipioVendedor'=>'GUATEMALA',
                          'direccionComercialVendedor'=>'12 av. 14-68 Zona 10', 
                          'NombreComercialRazonSocialVendedor'=>'Filum Copropiedad', 
                          'nombreCompletoVendedor'=>'Wakami',
                          'regimenISR'=>'1',
                          'personalizado_01'=>'N/A',
                          'personalizado_02'=>'N/A',
                          'personalizado_03'=>'N/A',
                          'personalizado_04'=>'N/A',
                          'personalizado_05'=>'N/A',
                          'personalizado_06'=>'N/A',
                          'personalizado_07'=>'N/A',
                          'personalizado_08'=>'N/A',
                          'personalizado_09'=>'N/A',
                          'personalizado_10'=>'N/A',
                          'personalizado_11'=>'N/A',
                          'personalizado_12'=>'N/A',
                          'personalizado_13'=>'N/A',
                          'personalizado_14'=>'N/A',
                          'personalizado_15'=>'N/A',
                          'personalizado_16'=>'N/A',
                          'personalizado_17'=>'N/A',
                          'personalizado_18'=>'N/A',
                          'personalizado_19'=>'N/A',
                          'personalizado_20'=>'N/A',                                    
                         'detalleDte'=>$detalle
                  )
             );

//Llamada para el estado de página 
$pagina = EstadoPagina::where('nombre', 'developer')->first();
$estado = $pagina->estado;

if($estado == 1){
  
  try{
             $client = new \SoapClient('https://www.ingface.net/listener/ingface?wsdl',array( 'exceptions' => 1)); 

             $resultado=$client->registrarDte(array("dte"=>$dte));

                if($resultado->return->valido)
                      {    

                           if($elmonto==''){
                                    //guardando tipo de pago
                                    $pagoventa=TpagoVenta::create([
                                        'id_ventas' => $idventas,
                                        'tipo_pago' => $tipopago,
                                        'referencia' => $mirefe,
                                        'monto' => $ventas->total,
                                         'tarjeta' => $mitarjeta,
                                              ]);
                                    $pagoventa->save();

                          }else{
                                  $totalmonto= $ventas->total-$mimonto;
                                       //guardando tipo de pago
                                  $pagoventa=TpagoVenta::create([
                                      'id_ventas' => $idventas,
                                      'tipo_pago' => $tipopago,
                                      'referencia' => $mirefe,
                                        'monto' => $mimonto,
                                         'tarjeta' => $mitarjeta,
                                            ]);
                                  $pagoventa->save();

                                 //guardando tipo de pago
                                  $pagoventa2=TpagoVenta::create([
                                      'id_ventas' => $idventas,
                                      'tipo_pago' => $mitpago2,
                                      'referencia' => $mirefe2,
                                       'monto' => $totalmonto,
                                        'tarjeta' => $mitarjeta2,
                                            ]);
                                  $pagoventa2->save();

                          }



                              foreach ($productoventas as $productoventa) {
                                //Reduciendo stock desde los productos vendidos
                                   $stockproducto=StockProducto::where('id_producto',$productoventa->id_producto)->first();

                                      if(!is_null($stockproducto) ){
                                        $stockactual=$stockproducto->stock;
                                        $restastock=$stockactual-$productoventa->cantidad;
                                          $stockproducto->fill([
                                                            'stock' =>  $restastock,
                                                        ]);
                                          $stockproducto->save();

                                      }

                              }

                              //Recibiendo DTE y CAE para factura
                              $midte=$resultado->return->numeroDte;
                              $micae=$resultado->return->cae;
                              
                              if($tipopago==4){

                                  $ventas->fill([
                                          'estado_ventas' => 3,
                                           'dte' => $midte,
                                          'cae' => $micae,
                                      ]);
                                  $ventas->save();

                                   }else{

                                    $ventas->fill([
                                              'estado_ventas' => 2,
                                             'dte' => $midte,
                                              'cae' => $micae,
                                          ]);
                                   $ventas->save();

                               }

                             return response()->json(['DTE' => $midte,'CAE'=> $micae],200);                 
 
            } else {
                  return response()->json(['ERROR' =>  $resultado->return->descripcion],200); 
            }

     } catch (SoapFault $E) { 
          $objResponse->addAlert($E->faultstring);
      }


        return response()->json(['venta: venta real.'],200);


        }elseif ($estado == 2) {
      
                          if($elmonto==''){
                                    //guardando tipo de pago
                                    $pagoventa=TpagoVenta::create([
                                        'id_ventas' => $idventas,
                                        'tipo_pago' => $tipopago,
                                        'referencia' => $mirefe,
                                        'monto' => $ventas->total,
                                         'tarjeta' => $mitarjeta,
                                              ]);
                                    $pagoventa->save();

                          }else{
                                  $totalmonto= $ventas->total-$mimonto;
                                       //guardando tipo de pago
                                  $pagoventa=TpagoVenta::create([
                                      'id_ventas' => $idventas,
                                      'tipo_pago' => $tipopago,
                                      'referencia' => $mirefe,
                                        'monto' => $mimonto,
                                         'tarjeta' => $mitarjeta,
                                            ]);
                                  $pagoventa->save();

                                 //guardando tipo de pago
                                  $pagoventa2=TpagoVenta::create([
                                      'id_ventas' => $idventas,
                                      'tipo_pago' => $mitpago2,
                                      'referencia' => $mirefe2,
                                       'monto' => $totalmonto,
                                        'tarjeta' => $mitarjeta2,
                                            ]);
                                  $pagoventa2->save();

                          }



                              foreach ($productoventas as $productoventa) {
                                //Reduciendo stock desde los productos vendidos
                                   $stockproducto=StockProducto::where('id_producto',$productoventa->id_producto)->first();

                                      if(!is_null($stockproducto) ){
                                        $stockactual=$stockproducto->stock;
                                        $restastock=$stockactual-$productoventa->cantidad;
                                          $stockproducto->fill([
                                                            'stock' =>  $restastock,
                                                        ]);
                                          $stockproducto->save();

                                      }

                              }

                            
                              
                               if($tipopago==4){

                                  $ventas->fill([
                                          'estado_ventas' => 3,
                                      ]);
                                  $ventas->save();

                                   }else{

                                    $ventas->fill([
                                              'estado_ventas' => 2,
                                          ]);
                                   $ventas->save();

                               }

                             //return response()->json(['DTE' => $midte,'CAE'=> $micae],200);
                              return response()->json(['Venta: venta developer.'],200);
          }

 }


     public function notacredito(Request $request,$id)
    {
        $idventas =$id;
       // $tipopago =$request['id_tpago'];      
       // $tipofac =$request['id_tfac'];  
      //  $referencia =$request['referencia'];    
      // $diascredito =$request['dias_credito'];    

        $ahora=Carbon::now();
   
      
        $ventas=Ventas::find( $idventas );

        //Buscando productos en ventas agregados
         $productoventas=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$idventas)->get();


        //Enviando factura electronica
          $detalle=[];
          $dte=[];
            //Buscando información de la sucursal
            $idsucursal=$ventas->id_sucursal;
            $misucursal=Sucursales::where('id',$idsucursal)->first();
            
            //Buscando los productos y agregando a una variable array
             foreach ($productoventas as $productoventa) {

                  $codigoProducto=$productoventa->NombreProducto->codigo;
                  $descripcionProducto=$productoventa->NombreProducto->nombre;
                  $precioUni=$productoventa->NombreProducto->preciop;
                  $montoBruto=round((($precioUni*$productoventa->cantidad)),2);

                  $exisdescuento=$productoventa->Venta->DescuentosVentas;

                    if($exisdescuento){
               
                      $porcentaje=$productoventa->Venta->DescuentosVentas->porcentaje;
                      $descuentoUnitario=($precioUni*$porcentaje)/100;
                      $precioUnitario=round(($precioUni-$descuentoUnitario),2);
                      $montoDescuento=($montoBruto*$porcentaje)/100;
                      $restamonto=round(($montoBruto-$montoDescuento),2);
                      $importeNetoGravado=round(($restamonto),2);
                      $detalleImpuestosIva=round(($restamonto*0.12),2);
                      $importeTotalOperacion=round(($restamonto),2);
                      $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);

                    }else{
                       $precioUnitario=round((($productoventa->NombreProducto->preciop)),2);
                       $montoDescuento=0;
                       $importeNetoGravado=round(($montoBruto),2);
                       $detalleImpuestosIva= round(($montoBruto*0.12),2);
                       $importeTotalOperacion=round(($montoBruto),2);
                       $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);
                    }

                  $detalle[]=array(
                       'cantidad'=> $productoventa->cantidad,
                       'unidadMedida'=> 'UND',
                       'codigoProducto'=>  $codigoProducto,
                       'descripcionProducto'=> $descripcionProducto,
                       'precioUnitario'=> "$precioUnitario",
                       'montoBruto'=> "$montoBr",
                       'montoDescuento'=> "$montoDescuento",
                       'importeNetoGravado'=>  "$importeNetoGravado",
                       'detalleImpuestosIva'=> "$detalleImpuestosIva",
                       'importeExento'=> "0",
                       'otrosImpuestos'=> "0",
                       'importeOtrosImpuestos'=> "0",
                       'importeTotalOperacion'=>"$importeTotalOperacion",
                       'tipoProducto'=> 'B',
                       'personalizado_01'=> 'N/A',
                       'personalizado_02'=> 'N/A',
                       'personalizado_03'=> 'N/A',
                       'personalizado_04'=> 'N/A',
                       'personalizado_05'=> 'N/A',
                       'personalizado_06'=> 'N/A'
                  );
             }

             $importeBruto= round((($ventas->total)/1.12),2);
             $detalleImpuestosIvat=round((($ventas->total)*0.12),2);

             $micliente=Clientes::where('id',$ventas->id_cliente)->first();
             $exisempre=$micliente->empresa;
             $existelefono=$micliente->telefono;
             $exiscorreo=$micliente->email;

             //Buscando CF en nit
             $exisnit=$micliente->nit;
             $nitcf='C';
             $encuencf=substr($exisnit,0,1);

             if( $encuencf==$nitcf){
                $nitComprador='C/F';
                $nombreComercialComprador='Consumidor Final';
             }else{
                $nitComprador=str_replace("-", "", $exisnit);

                $nombreComercialComprador=$micliente->nombre;

             }


             if($existelefono!=''){
                $telefonoComprador=$micliente->telefono;
             }else{
                $telefonoComprador='N/A';
             }

            if($exiscorreo!=''){
                $correoComprador=$micliente->email;
             }else{
                $correoComprador='N/A';
             }

             //Formato fecha 
            $fechafactura=Carbon::parse($ventas->fecha_factura);
            $fanio=$fechafactura->year;
            $fmes=$fechafactura->month;
            $fdia=$fechafactura->day;

            $createfecha=Carbon::create($fanio, $fmes, $fdia);

            $fechaDocumento=$createfecha->toDateString();

              if($misucursal->codigo_esta==4){
                 $fechaResolucion='2016-12-08';
            } else{
               $fechaResolucion='2016-09-21';
            }

             //Información de factura 
             $dte=array(
                  'usuario'=> 'FILUM',
                  'clave'=> 'BA67C270504DA22D0BA7E817D8A9A3C9BFB34077A9B899D924170E3F8016B432',
                  'validador'=> false,
                  'dte'=> array(
                          'codigoEstablecimiento'=> "$misucursal->codigo_esta",
                          'idDispositivo'=>'001',
                          'serieAutorizada'=>$misucursal->serie_nce,
                          'numeroResolucion'=>"$misucursal->resolucion_nce",
                          'fechaResolucion'=>$fechaResolucion,
                          'tipoDocumento'=>'NCE',
                          'serieDocumento'=>"$misucursal->codigo_satnce",
                          'estadoDocumento'=>'ACTIVO',
                          'numeroDocumento'=>"$ventas->id",
                          'fechaDocumento'=>$fechaDocumento,
                          'codigoMoneda'=>'GTQ',
                          'tipoCambio'=>'1',
                          'nitComprador'=>$nitComprador,
                          'nombreComercialComprador'=> $nombreComercialComprador, 
                          'direccionComercialComprador'=>$micliente->direccion, 
                          'telefonoComprador'=>$telefonoComprador,
                          'correoComprador'=>$correoComprador,
                          'regimen2989'=>false, 
                          'departamentoComprador'=>'N/A', 
                          'municipioComprador'=>'N/A',               
                          'importeBruto'=>$importeBruto,
                          'importeDescuento'=>0, 
                          'importeTotalExento'=>0,
                          'importeOtrosImpuestos'=>0,                               
                          'importeNetoGravado'=>$ventas->total, 
                          'detalleImpuestosIva'=>$detalleImpuestosIvat,
                          'montoTotalOperacion'=>$ventas->total, 
                          'descripcionOtroImpuesto'=>'N/A',
                          'observaciones'=>'N/A',
                          'nitVendedor'=>str_replace("-", "","8150406-3"),
                          'departamentoVendedor'=>'GUATEMALA', 
                          'municipioVendedor'=>'GUATEMALA',
                          'direccionComercialVendedor'=>'12 av. 14-68 Zona 10', 
                          'NombreComercialRazonSocialVendedor'=>'Filum Copropiedad', 
                          'nombreCompletoVendedor'=>'Wakami',
                          'regimenISR'=>'1',
                          'personalizado_01'=>'N/A',
                          'personalizado_02'=>'N/A',
                          'personalizado_03'=>'N/A',
                          'personalizado_04'=>'N/A',
                          'personalizado_05'=>'N/A',
                          'personalizado_06'=>'N/A',
                          'personalizado_07'=>'N/A',
                          'personalizado_08'=>'N/A',
                          'personalizado_09'=>'N/A',
                          'personalizado_10'=>'N/A',
                          'personalizado_11'=>'N/A',
                          'personalizado_12'=>'N/A',
                          'personalizado_13'=>'N/A',
                          'personalizado_14'=>'N/A',
                          'personalizado_15'=>'N/A',
                          'personalizado_16'=>'N/A',
                          'personalizado_17'=>'N/A',
                          'personalizado_18'=>'N/A',
                          'personalizado_19'=>'N/A',
                          'personalizado_20'=>'N/A',
                                    
                         'detalleDte'=>$detalle
                  )
             );

//Llamada para el estado de página 
$pagina = EstadoPagina::where('nombre', 'developer')->first();
$estado = $pagina->estado;

if ($estado == 1) {
  

  try{

             $client = new \SoapClient('https://www.ingface.net/listener/ingface?wsdl',array( 'exceptions' => 1)); 

             $resultado=$client->registrarDte(array("dte"=>$dte));

                if($resultado->return->valido)
                      {    

                               $ventas->fill([
                                          'estado_ventas' => 4,
                                      ]);
                                $ventas->save();

                                        //Regresar stock a producto

                                             $idsucu=$ventas->id_sucursal;
                                             $lasucursal=Sucursales::where('id',$idsucu)->first();


                                             if($lasucursal->codigo_esta==1){

                                                      $elcliente=$ventas->id_cliente;
                                                      $consignacion=Consignacion::where('id_cliente',$elcliente)->first();


                                                     if($consignacion){

                                                         foreach ($productoventas as $productoventa) {
                                                                            //Reduciendo stock desde los productos vendidos
                                                                               $stockproducto=StockConsignacion::where('id_consignacion',$consignacion->id)->where('id_producto',$productoventa->id_producto)->first();

                                                                                  if(!is_null($stockproducto) ){
                                                                                    $stockactual=$stockproducto->stock;
                                                                                    $sumastock=$stockactual+$productoventa->cantidad;
                                                                                      $stockproducto->fill([
                                                                                                        'stock' =>  $sumastock,
                                                                                                    ]);
                                                                                      $stockproducto->save();

                                                                                  }

                                                                        }

                                                      } else{


                                                             foreach ($productoventas as $productoventa) {
                                                                            //Reduciendo stock desde los productos vendidos
                                                                               $stockproducto=StockProducto::where('id_producto',$productoventa->id_producto)->first();

                                                                                  if(!is_null($stockproducto) ){
                                                                                    $stockactual=$stockproducto->stock;
                                                                                    $sumastock=$stockactual+$productoventa->cantidad;
                                                                                      $stockproducto->fill([
                                                                                                        'stock' =>  $sumastock,
                                                                                                    ]);
                                                                                      $stockproducto->save();

                                                                                  }

                                                                        }
                                                      }   
                                                                       

                                             } else{

                                                foreach ($productoventas as $productoventa) {
                                                    //Reduciendo stock desde los productos vendidos
                                                       $stockproducto=StockSucursal::where('id_sucursal',$idsucu)->where('id_producto',$productoventa->id_producto)->first();

                                                          if(!is_null($stockproducto) ){
                                                            $stockactual=$stockproducto->stock;
                                                            $sumastock=$stockactual+$productoventa->cantidad;
                                                              $stockproducto->fill([
                                                                                'stock' =>  $sumastock,
                                                                            ]);
                                                              $stockproducto->save();

                                                          }

                                                }

                                             }   
                                
                             

                              //Recibiendo DTE y CAE para factura
                              $midte=$resultado->return->numeroDte;
                              $micae=$resultado->return->cae;
                              
                        

                                $notacredito=NotaCredito::create([
                                    'id_ventas' =>$ventas->id,
                                     'dte' => $midte,
                                      'cae' => $micae,
                                          ]);
                                $notacredito->save(); 

                             return response()->json(['DTE' => $midte,'CAE'=> $micae],200);                 
 
            } else {
                  return response()->json(['ERROR' =>  $resultado->return->descripcion],200); 
            }

     } catch (SoapFault $E) { 
          $objResponse->addAlert($E->faultstring);
      }

      

      return response()->json(['Venta: venta real.'],200);


        }elseif ($estado == 2) {


                                $ventas->fill([
                                  'estado_ventas' => 4,
                                  ]);
                                $ventas->save();

                      //Regresar stock a producto

                             $idsucu=$ventas->id_sucursal;
                             $lasucursal=Sucursales::where('id',$idsucu)->first();


                             if($lasucursal->codigo_esta==1){

                                      $elcliente=$ventas->id_cliente;
                                      $consignacion=Consignacion::where('id_cliente',$elcliente)->first();


                                     if($consignacion){

                                         foreach ($productoventas as $productoventa) {
                                                            //Reduciendo stock desde los productos vendidos
                                                               $stockproducto=StockConsignacion::where('id_consignacion',$consignacion->id)->where('id_producto',$productoventa->id_producto)->first();

                                                                  if(!is_null($stockproducto) ){
                                                                    $stockactual=$stockproducto->stock;
                                                                    $sumastock=$stockactual+$productoventa->cantidad;
                                                                      $stockproducto->fill([
                                                                                        'stock' =>  $sumastock,
                                                                                    ]);
                                                                      $stockproducto->save();

                                                                  }

                                                        }

                                      } else{


                                             foreach ($productoventas as $productoventa) {
                                                            //Reduciendo stock desde los productos vendidos
                                                               $stockproducto=StockProducto::where('id_producto',$productoventa->id_producto)->first();

                                                                  if(!is_null($stockproducto) ){
                                                                    $stockactual=$stockproducto->stock;
                                                                    $sumastock=$stockactual+$productoventa->cantidad;
                                                                      $stockproducto->fill([
                                                                                        'stock' =>  $sumastock,
                                                                                    ]);
                                                                      $stockproducto->save();

                                                                  }

                                                        }
                                      }   
                                                       

                             } else{

                                foreach ($productoventas as $productoventa) {
                                    //Reduciendo stock desde los productos vendidos
                                       $stockproducto=StockSucursal::where('id_sucursal',$idsucu)->where('id_producto',$productoventa->id_producto)->first();

                                          if(!is_null($stockproducto) ){
                                            $stockactual=$stockproducto->stock;
                                            $sumastock=$stockactual+$productoventa->cantidad;
                                              $stockproducto->fill([
                                                                'stock' =>  $sumastock,
                                                            ]);
                                              $stockproducto->save();

                                          }

                                }

                             }   
                                
                                   



                                      
                                        $notacredito=NotaCredito::create([
                                            'id_ventas' =>$ventas->id,
                                            // 'dte' => $midte,
                                            //  'cae' => $micae,
                                                  ]);
                                        $notacredito->save(); 

                                     // return response()->json(['DTE' => $midte,'CAE'=> $micae],200);    
                                        return response()->json(['Venta: venta developer.'],200);
        }



 }


     public function notadebito(Request $request,$id)
    {
        $idventas =$id;
       // $tipopago =$request['id_tpago'];      
       // $tipofac =$request['id_tfac'];  
      //  $referencia =$request['referencia'];    
      // $diascredito =$request['dias_credito'];    

        $ahora=Carbon::now();
   
      
        $ventas=Ventas::find( $idventas );

        //Buscando productos en ventas agregados
         $productoventas=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$idventas)->get();



        //Enviando factura electronica
          $detalle=[];
          $dte=[];
            //Buscando información de la sucursal
            $idsucursal=$ventas->id_sucursal;
            $misucursal=Sucursales::where('id',$idsucursal)->first();
            
            //Buscando los productos y agregando a una variable array
             foreach ($productoventas as $productoventa) {

                  $codigoProducto=$productoventa->NombreProducto->codigo;
                  $descripcionProducto=$productoventa->NombreProducto->nombre;
                  $precioUni=$productoventa->NombreProducto->preciop;
                  $montoBruto=round((($precioUni*$productoventa->cantidad)),2);

                  $exisdescuento=$productoventa->Venta->DescuentosVentas;

                    if($exisdescuento){
               
                      $porcentaje=$productoventa->Venta->DescuentosVentas->porcentaje;
                      $descuentoUnitario=($precioUni*$porcentaje)/100;
                      $precioUnitario=round(($precioUni-$descuentoUnitario),2);
                      $montoDescuento=($montoBruto*$porcentaje)/100;
                      $restamonto=round(($montoBruto-$montoDescuento),2);
                      $importeNetoGravado=round(($restamonto),2);
                      $detalleImpuestosIva=round(($restamonto*0.12),2);
                      $importeTotalOperacion=round(($restamonto),2);
                      $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);

                    }else{
                       $precioUnitario=round((($productoventa->NombreProducto->preciop)),2);
                       $montoDescuento=0;
                       $importeNetoGravado=round(($montoBruto),2);
                       $detalleImpuestosIva= round(($montoBruto*0.12),2);
                       $importeTotalOperacion=round(($montoBruto),2);
                       $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);
                    }

                  $detalle[]=array(
                       'cantidad'=> $productoventa->cantidad,
                       'unidadMedida'=> 'UND',
                       'codigoProducto'=>  $codigoProducto,
                       'descripcionProducto'=> $descripcionProducto,
                       'precioUnitario'=> "$precioUnitario",
                       'montoBruto'=> "$montoBr",
                       'montoDescuento'=> "$montoDescuento",
                       'importeNetoGravado'=>  "$importeNetoGravado",
                       'detalleImpuestosIva'=> "$detalleImpuestosIva",
                       'importeExento'=> "0",
                       'otrosImpuestos'=> "0",
                       'importeOtrosImpuestos'=> "0",
                       'importeTotalOperacion'=>"$importeTotalOperacion",
                       'tipoProducto'=> 'B',
                       'personalizado_01'=> 'N/A',
                       'personalizado_02'=> 'N/A',
                       'personalizado_03'=> 'N/A',
                       'personalizado_04'=> 'N/A',
                       'personalizado_05'=> 'N/A',
                       'personalizado_06'=> 'N/A'
                  );
             }

             $importeBruto= round((($ventas->total)/1.12),2);
             $detalleImpuestosIvat=round((($ventas->total)*0.12),2);

             $micliente=Clientes::where('id',$ventas->id_cliente)->first();
             $exisempre=$micliente->empresa;
             $existelefono=$micliente->telefono;
             $exiscorreo=$micliente->email;

             //Buscando CF en nit
             $exisnit=$micliente->nit;
             $nitcf='C';
             $encuencf=substr($exisnit,0,1);

             if( $encuencf==$nitcf){
                $nitComprador='C/F';
                $nombreComercialComprador='Consumidor Final';
             }else{
                $nitComprador=str_replace("-", "", $exisnit);

                 $nombreComercialComprador=$micliente->nombre;
                

             }


             if($existelefono!=''){
                $telefonoComprador=$micliente->telefono;
             }else{
                $telefonoComprador='N/A';
             }

            if($exiscorreo!=''){
                $correoComprador=$micliente->email;
             }else{
                $correoComprador='N/A';
             }

             //Formato fecha 
            $fechafactura=Carbon::parse($ventas->fecha_factura);
            $fanio=$fechafactura->year;
            $fmes=$fechafactura->month;
            $fdia=$fechafactura->day;

            $createfecha=Carbon::create($fanio, $fmes, $fdia);

            $fechaDocumento=$createfecha->toDateString();

            if($misucursal->codigo_esta==4){
                 $fechaResolucion='2016-12-08';
            } else{
               $fechaResolucion='2016-09-21';
            }

             //Información de factura 
             $dte=array(
                  'usuario'=> 'FILUM',
                  'clave'=> 'BA67C270504DA22D0BA7E817D8A9A3C9BFB34077A9B899D924170E3F8016B432',
                  'validador'=> false,
                  'dte'=> array(
                          'codigoEstablecimiento'=> "$misucursal->codigo_esta",
                          'idDispositivo'=>'001',
                          'serieAutorizada'=>$misucursal->serie_nde,
                          'numeroResolucion'=>"$misucursal->resolucion_nde",
                          'fechaResolucion'=>$fechaResolucion,
                          'tipoDocumento'=>'NDE',
                          'serieDocumento'=>"$misucursal->codigo_satnde",
                          'estadoDocumento'=>'ACTIVO',
                          'numeroDocumento'=>"$ventas->id",
                          'fechaDocumento'=>$fechaDocumento,
                          'codigoMoneda'=>'GTQ',
                          'tipoCambio'=>'1',
                          'nitComprador'=>$nitComprador,
                          'nombreComercialComprador'=> $nombreComercialComprador, 
                          'direccionComercialComprador'=>$micliente->direccion, 
                          'telefonoComprador'=>$telefonoComprador,
                          'correoComprador'=>$correoComprador,
                          'regimen2989'=>false, 
                          'departamentoComprador'=>'N/A', 
                          'municipioComprador'=>'N/A',               
                          'importeBruto'=>$importeBruto,
                          'importeDescuento'=>0, 
                          'importeTotalExento'=>0,
                          'importeOtrosImpuestos'=>0,                               
                          'importeNetoGravado'=>$ventas->total, 
                          'detalleImpuestosIva'=>$detalleImpuestosIvat,
                          'montoTotalOperacion'=>$ventas->total, 
                          'descripcionOtroImpuesto'=>'N/A',
                          'observaciones'=>'N/A',
                          'nitVendedor'=>str_replace("-", "","8150406-3"),
                          'departamentoVendedor'=>'GUATEMALA', 
                          'municipioVendedor'=>'GUATEMALA',
                          'direccionComercialVendedor'=>'12 av. 14-68 Zona 10', 
                          'NombreComercialRazonSocialVendedor'=>'Filum Copropiedad', 
                          'nombreCompletoVendedor'=>'Wakami',
                          'regimenISR'=>'1',
                          'personalizado_01'=>'N/A',
                          'personalizado_02'=>'N/A',
                          'personalizado_03'=>'N/A',
                          'personalizado_04'=>'N/A',
                          'personalizado_05'=>'N/A',
                          'personalizado_06'=>'N/A',
                          'personalizado_07'=>'N/A',
                          'personalizado_08'=>'N/A',
                          'personalizado_09'=>'N/A',
                          'personalizado_10'=>'N/A',
                          'personalizado_11'=>'N/A',
                          'personalizado_12'=>'N/A',
                          'personalizado_13'=>'N/A',
                          'personalizado_14'=>'N/A',
                          'personalizado_15'=>'N/A',
                          'personalizado_16'=>'N/A',
                          'personalizado_17'=>'N/A',
                          'personalizado_18'=>'N/A',
                          'personalizado_19'=>'N/A',
                          'personalizado_20'=>'N/A',
                                    
                         'detalleDte'=>$detalle
                  )
             );

$pagina = EstadoPagina::where('nombre', 'developer')->first();
$estado = $pagina->estado;

if ($estado == 1) {

  try{

             $client = new \SoapClient('https://www.ingface.net/listener/ingface?wsdl',array( 'exceptions' => 1)); 

             $resultado=$client->registrarDte(array("dte"=>$dte));

                if($resultado->return->valido)
                      {    

                               $ventas->fill([
                                          'estado_ventas' => 2,
                                      ]);
                                $ventas->save();

                                 
                             

                              //Recibiendo DTE y CAE para factura
                              $midte=$resultado->return->numeroDte;
                              $micae=$resultado->return->cae;
                              
                        

                                $notacredito=NotaDebito::create([
                                    'id_ventas' =>$ventas->id,
                                     'dte' => $midte,
                                      'cae' => $micae,
                                          ]);
                                $notacredito->save(); 

                             return response()->json(['DTE' => $midte,'CAE'=> $micae],200);                 
 
            } else {
                  return response()->json(['ERROR' =>  $resultado->return->descripcion],200); 
            }

     } catch (SoapFault $E) { 
          $objResponse->addAlert($E->faultstring);
      }





      return response()->json(['Venta: venta real.'],200);
      } elseif($estado == 2){
           

                               $ventas->fill([
                                          'estado_ventas' => 2,
                                      ]);
                                $ventas->save();
                              //Recibiendo DTE y CAE para factura
                              //  $midte=$resultado->return->numeroDte;
                              //  $micae=$resultado->return->cae;
                              
                        

                                $notacredito=NotaDebito::create([
                                    'id_ventas' =>$ventas->id,
                                  //   'dte' => $midte,
                                  //    'cae' => $micae,
                                          ]);
                                $notacredito->save(); 

                            // return response()->json(['DTE' => $midte,'CAE'=> $micae],200);     
                                return response()->json(['Venta: venta developer.'],200);
        };
    }  



     public function storepro(Request $request)
    {

       $idventas=$request['id_ventas'];
       $idproducto=$request['id_producto'];
       $producto=Producto::where('id',$idproducto)->first();

        $productoventa=ProductoVenta::where('id_ventas',$idventas)->where('id_producto',$idproducto)->first();
         if(!$productoventa){
                $miproducto=ProductoVenta::create([
                  'id_ventas' => $request['id_ventas'],
                  'id_producto' =>$request['id_producto'],
                  'cantidad' =>$request['cantidad'],
                  'precio_producto' =>$producto->preciop,
                        ]);
              $miproducto->save();
              //Agregar total de ventas
             $ventas=Ventas::where('id',$idventas)->first();
             $productos=Producto::where('id',$idproducto)->first();

             $totalactual=$ventas->total;
             $preciop=$productos->preciop;
             $subtotal=$preciop*$request['cantidad'];
             $total=$totalactual+$subtotal;

                    $ventas->fill([
                          'total' => $total,
                        ]);
                    $ventas->save();

             //Analizar si existe descuento para modificarlo
             $descuento=DescuentosVentas::where("id_ventas",$idventas)->first();

             if($descuento){

                  $porcentaje=$descuento->porcentaje;
                  $midescuento=$descuento->descuento;
                  $mitotal=$ventas->total;

                  $regretotal=$mitotal+ $midescuento;
                  //Obteniendo monto de descuento10
                  $aplides=($regretotal*$porcentaje)/100;

                  //Total Actual
                  $totalactual=$regretotal-$aplides;

                  $ventas->fill([
                      'total' => $totalactual,
                    ]);
                  $ventas->save();

                   $descuento->fill([
                      'descuento' => $aplides,
                    ]);
                  $descuento->save();
             }

         }else{
                  return response()->json(['mensaje' =>  'El producto ya existe en la venta','codigo'=>404],404);
         }
    }

    public function storedes(Request $request)
    {
      $idventas= $request['id_ventas'];
      $idcliente= $request['id_cliente'];

      $porcliente=PorcentajeCliente::where('id_cliente',$idcliente)->first();
      $ventas=Ventas::where('id',$idventas)->first();

      $miporcentaje=$porcliente->porcentaje;
      $mitotal=$ventas->total;

      //Obteniendo monto de descuento10
      $aplides=($mitotal*$miporcentaje)/100;

      //Total Actual
      $totalactual=$mitotal-$aplides;


      $ventas->fill([
          'total' => $totalactual,
        ]);
        $ventas->save();

      $descuentos=DescuentosVentas::create([
                  'id_cliente' => $idcliente,
                  'id_ventas' => $idventas,
                  'porcentaje' => $miporcentaje,
                  'descuento' => $aplides,
                        ]);
      $descuentos->save();

           return response()->json(['id_venta' => $ventas->id],200);
    }



     public function storepromo(Request $request)
    {
      $idventas= $request['id_ventas'];
      $idproducto= $request['id_producto'];
      $idpromocion= $request['id_promociones'];

      $promociones=Promociones::where('id',$idpromocion)->first();
      $ventas=Ventas::where('id',$idventas)->first();
      $producto=Producto::where('id',$idproducto)->first();
     
  

      $mitotal=$ventas->total;
      $aplipromo=$producto->preciop;
      //Total Actual
      $totalactual=$mitotal-$aplipromo;


      $ventas->fill([
          'total' => $totalactual,
        ]);
        $ventas->save();

      $promocionesventas=PromocionesVentas::create([
                  'id_promociones' => $idpromocion,
                  'id_ventas' => $idventas,
                  'id_producto' => $idproducto,
                  'promocion' => $producto->preciop,
                        ]);
      $promocionesventas->save();

           return response()->json(['id_venta' => $ventas->id],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatepro(Request $request, $id)
    {
         $productoventa=ProductoVenta::find($id);


        $cantiactual= $productoventa->cantidad;
        $idventas= $productoventa->id_ventas;
        $idproducto= $productoventa->id_producto;
   
        $ventas=Ventas::where('id',$idventas)->first();
        $productos=Producto::where('id',$idproducto)->first();


        $totalactual=$ventas->total;
        $preciop=$productos->preciop;

        $subtotal=$preciop*$request['cantidad'];
        $subtotalante=$preciop*$cantiactual;

        $restotal=$totalactual-$subtotalante;
        $total=$restotal+$subtotal;

        $ventas->fill([
              'total' => $total,
            ]);
        $ventas->save();

        $productoventa->fill([
          'cantidad' => $request['cantidad'],
        ]);
        $productoventa->save();

         //Analizar si existe descuento para modificarlo
             $descuento=DescuentosVentas::where("id_ventas",$idventas)->first();

             if($descuento){

                  $porcentaje=$descuento->porcentaje;
                  $midescuento=$descuento->descuento;
                  $mitotal=$ventas->total;

                  $regretotal=$mitotal+ $midescuento;
                  //Obteniendo monto de descuento10
                  $aplides=($regretotal*$porcentaje)/100;

                  //Total Actual
                  $totalactual=$regretotal-$aplides;

                  $ventas->fill([
                      'total' => $totalactual,
                    ]);
                  $ventas->save();

                   $descuento->fill([
                      'descuento' => $aplides,
                    ]);
                  $descuento->save();
             }
    }




    //PDF para facturas ventas

     public function pdfventa($id)
    {
      //Trayendo ventas
       $ventas=Ventas::with("InfoClientes","NombreSucursal","PerfilUsuario","DescuentosVentas")->where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoice',['ventas'=>$ventas]);
        return $pdf->download($ventas->dte.'.pdf');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventas=Ventas::find($id);

        if($ventas->estado_ventas==1){
             $productoventas=ProductoVenta::where('id_ventas',$id)->get();

              foreach ($productoventas as $productoventa) {

                  ProductoVenta::destroy($productoventa->id);
              }

               Ventas::destroy($id);
        }

    }


     public function destroypro($id)
    {
        $productoventa=ProductoVenta::find($id);
        $idventas=$productoventa->id_ventas;
        $idproducto=$productoventa->id_producto;

             $ventas=Ventas::where('id',$idventas)->first();
             $productos=Producto::where('id',$idproducto)->first();

             $totalactual=$ventas->total;
             $preciop=$productos->preciop;
             $subtotal=$preciop*$productoventa->cantidad;
             $total=$totalactual-$subtotal;

                    $ventas->fill([
                          'total' => $total,
                        ]);
                    $ventas->save();

        ProductoVenta::destroy($id);
    }

     public function destroydes($id)
    {
        $desventas=DescuentosVentas::where('id_ventas',$id)->first();
        $descuento=$desventas->descuento;
        $iddes=$desventas->id;

             $ventas=Ventas::where('id',$id)->first();

             $total=$ventas->total;

             $nuevototal=$total+$descuento;

              $ventas->fill([
                    'total' => $nuevototal,
                  ]);
              $ventas->save();

        DescuentosVentas::destroy($iddes);
    }

    public function destroypromo($id)
    {
        $promoventas=PromocionesVentas::where('id_ventas',$id)->first();
        $promocion=$promoventas->promocion;
        $idpromo=$promoventas->id;

             $ventas=Ventas::where('id',$id)->first();

             $total=$ventas->total;

             $nuevototal=$total+$promocion;

              $ventas->fill([
                    'total' => $nuevototal,
                  ]);
              $ventas->save();

        PromocionesVentas::destroy($idpromo);
    }

}
