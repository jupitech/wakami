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
                  @role('admin|operativo') 
           					<li><a href="{{ URL::to('/nuevaventa') }}">Nueva Venta</a></li>
           					<li><a href="{{ URL::to('/clientes') }}">Clientes</a></li>
           					<li><a href="{{ URL::to('/ventas') }}">Listado de ventas</a></li>
           					<li><a href="">Movimiento de ventas</a></li>
                    @endrole
                    @role('vendedor') 
                    <li><a href="{{ URL::to('/minuevaventa') }}">Nueva Venta</a></li>
                    <li><a href="{{ URL::to('/clientes') }}">Clientes</a></li>
                    <li><a href="{{ URL::to('/misventas') }}">Listado de ventas</a></li>
                    @endrole
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_productos"></div>
           				<h1>Productos</h1>
           				<ul>
                  @role('admin|operativo') 
           					<li><a href="{{ URL::to('/productos') }}">Listado de productos</a></li>
           					<li><a href="">Top Productos</a></li>
                  @endrole
                    @role('vendedor')
                      <li><a href="{{ URL::to('/misproductos') }}">Listado de productos</a></li>
                       <li><a href="{{ URL::to('/misucursal') }}">Mi Sucursal</a></li>
                        <li><a href="">Productos de devolución</a></li>
                    @endrole
           				</ul>
           			</div>
           		</div>
                @role('admin|operativo') 
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_sucursales"></div>
           				<h1>Sucursales</h1>
           				<ul>
           					<li><a href="{{ URL::to('/sucursales') }}">Bodega de Sucursales</a></li>
           				</ul>
           			</div>
           		</div>
               @endrole
                 @role('admin|operativo') 
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
                @endrole
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
	           			<div class="ima_mescri ico_reportes"></div>
	           				<h1>Reportes</h1>
	           				<ul>
                     @role('admin|operativo') 
	           					<li><a href="">Reporte de ventas</a></li>
	           					<li><a href="">Reporte de compras</a></li>
	           					<li><a href="">Movimientos</a></li>
                       @endrole
                       @role('vendedor')
                       <li><a href="">Ventas del día</a></li>
                       <li><a href="">Ventas del mes</a></li>
                       <li><a href="">Crecimiento de ventas</a></li>
                        @endrole
	           				</ul>
	           			</div>
           		</div>
               @role('admin|operativo') 
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
	           		<div class="caja_mescri">
	           			<div class="ima_mescri ico_gastos"></div>
	           				<h1>Gastos/Compras</h1>
	           				<ul>
	           					<li><a href="{{ URL::to('/gastos') }}">Gastos</a></li>
	           					<li><a href="{{ URL::to('/compras') }}">Compras</a></li>
                      <li><a href="{{ URL::to('/proveedores')}}">Proveedores</a></li>
	           					<li><a href="">Donaciones</a></li>
	           				</ul>
           			</div>
           		</div>
               @endrole
                 @role('admin|operativo') 
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
                @endrole
           </div>
        </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush
