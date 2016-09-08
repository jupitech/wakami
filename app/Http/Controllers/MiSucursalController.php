<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use App\Models\Sucursales;
use App\Models\StockSucursal;
use App\Models\StockProducto;
use App\Models\OrdenEnvio;
use App\Models\ProductoEnvio;
use App\Models\Producto;
use App\Models\PendientePenvio;
use Carbon\Carbon;

class MiSucursalController extends Controller
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

          return view('admin.sucursales.misucursal');
       
       
    }

    public function misucursal()
    {
        $user = Auth::User();     
        $userId = $user->id; 

        $miusuario=User::with("PerfilUsuario","RolUsuario","SucursalUsuario")->where('id',$userId)->first();

        if(!$miusuario){
             return response()->json(['mensaje' =>  'No se encuentran usuarios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $miusuario],200);
    }


    public function indexenvios($id)
    {
           //Trayendo Productos de Sucursales
         $envios=OrdenEnvio::with("NombreSucursal","PerfilUsuario")->where('id_sucursal',$id)->where('estado_orden','!=',1)->get();
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
        //
    }


    public function enviarproductos(Request $request)
    {
        $user = Auth::User();     
        $userId = $user->id; 

        $idproducto=$request['id_producto'];
        $idsucursal=$request['id_sucursal'];
        $idproenvio=$request['id_proenvio'];
        $idorden=$request['id_orden'];
        $cantidad=$request['cantidad'];

        $producto=Producto::where('id',$idproducto)->first();

        //Producto compra cambia a estado 2
        $productoenvio=ProductoEnvio::find($idproenvio);
      
        //Verificando si hay productos pendientes en la compra
         $cantidadasig=$productoenvio->cantidad;
         if($cantidadasig>$cantidad){
           $actualcanti=$cantidadasig-$cantidad;

                 //Creando la compra pendiente
                  $pendienteproenvio=PendientePenvio::create([
                        'id_sucursal' => $idsucursal,
                        'id_orden' => $idorden,
                        'id_proenvio' => $idproenvio,
                        'id_producto' =>  $idproducto,
                        'cantidad' =>  $actualcanti,
                    ]);
                 $pendienteproenvio->save();

                  //Cambiando el estado del producto
                 $productoenvio->fill([
                      'estado_producto' => 3,
                      'cantidad' =>  $cantidad,
                  ]);
                  $productoenvio->save();

         }else{
            $productoenvio->fill([
                  'estado_producto' => 2,
            ]);
            $productoenvio->save();
         }
        

        //Stock de Producto de Bodega Central
        $stockproducto=StockProducto::find($idproducto);  
        $stockactual=$stockproducto->stock;

        //Restando stock de bodega central
        $restastock=$stockactual-$cantidad;

        $stockproducto->fill([
                  'stock' => $restastock,
            ]);
        $stockproducto->save();

         //Se envia a Stock de Producto con Bodega Central
        $Stocksucursal=StockSucursal::where('id_sucursal',$idsucursal)->where('id_producto',$idproducto)->first();

          if($Stocksucursal === null){

                $nuevoStock=StockSucursal::create([
                          'id_sucursal' => $idsucursal,
                          'id_producto' => $idproducto,
                          'stock' => $cantidad,
                          'estado_producto' =>  1,
                      ]);
                 $nuevoStock->save();
          }else{
                 $mistock= $Stocksucursal->stock;
                 $sumstock=$mistock+$cantidad;
                 $Stocksucursal->fill([
                         'stock' => $sumstock,
                  ]);
                 $Stocksucursal->save();
          }

      
        return response()->json(['id_proenvio' => $productoenvio->id],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
