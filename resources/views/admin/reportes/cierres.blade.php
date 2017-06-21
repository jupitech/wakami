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
   {{-- Busqueda por fecha especifica --}}
      <div class="col-sm-6 col-md-6 col-lg-6 spi">
                <div class="area_fecha">
                          <form class="form_fecha" name="forma" ng-submit="buscarreporte()">
                            <div class="form-group">
                              
                                  <div class="col-sm-4 spi spd">
                                        <label for="nombreU" class="col-sm-12 spi">Fecha Inicio</label>
                                        <div class="col-sm-12 spi spd">
                                              <input type="date" class="form-control" name="inicio" ng-model="mifecha.inicio" max="mifecha.fin" ng-max="mifecha.fin" required>
                                        </div>
                                        <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="forma.inicio.$error.max">Fecha máxima: @{{mifecha.fin | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 spd">
                                        <label for="nombreU" class="col-sm-12 spi">Fecha Fin</label>
                                        <div class="col-sm-12 spi spd">
                                              <input type="date" class="form-control" name="fin" ng-model="mifecha.fin" required>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 spd top_btn">
                                      <button type="submit" class="btn btn-primary">Buscar</button>
                                  </div>
                            </div>

                          </form>

                      </div>
      </div>
	 <div class="col-sm-12 spd spi">
    
    {{-- Saldos por dia --}}
            <div class="col-sm-12 col-md-12 col-lg-12 spd spi mtop">
              <div class="caja_contenido cajasaldos">
              <div class="col-sm-12 spd spi">
                       <h1>Saldos por sucursal</h1>
                    </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 spd" ng-repeat="sucursal in sucursales | filter:{'codigo_esta':'!1'} " ng-init="reportesucu(sucursal.id)">
                             <h3>@{{sucursal.nombre}}</h3>
                              <highcharts id="chart@{{sucursal.id}}"  chart='@{{renderOdia[sucursal.id]}}'></highcharts>
                             </div>
              </div>
            </div>

              {{-- Depositos por dia --}}
            <div class="col-sm-12 col-md-12 col-lg-12 spd spi mtop">
              <div class="caja_contenido cajasaldos">
              <div class="col-sm-12 spd spi">
                       <h1>Depositos por sucursal</h1>
                    </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 spd" ng-repeat="sucursal in sucursales | filter:{'codigo_esta':'!1'} " ng-init="reportedesucu(sucursal.id)">
                             <h3>@{{sucursal.nombre}}</h3>
                              <highcharts id="chart@{{sucursal.id}}"  chart='@{{renderOdep[sucursal.id]}}'></highcharts>
                             </div>
              </div>
            </div>
   </div>
	  <div class="caja_contenido mtop">
	           <table class="table">
	               <thead>
	                   <th>Sucursal</th>
	                   <th>Usuario</th>
                     <th class="t_100">Efectivo</th>
                     <th class="t_100">Crédito</th>
                     <th>Monto Cierre</th> 
                     <th>Fecha</th>
                     <th>Opciones</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="cierre in cierres">
                        <td ng-click="vercierre(cierre)">@{{ cierre.sucursal.nombre }}</td>
                        <td ng-click="vercierre(cierre)">@{{cierre.perfil_usuario.nombre}} @{{cierre.perfil_usuario.apellido}}</td>
                      
                       <!--  <td ng-click="vercierre(cierre)">Q@{{cierre.saldo_efectivo | number:2}} </td> -->
                          <td class="t_100" colspan="2" ng-click="vercierre(cierre)">
                            <span class="s_100" ng-repeat="pago in cierre.cierre_pago">Q@{{pago.monto_fisico  | number:2}}</span>
                          </td>
                            <td ng-click="vercierre(cierre)">Q@{{cierre.total_saldo | number:2}} </td>
                           
                        <td>@{{cierre.created_at}}</td>
                         <td></td>
                        
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