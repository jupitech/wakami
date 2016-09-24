<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Consignacion;
use App\Models\StockConsignacion;
use App\Models\StockProducto;
use App\Models\Producto;
use App\Models\Clientes;
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
}
