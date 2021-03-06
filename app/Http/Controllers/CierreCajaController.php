<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CierrePago;
use App\Http\Requests;
use App\Models\CierreCaja;
use App\Models\Sucursales;
use App\Models\SaldoActual;
use App\Models\SaldoDeposito;
use App\Models\Ventas;
use App\Models\GastosDiarios;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CierreCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //cargar listado de cierres de la sucursal
        return view('admin.ventas.cierrecaja');
    }

      public function indexcentral()
    {
        //cargar listado de cierres de la sucursal
        return view('admin.reportes.cierres');
    }

      public function indexcierrescentral(){

        $cierres =CierreCaja::with("Sucursal","PerfilUsuario","CierrePago")
            ->orderBy( \DB::raw('DAY(created_at)'),'DESC')
             ->orderBy('id_sucursal','DESC')
            ->get();
        if(!$cierres){
            return response()->json(['mensaje' =>  'No se encontraron cierres de esta sucursal en la base de datos','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $cierres],200);
    }

    public function indexsaldocentral(){
      $ayer=Carbon::yesterday();
      $hoy=Carbon::today();
        $saldoactual = SaldoActual::with("Deposito","Sucursal")->where('fecha','>=', $ayer)->where('fecha','<=',$hoy)->orderBy('id','desc')->groupBy('id_sucursal')->get();
        if(!$saldoactual){
            return response()->json(['datos' =>  array("efectivo"=>0)],200);
        }
        return response()->json(['datos' =>  $saldoactual],200);
    }


 public function estadocierre($id){
   $id_user = Auth::id();
      $cierre=CierreCaja::where('created_at','>=',Carbon::today())->where('id_user',$id_user)->where('id_sucursal',$id)->first();
         if(!$cierre){
             return response()->json(['mensaje' =>  'No se encuentran cierre actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $cierre],200);
    }

    public function indexsucur($id)
    {
        $sucursal = Sucursales::find($id);
         if(!$sucursal){
             return response()->json(['mensaje' =>  'No se encuentran sucursal actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursal],200);
    }

    public function cierrehoy($sucursal){

        $cierres_hoy = DB::table('cierre_caja')
            ->join('user_profile', 'user_profile.user_id', '=', 'cierre_caja.id_user')
            ->join('sucursales', 'sucursales.id', '=', 'cierre_caja.id_sucursal')
            ->select('cierre_caja.id','cierre_caja.created_at','cierre_caja.saldo_efectivo', 'user_profile.nombre', 'user_profile.apellido', 'cierre_caja.estado_caja','cierre_caja.total_saldo')
            ->where('cierre_caja.id_sucursal',$sucursal)
            ->latest()
            ->first();
        if(!$cierres_hoy){
            return response()->json(['mensaje' =>  'No se encontraron cierres de esta sucursal en la base de datos','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $cierres_hoy],200);
    }


    public function indexcierres($sucursal){

        $cierres = DB::table('cierre_caja')
            ->join('user_profile', 'user_profile.user_id', '=', 'cierre_caja.id_user')
            ->join('sucursales', 'sucursales.id', '=', 'cierre_caja.id_sucursal')
            ->select('cierre_caja.id','cierre_caja.created_at','cierre_caja.saldo_efectivo', 'user_profile.nombre', 'user_profile.apellido', 'cierre_caja.estado_caja','cierre_caja.total_saldo')
            ->where('cierre_caja.id_sucursal',$sucursal)
            ->orderBy('cierre_caja.id','DESC')
            ->get();
        if(!$cierres){
            return response()->json(['mensaje' =>  'No se encontraron cierres de esta sucursal en la base de datos','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $cierres],200);
    }

    public function indexsaldo($id){
        $saldoactual = SaldoActual::with("Deposito")->orderBy('id','desc')->where('id_sucursal',$id)->first();
        if(!$saldoactual){
            return response()->json(['datos' =>  array("efectivo"=>0)],200);
        }
        return response()->json(['datos' =>  $saldoactual],200);
    }

    public function indexsaldoac($id){
        $saldoactual = SaldoActual::with("Deposito")->orderBy('id','desc')->where('id_sucursal',$id)->get();
        if(!$saldoactual){
            return response()->json(['datos' =>  array("efectivo"=>0)],200);
        }
        return response()->json(['datos' =>  $saldoactual],200);
    }

    //TOTALES DE VENTAS. EFECTIVO TARJETA CHEQUE DEPOSITO
    public function totalventasefectivo($id){
        $id_user = Auth::id();
        $ventas_efectivo = \App\Models\Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
            ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal', 'left outer')
            ->where('ventas.id_sucursal',$id)
            ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',\Carbon\Carbon::today())
            ->where('ventas.id_user','=',$id_user)
            ->where('tpago_venta.tipo_pago', '=', 1)
            ->select(
                \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
                'ventas.id_sucursal',
                'tpago_venta.tipo_pago',
                \DB::raw('count(ventas.id) as cantidad'),
                \DB::raw('sum(ventas.total) as total')
            )
            ->groupBy('tpago_venta.tipo_pago')
            ->get();
        return response()->json(['datos' => $ventas_efectivo], 200 );
    }

    public function totalventastarjeta($id){
        $id_user = Auth::id();
        $ventas_tarjeta = \App\Models\Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
            ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal', 'left outer')
            ->where('ventas.id_sucursal',$id)
            ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',\Carbon\Carbon::today())
            ->where('ventas.id_user','=',$id_user)
            ->where('tpago_venta.tipo_pago', '=', 2)
            ->select(
                \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
                'ventas.id_sucursal',
                'tpago_venta.tipo_pago',
                \DB::raw('count(ventas.id) as cantidad'),
                \DB::raw('sum(ventas.total) as total')
            )
            ->groupBy('tpago_venta.tipo_pago')
            ->get();
        return response()->json(['datos' => $ventas_tarjeta], 200 );
    }

    public function totalventascheque($id){
        $id_user = Auth::id();
        $ventas_cheque = \App\Models\Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
            ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal', 'left outer')
            ->where('ventas.id_sucursal',$id)
            ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',\Carbon\Carbon::today())
            ->where('ventas.id_user','=',$id_user)
            ->where('tpago_venta.tipo_pago', '=', 3)
            ->select(
                \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
                'ventas.id_sucursal',
                'tpago_venta.tipo_pago',
                \DB::raw('count(ventas.id) as cantidad'),
                \DB::raw('sum(ventas.total) as total')
            )
            ->groupBy('tpago_venta.tipo_pago')
            ->get();
        return response()->json(['datos' => $ventas_cheque], 200 );
    }

    public function totalventasdeposito($id){
        $id_user = Auth::id();
        $ventas_deposito = \App\Models\Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
            ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal', 'left outer')
            ->where('ventas.id_sucursal',$id)
            ->where('ventas.estado_ventas',2)
            ->where('ventas.fecha_factura','>=',\Carbon\Carbon::today())
            ->where('ventas.id_user','=',$id_user)
            ->where('tpago_venta.tipo_pago', '=', 5)
            ->select(
                \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
                'ventas.id_sucursal',
                'tpago_venta.tipo_pago',
                \DB::raw('count(ventas.id) as cantidad'),
                \DB::raw('sum(ventas.total) as total')
            )
            ->groupBy('tpago_venta.tipo_pago')
            ->get();
        return response()->json(['datos' => $ventas_deposito], 200 );
    }


    public function indexreporsu(Request $request,$idsucursal)
    {

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


                        //Ordenes por dia
                       $ordendia = SaldoActual::where('id_sucursal',$idsucursal)
                      ->whereBetween('fecha', [$fini, $ffin])
                     ->select(
                        \DB::raw('DATE_FORMAT(fecha, "%d/%m") as name'),
                        \DB::raw('sum(efectivo) as y')
                           )
                     ->groupBy(\DB::raw('DATE(fecha)'))
                     ->get(); 



    


             if(!$ordendia){
                 return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
            }

           return response()->json(['datos' =>$ordendia],200);

 
    }


     public function indexrepordesu(Request $request,$idsucursal)
    {

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


                        //Ordenes por dia
                       $ordendia = SaldoDeposito::where('id_sucursal',$idsucursal)
                      ->whereBetween('fecha_deposito', [$fini, $ffin])
                     ->select(
                        \DB::raw('DATE_FORMAT(fecha_deposito, "%d/%m") as name'),
                        \DB::raw('sum(monto) as y')
                           )
                     ->groupBy(\DB::raw('DATE(fecha_deposito)'))
                     ->get(); 



    


             if(!$ordendia){
                 return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
            }

           return response()->json(['datos' =>$ordendia],200);

 
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
    public function store(Request $request, $id)
    {
        // return $request->all();
        $est = $request['estado'];
        $user = Auth::User();
        $userId = $user->id;
            $saldoactual = SaldoActual::orderBy('id','desc')->where('id_sucursal',$id)->first();
        if($saldoactual){
          $totalefectivosaldoactual = $saldoactual->efectivo;
        } else{
           $totalefectivosaldoactual = 0;
        }
        

        $totalsaldodeldia = $request['total_efectivo'];

        $cierrecaja=CierreCaja::create([
             'id_sucursal' => $request['id_sucursal'],
             'id_user' => $userId,
             'justficacion' => $request['justificacion'],
             'saldo_efectivo' => $totalefectivosaldoactual+$totalsaldodeldia,
             'estado_caja' => $est,
                   ]);
        $cierrecaja->save();

        $id_cierre = $cierrecaja->id;

        if ($request['gasto_efectivo'] == null) {
            $cierrepago = CierrePago::create([
                 'id_cierre' => $id_cierre,                  
                  'monto_sis' => $request['total_efectivo_sis'],
                  'monto_fisico' => $request['total_efectivo'],
                  'monto_diferencia' => $request['total_efectivo_sis']-$request['total_efectivo'],
                  'tipo_pago' => 1,                  
              ]);
            $cierrepago->save();

            $cierrepago2 = CierrePago::create([
                 'id_cierre' => $id_cierre,                  
                  'monto_sis' => $request['total_tarjeta_sis'],
                  'monto_fisico' => $request['total_tarjeta'],
                  'monto_diferencia' =>  $request['total_tarjeta_sis']-$request['total_tarjeta'],
                  'tipo_pago' => 2,                  
              ]);
            $cierrepago2->save();

            $gasto = GastosDiarios::create([
                'id_cierre' => $id_cierre,
                'descripcion' => '0',
                'gasto' => 0,
                ]);
            $gasto->save();

            if ($est == 1) {
              $saldo = SaldoActual::create([
                    'id_sucursal' => $request['id_sucursal'],
                    'id_user' => $userId, 
                    'efectivo' => $totalefectivosaldoactual + $totalsaldodeldia, 
                ]);

              $cierrecaja->fill([
                    'total_saldo' => $totalefectivosaldoactual +$request['total_efectivo']+$request['total_tarjeta'], 
                ]);
            }else{
              $saldo = SaldoActual::create([
                    'id_sucursal' => $request['id_sucursal'],
                    'id_user' => $userId, 
                    'efectivo' => 0, 
                ]);

              $cierrecaja->fill([
                    'total_saldo' => 0, 
                ]);
            }

            $cierrecaja->save();
            
            $saldo->save();
        }else{
            $cierrepago = CierrePago::create([
                 'id_cierre' => $id_cierre,                  
                  'monto_sis' => $request['total_efectivo_sis'],
                  'monto_fisico' => $request['total_efectivo']-$request['gasto_efectivo'],
                  'monto_diferencia' =>  $request['total_efectivo_sis']-$request['total_efectivo']-$request['gasto_efectivo'],
                    'tipo_pago' => 1, 
                  // 'conversion' => 0,
                  // 'monto_fisicod'=> 0
              ]);
            $cierrepago->save();

            $cierrepago2 = CierrePago::create([
                 'id_cierre' => $id_cierre,                  
                  'monto_sis' => $request['total_tarjeta_sis'],
                  'monto_fisico' =>  $request['total_tarjeta'],
                  'monto_diferencia' => $request['total_tarjeta_sis']-$request['total_tarjeta']-$request['gasto_efectivo'],
                  'tipo_pago' => 2,                  
              ]);
            $cierrepago2->save();

            $gasto = GastosDiarios::create([
                'id_cierre' => $id_cierre,
                'descripcion' => '0',
                'gasto' => $request['gasto_efectivo'],
                ]);
            $gasto->save();

            if ($est == 1) {
              $saldo = SaldoActual::create([
                    'id_sucursal' => $request['id_sucursal'],
                    'id_user' => $userId, 
                    'efectivo' => $totalefectivosaldoactual + $totalsaldodeldia, 
                ]);

              $cierrecaja->fill([
                    'total_saldo' => $totalefectivosaldoactual +$request['total_efectivo']+$request['total_tarjeta'],  
                ]);
            }else{
              $saldo = SaldoActual::create([
                    'id_sucursal' => $request['id_sucursal'],
                    'id_user' => $userId, 
                    'efectivo' => 0, 
                ]);

              $cierrecaja->fill([
                    'total_saldo' => 0, 
                ]);
            }

            $cierrecaja->save();

            $saldo->save();
        }
    }
  
    public function storedeposito(Request $request)
    {

          $user = Auth::User();
        $userId = $user->id;

          $fecha= $request['fecha_deposito'];
          $dt2 =new \DateTime($fecha);
          $carbon2 = Carbon::instance($dt2); 
          $a_dt2=$carbon2->year;
          $m_dt2=$carbon2->month;
          $d_dt2=$carbon2->day;

          $mifecha=Carbon::create($a_dt2, $m_dt2, $d_dt2, 0);

          $saldoactual=SaldoActual::where('id', $request['id_saldo'])->first();

          if($saldoactual){
             $saldo = SaldoDeposito::create([
                 'id_saldo' => $request['id_saldo'], 
                 'id_sucursal' => $request['id_sucursal'], 
                 'id_user' => $userId,                     
                 'banco' => $request['banco'],
                 'numero' => $request['numero'],
                 'monto' =>  $request['monto'],
                 'montosis' =>   $saldoactual->efectivo,
                 'fecha_deposito' =>  $mifecha,
                 'descripcion' =>  $request['descripcion'],
                 'estado_deposito' => 1, 
              ]);
            $saldo->save();

            if($request['monto'] > $saldoactual->efectivo){
                 $saldoactual->fill([
                    'efectivo' => 0, 
                ]);
                $saldoactual->save();
            }elseif($request['monto'] <= $saldoactual->efectivo){
                $resta=$saldoactual->efectivo-$request['monto'];
                $saldoactual->fill([
                    'efectivo' =>  $resta, 
                ]);
                 $saldoactual->save();
            }

          }

        
    }
    //
    /*****updatep1() pasa de estado 1 a 2
     * justificacion si queda en caja o queda, calculos efectivo a enntregar
     *
     *****/
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
