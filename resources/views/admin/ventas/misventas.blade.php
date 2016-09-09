@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="MisVentasCtrl">

	{{-- Ventas --}}
	
	 <div class="header_conte">
              <h1>Ventas</h1>
                <div class="btn_nuevo">
                    <a href="{{ URL::to('/minuevaventa') }}">Nueva Venta</a>
                </div>
     </div>
	<div class="col-sm-12">
	   <div class="info_colores">
		      <ul>
		        <li><span class="color_ncom"></span> <p>Venta no completada</p></li>
		        <li><span class="color_tercom"></span> <p>Venta facturada</p></li>
		      </ul>
    </div>
	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
	               <th></th>
	                   <th>No.Factura</th>
	                   <th>Nombre</th>
	                   <th>NIT</th>
                     <th>Dirección</th>
	                   <th>Teléfono</th>
                     <th>Tipo Cliente</th>
                     <th>Total</th>
                     <th>Fecha Factura</th>
	                   <th>Opciones</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="venta in ventas | orderBy:'-id'" ng-class="{'trc_ama':venta.estado_ventas==1}">
	                     <td class="td_first"></td>
                         <td></td>
	                       <td>@{{venta.info_clientes.empresa}}</td>
	                       <td>@{{venta.info_clientes.nit}} </td>
	                       <td>@{{venta.info_clientes.direccion}}</td>
	                       <td>@{{venta.info_clientes.telefono}}</td>
                         <td ng-switch="venta.info_clientes.tipo_cliente">
                           <span ng-switch-when="1">Individual</span>
                           <span ng-switch-when="2">Empresa</span>
                         </td>
                         <td>@{{venta.total | number:2}}</td>
                          <td>@{{venta.fecha_factura  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
	                       <td>
	                           <div class="area_opciones" ng-if="venta.estado_ventas==1">
                                 <ul>
                                     <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Venta No.Fac <strong>@{{venta.id}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(venta.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                 </ul>
                             </div>
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