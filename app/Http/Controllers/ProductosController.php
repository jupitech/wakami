<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Http\Requests;
use App\Models\Producto;
use App\Models\LineaProducto;
use App\Models\GaleriaImagen;
use App\Models\StockProducto;

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
         $productos=Producto::with("NombreLinea","NombreImagen","StockProducto")->get();
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

      
    $codigobarra= $request['codigo_barra'];

     if($codigobarra=''){
          $mibarra='';
      }else{
          $mibarra= $codigobarra;
      }

           $productos=Producto::create([
                  'codigo' => $request['codigo'],
                  'codigo_barra' => $mibarra,
                  'linea' => $request['linea'],
                  'nombre' => $request['nombre'],
                  'costo' => $request['costo'],
                  'preciop' => $request['preciop'],
                        ]);
          $productos->save();
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
           $productos=Producto::find($id);
        $productos->fill([
                  'codigo' => $request['codigo'],
                  'codigo_barra' => $request['codigo_barra'],
                  'linea' => $request['linea'],
                  'nombre' => $request['nombre'],
                  'costo' => $request['costo'],
                  'preciop' => $request['preciop'],
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
