<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\StockProducto;
use App\Models\Producto;
use App\Models\Donacion;
use App\Models\ProductoDonacion;
use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;

class DonacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('admin.gastos.donaciones');
    }



  public function indexdonaciones()
    {
        //Trayendo traslados
         $donaciones=Donacion::all();
         if(!$donaciones){
             return response()->json(['mensaje' =>  'No se encuentran devoluciones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $donaciones],200);
    }




       public function indexprodonaciones($id)
    {
           //Trayendo Producto
         $prodonaciones=ProductoDonacion::with("NombreProducto")->where('id_donacion',$id)->get();
         if(!$prodonaciones){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $prodonaciones],200);
    }





     //PDF para envios consignacion

     public function pdfenvio($id)
    {
      //Trayendo ventas
       $donacion=Donacion::where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoicedonacion',['donacion'=>$donacion]);
        return $pdf->download('Orden Donacion #'.$donacion->id.'.pdf');
 
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

          

        
 
            $donacion=Donacion::create([
                  'para' =>$request['para'],
                  //'fecha_entrega' =>$request['fecha_entrega'],
                  'descripcion' => $request['descripcion'],
                  'estado_donacion' =>  1,
                        ]);
            $donacion->save();
           
             
    }



     public function storeprodonacion(Request $request)
    {
        $idproducto=$request['id_producto'];
        $iddonacion=$request['id_donacion'];
        $producto=Producto::where('id',$idproducto)->first();
       // $subtotal=$request['cantidad']*$producto->costo;

         $existepro=ProductoDonacion::where('id_donacion',$iddonacion)->where('id_producto',$idproducto)->first();
           if($existepro === null){
                   $productodonacion=ProductoDonacion::create([
                  'id_donacion' =>   $iddonacion,
                   'id_producto' => $idproducto,
                   'cantidad' => $request['cantidad'],
                   'estado_producto' => 1,
                        ]);
                  $productodonacion->save();

                 

                   return response()->json(['id_donacion' => $productodonacion->id],200);
            }else{
                return response()->json(['mensaje' =>  'Producto ya ingresado a la compra','codigo'=>404],404);
            }       
    }




       public function updatepro(Request $request, $id)
    {
         $idproducto=$request['id_producto'];


        $productodonacion=ProductoDonacion::find($id);
        $iddonacion=$productodonacion->id_donacion;

    
        $productodonacion->fill([
                  'cantidad' => $request['cantidad']
            ]);
        $productodonacion->save();

       
    }


    


     public function updatep1(Request $request, $id)
    {
      //Cambiando orden a estado de Compra Enviada
        $donacion=Donacion::find($id);
        $donacion->fill([
                  'estado_donacion' => 2,
            ]);
        $donacion->save();
       
        
          //Buscando productos en devolucion agregados
         $productodonacion=ProductoDonacion::with("NombreProducto")->where('id_donacion',$id)->get();

          foreach ($productodonacion as $productodona) {
            //Reduciendo stock desde los productos vendidos

                                 $stockproducto=StockProducto::where('id_producto',$productodona->id_producto)->first();

                                  if(!is_null($stockproducto) ){
                                    $stockactual=$stockproducto->stock;
                                    $restartock=$stockactual-$productodona->cantidad;
                                      $stockproducto->fill([
                                                        'stock' =>  $restartock,
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
           Donacion::destroy($id);
    }

      
     public function destroypro($id)
    {
         ProductoDonacion::destroy($id);
    }

}
