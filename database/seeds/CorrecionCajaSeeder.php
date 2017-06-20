<?php

use Illuminate\Database\Seeder;
use App\Models\CierrePago;
use App\Models\CierreCaja;
use App\Models\SaldoActual;
use App\Models\Ventas;

class CorrecionCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cierres=CierreCaja::all();

        foreach ($cierres as $cierre) {
        	$pagos=CierrePago::where('id_cierre',$cierre->id)->get();
        	$suma=0;
        	$sumaefec=0;
        	$con=0;
        	foreach ($pagos as $pago) {
        		$con=$con+1;
        		$suma=$suma+ $pago->monto_fisico;

        		if($con==1){
        			$sumaefec=$pago->monto_fisico;
        		}
        	}

        	

        	      $cierre->fill([
	        	      	'saldo_efectivo' => $sumaefec,
	                    'total_saldo' => $suma,  
	                ]);

        	        $cierre->save();

        	        echo '| Id Cierre: '.$cierre->id.'...Saldo Efectivo: Q.'.$sumaefec.'...Saldo Total: Q.'.$suma.'...|  ';




        }

    }
}
