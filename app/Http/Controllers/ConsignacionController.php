<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Consignacion;
use App\Models\StockConsignacion;
use App\Models\StockProducto;
use App\Models\Producto;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\OrdenConsignacion;
use App\Models\ProductoEnvioco;
use App\Models\FacConsignacion;

use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\PorcentajeCliente;
use App\Models\CreditosVentas;
use App\Models\DescuentosVentas;

use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;

class ConsignacionController extends Controller
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
        return view('admin.bodegas.consignacion');
    }

         public function indexconsignacion()
    {

           //Trayendo Consignaciones
         $consignacion=Consignacion::with("InfoCliente")->get();
         if(!$consignacion){
             return response()->json(['mensaje' =>  'No se encuentran consignaciones actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $consignacion],200);
    }

         public function indexproconsignacion($id)
    {
           //Trayendo Productos de Sucursales
         $stockconsignacion=StockConsignacion::with("NombreProducto")->where('id_consignacion',$id)->get();
         if(!$stockconsignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockconsignacion],200);
    }


             public function indexproconsignacionas($id)
    {
           //Trayendo Productos de Sucursales
         $stockconsignacion=StockConsignacion::with("NombreProducto")->where('id_consignacion',$id)->where('stock','>',0)->get();
         if(!$stockconsignacion){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockconsignacion],200);
    }



       public function stockproducto($id)
    {
           //Trayendo Productos de Sucursales
         $stockproducto=StockProducto::where('id_producto',$id)->where('bodega_actual',1)->first();
         if(!$stockproducto){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockproducto],200);
    }

     public function indexenvios()
    {
           //Trayendo Productos de Sucursales
         $envios=OrdenConsignacion::with("NombreConsignacion")->get();
         if(!$envios){
             return response()->json(['mensaje' =>  'No se encuentran envios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $envios],200);
    }

     public function indexproenvios($id)
    {
           //Trayendo Productos de Sucursales
         $envios=ProductoEnvioco::with("NombreProducto","PendienteProducto")->where('id_orden',$id)->get();
         if(!$envios){
             return response()->json(['mensaje' =>  'No se encuentran envios actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $envios],200);
    }

       public function indexventas($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta","NombreSucursal","DescuentosVentas","ConsignacionVentas")->whereHas('ConsignacionVentas',function ($query) use ($id) {$query->where('id_consignacion',$id);})->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


     public function indexmiventa($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta","DescuentosVentas")->where('id',$id)->first();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

       public function indexmiproducto($id)
    {
           //Trayendo Producto
         $productos=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$id)->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

      public function indexmidescuento($id)
    {
           //Trayendo Producto
         $descuentos=DescuentosVentas::where('id_ventas',$id)->get();
         if(!$descuentos){
             return response()->json(['mensaje' =>  'No se encuentran descuentos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $descuentos],200);
    }


      public function indexmisucursal($id)
    {
           //Trayendo Producto
         $sucursales=Sucursales::where('id',$id)->first();
         if(!$sucursales){
             return response()->json(['mensaje' =>  'No se encuentran sucursales actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $sucursales],200);
    }


    //PDF para facturas ventas

     public function pdfventa($id)
    {
      //Trayendo ventas
       $ventas=Ventas::with("InfoClientes","NombreSucursal","PerfilUsuario","DescuentosVentas")->where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoice',['ventas'=>$ventas]);
        return $pdf->download($ventas->dte.'.pdf');
 
    }


     //PDF para envios consignacion

     public function pdfenvio($id)
    {
      //Trayendo ventas
       $envios=OrdenConsignacion::with("NombreConsignacion")->where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoiceenvio',['envios'=>$envios]);
        return $pdf->download('Orden Envio #'.$envios->id.'.pdf');
 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             $idcliente=$request['id_cliente'];

            $consignacion=Consignacion::where('id_cliente',$idcliente)->first();
            if(!$consignacion){   
              $consig=Consignacion::create([
                  'id_cliente' => $request['id_cliente'],
                  'estado_consignacion' => 1,
                        ]);
             $consig->save();
            } else{
                     return response()->json(['mensaje' =>  'El Cliente ya tiene una bodega de consignacion creada','codigo'=>404],404);
             }
    }



       public function storeenvio(Request $request)
    {
          $user = Auth::User();     
          $userId = $user->id; 


           $ordenenvio=OrdenConsignacion::create([
          'id_consignacion' => $request['id_consignacion'],
          'id_user' => $userId,
          'estado_orden' => 1,
                ]);
          $ordenenvio->save();
           return response()->json(['id_user' => $ordenenvio->id],200);
    }




      public function storeproenvio(Request $request)
    {
        $idproducto=$request['id_producto'];
        $idorden=$request['id_orden'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->preciop;

        $existepro=ProductoEnvioco::where('id_orden',$idorden)->where('id_producto',$idproducto)->first();

            if($existepro === null){
                  $productoenvio=ProductoEnvioco::create([
                     'id_orden' =>  $idorden,
                     'id_producto' => $idproducto,
                     'precio_producto' => $producto->preciop,
                     'cantidad' => $request['cantidad'],
                     'subtotal' => $subtotal,
                      'estado_producto' => 1,
                    ]);
                   $productoenvio->save();

                  $idorden=$productoenvio->id_orden;

                    $ordenenvio=OrdenConsignacion::find($idorden);
                    //Sumar el subtotal actual
                    $totalfinal=($ordenenvio->total_compra)+$subtotal;
                    $ordenenvio->fill([
                              'total_compra' => $totalfinal,
                        ]);
                    $ordenenvio->save();

                   return response()->json(['id_proenvio' => $productoenvio->id],200);
            }else{

                    return response()->json(['mensaje' =>  'Producto ya ingresado al envio','codigo'=>404],404);
            }
           
    }


      public function nuevaventa(Request $request,$idcliente)
    {
      $user = Auth::User();     
      $userId = $user->id; 
        
              $ventas=Ventas::create([
                  'id_cliente' => $idcliente,
                  'id_sucursal' => 3,
                  'id_user' => $userId,
                  'estado_ventas' => 1,
                        ]);
          $ventas->save();
           return response()->json(['id_venta' => $ventas->id],200);
    }


       public function storepro(Request $request)
    {

       $idventas=$request['id_ventas'];
       $idproducto=$request['id_producto'];

        $productoventa=ProductoVenta::where('id_ventas',$idventas)->where('id_producto',$idproducto)->first();
         if(!$productoventa){
                $miproducto=ProductoVenta::create([
                  'id_ventas' => $request['id_ventas'],
                  'id_producto' =>$request['id_producto'],
                  'cantidad' =>$request['cantidad'],
                        ]);
              $miproducto->save();
              //Agregar total de ventas
             $ventas=Ventas::where('id',$idventas)->first();
             $productos=Producto::where('id',$idproducto)->first();

             $totalactual=$ventas->total;
             $preciop=$productos->preciop;
             $subtotal=$preciop*$request['cantidad'];
             $total=$totalactual+$subtotal;

                    $ventas->fill([
                          'total' => $total,
                        ]);
                    $ventas->save();

             //Analizar si existe descuento para modificarlo
             $descuento=DescuentosVentas::where("id_ventas",$idventas)->first();

             if($descuento){

                  $porcentaje=$descuento->porcentaje;
                  $midescuento=$descuento->descuento;
                  $mitotal=$ventas->total;

                  $regretotal=$mitotal+ $midescuento;
                  //Obteniendo monto de descuento10
                  $aplides=($regretotal*$porcentaje)/100;

                  //Total Actual
                  $totalactual=$regretotal-$aplides;

                  $ventas->fill([
                      'total' => $totalactual,
                    ]);
                  $ventas->save();

                   $descuento->fill([
                      'descuento' => $aplides,
                    ]);
                  $descuento->save();
             }

         }else{
                  return response()->json(['mensaje' =>  'El producto ya existe en la venta','codigo'=>404],404);
         }
    }

    public function storedes(Request $request)
    {
      $idventas= $request['id_ventas'];
      $idcliente= $request['id_cliente'];

      $porcliente=PorcentajeCliente::where('id_cliente',$idcliente)->first();
      $ventas=Ventas::where('id',$idventas)->first();

      $miporcentaje=$porcliente->porcentaje;
      $mitotal=$ventas->total;

      //Obteniendo monto de descuento10
      $aplides=($mitotal*$miporcentaje)/100;

      //Total Actual
      $totalactual=$mitotal-$aplides;


      $ventas->fill([
          'total' => $totalactual,
        ]);
        $ventas->save();

      $descuentos=DescuentosVentas::create([
                  'id_cliente' => $idcliente,
                  'id_ventas' => $idventas,
                  'porcentaje' => $miporcentaje,
                  'descuento' => $aplides,
                        ]);
      $descuentos->save();

           return response()->json(['id_venta' => $ventas->id],200);
    }


    //Factura Electrónica
   public function storefac(Request $request)
    {
        $idventas =$request['id_ventas'];
        $idconsignacion =$request['id_consignacion'];
        $tipopago =$request['id_tpago'];      
        $tipofac =$request['id_tfac'];  
        $referencia =$request['referencia'];    
        $diascredito =$request['dias_credito'];    

        $ahora=Carbon::now();
   
        if($referencia=''){
            $mirefe='';
        } else{
             $mirefe=$referencia;
        } 

        $ventas=Ventas::find( $idventas );

        //Buscando productos en ventas agregados
         $productoventas=ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$idventas)->get();


            //Analizando tipo de pago y actualizando factura 
                            if($tipopago==4){

                                  $ventas->fill([
                                          'fecha_factura' => $ahora,
                                          'estado_ventas' => 3,
                                      ]);
                                  $ventas->save();

                                  $fechalimite=Carbon::now()->addDays($diascredito);


                                   $creditoventa=CreditosVentas::create([
                                      'id_ventas' => $idventas,
                                      'dias_credito' => $diascredito,
                                      'fecha_limite' => $fechalimite,
                                      'estado_credito' => 1,
                                            ]);
                                   $creditoventa->save();

                            }else{

                                  $ventas->fill([
                                          'fecha_factura' => $ahora,
                                      ]);
                                  $ventas->save();

                            }



        //Enviando factura electronica
          $detalle=[];
          $dte=[];
            //Buscando información de la sucursal
            $idsucursal=$ventas->id_sucursal;
            $misucursal=Sucursales::where('id',$idsucursal)->first();
            
            //Buscando los productos y agregando a una variable array
             foreach ($productoventas as $productoventa) {

                  $codigoProducto=$productoventa->NombreProducto->codigo;
                  $descripcionProducto=$productoventa->NombreProducto->nombre;
                  $precioUni=$productoventa->NombreProducto->preciop;
                  $montoBruto=round((($precioUni*$productoventa->cantidad)),2);

                  $exisdescuento=$productoventa->Venta->DescuentosVentas;

                    if($exisdescuento){
               
                      $porcentaje=$productoventa->Venta->DescuentosVentas->porcentaje;
                      $descuentoUnitario=($precioUni*$porcentaje)/100;
                      $precioUnitario=round(($precioUni-$descuentoUnitario),2);
                      $montoDescuento=($montoBruto*$porcentaje)/100;
                      $restamonto=round(($montoBruto-$montoDescuento),2);
                      $importeNetoGravado=round(($restamonto),2);
                      $detalleImpuestosIva=round(($restamonto*0.12),2);
                      $importeTotalOperacion=round(($restamonto),2);
                      $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);

                    }else{
                       $precioUnitario=round((($productoventa->NombreProducto->preciop)),2);
                       $montoDescuento=0;
                       $importeNetoGravado=round(($montoBruto),2);
                       $detalleImpuestosIva= round(($montoBruto*0.12),2);
                       $importeTotalOperacion=round(($montoBruto),2);
                       $montoBr=round(($importeTotalOperacion-$detalleImpuestosIva),2);
                    }

                  $detalle[]=array(
                       'cantidad'=> $productoventa->cantidad,
                       'unidadMedida'=> 'UND',
                       'codigoProducto'=>  $codigoProducto,
                       'descripcionProducto'=> $descripcionProducto,
                       'precioUnitario'=> "$precioUnitario",
                       'montoBruto'=> "$montoBr",
                       'montoDescuento'=> "$montoDescuento",
                       'importeNetoGravado'=>  "$importeNetoGravado",
                       'detalleImpuestosIva'=> "$detalleImpuestosIva",
                       'importeExento'=> "0",
                       'otrosImpuestos'=> "0",
                       'importeOtrosImpuestos'=> "0",
                       'importeTotalOperacion'=>"$importeTotalOperacion",
                       'tipoProducto'=> 'B',
                       'personalizado_01'=> 'N/A',
                       'personalizado_02'=> 'N/A',
                       'personalizado_03'=> 'N/A',
                       'personalizado_04'=> 'N/A',
                       'personalizado_05'=> 'N/A',
                       'personalizado_06'=> 'N/A'
                  );
             }

             $importeBruto= round((($ventas->total)/1.12),2);
             $detalleImpuestosIvat=round((($ventas->total)*0.12),2);

             $micliente=Clientes::where('id',$ventas->id_cliente)->first();
             $exisempre=$micliente->empresa;
             $existelefono=$micliente->telefono;
             $exiscorreo=$micliente->email;

             //Buscando CF en nit
             $exisnit=$micliente->nit;
             $nitcf='C';
             $encuencf=substr($exisnit,0,1);

             if( $encuencf==$nitcf){
                $nitComprador='C/F';
                $nombreComercialComprador='Consumidor Final';
             }else{
                $nitComprador=str_replace("-", "", $exisnit);

                 if($exisempre!=''){

                    $nombreComercialComprador=$micliente->empresa;
                 }else{
                    $nombreComercialComprador=$micliente->nombre;
                 }

             }


             if($existelefono!=''){
                $telefonoComprador=$micliente->telefono;
             }else{
                $telefonoComprador='N/A';
             }

            if($exiscorreo!=''){
                $correoComprador=$micliente->email;
             }else{
                $correoComprador='N/A';
             }

             //Formato fecha 
            $fechafactura=Carbon::parse($ventas->fecha_factura);
            $fanio=$fechafactura->year;
            $fmes=$fechafactura->month;
            $fdia=$fechafactura->day;

            $createfecha=Carbon::create($fanio, $fmes, $fdia);

            $fechaDocumento=$createfecha->toDateString();

            $fechaResolucion='2016-09-21';

             //Información de factura 
             $dte=array(
                  'usuario'=> 'FILUM',
                  'clave'=> 'BA67C270504DA22D0BA7E817D8A9A3C9BFB34077A9B899D924170E3F8016B432',
                  'validador'=> false,
                  'dte'=> array(
                          'codigoEstablecimiento'=> "$misucursal->codigo_esta",
                          'idDispositivo'=>'001',
                          'serieAutorizada'=>$misucursal->serie,
                          'numeroResolucion'=>"$misucursal->resolucion",
                          'fechaResolucion'=>$fechaResolucion,
                          'tipoDocumento'=>'FACE',
                          'serieDocumento'=>"$misucursal->codigo_sat",
                          'estadoDocumento'=>'ACTIVO',
                          'numeroDocumento'=>"$ventas->id",
                          'fechaDocumento'=>$fechaDocumento,
                          'codigoMoneda'=>'GTQ',
                          'tipoCambio'=>'1',
                          'nitComprador'=>$nitComprador,
                          'nombreComercialComprador'=> $nombreComercialComprador, 
                          'direccionComercialComprador'=>$micliente->direccion, 
                          'telefonoComprador'=>$telefonoComprador,
                          'correoComprador'=>$correoComprador,
                          'regimen2989'=>false, 
                          'departamentoComprador'=>'N/A', 
                          'municipioComprador'=>'N/A',               
                          'importeBruto'=>$importeBruto,
                          'importeDescuento'=>0, 
                          'importeTotalExento'=>0,
                          'importeOtrosImpuestos'=>0,                               
                          'importeNetoGravado'=>$ventas->total, 
                          'detalleImpuestosIva'=>$detalleImpuestosIvat,
                          'montoTotalOperacion'=>$ventas->total, 
                          'descripcionOtroImpuesto'=>'N/A',
                          'observaciones'=>'N/A',
                          'nitVendedor'=>str_replace("-", "","8150406-3"),
                          'departamentoVendedor'=>'GUATEMALA', 
                          'municipioVendedor'=>'GUATEMALA',
                          'direccionComercialVendedor'=>'12 av. 14-68 Zona 10', 
                          'NombreComercialRazonSocialVendedor'=>'Filum Copropiedad', 
                          'nombreCompletoVendedor'=>'Wakami',
                          'regimenISR'=>'1',
                          'personalizado_01'=>'N/A',
                          'personalizado_02'=>'N/A',
                          'personalizado_03'=>'N/A',
                          'personalizado_04'=>'N/A',
                          'personalizado_05'=>'N/A',
                          'personalizado_06'=>'N/A',
                          'personalizado_07'=>'N/A',
                          'personalizado_08'=>'N/A',
                          'personalizado_09'=>'N/A',
                          'personalizado_10'=>'N/A',
                          'personalizado_11'=>'N/A',
                          'personalizado_12'=>'N/A',
                          'personalizado_13'=>'N/A',
                          'personalizado_14'=>'N/A',
                          'personalizado_15'=>'N/A',
                          'personalizado_16'=>'N/A',
                          'personalizado_17'=>'N/A',
                          'personalizado_18'=>'N/A',
                          'personalizado_19'=>'N/A',
                          'personalizado_20'=>'N/A',
                                    
                         'detalleDte'=>$detalle
                  )
             );



  try{

             $client = new \SoapClient('https://www.ingface.net/listener/ingface?wsdl',array( 'exceptions' => 1)); 

             $resultado=$client->registrarDte(array("dte"=>$dte));

                if($resultado->return->valido)
                      {    


                              $pagoventa=TpagoVenta::create([
                              'id_ventas' => $idventas,
                              'tipo_pago' => $tipopago,
                              'referencia' => $mirefe,
                                    ]);
                         $pagoventa->save();

                         $consignacion=Consignacion::where('id_cliente',$ventas->id_cliente)->first();

                            $facconsig=FacConsignacion::create([
                              'id_ventas' => $idventas,
                              'id_consignacion' => $consignacion->id,
                              'estado_factura' => 1,
                                    ]);
                            $facconsig->save();



                              foreach ($productoventas as $productoventa) {
                                //Reduciendo stock desde los productos vendidos
                                   $stockproducto=StockConsignacion::where('id_producto',$productoventa->id_producto)->where('id_consignacion',$consignacion->id)->first();

                                      if(!is_null($stockproducto) ){
                                        $stockactual=$stockproducto->stock;
                                        $restastock=$stockactual-$productoventa->cantidad;
                                          $stockproducto->fill([
                                                            'stock' =>  $restastock,
                                                        ]);
                                          $stockproducto->save();

                                      }

                              }

                              //Recibiendo DTE y CAE para factura
                              $midte=$resultado->return->numeroDte;
                              $micae=$resultado->return->cae;


                                 if($tipopago==4){

                                  $ventas->fill([
                                          'estado_ventas' => 3,
                                           'dte' => $midte,
                                          'cae' => $micae,
                                      ]);
                                  $ventas->save();

                                   }else{

                                    $ventas->fill([
                                              'estado_ventas' => 2,
                                             'dte' => $midte,
                                              'cae' => $micae,
                                          ]);
                                   $ventas->save();

                               }



                             return response()->json(['DTE' => $midte,'CAE'=> $micae],200);                 
 
            } else {
                  return response()->json(['ERROR' =>  $resultado->return->descripcion],200); 
            }

     } catch (SoapFault $E) { 
          $objResponse->addAlert($E->faultstring);
      }


      //Pruebas de ventas
/*
          //guardando tipo de pago
                         $pagoventa=TpagoVenta::create([
                              'id_ventas' => $idventas,
                              'tipo_pago' => $tipopago,
                              'referencia' => $mirefe,
                                    ]);
                         $pagoventa->save();

                         $consignacion=Consignacion::where('id_cliente',$ventas->id_cliente)->first();

                            $facconsig=FacConsignacion::create([
                              'id_ventas' => $idventas,
                              'id_consignacion' => $consignacion->id,
                              'estado_factura' => 1,
                                    ]);
                            $facconsig->save();



                              foreach ($productoventas as $productoventa) {
                                //Reduciendo stock desde los productos vendidos
                                   $stockproducto=StockConsignacion::where('id_producto',$productoventa->id_producto)->first();

                                      if(!is_null($stockproducto) ){
                                        $stockactual=$stockproducto->stock;
                                        $restastock=$stockactual-$productoventa->cantidad;
                                          $stockproducto->fill([
                                                            'stock' =>  $restastock,
                                                        ]);
                                          $stockproducto->save();

                                      }

                              }

                              //Recibiendo DTE y CAE para factura
                            //  $midte=$resultado->return->numeroDte;
                            //  $micae=$resultado->return->cae;
                              
                              $ventas->fill([
                                              'estado_ventas' => 2,
                                           // 'dte' => $midte,
                                            //  'cae' => $micae,
                                          ]);
                              $ventas->save();

*/

 }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function updatepro(Request $request, $id)
    {
         $productoventa=ProductoVenta::find($id);


        $cantiactual= $productoventa->cantidad;
        $idventas= $productoventa->id_ventas;
        $idproducto= $productoventa->id_producto;
   
        $ventas=Ventas::where('id',$idventas)->first();
        $productos=Producto::where('id',$idproducto)->first();


        $totalactual=$ventas->total;
        $preciop=$productos->preciop;

        $subtotal=$preciop*$request['cantidad'];
        $subtotalante=$preciop*$cantiactual;

        $restotal=$totalactual-$subtotalante;
        $total=$restotal+$subtotal;

        $ventas->fill([
              'total' => $total,
            ]);
        $ventas->save();

        $productoventa->fill([
          'cantidad' => $request['cantidad'],
        ]);
        $productoventa->save();

         //Analizar si existe descuento para modificarlo
             $descuento=DescuentosVentas::where("id_ventas",$idventas)->first();

             if($descuento){

                  $porcentaje=$descuento->porcentaje;
                  $midescuento=$descuento->descuento;
                  $mitotal=$ventas->total;

                  $regretotal=$mitotal+ $midescuento;
                  //Obteniendo monto de descuento10
                  $aplides=($regretotal*$porcentaje)/100;

                  //Total Actual
                  $totalactual=$regretotal-$aplides;

                  $ventas->fill([
                      'total' => $totalactual,
                    ]);
                  $ventas->save();

                   $descuento->fill([
                      'descuento' => $aplides,
                    ]);
                  $descuento->save();
             }
    }



     public function updateproenvio(Request $request, $id)
    {
        $idproducto=$request['id_producto'];
        $producto=Producto::where('id',$idproducto)->first();
        $subtotal=$request['cantidad']*$producto->preciop;

        $productoenvio=ProductoEnvioco::find($id);
        $idorden=$productoenvio->id_orden;

        $ordenenvio=OrdenConsignacion::find($idorden);
        //Restar subtotal del producto
        $restartotal=$ordenenvio->total_compra- $productoenvio->subtotal;
        //Sumar el subtotal actual
        $totalfinal=$restartotal+ $subtotal;
        $ordenenvio->fill([
                  'total_compra' => $totalfinal,
            ]);
        $ordenenvio->save();


        $productoenvio->fill([
                  'cantidad' => $request['cantidad'],
                  'subtotal' => $subtotal,
            ]);
        $productoenvio->save();

       
    }

    //Enviar Orden
    public function updatep1(Request $request, $id)
    {

        $ordenenvio=OrdenConsignacion::find($id);
        $productoenvios=ProductoEnvioco::where('id_orden',$id)->get();
        $idconsignacion=$ordenenvio->id_consignacion;

        foreach ($productoenvios as $productoenvio) {

            //Reduciendo stock desde los productos vendidos
               $stockproducto=StockProducto::where('id_producto',$productoenvio->id_producto)->first();

                  if($stockproducto ){
                    $stockactual=$stockproducto->stock;
                    $restastock=$stockactual-$productoenvio->cantidad;
                      $stockproducto->fill([
                                        'stock' =>  $restastock,
                                    ]);
                      $stockproducto->save();

                  }

                //Agregando stock desde los productos vendidos
               $stockconsignacion=StockConsignacion::where('id_producto',$productoenvio->id_producto)->where('id_consignacion', $idconsignacion)->first();

                  if(!$stockconsignacion){
                       $stockconsig=StockConsignacion::create([
                                  'id_consignacion' => $idconsignacion,
                                  'id_producto' => $productoenvio->id_producto,
                                  'stock' => $productoenvio->cantidad,
                                  'estado_producto' => 1,
                            ]);
                        $stockconsig->save();
                  
                  }else{
                        $stockactual=$stockconsignacion->stock;
                    $sumarstock=$stockactual+$productoenvio->cantidad;
                      $stockconsignacion->fill([
                                        'stock' =>  $sumarstock,
                                    ]);
                      $stockconsignacion->save();

                  }
     

          }

        $ordenenvio->fill([
              'estado_orden' => 2,
              'fecha_entrega' => Carbon::now(),
            ]);
        $ordenenvio->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Consignacion::destroy($id);
    }

     public function destroypro($id)
    {
        $proenvio=ProductoEnvioco::find($id);
        $idorden=$proenvio->id_orden;
        $subtotal=$proenvio->subtotal;

        $ordenenvio=OrdenConsignacion::find($idorden);
        $restartotal=$ordenenvio->total_compra- $subtotal;
        $ordenenvio->fill([
                  'total_compra' => $restartotal,
            ]);
        $ordenenvio->save();
        ProductoEnvioco::destroy($id);
    }


      public function destroyprofac($id)
    {
        $productoventa=ProductoVenta::find($id);
        $idventas=$productoventa->id_ventas;
        $idproducto=$productoventa->id_producto;

             $ventas=Ventas::where('id',$idventas)->first();
             $productos=Producto::where('id',$idproducto)->first();

             $totalactual=$ventas->total;
             $preciop=$productos->preciop;
             $subtotal=$preciop*$productoventa->cantidad;
             $total=$totalactual-$subtotal;

                    $ventas->fill([
                          'total' => $total,
                        ]);
                    $ventas->save();

        ProductoVenta::destroy($id);
    }
    

     public function destroydes($id)
    {
        $desventas=DescuentosVentas::where('id_ventas',$id)->first();
        $descuento=$desventas->descuento;
        $iddes=$desventas->id;

             $ventas=Ventas::where('id',$id)->first();

             $total=$ventas->total;

             $nuevototal=$total+$descuento;

              $ventas->fill([
                    'total' => $nuevototal,
                  ]);
              $ventas->save();

        DescuentosVentas::destroy($iddes);
    }

}
