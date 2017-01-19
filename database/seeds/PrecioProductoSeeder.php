<?php

use Illuminate\Database\Seeder;
use App\Models\ProductoVenta;
use App\Models\Producto;

class PrecioProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$productos=Producto::all();

    	  foreach ($productos as $producto) {

    	  	$idproducto=$producto->id;
    	  	$total=$producto->preciop;
            //Buscando pago de ventas
               $preciopro=ProductoVenta::where('id_producto',$idproducto)->get();
                 foreach ($preciopro as $precio) {
		                  if(!is_null($precio) ){
		                    $precio->fill([
		                                  'precio_producto' =>$total,
		                              ]);
		                  $precio->save();

		                  }
		         }         

          }
   	}
}
