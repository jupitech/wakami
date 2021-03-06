<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\StockProducto;
use App\Models\Producto;
use App\Models\Sucursales;
use App\Models\StockSucursal;
use App\Models\Devolucion;
use App\Models\ProductoDevolucion;
use App\Models\StockDefectuoso;
use App\Models\Consignacion;
use App\Models\StockConsignacion;
use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;

class DevolucionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('admin.productos.devoluciones');
    }

        public function indexsucu()
    {
          return view('admin.productos.misdevoluciones');
    }


  public function indexdevoluciones()
    {
        //Trayendo traslados
         $devoluciones=Devolucion::with("DSucursal","DUsuario","DConsignacion")->get();
         if(!$devoluciones){
             return response()->json(['mensaje' =>  'No se encuentran devoluciones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $devoluciones],200);
    }


  
  public function indexdevolucionessucu($id)
    {
        //Trayendo traslados
         $devoluciones=Devolucion::with("DSucursal","DUsuario")->where('desde_sucursal',$id)->get();
         if(!$devoluciones){
             return response()->json(['mensaje' =>  'No se encuentran devoluciones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $devoluciones],200);
    }
    

       public function indexprodevoluciones($id)
    {
           //Trayendo Producto
         $prodevoluciones=ProductoDevolucion::with("NombreProducto")->where('id_devolucion',$id)->get();
         if(!$prodevoluciones){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $prodevoluciones],200);
    }

    
      public function indexprodevolucionessucu($id)
    {
           //Trayendo Producto
         $prodevoluciones=ProductoDevolucion::with("NombreProducto")->where('id_devolucion',$id)->get();
         if(!$prodevoluciones){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $prodevoluciones],200);
    } 


      public function indexproconsignacionas($id)
    {
           //Trayendo Productos de Sucursales
         $stockconsignacion=StockConsignacion::with("NombreProducto")->where('id_consignacion',$id)->where('stock','>',0)->get();
         if(!$stockconsignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockconsignacion],200);
    }

     public function indexprosucursales($id)
    {
           //Trayendo Productos de Sucursales
         $stocksucursal=StockSucursal::with("NombreProducto")->where('id_sucursal',$id)->where('stock','>',0)->get();
         if(!$stocksucursal){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stocksucursal],200);
    }



     //PDF para envios consignacion

     public function pdfenvio($id)
    {
      //Trayendo ventas
       $devolucion=Devolucion::with("DSucursal","DConsignacion","DUsuario")->where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoicedevolucion',['devolucion'=>$devolucion]);
        return $pdf->download('Orden Devolucion #'.$devolucion->id.'.pdf');
 
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

          $consignacion=$request['consignacion'];

          if($consignacion==''){
            $miconsig='';
          } else{
               $miconsig=$consignacion;
          }

          $misucursal=Sucursales::where('codigo_esta',1)->first();
 
            $devolucion=Devolucion::create([
                  'desde_sucursal' =>$request['desde'],
                  'desde_user' => $userId,
                  'estado_devolucion' => 1,
                  'descripcion' => $request['descripcion'],
                  'hacia' => $request['hacia'],
                  'desde_consignacion' =>  $miconsig,
                        ]);
            $devolucion->save();
           
             
    }


     public function storesucu(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 

          $sucursal=$request['desde'];

        
          $misucursal=Sucursales::where('codigo_esta',$sucursal)->first();
           $central=Sucursales::where('codigo_esta',1)->first();

            $devolucion=Devolucion::create([
                  'desde_sucursal' =>$request['desde'],
                  'desde_user' => $userId,
                  'estado_devolucion' => 1,
                  'descripcion' => $request['descripcion'],
                  'hacia' => $central->id,
                  'desde_consignacion' => 0,
                        ]);
            $devolucion->save();
           
             
    }

     public function storeprodevolucion(Request $request)
    {
        $idproducto=$request['id_producto'];
        $iddevolucion=$request['id_devolucion'];
        $producto=Producto::where('id',$idproducto)->first();
       // $subtotal=$request['cantidad']*$producto->costo;

         $existepro=ProductoDevolucion::where('id_devolucion',$iddevolucion)->where('id_producto',$idproducto)->first();
           if($existepro === null){
                   $productodevolucion=ProductoDevolucion::create([
                  'id_devolucion' =>   $iddevolucion,
                   'id_producto' => $idproducto,
                   'cantidad' => $request['cantidad'],
                   'estado_producto' => 1,
                        ]);
                  $productodevolucion->save();

                 

                   return response()->json(['id_prodevolucion' => $productodevolucion->id],200);
            }else{
                return response()->json(['mensaje' =>  'Producto ya ingresado a la compra','codigo'=>404],404);
            }       
    }



     public function storeprodevolucionsucu(Request $request)
    {
        $idproducto=$request['id_producto'];
        $iddevolucion=$request['id_devolucion'];
        $producto=Producto::where('id',$idproducto)->first();
       // $subtotal=$request['cantidad']*$producto->costo;

         $existepro=ProductoDevolucion::where('id_devolucion',$iddevolucion)->where('id_producto',$idproducto)->first();
           if($existepro === null){
                   $productodevolucion=ProductoDevolucion::create([
                  'id_devolucion' =>   $iddevolucion,
                   'id_producto' => $idproducto,
                   'cantidad' => $request['cantidad'],
                   'estado_producto' => 1,
                        ]);
                  $productodevolucion->save();

                 

                   return response()->json(['id_prodevolucion' => $productodevolucion->id],200);
            }else{
                return response()->json(['mensaje' =>  'Producto ya ingresado a la compra','codigo'=>404],404);
            }       
    }





       public function updatepro(Request $request, $id)
    {
         $idproducto=$request['id_producto'];


        $productodevolucion=ProductoDevolucion::find($id);
        $iddevolucion=$productodevolucion->id_devolucion;

    
        $productodevolucion->fill([
                  'cantidad' => $request['cantidad']
            ]);
        $productodevolucion->save();

       
    }


       public function updateprosucu(Request $request, $id)
    {
         $idproducto=$request['id_producto'];


        $productodevolucion=ProductoDevolucion::find($id);
        $iddevolucion=$productodevolucion->id_devolucion;

    
        $productodevolucion->fill([
                  'cantidad' => $request['cantidad']
            ]);
        $productodevolucion->save();

       
    }



     public function updatep1(Request $request, $id)
    {
      //Cambiando orden a estado de Compra Enviada
        $devolucion=Devolucion::find($id);
        $devolucion->fill([
                  'estado_devolucion' => 2,
            ]);
        $devolucion->save();
        $desucursal=$devolucion->desde_sucursal;
        $bodega=$devolucion->hacia;
        
          //Buscando productos en devolucion agregados
         $productodevolucion=ProductoDevolucion::with("NombreProducto")->where('id_devolucion',$id)->get();

          foreach ($productodevolucion as $productodevo) {
            //Reduciendo stock desde los productos vendidos

                             //Restar de bodega
                             if($desucursal!=104){
                                 $stockproducto=StockProducto::where('id_producto',$productodevo->id_producto)->first();

                                  if(!is_null($stockproducto) ){
                                    $stockactual=$stockproducto->stock;
                                    $restartock=$stockactual-$productodevo->cantidad;
                                      $stockproducto->fill([
                                                        'stock' =>  $restartock,
                                                    ]);
                                      $stockproducto->save();

                                  }

                             } else{

                              $dconsig=$devolucion->desde_consignacion;

                                 $stockconsig=StockConsignacion::where('id_consignacion',$dconsig)->where('id_producto',$productodevo->id_producto)->first();

                                  if(!is_null($stockconsig) ){
                                    $stockactual=$stockconsig->stock;
                                    $restartock=$stockactual-$productodevo->cantidad;
                                      $stockconsig->fill([
                                                        'stock' =>  $restartock,
                                                    ]);
                                      $stockconsig->save();

                                  }

                             }   




                        if($bodega==105){

                            //Sumar a bodega
                            $stockdefectuoso=StockDefectuoso::where('id_producto',$productodevo->id_producto)->first();

                                  if(!is_null($stockdefectuoso) ){
                                    $stockactual=$stockdefectuoso->stock;
                                    $sumastock=$stockactual+$productodevo->cantidad;
                                      $stockdefectuoso->fill([
                                                        'stock' =>  $sumastock,
                                                        'fecha_entrega' =>  Carbon::now(),
                                                    ]);
                                      $stockdefectuoso->save();

                                  } else{
                                        StockDefectuoso::create([
                                                     'id_producto' =>  $productodevo->id_producto,
                                                     'stock' =>  $productodevo->cantidad,
                                                     'fecha_entrega' =>  Carbon::now(),
                                                     'estado_producto' =>  1,
                                            ]);
                                  }
                            

                        } else{

                                    $stockproducto=StockProducto::where('id_producto',$productodevo->id_producto)->first();

                                  if(!is_null($stockproducto) ){
                                    $stockactual=$stockproducto->stock;
                                    $sumartock=$stockactual+$productodevo->cantidad;
                                      $stockproducto->fill([
                                                        'stock' =>  $sumartock,
                                                    ]);
                                      $stockproducto->save();
                                       }
                           }

             }
    }



   

     public function updatep1sucu(Request $request, $id)
    {
      //Cambiando orden a estado de Compra Enviada
        $devolucion=Devolucion::find($id);
        $devolucion->fill([
                  'estado_devolucion' => 2,
            ]);
        $devolucion->save();
        $desucursal=$devolucion->desde_sucursal;
        $bodega=$devolucion->hacia;
        
          //Buscando productos en devolucion agregados
         $productodevolucion=ProductoDevolucion::with("NombreProducto")->where('id_devolucion',$id)->get();

          foreach ($productodevolucion as $productodevo) {
            //Reduciendo stock desde los productos vendidos

                                 $stockproductosucu=StockSucursal::where('id_producto',$productodevo->id_producto)->where('id_sucursal',$desucursal)->first();

                                  if(!is_null($stockproductosucu) ){
                                    $stockactual=$stockproductosucu->stock;
                                    $restartock=$stockactual-$productodevo->cantidad;
                                      $stockproductosucu->fill([
                                                        'stock' =>  $restartock,
                                                    ]);
                                      $stockproductosucu->save();

                                  }

                                     $stockproducto=StockProducto::where('id_producto',$productodevo->id_producto)->first();

                                  if(!is_null($stockproducto) ){
                                    $stockactual=$stockproducto->stock;
                                    $sumartock=$stockactual+$productodevo->cantidad;
                                      $stockproducto->fill([
                                                        'stock' =>  $sumartock,
                                                    ]);
                                      $stockproducto->save();
                                       }
 

             }
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
           Devolucion::destroy($id);
    }

        public function destroysucu($id)
    {
           Devolucion::destroy($id);
    }



     public function destroypro($id)
    {
         ProductoDevolucion::destroy($id);
    }

     public function destroyprosucu($id)
    {
         ProductoDevolucion::destroy($id);
    }

}
