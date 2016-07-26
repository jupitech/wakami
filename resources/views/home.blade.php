@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
        <div class="col-md-12 top_conte">
           <div class="menu_escritorio">
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_ventas"></div>
           				<h1>Ventas</h1>
           				<ul>
           					<li><a href="">Ventas del dia</a></li>
           					<li><a href="">Clientes</a></li>
           					<li><a href="">Listado de ventas</a></li>
           					<li><a href="">Movimiento de ventas</a></li>
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_productos"></div>
           				<h1>Productos</h1>
           				<ul>
           					<li><a href="">Listado de productos</a></li>
           					<li><a href="">Top Productos</a></li>
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_sucursales"></div>
           				<h1>Sucursales</h1>
           				<ul>
           					<li><a href="">Bodega de Sucursales</a></li>
           					<li><a href="">Asignar Usuarios</a></li>
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_bodegas"></div>
           				<h1>Bodegas</h1>
           				<ul>
           					<li><a href="">Consignación</a></li>
           					<li><a href="">Movimiento entre bodegas</a></li>
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
	           			<div class="ima_mescri ico_reportes"></div>
	           				<h1>Reportes</h1>
	           				<ul>
	           					<li><a href="">Reporte de ventas</a></li>
	           					<li><a href="">Reporte de compras</a></li>
	           					<li><a href="">Movimientos</a></li>
	           				</ul>
	           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
	           		<div class="caja_mescri">
	           			<div class="ima_mescri ico_gastos"></div>
	           				<h1>Gastos/Compras</h1>
	           				<ul>
	           					<li><a href="">Gastos</a></li>
	           					<li><a href="">Compras</a></li>
                      <li><a href="{{ URL::to('/proveedores')}}">Proveedores</a></li>
	           					<li><a href="">Donaciones</a></li>
	           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
		           		<div class="caja_mescri">
		           			<div class="ima_mescri ico_configuraciones"></div>
		           				<h1>Configuraciones</h1>
		           				<ul>
		           					<li><a href="{{ URL::to('/usuarios') }}">Usuarios</a></li>
		           					<li><a href="">Parametros Generales</a></li>
		           					<li><a href="">Accesos</a></li>
		           				</ul>
		           			</div>
           		</div>
           </div>
        </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush
