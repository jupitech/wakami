<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\OrdenCompra;
use App\Models\ProductoCompra;
use App\Models\Producto;
use App\Models\EntregaCompra;
use App\Models\StockProducto;
use Auth;
use Carbon\Carbon;

class OrdenCompraController extends Controller
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
           return view('admin.compras.compras');
    }
    

    public function indexcompras()
    {
           //Trayendo Producto
         $compras=OrdenCompra::with("NombreProveedor")->get();
         if(!$compras){
             return response()->json(['mensaje' =>  'No se encuentran compras actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $compras],200);
    }

       public function indexprocompras($id)
    {
           //Trayendo Producto
         $procompras=ProductoCompra::with("NombreProducto")->where('id_orden',$id)->get();
         if(!$procompras){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $procompras],200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeprocompra(Request $request)
    {
        $idproducto=$request['id_producto'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->costo;

           $productocompra=ProductoCompra::create([
          'id_orden' => $request['id_orden'],
           'id_producto' => $idproducto,
           'precio_producto' => $producto->costo,
           'cantidad' => $request['cantidad'],
            'subtotal' => $subtotal,
           'estado_producto' => 1,
                ]);
          $productocompra->save();
           return response()->json(['id_procompra' => $productocompra->id],200);
    }



        public function store(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 
          $diasentrega= $request['fecha_entrega'];


                   $ordencompra=OrdenCompra::create([
                  'id_proveedor' => $request['id_proveedor'],
                  'id_user' => $userId,
                  'fecha_entrega' => Carbon::today()->addDays($diasentrega),
                  'estado_orden' => 1,
                        ]);
          $ordencompra->save();
           return response()->json(['id_user' => $ordencompra->id],200);
    }

     public function enviarproductos(Request $request)
    {
        $user = Auth::User();     
        $userId = $user->id; 

        $idproducto=$request['id_producto'];
        $idprocompra=$request['id_procompra'];
        $idorden=$request['id_orden'];
        $cantidad=$request['cantidad'];
        $producto=Producto::where('id',$idproducto)->first();

        //Producto compra cambia a estado 2
        $productocompra=ProductoCompra::find($idprocompra);
        $productocompra->fill([
                  'estado_producto' => 2,
            ]);
        $productocompra->save();
        //Se realiza un dato de la entrega de compra del producto
        $entregacompra=EntregaCompra::create([
                  'id_orden' => $idorden,
                  'id_procompra' => $idprocompra,
                  'id_producto' =>  $idproducto,
                  'cantidad' =>  $cantidad,
              ]);
         $entregacompra->save();

         //Se envia a Stock de Producto con Bodega Central
          $stockproducto=StockProducto::find($idproducto);

          if($stockproducto === null){

                $nuevoStock=StockProducto::create([
                          'id_producto' => $idproducto,
                          'stock' => $cantidad,
                          'bodega_actual' =>  1,
                          'act_su' =>  0,
                          'act_co' =>  0,
                          'id_user' =>  $userId,
                          'estado_producto' =>  1,
                      ]);
                 $nuevoStock->save();
          }else{
                 $mistock= $stockproducto->stock;
                 $sumstock=$mistock+$cantidad;
                 $stockproducto->fill([
                         'stock' => $sumstock,
                         'id_user' =>  $userId,
                  ]);
                 $stockproducto->save();
          }

      
        return response()->json(['id_procompra' => $productocompra->id],200);
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
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatep1(Request $request, $id)
    {
           $ordencompra=OrdenCompra::find($id);
        $ordencompra->fill([
                  'total_compra' => $request['total_compra'],
                  'estado_orden' => 2,
            ]);
        $ordencompra->save();
    }

     public function updatep2(Request $request, $id)
    {
           $ordencompra=OrdenCompra::find($id);
        $ordencompra->fill([
                  'estado_orden' => 4,
            ]);
        $ordencompra->save();
    }

    public function update(Request $request, $id)
    {
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         OrdenCompra::destroy($id);
    }
    
     public function destroypro($id)
    {
         ProductoCompra::destroy($id);
    }
     public function destroypro2($id)
    {
        $procompra=ProductoCompra::find($id);
        $idorden=$procompra->id_orden;
        $subtotal=$procompra->subtotal;

        $ordencompra=OrdenCompra::find($idorden);
        $restartotal=$ordencompra->total_compra- $subtotal;
        $ordencompra->fill([
                  'total_compra' => $restartotal,
            ]);
        $ordencompra->save();

         ProductoCompra::destroy($id);
    }
}
