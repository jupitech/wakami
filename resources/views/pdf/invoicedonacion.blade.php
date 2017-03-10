<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Orden de Devolucion</title>
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
				
				
				<td class="dere">Fecha de donacion: {{$donacion->created_at}}</td>
			</tr>
			<tr>
				<td></td>
				<td class="dere mbold">Orden Donacion #{{$donacion->id}}</td>
			</tr>
		</tbody>
	</table>
	<table class="ttop">
		<tbody>
			<tr>
				   
						<td><strong>PARA : </strong>{{$donacion->para</td>	
				
			</tr>
		</tbody>
	</table>
	<table class="ttop">
	<thead>
		<tr>
			<th>Código</th>
			<th>Producto</th>
			<th>Cantidad</th>
		</tr>
		
	</thead>
	   <?php
                    $productos=\App\Models\ProductoDonacion::with("NombreProducto")->where('id_donacion',$donacion->id)->get();
                    ?>
      <tbody class="tablepro">
   
						@foreach($productos as $producto)
						
					  	<tr>
					  		<td>{{$producto->NombreProducto->codigo}}</td>
							<td>{{$producto->NombreProducto->nombre}}</td>
							<td>{{$producto->cantidad}}</td>
							
						</tr>
					
		      	 	@endforeach
   	 	

      </tbody>
      

	</table>
	
</body>
</html>