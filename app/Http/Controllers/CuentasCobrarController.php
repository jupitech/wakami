<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditosVentas;
use App\Models\AlertaCredito;
use Carbon\Carbon;
use Excel;

class CuentasCobrarController extends Controller
{
    public function index()
    {
        //cargar listado de cierres de la sucursal
        return view('admin.reportes.cuentascobrar');
    }


    public function indexcredito()
    {
        //Trayendo Producto
        $credito=CreditosVentas::with("Ventas")->where('estado_credito',1)->orderBy('id','desc')->get();
        if(!$credito){
            return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $credito],200);
    }

    public function indexalerta()
    {
        $manana=Carbon::tomorrow();
        //Trayendo Producto
        $alerta=AlertaCredito::with("Credito")->where('estado_alerta',1)->where('fecha_credito','<=',$manana)->orderBy('id','desc')->get();
        if(!$alerta){
            return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
        return response()->json(['datos' =>  $alerta],200);
    }

     public function crearexcel(Request $request)
    {

        $dia=Carbon::today();

          $m_dt= $dia->month;
          $d_dt= $dia->day;
     
        
        //Query de los productos comprados del numero de orden
        $credi = CreditosVentas::leftJoin('ventas', 'ventas.id', '=', 'creditos_ventas.id_ventas')
                  ->leftJoin('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
                  ->leftJoin('clientes', 'clientes.id', '=', 'ventas.id_cliente')
                  ->leftJoin('user_profile', 'user_profile.user_id', '=', 'ventas.id_user')
                  ->select(
                    'ventas.dte', 
                    'ventas.total', 
                    'sucursales.nombre as sucursal', 
                    'clientes.nombre as cliente',
                    'user_profile.nombre',
                    'ventas.fecha_factura',
                    'creditos_ventas.fecha_limite'
                       )
                  ->where('estado_credito',1)
                  ->get();

        $nombrearchivo='CuentasCobrar-Dia'.$d_dt.$m_dt;

        $proArray = []; 
        $proArray[] = ['No factura','Total','Sucursal','Nombre Cliente','Vendido por','Fecha Factura','Fecha de vencimiento'];

         foreach ($credi as $pro) {
            $proArray[] = $pro->toArray();
           }
         $hoy=Carbon::now();


        //Creando Excel para orden
        Excel::create($nombrearchivo, function($excel) use($proArray,$d_dt,$m_dt, $hoy){
                  $excel->sheet('Cuentas por Cobrar-'.$d_dt.$m_dt, function($sheet) use($proArray,$d_dt,$m_dt, $hoy) {
                      $sheet->row(1, function ($row) {
                              $row->setFontSize(25);
                          });
                       $sheet->cells('A5:E5', function ($cells) {
                             $cells->setFontWeight('bold');
                            $cells->setBorder('solid', 'none', 'none', 'solid');
                          });
                      $sheet->row(1, array('Cuentas por Cobrar-'.$d_dt.$m_dt));
                       
                     $sheet->row(2, array('Popdashboard'));
                     $sheet->row(3, array('Fecha:'.$hoy));
                     $sheet->fromArray($proArray, null, 'A5', false, false);
                    });
            })->store('xlsx', public_path('exports/cuentasporcobrar'));

          //Enviando correo a proveedor

        $exceladj=public_path().'/exports/cuentasporcobrar/'.$nombrearchivo.'.xlsx';

          return response()->json(['datos' => $nombrearchivo],200);


    }




}


