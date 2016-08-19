@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="VentasCtrl">

	{{-- Ventas --}}
	
	 <div class="header_conte">
              <h1>Ventas</h1>
                <div class="btn_nuevo">
                    <a href="">Nueva Venta</a>
                </div>
     </div>
	<div class="col-sm-12">
	  
	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
	                   <th>No.Factura</th>
	                   <th>Nombre</th>
	                   <th>NIT</th>
                     <th>Dirección</th>
	                   <th>Teléfono</th>
                     <th>Tipo Cliente</th>
	                   <th>Opciones</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="venta in ventas">
                         <td></td>
	                       <td>@{{venta.info_clientes.empresa}}</td>
	                       <td>@{{venta.info_clientes.nit}} </td>
	                       <td>@{{venta.info_clientes.direccion}}</td>
	                       <td>@{{venta.info_clientes.telefono}}</td>
                         <td ng-switch="venta.info_clientes.tipo_cliente">
                           <span ng-switch-when="1">Individual</span>
                           <span ng-switch-when="2">Empresa</span>
                         </td>
	                       <td>
	                          
	                       </td>
	                   </tr>
	                  
	               </tbody>
	           </table>
	      
	  </div>
	</div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush