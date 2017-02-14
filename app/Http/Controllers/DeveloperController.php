<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\EstadoPagina;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function estado_pagina()
    {
        $pagina=EstadoPagina::where('nombre','developer')->first();
        $estado=$pagina->estado;

        if(!$estado){
            return response()->json(['mensaje' =>  'No se encuentran el estado de la pagina','codigo'=>404],404);
        }
        
        return response()->json(['estado' =>  $estado],200);
    }

    public function modo_developer()
    {
        //Obteniendo fila del estado de la página en la base de datos...
        $pagina=EstadoPagina::where('nombre','developer')->first();
        $estado=$pagina->estado;

        // $actualizar=EstadoPagina::find($id);

        if ($estado == 1) {
            $pagina->fill([
                'estado' => 2
            ]);
        } elseif ( $estado == 2){
            $pagina->fill([
                'estado' => 1
            ]);
        }

        $pagina->save();
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
