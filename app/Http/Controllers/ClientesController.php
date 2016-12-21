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

    public function indexsu()
    {
          return view('admin.ventas.clientessu');
    }

     public function indexclientes()
    {
           //Trayendo Proveedores
         $clientes=Clientes::with("PorcentajeCliente")->get();
         if(!$clientes){
             return response()->json(['mensaje' =>  'No se encuentran clientes actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $clientes],200);
    }


        public function indexclientenit(Request $request)
    {

      $nit= $request['nit'];
        //Trayendo Clientes por nit
        $clientes=Clientes::with("PorcentajeCliente")->where('nit',$nit)->first();
        if(!$clientes){
            return response()->json(['mensaje' =>  'No se encuentran clientes actualmente','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $clientes],200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nit= $request['nit'];
        $celular= $request['celular'];
        $empresa= $request['empresa'];
        $email= $request['email'];
        $contacto= $request['contacto'];

        if($celular=''){  $micel='';
        }else{ $micel= $celular;
        }

        if($empresa=''){$miempresa='';
        }else{ $miempresa= $empresa;
        }

        if($email=''){$miemail='';
        }else{ $miemail= $email;
        }

        if($contacto=''){$micontacto='';
        }else{ $micontacto= $contacto;
        }

        if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){

             $clientes=Clientes::create([
                  'empresa' => $miempresa,
                  'nombre' => $request['nombre'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'celular' => $micel,
                  'email' => $miemail,
                  'tipo_cliente' => $request['tipo_cliente'],
                  'contacto' => $micontacto,
                        ]);
              $clientes->save();

               $clientenit=Clientes::find($clientes->id);
               $minit='C/F-'.$clientes->id;

                $clientenit->fill([
                  'nit' => $minit,
                    ]);
                $clientenit->save();

        }else{
             $clientes=Clientes::create([
                  'empresa' => $miempresa,
                  'nombre' => $request['nombre'],
                  'nit' => $request['nit'],
                  'direccion' => $request['direccion'],
                  'telefono' => $request['telefono'],
                  'celular' => $micel,
                  'email' => $miemail,
                  'tipo_cliente' => $request['tipo_cliente'],
                  'contacto' => $micontacto,
                        ]);
              $clientes->save();

             
        }
        
    }

      public function storepor(Request $request)
    {

             $porcentaje=PorcentajeCliente::create([
                  'id_cliente' => $request['id_cliente'],
                  'tipo_cliente' => $request['tipo_cliente'],
                  'porcentaje' => $request['porcentaje'],
                        ]);
              $porcentaje->save();
        
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
        $nit= $request['nit'];

         if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){
                        $clientes=Clientes::find($id);

                        $minit='C/F-'.$clientes->id;
                        
                        $clientes->fill([
                                  'empresa' => $request['empresa'],
                                  'nombre' => $request['nombre'],
                                  'nit' => $minit,
                                  'direccion' => $request['direccion'],
                                  'telefono' => $request['telefono'],
                                  'celular' => $request['celular'],
                                  'email' => $request['email'],
                                  'tipo_cliente' => $request['tipo_cliente'],
                                  'contacto' => $request['contacto'],
                            ]);
                        $clientes->save();
            }else{
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
                                  'contacto' => $request['contacto'],
                            ]);
                        $clientes->save();
            }
    }

    public function updatepor(Request $request, $id)
    {
              $porcentaje=PorcentajeCliente::where('id_cliente',$id)->first();

             $porcentaje->fill([
                  'porcentaje' => $request['porcentaje'],
                        ]);
              $porcentaje->save();
        
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
