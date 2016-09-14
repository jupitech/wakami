<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\TfacVenta;
use App\Models\StockProducto;
use App\Models\Clientes;
use App\Models\Producto;
use App\User;
use Auth;
use Carbon\Carbon;

class VentasCentralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function __contruct(){
        $this->middleware('role:admin|operativo');
    }


    public function index()
    {
        return view('admin.ventas.ventas');
    }

     public function indexnueva()
    {
        return view('admin.ventas.nuevaventa');
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

      public function indexventas()
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta","NombreSucursal")->get();
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

       public function stockproducto($id)
    {
           //Trayendo Productos de Sucursales
         $stockproducto=StockProducto::where('id_producto',$id)->where('bodega_actual',1)->first();
         if(!$stockproducto){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockproducto],200);
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
                  'id_sucursal' => 3,
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
      $telefono= $request['telefono'];
      $empresa= $request['empresa'];
      $email= $request['email'];

      if($celular=''){
          $micel='';
      }else{
          $micel= $celular;
      }

      if($telefono=''){
          $mitelefono='';
      }else{
          $mitelefono= $telefono;
      }

      if($empresa=''){
          $miempresa='';
      }else{
          $miempresa= $empresa;
      }

      if($email=''){
          $miemail='';
      }else{
          $miemail= $email;
      }


      if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){
                 $clientes=Clientes::create([
                  'empresa' => $miempresa,
                  'nombre' => $request['nombre'],
                  'direccion' => $request['direccion'],
                  'telefono' => $mitelefono,
                  'celular' => $micel,
                  'email' =>  $miemail,
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
                          'empresa' => $miempresa,
                          'nombre' => $request['nombre'],
                          'nit' => $request['nit'],
                          'direccion' => $request['direccion'],
                          'telefono' => $mitelefono,
                          'celular' => $micel,
                          'email' => $miemail,
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

        if($referencia=''){
            $mirefe='';
        } else{
             $mirefe=$referencia;
        } 
              $pagoventa=TpagoVenta::create([
                  'id_ventas' => $idventas,
                  'tipo_pago' => $tipopago,
                  'referencia' => $mirefe,
                        ]);
             $pagoventa->save();


        $ventas=Ventas::find( $idventas );
        $ventas->fill([
                'fecha_factura' => Carbon::now(),
                'estado_ventas' => 2,
            ]);
        $ventas->save();

             //Buscando productos en ventas agregados
         $productoventas=ProductoVenta::where('id_ventas',$idventas)->get();
          foreach ($productoventas as $productoventa) {
            //Reduciendo stock desde los productos vendidos
               $stockproducto=StockProducto::where('id_producto',$productoventa->id_producto)->first();

                  if(!is_null($stockproducto) ){
                    $stockactual=$stockproducto->stock;
                    $restastock=$stockactual-$productoventa->cantidad;
                      $stockproducto->fill([
                                        'stock' =>  $restastock,
                                    ]);
                      $stockproducto->save();

                  }

          }
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
         $productoventa=ProductoVenta::find($id);


        $cantiactual= $productoventa->cantidad;
        $idventas= $productoventa->id_ventas;
        $idproducto= $productoventa->id_producto;
   
        $ventas=Ventas::where('id',$idventas)->first();
        $productos=Producto::where('id',$idproducto)->first();


        $totalactual=$ventas->total;
        $preciop=$productos->preciop;

        $subtotal=$preciop*$request['cantidad'];
        $subtotalante=$preciop*$cantiactual;

        $restotal=$totalactual-$subtotalante;
        $total=$restotal+$subtotal;

        $ventas->fill([
              'total' => $total,
            ]);
        $ventas->save();

        $productoventa->fill([
          'cantidad' => $request['cantidad'],
        ]);
        $productoventa->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventas=Ventas::find($id);

        if($ventas->estado_ventas==1){
             $productoventas=ProductoVenta::where('id_ventas',$id)->get();

              foreach ($productoventas as $productoventa) {

                  ProductoVenta::destroy($productoventa->id);
              }

               Ventas::destroy($id);
        }

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
