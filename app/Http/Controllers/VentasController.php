<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\TfacVenta;
use App\Models\StockProducto;
use App\Models\StockSucursal;
use App\Models\Clientes;
use App\Models\Producto;
use App\User;
use Auth;
use Carbon\Carbon;


class VentasController extends Controller
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
        return view('admin.ventas.misventas');
    }

    public function indexnueva()
    {
        return view('admin.ventas.minuevaventa');
    }

    public function indexmiventa($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta")->where('id',$id)->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


      public function indexventas($id)
    {
           //Trayendo Ventas de sucursal
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta")->where('id_sucursal',$id)->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

      public function indexmiproducto($id)
    {
           //Trayendo Producto
         $productos=ProductoVenta::with("NombreProducto")->where('id_ventas',$id)->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

       public function stockproducto($idsucursal,$id)
    {
           //Trayendo Productos de Sucursales
         $stocksucursal=StockSucursal::where('id_producto',$id)->where('id_sucursal',$idsucursal)->first();
         if(!$stocksucursal){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stocksucursal],200);
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
                  'id_sucursal' => $request['id_sucursal'],
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

      if($celular=''){
          $micel='';
      }else{
          $micel= $celular;
      }


      if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){
                 $clientes=Clientes::create([
                  'empresa' => $request['empresa'],
                  'nombre' => $request['nombre'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'celular' => $micel,
                  'email' => $request['email'],
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
                          'empresa' => $request['empresa'],
                          'nombre' => $request['nombre'],
                          'nit' => $request['nit'],
                          'direccion' => $request['direccion'],
                          'telefono' => $request['telefono'],
                          'celular' => $micel,
                          'email' => $request['email'],
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
        $tipofac =$request['id_tfac'];  
        $referencia =$request['referencia'];    
        
              $pagoventa=TpagoVenta::create([
                  'id_ventas' => $idventas,
                  'tipo_pago' => $tipopago,
                  'referencia' => $referencia,
                        ]);
             $pagoventa->save();

               $facventa=TfacVenta::create([
                  'id_ventas' => $idventas,
                  'tipo_factura' => $tipofac,
                  'referencia' => $referencia,
                        ]);
                $facventa->save();

        $ventas=Ventas::find( $idventas );
        $ventas->fill([
                'fecha_factura' => Carbon::now(),
                'estado_ventas' => 2,
            ]);
        $ventas->save();
    }


     public function storepro(Request $request)
    {

       $idventas=$request['id_ventas'];
       $idproducto=$request['id_producto'];

        $productoventa=ProductoVenta::where('id_ventas',$idventas)->where('id_producto',$idproducto)->first();
         if(!$productoventa){
                $miproducto=ProductoVenta::create([
                  'id_ventas' => $request['id_ventas'],
                  'id_producto' =>$request['id_producto'],
                  'cantidad' =>$request['cantidad'],
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
         }else{
                  return response()->json(['mensaje' =>  'El producto ya existe en la venta','codigo'=>404],404);
         }
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
           $productos=ProductoVenta::find($id);
        $productos->fill([
              'cantidad' => $request['cantidad'],
            ]);
        $productos->save();
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
}
