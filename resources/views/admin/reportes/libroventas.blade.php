@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ReporteVentasCtrl" ng-cloak>
	<div class="header_conte">
              <h1>Libro de Ventas</h1>
     </div>
     <div class="col-sm-12">
       {{-- Busqueda por fecha especifica --}}
     	<div class="col-sm-8 col-md-8 col-lg-8 spi">
     		        <div class="area_fecha">
                          <form class="form_fecha" name="forma" ng-submit="buscarreportel()">
                            <div class="form-group">
                                  <div class="col-sm-4 spi">
                                     <label for="nombreU" class="col-sm-12 spi">Sucursal</label>
                                      <ol class="ol_peq nya-bs-select" ng-model="mifecha.sucursal" title="Selecciona una sucursal..." required  data-size="10">
                                                          <li nya-bs-option="sucursal in sucursales" data-value="sucursal.id">
                                                            <a>
                                                             <span>
                                                                  @{{ sucursal.nombre}}
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                        </ol>
                                  </div>
                                  <div class="col-sm-3 spi spd">
                                        <label for="nombreU" class="col-sm-12 spi">Fecha Inicio</label>
                                        <div class="col-sm-12 spi spd">
                                              <input type="date" class="form-control" name="inicio" ng-model="mifecha.inicio" max="mifecha.fin" ng-max="mifecha.fin" required>
                                        </div>
                                        <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="forma.inicio.$error.max">Fecha máxima: @{{mifecha.fin | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                  </div>
                                  <div class="col-sm-3 spd">
                                        <label for="nombreU" class="col-sm-12 spi">Fecha Fin</label>
                                        <div class="col-sm-12 spi spd">
                                              <input type="date" class="form-control" name="fin" ng-model="mifecha.fin" required>
                                        </div>
                                  </div>
                                  <div class="col-sm-2 spd top_btn">
                                      <button type="submit" class="btn btn-primary">Buscar</button>
                                  </div>
                            </div>

                          </form>

                      </div>
     	</div>
     	<div class="col-sm-4 spd">
      <div class="mtop btn_seg">
          <a ng-click="exportData()"><span class="glyphicon glyphicon-save"></span> A Excel</a>
      </div>
     		    
     	</div>
         
            <div  id="exportable" class="caja_contenido mtop">
             <table class="table">
                 <thead>
                     <th>Estado</th>       
                     <th>Fecha Factura</th>
                     <th>No.Factura</th>
                     <th>Pago</th>
                     <th>Nombre</th>
                     <th>NIT</th>
                     <th>Total</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="venta in fventas =(ventasl | filter: query )" ng-class="{'trc_ama':venta.estado_ventas==1,'trc_ver':venta.estado_ventas==3,'trc_fca':venta.estado_ventas==4}">
                         <td  ng-switch="venta.estado_ventas">
                              <span ng-switch-when="2" >Completada</span>
                               <span ng-switch-when="3">Crédito</span>
                               <span ng-switch-when="4">Cancelada</span>
                         </td>
                        <td>@{{venta.fecha_factura  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                         <td ng-click="abrirventa(venta)"><small>@{{venta.dte}}</small></td>

                        
                          <td ng-click="abrirventa(venta)" ng-switch="venta.pago_venta.tipo_pago">
                               <span ng-switch-when="1" class="ico_td ico_pefectivo">Efectivo</span>
                               <span ng-switch-when="2" class="ico_td ico_ppos">POS</span>
                               <span ng-switch-when="3" class="ico_td ico_pcheque">Cheque</span>
                               <span ng-switch-when="4" class="ico_td ico_pcredito">Crédito</span>
                               <span ng-switch-when="5" class="ico_td ico_pdeposito">Deposito</span>
                         </td>
                         <td ng-click="abrirventa(venta)">@{{venta.info_clientes.nombre}} <small>@{{venta.info_clientes.empresa}}</small></td>
                         <td ng-click="abrirventa(venta)">@{{venta.info_clientes.nit}} </td>
                         <td class="tot_venta" ng-click="abrirventa(venta)"><span ng-if="venta.estado_ventas!=4">@{{venta.total | currency: 'Q'}}</span><span ng-if="venta.estado_ventas==4">Q 0.00</span></td>

                          
                      
                     </tr>
                     <tr>
                       <th colspan="5"></th>
                       <th><strong>Total</strong></th>
                       <th><strong>@{{sumatotal | currency: 'Q'}}</strong></th>
                       <th></th>
                     </tr>
                      <tr>
                       <th colspan="5"></th>
                       <th><strong>Total S/IVA</strong></th>
                       <th><strong>Q@{{(sumatotal)/1.12 | number:2}}</strong></th>
                       <th></th>
                     </tr>
                       <tr>
                       <th colspan="5"></th>
                       <th><strong>IVA</strong></th>
                       <th><strong>Q@{{(sumatotal)-((sumatotal)/1.12) | number:2}}</strong></th>
                       <th></th>
                     </tr>
                    
                 </tbody>
             </table>
        
    </div> 

     </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ReporteVentasCtrl.js"></script>
@endpush