<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Sucursales;
use App\Models\StockSucursal;
use App\Models\StockProducto;
use App\User;
use Auth;
use Carbon\Carbon;

class SucursalController extends Controller
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
        return view('admin.sucursales.sucursales');
    }

     public function indexsucursales()
    {

           //Trayendo Sucursales
         $sucursales=Sucursales::with("PerfilUsuario")->get();
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

              $sucursales=Sucursales::create([
                  'nombre' => $request['nombre'],
                  'ubicacion' => $request['ubicacion'],
                  'id_user' =>  $request['id_user'],
                        ]);
          $sucursales->save();
    }

    public function storepro(Request $request)
    {
        $sucursal=$request['id_sucursal'];
        $producto=$request['id_producto'];
        $stocksucursal=StockSucursal::where('id_sucursal',$sucursal)->where('id_producto',$producto)->first();
         if(!$stocksucursal){
                 $prosucursal=StockSucursal::create([
                  'id_sucursal' => $request['id_sucursal'],
                  'id_producto' => $request['id_producto'],
                  'stock' =>  $request['stock'],
                  'estado_producto' =>  1,
                        ]);
                $prosucursal->save();
         }else{
                  return response()->json(['mensaje' =>  'El producto ya existe en la sucursal','codigo'=>404],404);
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
          $sucursales=Sucursales::find($id);
        $sucursales->fill([
              'nombre' => $request['nombre'],
              'ubicacion' => $request['ubicacion'],
              'id_user' =>  $request['id_user'],
            ]);
        $sucursales->save();
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
        StockSucursal::destroy($id);
    }
}
