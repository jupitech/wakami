<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Http\Requests;
use App\Models\Producto;
use App\Models\MovimientoPrecio;
use App\Models\Proveedores;
use App\Models\LineaProducto;
use App\Models\GaleriaImagen;
use App\Models\StockProducto;
use Auth;
use Excel;
use Carbon\Carbon;

class ProductosController extends Controller
{


    public function __contruct(){
        $this->middleware('role:admin|operativo|vendedor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return view('admin.productos.productos');
    }

    public function indexproductos()
    {
           //Trayendo Producto
         $productos=Producto::with("NombreLinea","NombreImagen","StockProducto","NombreProveedor")->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

    public function movpreciopro($id)
    {
      $movimientoprecio=MovimientoPrecio::with('NombreUsuario','NombreProducto')->where('id_producto',$id)->get();
        if(!$movimientoprecio){
            return response()->json(['mensaje' => 'No se encuentran movimientos de precios actualmente.','codigo'=>404],404);
        }            
            return response()->json(['datos' => $movimientoprecio],200);
    }
   

    public function productosconstock()
    {
           //Trayendo Producto
         $productos=Producto::with("NombreLinea","NombreImagen","StockProducto")->whereHas('StockProducto',function ($query) {$query->where('stock','>',0);})->get();
         if(!$productos){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $productos],200);
    }

      public function indexlineas()
    {
           //Trayendo Lineas
         $lineas=LineaProducto::all();
         if(!$lineas){
             return response()->json(['mensaje' =>  'No se encuentran lineas actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $lineas],200);
    }

      public function excelproductos()
    {
          
                //Query de los productos comprados del numero de orden
                $productos = LineaProducto::leftJoin('producto', 'linea_producto.id', '=', 'producto.linea')
                          ->leftJoin('stock_producto', 'stock_producto.id_producto', '=', 'producto.id')
                          ->leftJoin('proveedores', 'proveedores.id', '=', 'producto.id_proveedor')
                          ->select(
                            'proveedores.empresa',
                            'producto.codigo', 
                            'linea_producto.nombre as linea', 
                            'producto.nombre as nombre', 
                            'stock_producto.stock',
                            'producto.costo',
                            'producto.preciop'
                               )
                          ->get();
  //return response()->json(['datos' =>  $productos],200);
                $nombrearchivo='Stock Central Hoy';

                $proArray = []; 
                $proArray[] = ['Proveedor','Codigo','Linea','Producto','Stock','Costo','Precio P'];

                 foreach ($productos as $pro) {
                    $proArray[] = $pro->toArray();
                   }
                 $hoy=Carbon::now();


                //Creando Excel para orden
                Excel::create($nombrearchivo, function($excel) use($proArray, $hoy){
                          $excel->sheet('Stock Actual', function($sheet) use($proArray, $hoy) {
                              $sheet->row(1, function ($row) {
                                      $row->setFontSize(15);
                                  });
                               $sheet->cells('A5:F5', function ($cells) {
                                     $cells->setFontWeight('bold');
                                    $cells->setBorder('solid', 'none', 'none', 'solid');
                                  });
                              $sheet->row(1, array('Productos con stock actual'));
                               
                             $sheet->row(2, array('Wakami Guatemala'));
                             $sheet->row(3, array('Fecha:'.$hoy));
                             $sheet->fromArray($proArray, null, 'A5', false, false);
                            });
                    })->download('xlsx');

      
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createimagen($id)
    {
         $producto=Producto::find($id);
         return view('admin.productos.imagen',['producto'=>$producto]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function storelinea(Request $request)
    {
         $lineas=LineaProducto::create([
                  'nombre' => $request['nombre']
                        ]);
          $lineas->save();
    }


    public function store(Request $request)
    {

         $user = Auth::User();     
         $userId = $user->id; 
      
       $codigobarra= $request['codigo_barra'];
       $idproveedor= $request['id_proveedor'];

       if($codigobarra==''){
          $mibarra='';
      }else{
          $mibarra= $codigobarra;
      }

        if($idproveedor==''){
          $miprove='';
      }else{
          $miprove= $idproveedor;
      }

           $productos=Producto::create([
                  'codigo' => $request['codigo'],
                  'codigo_barra' => $mibarra,
                  'linea' => $request['linea'],
                  'nombre' => $request['nombre'],
                  'costo' => $request['costo'],
                  'preciop' => $request['preciop'],
                  'id_proveedor' => $miprove,
                        ]);
          $productos->save();

          $movprecio=MovimientoPrecio::create([
                  'id_producto' => $productos->id,
                  'precio_anterior' =>   $request['preciop'],
                  'precio_actual' =>    $request['preciop'],
                  'id_user' =>  $userId,
                        ]);   
          $movprecio->save();   
    }

     public function storeimagen(Request $request)
    {
          $path = public_path().'/uploads/';
          $files = $request->file('file');
          $fileName = uniqid() . $files->getClientOriginalName();
          $fileSize = $files->getClientSize();
          $fileTipo = $files->getClientMimeType();
          $fileRuta = 'uploads/'.$fileName;
          $files->move($path, $fileName);
          
            $galeriaimagen=GaleriaImagen::create([
                  'nombre' => $fileName,
                  'ruta' => $fileRuta,
                  'tipo' =>   $fileTipo,
                  'size' =>  $fileSize,
                        ]);
          $galeriaimagen->save();  
          $id_producto=$request->input('id_producto');
          $productos=Producto::find($id_producto);

          $productos->fill([
                         'imagen_id' => $galeriaimagen->id,
                   ]);
          $productos->save();

          return view('admin.productos.productos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stockproducto($id)
    {
         $stockproducto=StockProducto::find($id);
        if(!$stockproducto){
             return response()->json(['mensaje' =>  'No se encuentran productos actualmente','codigo'=>404],404);
        }
         return response()->json(['datos' =>  $stockproducto],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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

         $user = Auth::User();     
          $userId = $user->id; 

           $productos=Producto::find($id);
           $precioante=$productos->preciop;

         
            $movprecio=MovimientoPrecio::create([
                  'id_producto' => $id,
                  'precio_anterior' =>  $precioante,
                  'precio_actual' =>    $request['preciop'],
                  'id_user' =>  $userId,
                        ]);   
           $movprecio->save();             

        $productos->fill([
                  'codigo' => $request['codigo'],
                  'codigo_barra' => $request['codigo_barra'],
                  'linea' => $request['linea'],
                  'nombre' => $request['nombre'],
                  'costo' => $request['costo'],
                  'preciop' => $request['preciop'],
                  'id_proveedor' => $request['id_proveedor'],
            ]);
        $productos->save();
    }

     public function updatelinea(Request $request, $id)
    {
        $lineas=LineaProducto::find($id);
        $lineas->fill([
                'nombre' =>  $request['nombre']
            ]);
        $lineas->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Producto::destroy($id);
    }
     public function destroylinea($id)
    {
        LineaProducto::destroy($id);
    }
}
