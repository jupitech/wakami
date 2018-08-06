<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Sucursales;
use App\Models\StockSucursal;
use App\Models\StockProducto;
use App\Models\AjusteInventario;
use App\Models\OrdenEnvio;
use App\Models\ProductoEnvio;
use App\Models\Producto;
use App\Models\PendientePenvio;
use App\User;
use Auth;
use Carbon\Carbon;

class SucursalController extends Controller
{
    public function __contruct(){
        $this->middleware('role:admin|operativo|vendedor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sucursales.sucursales');
    }

     public function indexsucursales()
    {

           //Trayendo Sucursales
         $sucursales=Sucursales::with("PerfilUsuario","PerfilUsuario2")->get();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran sucursales actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
    }

     public function indexusers()
    {

        //Trayendo Usuarios
         $usuarios=User::with("PerfilUsuario","RolUsuario")->get();
         if(!$usuarios){
             return response()->json(['mensaje' =>  'No se encuentran sucursales actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $usuarios],200);
    }

     public function indexprosucursales($id)
    {
           //Trayendo Productos de Sucursales
         $stocksucursal=StockSucursal::with("NombreProducto")->where('id_sucursal',$id)->get();
         if(!$stocksucursal){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stocksucursal],200);
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
         $envios=OrdenEnvio::with("NombreSucursal")->get();
         if(!$envios){
             return response()->json(['mensaje' =>  'No se encuentran envios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $envios],200);
    }

     public function indexproenvios($id)
    {
           //Trayendo Productos de Sucursales
         $envios=ProductoEnvio::with("NombreProducto","PendienteProducto")->where('id_orden',$id)->get();
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

      $iduser2= $request['id_user2'];

      if($iduser2!=''){
         $miduser2=$iduser2;
      }else{
         $miduser2='';
      }

              $sucursales=Sucursales::create([
                  'nombre' => $request['nombre'],
                  'ubicacion' => $request['ubicacion'],
                  'telefono' => $request['telefono'],
                  'serie' => $request['serie'],
                  'id_user' =>  $request['id_user'],
                  'id_user2' =>  $miduser2,
                  'codigo_esta' =>  $request['codigo_esta'],
                  'codigo_sat' =>  $request['codigo_sat'],
                  'resolucion' =>  $request['resolucion'],
                  'fresolucion' =>  $request['fresolucion'],
                  'codigo_satnce' =>  $request['codigo_satnce'],
                  'serie_nce' =>  $request['serie_nce'],
                  'resolucion_nce' =>  $request['resolucion_nce'],
                  'fresolucion_nce' =>  $request['fresolucion_nce'],
                  'codigo_satnde' =>  $request['codigo_satnde'],
                  'serie_nde' =>  $request['serie_nde'],
                  'resolucion_nde' =>  $request['resolucion_nde'],
                  'fresolucion_nde' =>  $request['fresolucion_nde'],
                  
                        ]);
          $sucursales->save();
    }



       public function storeenvio(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 


           $ordenenvio=OrdenEnvio::create([
          'id_sucursal' => $request['id_sucursal'],
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

        $existepro=ProductoEnvio::where('id_orden',$idorden)->where('id_producto',$idproducto)->first();

            if($existepro === null){
                  $productoenvio=ProductoEnvio::create([
                     'id_orden' =>  $idorden,
                     'id_producto' => $idproducto,
                     'precio_producto' => $producto->preciop,
                     'cantidad' => $request['cantidad'],
                     'subtotal' => $subtotal,
                      'estado_producto' => 1,
                    ]);
                   $productoenvio->save();

                  $idorden=$productoenvio->id_orden;

                    $ordenenvio=OrdenEnvio::find($idorden);
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

     public function storestock(Request $request,$id)
    {

       $user = Auth::User();     
         $userId = $user->id; 

         $stockac=StockSucursal::where('id_sucursal',$request['id_sucursal'])->where('id_producto',$id)->first();
         $restante= $request['stock_actual']-($stockac->stock);

         $ajuste=AjusteInventario::create([
                  'id_user' => $userId,
                  'id_producto' => $id,
                  'stock_anterior' => $stockac->stock,
                  'stock_actual' => $request['stock_actual'],
                  'stock_restante' => $restante,
                  'tipo_stock' => 'S',
                  'justificacion' => $request['justificacion'],
                  'id_sucursal' => $request['id_sucursal'],
                        ]);
          $ajuste->save();

           $stockac->fill([
                  'stock' =>  $request['stock_actual'],
            ]);
           $stockac->save();
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
          $sucursales=Sucursales::find($id);
        $sucursales->fill([
                'nombre' => $request['nombre'],
                'ubicacion' => $request['ubicacion'],
                'telefono' => $request['telefono'],
                'serie' => $request['serie'],
                'id_user' =>  $request['id_user'],
                'id_user2' =>  $request['id_user2'],
                'codigo_esta' =>  $request['codigo_esta'],
                'codigo_sat' =>  $request['codigo_sat'],
                'resolucion' =>  $request['resolucion'],
                'fresolucion' =>  $request['fresolucion'],
                'codigo_satnce' =>  $request['codigo_satnce'],
                'serie_nce' =>  $request['serie_nce'],
                'resolucion_nce' =>  $request['resolucion_nce'],
                'fresolucion_nce' =>  $request['fresolucion_nce'],
                'codigo_satnde' =>  $request['codigo_satnde'],
                'serie_nde' =>  $request['serie_nde'],
                'resolucion_nde' =>  $request['resolucion_nde'],
                'fresolucion_nde' =>  $request['fresolucion_nde'],
            ]);
        $sucursales->save();
    }


    public function updateproenvio(Request $request, $id)
    {
        $idproducto=$request['id_producto'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->preciop;

        $productoenvio=ProductoEnvio::find($id);
        $idorden=$productoenvio->id_orden;

        $ordenenvio=OrdenEnvio::find($idorden);
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
        $ordenenvio=OrdenEnvio::find($id);
        $ordenenvio->fill([
              'estado_orden' => 2,
              'fecha_entrega' => Carbon::now(),
            ]);
        $ordenenvio->save();
    }

    public function updatep2(Request $request, $id)
    {
        $ordenenvio=OrdenEnvio::find($id);
        $ordenenvio->fill([
                  'estado_orden' => 4,
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
        Sucursales::destroy($id);
    }

    public function destroypro($id)
    {
        $proenvio=ProductoEnvio::find($id);
        $idorden=$proenvio->id_orden;
        $subtotal=$proenvio->subtotal;

        $ordenenvio=OrdenEnvio::find($idorden);
        $restartotal=$ordenenvio->total_compra- $subtotal;
        $ordenenvio->fill([
                  'total_compra' => $restartotal,
            ]);
        $ordenenvio->save();
        ProductoEnvio::destroy($id);
    }
}
