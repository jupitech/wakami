<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\OrdenCompra;
use App\Models\ProductoCompra;
use App\Models\Producto;
use App\Models\EntregaCompra;
use App\Models\PendienteProcompra;
use App\Models\StockProducto;
use App\Models\Proveedores;
use Auth;
use Excel;
use Mail;
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
         $procompras=ProductoCompra::with("NombreProducto","EntregaProducto","PendienteProducto")->where('id_orden',$id)->get();
         if(!$procompras){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $procompras],200);
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
         $idorden=$request['id_orden'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->costo;

         $existepro=ProductoCompra::where('id_orden',$idorden)->where('id_producto',$idproducto)->first();
           if($existepro === null){
                   $productocompra=ProductoCompra::create([
                  'id_orden' =>   $idorden,
                   'id_producto' => $idproducto,
                   'precio_producto' => $producto->costo,
                   'cantidad' => $request['cantidad'],
                    'subtotal' => $subtotal,
                   'estado_producto' => 1,
                        ]);
                  $productocompra->save();

                    $idorden=$productocompra->id_orden;

                      $ordencompra=OrdenCompra::find($idorden);
                      //Sumar el subtotal actual
                      $totalfinal=($ordencompra->total_compra)+$subtotal;
                      $ordencompra->fill([
                                'total_compra' => $totalfinal,
                          ]);
                      $ordencompra->save();

                   return response()->json(['id_procompra' => $productocompra->id],200);
            }else{
                return response()->json(['mensaje' =>  'Producto ya ingresado a la compra','codigo'=>404],404);
            }       
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
      
        //Verificando si hay productos pendientes en la compra
         $cantidadasig=$productocompra->cantidad;
         if($cantidadasig>$cantidad){
           $actualcanti=$cantidadasig-$cantidad;

                 //Creando la compra pendiente
                  $pendienteprocompra=PendienteProcompra::create([
                        'id_orden' => $idorden,
                        'id_procompra' => $idprocompra,
                        'id_producto' =>  $idproducto,
                        'cantidad' =>  $actualcanti,
                    ]);
                 $pendienteprocompra->save();

                  //Cambiando el estado del producto
                 $productocompra->fill([
                      'estado_producto' => 3,
                  ]);
                  $productocompra->save();

         }else{
            $productocompra->fill([
                  'estado_producto' => 2,
            ]);
            $productocompra->save();
         }
        

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

     public function enviarproductopen(Request $request)
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
          $stockproducto=StockProducto::where('id_producto',$idproducto)->first();

          if(!$stockproducto){

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
     * Enviando a proveedor la primera opcion de compra
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatep1(Request $request, $id)
    {
      //Cambiando orden a estado de Compra Enviada
       $ordencompra=OrdenCompra::find($id);
        $ordencompra->fill([
                  'estado_orden' => 2,
            ]);
        $ordencompra->save();
        $idprove=$ordencompra->id_proveedor;
        //Información de Proveedores, en especial el email
         $proveedor=Proveedores::where('id', $idprove)->first();
         $emailprove=$proveedor->email_encargado;
         $encargado=$proveedor->encargado;

        //Query de los productos comprados del numero de orden
        $procompra = ProductoCompra::join('producto', 'producto.id', '=', 'producto_compra.id_producto')
                  ->select(
                    'producto.codigo', 
                    'producto.nombre', 
                    'producto_compra.precio_producto', 
                    'producto_compra.cantidad',
                    'producto_compra.subtotal'
                       )
                  ->where('producto_compra.id_orden',$id)
                  ->get();

        $nombrearchivo='OrdenCompra-No'.$id;

        $proArray = []; 
        $proArray[] = ['Codigo','Producto','Precio','Cantidad','Subtotal'];

         foreach ($procompra as $pro) {
            $proArray[] = $pro->toArray();
           }
         $hoy=Carbon::now();


        //Creando Excel para orden
        Excel::create($nombrearchivo, function($excel) use($proArray,$id, $hoy){
                  $excel->sheet('Orden-'.$id, function($sheet) use($proArray,$id, $hoy) {
                      $sheet->row(1, function ($row) {
                              $row->setFontSize(25);
                          });
                       $sheet->cells('A5:E5', function ($cells) {
                             $cells->setFontWeight('bold');
                            $cells->setBorder('solid', 'none', 'none', 'solid');
                          });
                      $sheet->row(1, array('Orden de Compra-#'.$id));
                       
                     $sheet->row(2, array('Wakami Guatemala'));
                     $sheet->row(3, array('Fecha:'.$hoy));
                     $sheet->fromArray($proArray, null, 'A5', false, false);
                    });
            })->store('xlsx', public_path('exports/ordenes'));

          //Enviando correo a proveedor

        $exceladj=public_path().'/exports/ordenes/'.$nombrearchivo.'.xlsx';

        Mail::send('emails.ordenes', ['orden' => $id,'encargado' => $encargado], function ($message) use ($id, $exceladj, $emailprove) {
              $message->from('carlos.ruano@creationgt.com', 'Wakami Guatemala');

              $message->to($emailprove);
              $message->subject(' Nueva Orden de Compra-No '.$id);
              $message->attach($exceladj);
          });



    }


    public function updatepen(Request $request, $id)
    {
      //Cambiando orden a estado de Compra Enviada
       $ordencompra=OrdenCompra::find($id);
        $ordencompra->fill([
                  'estado_orden' => 3,
            ]);
        $ordencompra->save();
        $idprove=$ordencompra->id_proveedor;
        //Información de Proveedores, en especial el email
         $proveedor=Proveedores::where('id', $idprove)->first();
         $emailprove=$proveedor->email_encargado;
         $encargado=$proveedor->encargado;

        //Query de los productos comprados del numero de orden
        $procompra = PendienteProcompra::join('producto', 'producto.id', '=', 'pendiente_procompra.id_producto')
                  ->select(
                    'producto.codigo', 
                    'producto.nombre', 
                    'producto.costo', 
                    'pendiente_procompra.cantidad'
                       )
                  ->where('pendiente_procompra.id_orden',$id)
                  ->get();

        $nombrearchivo='PendienteCompra-No'.$id;

        $proArray = []; 
        $proArray[] = ['Codigo','Producto','Precio','Cantidad'];

         foreach ($procompra as $pro) {
            $proArray[] = $pro->toArray();
           }
         $hoy=Carbon::now();


        //Creando Excel para orden
        Excel::create($nombrearchivo, function($excel) use($proArray,$id, $hoy){
                  $excel->sheet('OrdenPendiente-'.$id, function($sheet) use($proArray,$id, $hoy) {
                      $sheet->row(1, function ($row) {
                              $row->setFontSize(25);
                          });
                       $sheet->cells('A5:E5', function ($cells) {
                             $cells->setFontWeight('bold');
                            $cells->setBorder('solid', 'none', 'none', 'solid');
                          });
                      $sheet->row(1, array('Orden de Compra-#'.$id));
                       
                     $sheet->row(2, array('Productos Pendientes'));
                     $sheet->row(3, array('Fecha:'.$hoy));
                     $sheet->setCellValue('B5','=SUM(B2:B4)');
                     $sheet->fromArray($proArray, null, 'A5', false, false);
                    });
            })->store('xlsx', public_path('exports/ordenes'));

          //Enviando correo a proveedor

        $exceladj=public_path().'/exports/ordenes/'.$nombrearchivo.'.xlsx';

        Mail::send('emails.pendientes', ['orden' => $id,'encargado' => $encargado], function ($message) use ($id, $exceladj, $emailprove) {
              $message->from('carlos.ruano@creationgt.com', 'Wakami Guatemala');

              $message->to($emailprove);
              $message->subject('Productos pendientes de Compra-No '.$id);
              $message->attach($exceladj);
          });



    }


     public function updatep2(Request $request, $id)
    {
        $ordencompra=OrdenCompra::find($id);
        $ordencompra->fill([
                  'estado_orden' => 4,
            ]);
        $ordencompra->save();

    }

    public function updatepro(Request $request, $id)
    {
         $idproducto=$request['id_producto'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->costo;

        $productocompra=ProductoCompra::find($id);
        $idorden=$productocompra->id_orden;

        $ordencompra=OrdenCompra::find($idorden);
        //Restar subtotal del producto
        $restartotal=$ordencompra->total_compra- $productocompra->subtotal;
        //Sumar el subtotal actual
        $totalfinal=$restartotal+ $subtotal;
        $ordencompra->fill([
                  'total_compra' => $totalfinal,
            ]);
        $ordencompra->save();


        $productocompra->fill([
                  'cantidad' => $request['cantidad'],
                  'subtotal' => $subtotal,
            ]);
        $productocompra->save();

       
    }

     public function update(Request $request, $id)
    {
        $ordencompra=OrdenCompra::find($id);
          $diasentrega= $request['fecha_entrega'];
          $fechacreacion= $ordencompra->created_at;
          $miCarbon= Carbon::parse($fechacreacion);
        $ordencompra->fill([
                  'id_proveedor' => $request['id_proveedor'],
                  'fecha_entrega' => $miCarbon->addDays($diasentrega),
            ]);
        $ordencompra->save();
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


     public function destroypro2($id)
    {
        //Productos pendientes
        $pencompra=PendienteProcompra::where('id_procompra',$id)->first();
        //Productos compra
        $procompra=ProductoCompra::find($id);
        //Columnas de compra
        $idorden=$procompra->id_orden;
        $preciopro=$procompra->precio_producto;
        $cantidad_pro=$procompra->cantidad;

        //Columna de pendientes
        $id_pen= $pencompra->id;
        $cantidad_pen=$pencompra->cantidad;

        //Operaciones
        $cantidad_actual=$cantidad_pro-$cantidad_pen;
        $subtotal= $preciopro*$cantidad_pen;
         $restarsubtotal=$procompra->subtotal- $subtotal;
        //Guardando nueva cantidad al producto
         $procompra->fill([
                  'cantidad' => $cantidad_actual,
                  'subtotal' => $restarsubtotal,
                   'estado_producto' => 2,
            ]);
        $procompra->save();


        //Actualizando total
  
        $ordencompra=OrdenCompra::find($idorden);

        $restartotal=$ordencompra->total_compra- $subtotal;
        $ordencompra->fill([
                  'total_compra' => $restartotal,
            ]);
        $ordencompra->save();

          //Eliminando productos pendientes
         PendienteProcompra::destroy($id_pen);
    }
}
