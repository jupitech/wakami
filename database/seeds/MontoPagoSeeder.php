<?php

use Illuminate\Database\Seeder;
use App\Models\Ventas;
use App\Models\TpagoVenta;

class MontoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$ventas=Ventas::all();

    	  foreach ($ventas as $venta) {

    	  	$idventa=$venta->id;
    	  	$total=$venta->total;
            //Buscando pago de ventas
               $pagoventa=TpagoVenta::where('id_ventas',$idventa)->first();

                  if(!is_null($pagoventa) ){
                    $pagoventa->fill([
                                  'monto' =>$total,
                              ]);
                  $pagoventa->save();

                  }

          }
   	}
}
