

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Orden de Envio</title>
</head>
<body>
<style>
	body{
		font-family: sans-serif;
	}
	img{
		padding: 5px;
	}
	table{
		width: 100%;
	}
	td{
		font-size: 11px;
		padding: 2px 5px;
	}
	th{
		background: #eee;
		font-size: 11px;
		padding: 5px 5px;
	}
	.dere{
		text-align: right;
	}
	.mbold{
		font-weight: bold;
	}
	.ttop{
		margin-top: 35px;
	}
		.ttrop{
		margin-top: 80px;
	}
	.tablepro{
		   height: auto;
     min-height:200px;
	}
	.tablepro td{
			padding: 6px 5px;
	}
	.tfoot{
		border-top: 1px solid #eee;
		padding-top: 50px;
	}
</style>
	<table>
		<tbody>
			<tr>
				<td rowspan="4">
					<img width="90px" src="https://sistemafilum.net/css/img/wakami_logo.png" alt="">
				</td>
				<td>Filum Copropiedad-Wakami</td>
				
				
				<td class="dere">Fecha Entrega: {{$envios->fecha_entrega}}</td>
			</tr>
			<tr>
				<td>NIT: 8150406-3</td>
				<td class="dere mbold">Orden #{{$envios->id}}</td>
			</tr>
		</tbody>
	</table>
	<table class="ttop">
		<tbody>
			<tr>
				<td><strong>NOMBRE: </strong>{{$envios->NombreConsignacion->InfoCliente->nombre}}</td>
				<td><strong>NIT: </strong>{{$envios->NombreConsignacion->InfoCliente->nit}}</td>
			</tr>
			<tr>
				<td><strong>DIRECCIÓN: </strong>{{$envios->NombreConsignacion->InfoCliente->direccion}} </td>
				<td><strong>TELÉFONO: </strong>{{$envios->NombreConsignacion->InfoCliente->telefono}}</td>
			</tr>
			<tr>
				<td><strong>DESCUENTO: </strong>{{$envios->NombreConsignacion->InfoCliente->PorcentajeCliente->porcentaje}}% </td>
			</tr>
		</tbody>
	</table>
	<table class="ttop">
	<thead>
		<tr>
			<th rowspan="2">Producto</th>
			<th rowspan="2">Cant.</th>
			<th colspan="2">Precio</th>
			<th rowspan="2">Subtotal Distribuidor</th>
		</tr>
		<tr>
			<th>Distribuidor</th>
			<th>Público</th>
		</tr>
	</thead>
	   <?php
                    $productos=\App\Models\ProductoEnvioco::with("NombreProducto","PendienteProducto")->where('id_orden',$envios->id)->get();
                    ?>
      <tbody class="tablepro">
      @if ($envios->NombreConsignacion->InfoCliente->PorcentajeCliente)
      	 	@foreach($productos as $producto)
				
			  <tr>
				<td>{{$producto->NombreProducto->codigo}}-{{$producto->NombreProducto->nombre}}</td>
				<td>{{$producto->cantidad}}</td>
				<td>Q{{number_format( ($producto->NombreProducto->preciop-(($envios->NombreConsignacion->InfoCliente->PorcentajeCliente->porcentaje*$producto->NombreProducto->preciop)/100)), 2, '.', ',')}}</td>
				<td>Q{{number_format($producto->NombreProducto->preciop, 2, '.', ',')}}</td>
				<td>Q{{number_format((($producto->NombreProducto->preciop-(($envios->NombreConsignacion->InfoCliente->PorcentajeCliente->porcentaje*$producto->NombreProducto->preciop)/100))*$producto->cantidad), 2, '.', ',')}}</td>
			</tr>
			
      	 	@endforeach
		@else 

						@foreach($productos as $producto)
						
					  	<tr>
							<td>{{$producto->NombreProducto->codigo}}-{{$producto->NombreProducto->nombre}}</td>
							<td>{{$producto->cantidad}}</td>
							<td>Q{{number_format($producto->NombreProducto->preciop, 2, '.', ',')}}</td>
							<td>Q{{number_format(($producto->NombreProducto->preciop*$producto->cantidad), 2, '.', ',')}}</td>
						</tr>
					
		      	 	@endforeach
    	 @endif 	 	

      </tbody>
      <tfoot>
      	<tr>
      		<td colspan="3"></td>
      		<td class="dere mbold">TOTAL</td>
      		<td>Q{{number_format(($envios->total_compra-(($envios->NombreConsignacion->InfoCliente->PorcentajeCliente->porcentaje*$envios->total_compra)/100)), 2, '.', ',')}}</td>
      	</tr>
      </tfoot>

	</table>
	
</body>
</html>