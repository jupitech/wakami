<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Consignacion;
use App\Models\StockConsignacion;
use App\Models\StockProducto;
use App\Models\Producto;
use App\Models\Clientes;
use App\Models\OrdenConsignacion;
use App\Models\ProductoEnvioco;
use App\User;
use Auth;
use Carbon\Carbon;

class ConsignacionController extends Controller
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
        return view('admin.bodegas.consignacion');
    }

         public function indexconsignacion()
    {

           //Trayendo Consignaciones
         $consignacion=Consignacion::with("InfoCliente")->get();
         if(!$consignacion){
             return response()->json(['mensaje' =>  'No se encuentran consignaciones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $consignacion],200);
    }

         public function indexproconsignacion($id)
    {
           //Trayendo Productos de Sucursales
         $stockconsignacion=StockConsignacion::with("NombreProducto")->where('id_consignacion',$id)->get();
         if(!$stockconsignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockconsignacion],200);
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

     public function indexenvios()
    {
           //Trayendo Productos de Sucursales
         $envios=OrdenConsignacion::with("NombreConsignacion")->get();
         if(!$envios){
             return response()->json(['mensaje' =>  'No se encuentran envios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $envios],200);
    }

     public function indexproenvios($id)
    {
           //Trayendo Productos de Sucursales
         $envios=ProductoEnvioco::with("NombreProducto","PendienteProducto")->where('id_orden',$id)->get();
         if(!$envios){
             return response()->json(['mensaje' =>  'No se encuentran envios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $envios],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             $idcliente=$request['id_cliente'];

            $consignacion=Consignacion::where('id_cliente',$idcliente)->first();
            if(!$consignacion){   
              $consig=Consignacion::create([
                  'id_cliente' => $request['id_cliente'],
                  'estado_consignacion' => 1,
                        ]);
             $consig->save();
            } else{
                     return response()->json(['mensaje' =>  'El Cliente ya tiene una bodega de consignacion creada','codigo'=>404],404);
             }
    }



       public function storeenvio(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 


           $ordenenvio=OrdenConsignacion::create([
          'id_consignacion' => $request['id_consignacion'],
          'id_user' => $userId,
          'estado_orden' => 1,
                ]);
          $ordenenvio->save();
           return response()->json(['id_user' => $ordenenvio->id],200);
    }




      public function storeproenvio(Request $request)
    {
        $idproducto=$request['id_producto'];
        $idorden=$request['id_orden'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->preciop;

        $existepro=ProductoEnvioco::where('id_orden',$idorden)->where('id_producto',$idproducto)->first();

            if($existepro === null){
                  $productoenvio=ProductoEnvioco::create([
                     'id_orden' =>  $idorden,
                     'id_producto' => $idproducto,
                     'precio_producto' => $producto->preciop,
                     'cantidad' => $request['cantidad'],
                     'subtotal' => $subtotal,
                      'estado_producto' => 1,
                    ]);
                   $productoenvio->save();

                  $idorden=$productoenvio->id_orden;

                    $ordenenvio=OrdenConsignacion::find($idorden);
                    //Sumar el subtotal actual
                    $totalfinal=($ordenenvio->total_compra)+$subtotal;
                    $ordenenvio->fill([
                              'total_compra' => $totalfinal,
                        ]);
                    $ordenenvio->save();

                   return response()->json(['id_proenvio' => $productoenvio->id],200);
            }else{

                    return response()->json(['mensaje' =>  'Producto ya ingresado al envio','codigo'=>404],404);
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
        
    }

     public function updateproenvio(Request $request, $id)
    {
        $idproducto=$request['id_producto'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->preciop;

        $productoenvio=ProductoEnvioco::find($id);
        $idorden=$productoenvio->id_orden;

        $ordenenvio=OrdenConsignacion::find($idorden);
        //Restar subtotal del producto
        $restartotal=$ordenenvio->total_compra- $productoenvio->subtotal;
        //Sumar el subtotal actual
        $totalfinal=$restartotal+ $subtotal;
        $ordenenvio->fill([
                  'total_compra' => $totalfinal,
            ]);
        $ordenenvio->save();


        $productoenvio->fill([
                  'cantidad' => $request['cantidad'],
                  'subtotal' => $subtotal,
            ]);
        $productoenvio->save();

       
    }

    //Enviar Orden
    public function updatep1(Request $request, $id)
    {

        $ordenenvio=OrdenConsignacion::find($id);
        $productoenvios=ProductoEnvioco::where('id_orden',$id)->get();
        $idconsignacion=$ordenenvio->id_consignacion;

        foreach ($productoenvios as $productoenvio) {

            //Reduciendo stock desde los productos vendidos
               $stockproducto=StockProducto::where('id_producto',$productoenvio->id_producto)->first();

                  if($stockproducto ){
                    $stockactual=$stockproducto->stock;
                    $restastock=$stockactual-$productoenvio->cantidad;
                      $stockproducto->fill([
                                        'stock' =>  $restastock,
                                    ]);
                      $stockproducto->save();

                  }

                //Agregando stock desde los productos vendidos
               $stockconsignacion=StockConsignacion::where('id_producto',$productoenvio->id_producto)->where('id_consignacion', $idconsignacion)->first();

                  if(!$stockconsignacion){
                       $stockconsig=StockConsignacion::create([
                                  'id_consignacion' => $idconsignacion,
                                  'id_producto' => $productoenvio->id_producto,
                                  'stock' => $productoenvio->cantidad,
                                  'estado_producto' => 1,
                            ]);
                        $stockconsig->save();
                  
                  }else{
                        $stockactual=$stockconsignacion->stock;
                    $sumarstock=$stockactual+$productoenvio->cantidad;
                      $stockconsignacion->fill([
                                        'stock' =>  $sumarstock,
                                    ]);
                      $stockconsignacion->save();

                  }
     

          }

        $ordenenvio->fill([
              'estado_orden' => 2,
              'fecha_entrega' => Carbon::now(),
            ]);
        $ordenenvio->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Consignacion::destroy($id);
    }

     public function destroypro($id)
    {
        $proenvio=ProductoEnvioco::find($id);
        $idorden=$proenvio->id_orden;
        $subtotal=$proenvio->subtotal;

        $ordenenvio=OrdenConsignacion::find($idorden);
        $restartotal=$ordenenvio->total_compra- $subtotal;
        $ordenenvio->fill([
                  'total_compra' => $restartotal,
            ]);
        $ordenenvio->save();
        ProductoEnvioco::destroy($id);
    }
}
