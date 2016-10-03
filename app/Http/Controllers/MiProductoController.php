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
use Excel;
use Carbon\Carbon;

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
    
     public function excelproductos($id)
    {
          
                //Query de los productos comprados del numero de orden
                $productos = LineaProducto::leftJoin('producto', 'linea_producto.id', '=', 'producto.linea')
                          ->leftJoin('stock_sucursal', 'stock_sucursal.id_producto', '=', 'producto.id')
                          ->select(
                            'producto.codigo', 
                            'linea_producto.nombre as linea', 
                            'producto.nombre as nombre', 
                            'stock_sucursal.stock',
                            'producto.costo',
                            'producto.preciop'
                               )
                          ->where('stock_sucursal.id_sucursal',$id)
                          ->get();
  //return response()->json(['datos' =>  $productos],200);
                $nombrearchivo='Stock Sucursal Hoy';

                $proArray = []; 
                $proArray[] = ['Codigo','Linea','Producto','Stock','Costo','Precio P'];

                 foreach ($productos as $pro) {
                    $proArray[] = $pro->toArray();
                   }
                 $hoy=Carbon::now();


                //Creando Excel para orden
                Excel::create($nombrearchivo, function($excel) use($proArray, $hoy){
                          $excel->sheet('Stock Actual', function($sheet) use($proArray, $hoy) {
                              $sheet->row(1, function ($row) {
                                      $row->setFontSize(15);
                                  });
                               $sheet->cells('A5:F5', function ($cells) {
                                     $cells->setFontWeight('bold');
                                    $cells->setBorder('solid', 'none', 'none', 'solid');
                                  });
                              $sheet->row(1, array('Productos con stock actual'));
                               
                             $sheet->row(2, array('Wakami Guatemala'));
                             $sheet->row(3, array('Fecha:'.$hoy));
                             $sheet->fromArray($proArray, null, 'A5', false, false);
                            });
                    })->download('xlsx');

      
    }

    

}
