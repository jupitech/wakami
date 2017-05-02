<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Producto;
use App\Models\StockProducto;
use App\Models\StockSucursal;
use App\Models\StockConsignacion;
use App\Models\Sucursales;
use App\Models\Consignacion;


class InventarioConsoController extends Controller
{
    
    public function __contruct(){
        $this->middleware('role:admin|operativo');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('admin.productos.inventariocon');
    }


      public function indexproductos()
    {
           //Trayendo Producto
         $productos=Producto::with("NombreLinea","NombreImagen","StockProducto","StockSucursal","NombreProveedor","StockConsignacion")->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }


      public function sucursales()
    {
           //Trayendo Producto
         $sucursales=Sucursales::where('codigo_esta','!=',1)->get();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
    }


      public function consignacion()
    {
           //Trayendo Producto
         $consignacion=Consignacion::with("InfoCliente")->get();
         if(!$consignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $consignacion],200);
    }


      public function sumsucursal()
    {
           //Trayendo Producto
         $sucursales=StockSucursal::groupBy('id_sucursal')
         ->selectRaw('id_sucursal, sum(stock) as total')
  		 ->get();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
    }

      public function sumconsignacion()
    {
           //Trayendo Producto
         $consignacion=StockConsignacion::groupBy('id_consignacion')
         ->selectRaw('id_consignacion, sum(stock) as total')
  		 ->get();
         if(!$consignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $consignacion],200);
    }





}
