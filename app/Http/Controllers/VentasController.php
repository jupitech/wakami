<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\ProductoVenta;
use App\Models\TpagoVenta;
use App\Models\TfacVenta;
use App\Models\StockProducto;
use App\Models\StockSucursal;
use App\Models\Clientes;
use App\Models\Sucursales;
use App\Models\Producto;
use App\Models\DescuentosVentas;
use App\User;
use Auth;
use Carbon\Carbon;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use SoapClient;
use Excel;
use PDF;


class VentasController extends Controller
{


    public function __contruct(){
        $this->middleware('role:vendedor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ventas.misventas');
    }

    public function indexnueva()
    {
        return view('admin.ventas.minuevaventa');
    }

    public function indexmiventa($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta","PerfilUsuario")->where('id',$id)->first();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


      public function indexventas($id)
    {
           //Trayendo Ventas de sucursal
         $ventas=Ventas::with("PagoVenta","InfoClientes","FacVenta","PerfilUsuario")->where('id_sucursal',$id)->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }
    
          public function indexventasdia($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")->where('id_sucursal',$id)->where('fecha_factura','>=',Carbon::today())->orderBy('id', 'desc')->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

      public function indexventasmes($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")->where('id_sucursal',$id)->where('fecha_factura','>=',Carbon::today()->startOfMonth())->orderBy('id', 'desc')->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

    
       public function indexventasanio($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("PagoVenta","InfoClientes","PerfilUsuario","NombreSucursal","DescuentosVentas")->where('id_sucursal',$id)->where('fecha_factura','>=',Carbon::today()->startOfYear())->orderBy('id', 'desc')->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


      public function indexmiproducto($id)
    {
           //Trayendo Producto
         $productos=ProductoVenta::with("NombreProducto")->where('id_ventas',$id)->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
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


       public function stockproducto($sucursal,$id)
    {
           //Trayendo Productos de Sucursales
         $stocksucursal=StockSucursal::with("NombreProducto")->where('id_sucursal',$sucursal)->where('id_producto',$id)->first();
         if(!$stocksucursal){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stocksucursal],200);
    }

       public function ventadiasucursal($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->where('id_sucursal',$id)
                  ->where('estado_ventas',2)
                  ->where('fecha_factura','>=',Carbon::today())
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

     public function ventamessucursal($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->where('id_sucursal',$id)
                  ->where('estado_ventas',2)
                  ->where('fecha_factura','>=',Carbon::today()->startOfMonth())
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

      public function ventaaniosucursal($id)
    {
           //Trayendo Producto
         $ventas=Ventas::with("NombreSucursal")
                  ->where('id_sucursal',$id)
                  ->where('estado_ventas',2)
                  ->where('fecha_factura','>=',Carbon::today()->startOfYear())
                  ->groupBy('id_sucursal')
                  ->select('id_sucursal', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

  
       public function ventadiapago($id)
    {

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal', 'left outer')
          ->where('ventas.id_sucursal',$id)
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today())
          ->select(
             \DB::raw('ifnull(sucursales.codigo_esta,0) as codigo_esta'),
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
               )
          ->groupBy('tpago_venta.tipo_pago')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


       public function ventamespago($id)
    {

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->leftJoin('sucursales', 'ventas.id_sucursal', '=', 'sucursales.id')
          ->where('ventas.id_sucursal',$id)
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today()->startOfMonth())
          ->select(
            'sucursales.codigo_esta',
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
               )
          ->groupBy('tpago_venta.tipo_pago')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

   public function ventaaniopago($id)
    {

          $ventas = Ventas::join('tpago_venta', 'tpago_venta.id_ventas', '=', 'ventas.id')
          ->join('sucursales', 'sucursales.id', '=', 'ventas.id_sucursal')
          ->where('ventas.id_sucursal',$id)
          ->where('ventas.estado_ventas',2)
          ->where('ventas.fecha_factura','>=',Carbon::today()->startOfYear())
          ->select(
            'sucursales.codigo_esta',
            'ventas.id_sucursal', 
            'tpago_venta.tipo_pago', 
            \DB::raw('count(ventas.id) as cantidad'),
            \DB::raw('sum(ventas.total) as total')
               )
          ->groupBy('tpago_venta.tipo_pago')
          ->get();        

         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

       public function ventadiafac($id)
    {
           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',Carbon::today())
                  ->where('id_sucursal',$id)
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

    public function ventamesfac($id)
    {
           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',Carbon::today()->startOfMonth())
                  ->where('id_sucursal',$id)
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }

    
     public function ventaaniofac($id)
    {
           //Trayendo Producto
         $ventas=Ventas::where('fecha_factura','>=',Carbon::today()->startOfYear())
                   ->where('id_sucursal',$id)
                  ->groupBy('estado_ventas')
                  ->select('estado_ventas', \DB::raw('count(id) as cantidad'),\DB::raw('sum(total) as total'))
                  ->get();
         if(!$ventas){
             return response()->json(['mensaje' =>  'No se encuentran ventas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $ventas],200);
    }


    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $user = Auth::User();     
          $userId = $user->id; 
        
              $ventas=Ventas::create([
                  'id_cliente' => $request['id_cliente'],
                  'id_sucursal' => $request['id_sucursal'],
                  'id_user' => $userId,
                  'estado_ventas' => 1,
                        ]);
          $ventas->save();
           return response()->json(['id_venta' => $ventas->id],200);
    }

     public function storeclie(Request $request,$id)
    {
      $user = Auth::User();     
      $userId = $user->id; 
      $nit= $request['nit'];
      $celular= $request['celular'];
      $telefono= $request['telefono'];
      $email= $request['email'];

      if($celular=''){
          $micel='';
      }else{
          $micel= $celular;
      }

      if($telefono=''){
          $mitelefono='';
      }else{
          $mitelefono= $telefono;
      }

      if($email=''){
          $miemail='';
      }else{
          $miemail= $email;
      }


      if($nit=='cf' || $nit=='CF' || $nit=='c/f' || $nit=='C/F'){
                $clientes=Clientes::create([
                  'nombre' => $request['nombre'],
                  'direccion' => $request['direccion'],
                  'telefono' => $mitelefono,
                  'celular' => $micel,
                  'email' => $miemail,
                  'tipo_cliente' => 1,
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
                        'nombre' => $request['nombre'],
                        'nit' => $request['nit'],
                        'direccion' => $request['direccion'],
                        'telefono' => $mitelefono,
                        'celular' => $micel,
                        'email' => $miemail,
                        'tipo_cliente' => 1,
                                ]);
                  $clientes->save();
            }
                 


              $ventas=Ventas::create([
                  'id_cliente' => $clientes->id,
                  'id_sucursal' => $id,
                  'id_user' => $userId,
                  'estado_ventas' => 1,
                        ]);
          $ventas->save();
           return response()->json(['id_venta' => $ventas->id],200);
    }


  public function storefac(Request $request)
{
        $idventas =$request['id_ventas'];
        $tipopago =$request['id_tpago'];      
        $tipofac =$request['id_tfac'];  
        $referencia =$request['referencia'];  

        $ahora=Carbon::now();

        if($referencia==''){
            $mirefe='';
        } else{
             $mirefe=$referencia;
        } 

        $ventas=Ventas::find( $idventas );

        //Buscando productos en ventas agregados
        $productoventas=ProductoVenta::where('id_ventas',$idventas)->get();

        $ventas->fill([
          'fecha_factura' => $ahora,
           ]);
        $ventas->save();

        
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

                          //guardando tipo de pago
                          $pagoventa=TpagoVenta::create([
                              'id_ventas' => $idventas,
                              'tipo_pago' => $tipopago,
                              'referencia' => $mirefe,
                                    ]);
                         $pagoventa->save();



                                 foreach ($productoventas as $productoventa) {
                                      //Reduciendo stock desde los productos vendidos
                                         $stocksucursal=StockSucursal::where('id_sucursal',$idsucursal)->where('id_producto',$productoventa->id_producto)->first();

                                            if(!is_null($stocksucursal) ){
                                              $stockactual=$stocksucursal->stock;
                                              $restastock=$stockactual-$productoventa->cantidad;
                                                $stocksucursal->fill([
                                                                  'stock' =>  $restastock,
                                                              ]);
                                                $stocksucursal->save();

                                            }

                                    }

                              //Recibiendo DTE y CAE para factura
                              $midte=$resultado->return->numeroDte;
                              $micae=$resultado->return->cae;
                              
                              $ventas->fill([
                                              'estado_ventas' => 2,
                                              'dte' => $midte,
                                              'cae' => $micae,
                                          ]);
                              $ventas->save();

                             return response()->json(['DTE' => $midte,'CAE'=> $micae],200);                 
 
            } else {
                  return response()->json(['ERROR' =>  $resultado->return->descripcion],200); 
            }

     } catch (SoapFault $E) { 
          $objResponse->addAlert($E->faultstring);
      }
      

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
         }else{
                  return response()->json(['mensaje' =>  'El producto ya existe en la venta','codigo'=>404],404);
         }
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


    }

      public function pdfventa($id)
    {
      //Trayendo ventas
       $ventas=Ventas::with("InfoClientes","NombreSucursal","PerfilUsuario","DescuentosVentas")->where('id',$id)->first();
       $pdf = PDF::loadView('pdf.invoice',['ventas'=>$ventas]);
        return $pdf->download($ventas->dte.'.pdf');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventas=Ventas::find($id);

        if($ventas->estado_ventas==1){
             $productoventas=ProductoVenta::where('id_ventas',$id)->get();

              foreach ($productoventas as $productoventa) {

                  ProductoVenta::destroy($productoventa->id);
              }

               Ventas::destroy($id);
        }

    }
     public function destroypro($id)
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
}
