@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="CierresCtrl" ng-cloak>
	
	
	{{-- Cierres --}}
	
	 <div class="header_conte">
              <h1>Cierres</h1>
     </div>
	<div class="col-sm-12">
	 <div class="col-sm-12 spd spi">
    
    <div class="col-sm-6">
        <div class="porusuario" ng-repeat="saldo in saldos">
              <div class="col-sm-6">Saldo @{{saldo.sucursal.nombre}}</div>
              <div class="col-sm-6">Q@{{saldo.efectivo | number:2}}</div>
        </div>
    </div>
   </div>
	  <div class="caja_contenido mtop">
	           <table class="table">
	               <thead>
	                   <th>Sucursal</th>
	                   <th>ID</th>
	                   <th>Usuario</th>
	                   <th>Monto Cierre</th>
	                   <th>Saldo Efectivo</th>    
                     <th>Crédito/Deposito</th>
                     <th>Fecha</th>
                     <th>Tipo de Cierre</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="cierre in cierres">
                        <td ng-click="vercierre(cierre)">@{{ cierre.sucursal.nombre }}</td>
                        <td ng-click="vercierre(cierre)">@{{ cierre.id }}</td>
                        <td ng-click="vercierre(cierre)">@{{cierre.perfil_usuario.nombre}} @{{cierre.perfil_usuario.apellido}}</td>
                        <td ng-click="vercierre(cierre)">Q@{{cierre.total_saldo | number:2}} </td>
                        <td ng-click="vercierre(cierre)">Q@{{cierre.saldo_efectivo | number:2}} </td>
                          <td ng-click="vercierre(cierre)">Q@{{cierre.total_saldo-cierre.saldo_efectivo | number:2}} </td>
                        <td>@{{cierre.created_at}}</td>
                        <td>
                          <p ng-if="cierre.estado_caja == 1">Mandado a Saldo</p>
                          <p ng-if="cierre.estado_caja == 2">Depositado</p>
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
    <script src="/js/controller/CierresCtrl.js"></script>
@endpush