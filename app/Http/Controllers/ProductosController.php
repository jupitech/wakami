<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Producto;
use App\Models\LineaProducto;

class ProductosController extends Controller
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
          return view('admin.productos.productos');
    }

    public function indexproductos()
    {
           //Trayendo Producto
         $productos=Producto::all();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

      public function indexlineas()
    {
           //Trayendo Lineas
         $lineas=LineaProducto::all();
         if(!$lineas){
             return response()->json(['mensaje' =>  'No se encuentran lineas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $lineas],200);
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

     public function storelinea(Request $request)
    {
         $lineas=LineaProducto::create([
                  'nombre' => $request['nombre']
                        ]);
          $lineas->save();
    }


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
