<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\OrdenCompra;
use App\Models\ProductoCompra;
use App\Models\Producto;
use App\Models\EntregaCompra;
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
           return response()->json(['id_orden' => $ordencompra->id],200);
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
         OrdenCompra::destroy($id);
    }
    
     public function destroypro($id)
    {
         ProductoCompra::destroy($id);
    }
}
