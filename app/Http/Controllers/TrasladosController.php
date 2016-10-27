<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Sucursales;
use App\Models\Traslados;
use App\Models\StockSucursal;
use App\Models\Producto;
use App\User;
use Auth;
use Carbon\Carbon;

class TrasladosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.productos.traslados');
    }
    
     public function indextrasladosen($id)
    {
        //Trayendo traslados
         $traslados=Traslados::with("NombreProducto","DSucursal","HaUsuario","DUsuario","HaSucursal")->where('desde_sucursal',$id)->get();
         if(!$traslados){
             return response()->json(['mensaje' =>  'No se encuentran traslados actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $traslados],200);
    }

    public function indextrasladosre($id)
    {
        //Trayendo traslados
         $traslados=Traslados::with("NombreProducto","DSucursal","HaUsuario","DUsuario","HaSucursal")->where('a_sucursal',$id)->get();
         if(!$traslados){
             return response()->json(['mensaje' =>  'No se encuentran traslados actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $traslados],200);
    }

    public function indexsucursales($id)
    {
        //Trayendo Sucursales
         $sucursales=Sucursales::with("PerfilUsuario","PerfilUsuario2")->where('id','!=',$id)->where('codigo_esta','!=',1)->get();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran sucursales actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
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
    public function store(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 


           $traslados=Traslados::create([
          'id_producto' => $request['id_producto'],
          'cantidad' => $request['cantidad'],
          'desde_sucursal' => $request['desde_sucursal'],
          'desde_user' => $userId,
          'a_sucursal' => $request['a_sucursal'],
          'estado_traslado' => 1,
                ]);
          $traslados->save();
           return response()->json(['id' => $traslados->id],200);
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
}
