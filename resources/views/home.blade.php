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
                  @role('admin|operativo|developer') 
           					<li><a href="{{ URL::to('/nuevaventa') }}">Nueva Venta</a></li>
           					<li><a href="{{ URL::to('/clientes') }}">Clientes</a></li>
           					<li><a href="{{ URL::to('/ventas') }}">Listado de ventas</a></li>
                    <li><a href="{{ URL::to('/promociones') }}">Promociones</a></li>
           					<li><a href="">Movimiento de ventas</a></li>
                    @endrole
                    @role('vendedor') 
                    <li><a href="{{ URL::to('/minuevaventa') }}">Nueva Venta</a></li>
                    <li><a href="{{ URL::to('/clientessu') }}">Clientes</a></li>
                    <li><a href="{{ URL::to('/misventas') }}">Listado de ventas</a></li>
                     <li><a href="{{ URL::to('/cierrecaja') }}">Cierre de Caja</a></li>
                    @endrole
           				</ul>
           			</div>
           		</div>
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_productos"></div>
           				<h1>Productos</h1>
           				<ul>
                  @role('admin|operativo|developer') 
           					<li><a href="{{ URL::to('/productos') }}">Listado de productos</a></li>
           					 <li><a href="{{ URL::to('/inventariocon') }}">Inventario Consolidado</a></li>
                    <li><a href="{{ URL::to('/devoluciones') }}">Devoluciones</a></li>
                  @endrole
                    @role('vendedor')
                      <li><a href="{{ URL::to('/misproductos') }}">Listado de productos</a></li>
                       <li><a href="{{ URL::to('/misucursal') }}">Mi Sucursal</a></li>
                         <li><a href="{{ URL::to('/traslados') }}">Traslados</a></li>
                        <li><a href="{{ URL::to('/misdevoluciones') }}">Devoluciones</a></li>
                    @endrole
           				</ul>
           			</div>
           		</div>
                @role('admin|operativo|developer') 
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_sucursales"></div>
           				<h1>Sucursales</h1>
           				<ul>
           					<li><a href="{{ URL::to('/sucursales') }}">Bodega de Sucursales</a></li>
                       <li><a href="{{ URL::to('/cierres') }}">Cierres Sucursales</a></li>
           				</ul>
           			</div>
           		</div>
               @endrole
                 @role('admin|operativo|developer') 
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
           				<div class="ima_mescri ico_bodegas"></div>
           				<h1>Consignación</h1>
           				<ul>
           					<li><a href="{{ URL::to('/consignacion') }}">Consignación</a></li>
           				</ul>
           			</div>
           		</div>
                @endrole
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
           			<div class="caja_mescri">
	           			<div class="ima_mescri ico_reportes"></div>
	           				<h1>Reportes</h1>
	           				<ul>
                     @role('admin|operativo|developer') 
	           					<li><a href="{{ URL::to('/reporteventas') }}">Reporte de ventas</a></li>
                       <li><a href="{{ URL::to('/libroventas') }}">Libro de Ventas</a></li>
                        <li><a href="{{ URL::to('/cuentascobrar') }}">Cuentas por cobrar</a></li>

                       @endrole
                       @role('vendedor')
                       <li><a href="">Ventas del día</a></li>
                       <li><a href="">Ventas del mes</a></li>
                       <li><a href="">Crecimiento de ventas</a></li>
                        @endrole
	           				</ul>
	           			</div>
           		</div>
               @role('admin|operativo|developer') 
           		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
	           		<div class="caja_mescri">
	           			<div class="ima_mescri ico_gastos"></div>
	           				<h1>Gastos/Compras</h1>
	           				<ul>
	           					<li><a href="{{ URL::to('/gastos') }}">Gastos</a></li>
	           					<li><a href="{{ URL::to('/compras') }}">Compras</a></li>
                      <li><a href="{{ URL::to('/proveedores')}}">Proveedores</a></li>
	           					<li><a href="{{ URL::to('/donaciones') }}">Donaciones</a></li>
	           				</ul>
           			</div>
           		</div>
               @endrole
                 @role('admin|operativo|developer') 
                 		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
      		           		<div class="caja_mescri">
      		           			<div class="ima_mescri ico_configuraciones"></div>
      		           				<h1>Configuraciones</h1>
      		           				<ul>
      		           					<li><a href="{{ URL::to('/usuarios') }}">Usuarios</a></li>
                              @role('developer')
                                <li><a href="{{ URL::to('/developer') }}">Developer</a></li>
                              @endrole
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