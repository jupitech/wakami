<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedores;

class ProveedoresController extends Controller
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
         return view('admin.gastos.proveedores');
    }


    public function indexproveedores()
    {
           //Trayendo Proveedores
         $proveedores=Proveedores::all();
         if(!$proveedores){
             return response()->json(['mensaje' =>  'No se encuentran proveedores actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $proveedores],200);
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
          $proveedores=Proveedores::create([
                  'empresa' => $request['empresa'],
                  'encargado' => $request['encargado'],
                  'nit' => $request['nit'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'telefono_encargado' => $request['telefono_encargado'],
                  'email_encargado' => $request['email_encargado']
                        ]);
          $proveedores->save();
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
        $proveedores=Proveedores::find($id);
        $proveedores->fill([
                'empresa' =>  $request['empresa'],
                'encargado' =>  $request['encargado'],
                'nit' =>  $request['nit'],
                'direccion' =>  $request['direccion'],
                'telefono' =>  $request['telefono'],
                'telefono_encargado' =>  $request['telefono_encargado'],
                'email_encargado' =>  $request['email_encargado'],
            ]);
        $proveedores->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proveedores::destroy($id);
    }
}
