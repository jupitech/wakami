<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Promociones;
use App\Models\PromocionesVentas;
use App\User;
use Auth;
use Carbon\Carbon;

class PromocionesController extends Controller
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
        return view('admin.ventas.promociones');
    }

    public function indexpromociones()
    {
           //Trayendo Proveedores
         $promociones=Promociones::with("NombreLinea","NombreProducto")->get();
         if(!$promociones){
             return response()->json(['mensaje' =>  'No se encuentran promociones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $promociones],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $porcantidad=$request['por_cantidad'];
        $porttotal=$request['por_total'];
        $idproducto=$request['id_producto'];
        $idlinea=$request['id_linea'];
        $porcentajeproducto=$request['porcentaje_producto'];
        $porcentajelinea=$request['porcentaje_linea'];
        $porcentajetotal=$request['porcentaje_total'];

         if($porcantidad==''){  $micantidad='0';
        }else{ $micantidad= $porcantidad;
        }

         if($porttotal==''){  $mitotal='0';
        }else{ $mitotal= $porttotal;
        }


        if($idproducto==''){  $miproducto='';
        }else{ $miproducto= $idproducto;
        }

         if($idlinea==''){  $milinea='';
        }else{ $milinea= $idlinea;
        }

           if($porcentajeproducto==''){  $porproducto='';
        }else{ $porproducto= $porcentajeproducto;
        }

         if($porcentajelinea==''){  $porlinea='';
        }else{ $porlinea= $porcentajelinea;
        }

         if($porcentajetotal==''){  $portotal='';
        }else{ $portotal= $porcentajetotal;
        }

        //Fechas

         $fechainicio= $request['fecha_inicio'];
         $fechafin= $request['fecha_fin'];

          $fi =new \DateTime($fechainicio);
          $carbon = Carbon::instance($fi); 
          $a_fi=$carbon->year;
          $m_fi=$carbon->month;
          $d_fi=$carbon->day;

          $ff =new \DateTime($fechafin);
          $carbon2 = Carbon::instance($ff); 
          $a_ff=$carbon2->year;
          $m_ff=$carbon2->month;
          $d_ff=$carbon2->day;


          $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
          $ffin=Carbon::create($a_ff, $m_ff, $d_ff, 23,59,59);




        $promociones=Promociones::create([
                  'nombre' => $request['nombre'],
                  'id_producto' => $miproducto,
                  'id_linea' => $milinea,
                  'por_cantidad' => $micantidad,
                  'por_total' => $mitotal,
                  'porcentaje_producto' => $porproducto,
                  'porcentaje_linea' => $porlinea,
                  'porcentaje_total' => $portotal,
                  'tipo_promocion' => $request['tipo_promocion'],
                  'fecha_inicio' => $fini,
                  'fecha_fin' => $ffin,
                  'estado_promocion' =>1,
                        ]);
          $promociones->save();
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

        $idproducto=$request['id_producto'];
        $idlinea=$request['id_linea'];
        $porttotal=$request['por_total'];
        $porcentajeproducto=$request['porcentaje_producto'];
        $porcentajelinea=$request['porcentaje_linea'];
        $porcentajetotal=$request['porcentaje_total'];

        //Fechas

         $fechainicio= $request['fecha_inicio'];
         $fechafin= $request['fecha_fin'];

          $fi =new \DateTime($fechainicio);
          $carbon = Carbon::instance($fi); 
          $a_fi=$carbon->year;
          $m_fi=$carbon->month;
          $d_fi=$carbon->day;

          $ff =new \DateTime($fechafin);
          $carbon2 = Carbon::instance($ff); 
          $a_ff=$carbon2->year;
          $m_ff=$carbon2->month;
          $d_ff=$carbon2->day;


          $fini=Carbon::create($a_fi, $m_fi, $d_fi, 0,0,0);
          $ffin=Carbon::create($a_ff, $m_ff, $d_ff, 23,59,59);


        $promociones=Promociones::find($id);
        $promociones->fill([
                  'nombre' => $request['nombre'],
                  'id_producto' => $idproducto,
                  'id_linea' => $idlinea,
                  'por_cantidad' => $request['por_cantidad'],
                  'por_total' => $porttotal,
                  'porcentaje_producto' => $porcentajeproducto,
                  'porcentaje_linea' => $porcentajelinea,
                  'porcentaje_total' => $porcentajetotal,
                  'tipo_promocion' => $request['tipo_promocion'],
                  'fecha_inicio' => $fini,
                  'fecha_fin' => $ffin,
            ]);
        $promociones->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Promociones::destroy($id);
    }
}
