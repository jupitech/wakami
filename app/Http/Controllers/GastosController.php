<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Gastos;
use App\Models\CategoriaGasto;
use Excel;
use Carbon\Carbon;

class GastosController extends Controller
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
         return view('admin.gastos.gastos');
    }

      public function indexgastos()
    {
           //Trayendo Producto
         $gastos=Gastos::with("Categoria")->get();
         if(!$gastos){
             return response()->json(['mensaje' =>  'No se encuentran gastos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $gastos],200);
    }

       public function indexcategoria()
    {
           //Trayendo Lineas
         $categoria=CategoriaGasto::all();
         if(!$categoria){
             return response()->json(['mensaje' =>  'No se encuentran categorias actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $categoria],200);
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

        $fecha_gasto= $request['fecha_gasto'];


         if($fecha_gasto){

          $dt2 =new \DateTime($fecha_gasto);
          $carbon2 = Carbon::instance($dt2); 
          $a_dt2=$carbon2->year;
          $m_dt2=$carbon2->month;
          $d_dt2=$carbon2->day;

            $mifecha_gasto=Carbon::create($a_dt2, $m_dt2, $d_dt2, 0);
          }else{
            $mifecha_gasto='';
            $m_dt2='';
          }
       
           $gastos=Gastos::create([
                  'id_categoria' => $request['id_categoria'],
                  'descripcion' => $request['descripcion'],
                  'mes' => $m_dt2,
                  'costo' => $request['costo'],
                  'fecha_gasto' => $mifecha_gasto,
                  'estado_gasto' => 1,
                        ]);
          $gastos->save();
    }


      public function storecategoria(Request $request)
    {
         $categoria=CategoriaGasto::create([
                  'nombre' => $request['nombre']
                        ]);
          $categoria->save();
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

          $fecha_gasto= $request['fecha_gasto'];


         if($fecha_gasto){

              $dt2 =new \DateTime($fecha_gasto);
              $carbon2 = Carbon::instance($dt2); 
              $a_dt2=$carbon2->year;
              $m_dt2=$carbon2->month;
              $d_dt2=$carbon2->day;

              $mifecha_gasto=Carbon::create($a_dt2, $m_dt2, $d_dt2, 0);
          }else{
            $mifecha_gasto='';
            $m_dt2='';
          }

        $gastos=Gastos::find($id);
        $gastos->fill([
                  'id_categoria' => $request['id_categoria'],
                  'descripcion' => $request['descripcion'],
                  'mes' => $m_dt2,
                  'costo' => $request['costo'],
                  'fecha_gasto' => $mifecha_gasto,
            ]);
        $gastos->save();
    }

      public function updatecategoria(Request $request, $id)
    {
        $categoria=CategoriaGasto::find($id);
        $categoria->fill([
                'nombre' =>  $request['nombre']
            ]);
        $categoria->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Gastos::destroy($id);
    }

    public function destroycategoria($id)
    {
        CategoriaGasto::destroy($id);
    }
}
