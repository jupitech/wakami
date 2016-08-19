<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Clientes;
use App\Models\PorcentajeCliente;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index()
    {
          return view('admin.ventas.clientes');
    }

     public function indexclientes()
    {
           //Trayendo Proveedores
         $clientes=Clientes::all();
         if(!$clientes){
             return response()->json(['mensaje' =>  'No se encuentran clientes actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $clientes],200);
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
         $clientes=Clientes::create([
                  'empresa' => $request['empresa'],
                  'nombre' => $request['nombre'],
                  'nit' => $request['nit'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'celular' => $request['celular'],
                  'email' => $request['email'],
                  'tipo_cliente' => $request['tipo_cliente'],
                        ]);
          $clientes->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $clientes=Clientes::find($id);
        $clientes->fill([
                  'empresa' => $request['empresa'],
                  'nombre' => $request['nombre'],
                  'nit' => $request['nit'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'celular' => $request['celular'],
                  'email' => $request['email'],
                  'tipo_cliente' => $request['tipo_cliente'],
            ]);
        $clientes->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clientes::destroy($id);
    }
}
