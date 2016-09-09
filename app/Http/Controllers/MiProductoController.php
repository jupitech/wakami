<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Http\Requests;
use App\Models\Producto;
use App\Models\StockSucursal;
use App\Models\LineaProducto;
use App\Models\GaleriaImagen;
use App\Models\StockProducto;

class MiProductoController extends Controller
{


    public function __contruct(){
        $this->middleware('role:vendedor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('admin.productos.misproductos');
    }

    public function indexproductos($id)
    {
           //Trayendo Producto
         $productos=StockSucursal::with("NombreProducto")->where('id_sucursal',$id)->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

      public function indexlineas()
    {
           //Trayendo Lineas
         $lineas=LineaProducto::all();
         if(!$lineas){
             return response()->json(['mensaje' =>  'No se encuentran lineas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $lineas],200);
    }
    

}
