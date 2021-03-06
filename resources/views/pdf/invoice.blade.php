
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura Electronica</title>
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
		font-size: 12px;
		padding: 2px 5px;
	}
	th{
		background: #eee;
		font-size: 12px;
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
			<!-- 	<td rowspan="4">
				<img width="90px" src="https://sistemafilum.net/css/img/wakami_logo.png" alt="">
			</td>
			 -->
				
				<td rowspan="4"></td>
				<td>Filum Copropiedad</td>
				<td class="dere">Fecha: {{$ventas->fecha_factura}}</td>
			</tr>
			<tr>
				<td>{{$ventas->NombreSucursal->ubicacion}}</td>
				<td class="dere">Factura Electrónica</td>
			</tr>
			<tr>
				<td>{{$ventas->NombreSucursal->telefono}}</td>
				<td class="dere mbold">{{$ventas->dte}}</td>
			</tr>
			<tr>
				<td>NIT: 8150406-3</td>
			</tr>
		</tbody>
	</table>
	<table class="ttop">
		<tbody>
			<tr>
				<td><strong>NOMBRE: </strong>@if ($ventas->InfoClientes->empresa === ""){{$ventas->InfoClientes->nombre}} @else {{$ventas->InfoClientes->empresa}} @endif</td>
				<td><strong>NIT: </strong>{{$ventas->InfoClientes->nit}}</td>
			</tr>
			<tr>
				<td><strong>DIRECCIÓN: </strong>{{$ventas->InfoClientes->direccion}} </td>
				<td><strong>TELÉFONO: </strong>{{$ventas->InfoClientes->telefono}}</td>
			</tr>
		</tbody>
	</table>
	<table class="ttop">
	<thead>
		<tr>
			<th>Producto</th>
			<th>Cantidad</th>
			<th>Precio</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	   <?php
                    $productos=\App\Models\ProductoVenta::with("NombreProducto","Venta")->where('id_ventas',$ventas->id)->get();
                    ?>
      <tbody class="tablepro">
    
      	 	@foreach($productos as $producto)
      	 		  @if ($producto->Venta->DescuentosVentas)
									<tr>
										<td>{{$producto->NombreProducto->codigo}}-{{$producto->NombreProducto->nombre}}</td>
										<td>{{$producto->cantidad}}</td>
										<td>Q{{number_format( ($producto->precio_producto-(($producto->Venta->DescuentosVentas->porcentaje*$producto->precio_producto)/100)), 2, '.', ',')}}</td>
										<td>Q{{number_format((($producto->precio_producto-(($producto->Venta->DescuentosVentas->porcentaje*$producto->precio_producto)/100))*$producto->cantidad), 2, '.', ',')}}</td>
									</tr>
			  	@else 
			  	<tr>
					<td>{{$producto->NombreProducto->codigo}}-{{$producto->NombreProducto->nombre}}</td>
					<td>{{$producto->cantidad}}</td>
					<td>Q{{number_format($producto->precio_producto, 2, '.', ',')}}</td>
					<td>Q{{number_format(($producto->precio_producto*$producto->cantidad), 2, '.', ',')}}</td>
				</tr>
				@endif
      	 	@endforeach
		

      </tbody>
      <tfoot>
      	<tr>
      		<td colspan="2"></td>
      		<td class="dere mbold">TOTAL</td>
      		<td>Q{{number_format($ventas->total, 2, '.', ',')}}</td>
      	</tr>
      </tfoot>

	</table>
	<table class="ttrop">
		<tbody>
			<tr>
				<td>Documento Tributario Electrónico Según Resolución SAT <strong>{{$ventas->NombreSucursal->resolucion}}</strong> De Fecha: {{$ventas->NombreSucursal->fresolucion}} Serie: {{$ventas->NombreSucursal->serie}} Del 1 Al 1000000 GFACE: INFILE,S.A. NIT: 1252133-7 </td>
			</tr>
			<tr>
				<td><strong>SUJETO A PAGOS TRIMESTRALES</strong></td>
			</tr>
			<tr>
				<td>Cualquier cambio de mercadería  por defecto de producción debe realizarse en los 30 días posteriores a la compra presentando esta factura.</td>
			</tr>
		</tbody>
	</table>
</body>
</html>