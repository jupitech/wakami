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
