@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ReporteVentasCtrl" ng-cloak>
	<div class="header_conte">
              <h1>Reporte de Ventas</h1>
     </div>
     <div class="col-sm-12">
       {{-- Busqueda por fecha especifica --}}
     	<div class="col-sm-8 col-md-7 col-lg-6 spi">
     		        <div class="area_fecha">
                          <form class="form_fecha" name="forma" ng-submit="buscarreporte()">
                            <div class="form-group">
                                  <div class="col-sm-5 spi spd">
                                        <label for="nombreU" class="col-sm-12 spi">Fecha Inicio</label>
                                        <div class="col-sm-12 spi spd">
                                              <input type="date" class="form-control" name="inicio" ng-model="mifecha.inicio" max="mifecha.fin" ng-max="mifecha.fin" required>
                                        </div>
                                        <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="forma.inicio.$error.max">Fecha máxima: @{{mifecha.fin | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                  </div>
                                  <div class="col-sm-5 spd">
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
     	<div class="col-sm-6">
     		
     	</div>
      {{-- Analisis de total de ventas --}}
      <div class="ventasdia col-sm-12 spd spi">
          
             {{--    Barra Comparacion ventas y gastos --}}
             <div class="col-sm-2 spi">
               <div class="caja_contenido">
                 <div class="col-sm-12 spd spi">
                       <h1>Ventas/Gastos</h1>
                    </div>
                     <div class="col-sm-12 spd spi">
                           <div class="col-sm-12 col-md-12 col-lg-12 spd">
                             
                              <highcharts chart='@{{renderVentaGasto}}'></highcharts>
                             </div>
                     </div>
               </div>
             </div>
            {{-- Por sucursal --}}
            <div class="col-sm-6  col-md-6 col-lg-6 ">
                  <div class="caja_contenido">
                    <div class="col-sm-12 spd spi">
                       <h1>Total de ventas</h1>
                    </div>
                     <div class="col-sm-12 spd spi">
                     <div class="col-sm-12 col-md-12 col-lg-6 spd">
                     
                      <highcharts chart='@{{renderChart}}'></highcharts>
                     </div>
                     <div class=" col-sm-12 col-md-12 col-lg-6 spd">
                       <div class="total_datos">
                         <table class="table">
                           <tbody>
                               <tr class="t_real">
                               <th>Total real</th>
                               <td>@{{totalventas.mitotal | currency: 'Q'}}</td>
                             </tr>
                              <tr>
                               <td> Costos</td>
                               <td>@{{totalneto.costo | currency: 'Q'}}</td>
                             </tr>
                              <tr>
                               <td> Descuentos</td>
                               <td>@{{descuentosventas.descuentos | currency: 'Q'}}</td>
                             </tr>
                             
                             
                             
                             
                           </tbody>
                         </table>
                       </div>
                     </div>
                     </div>
                   
                    
                  </div>
              </div>
              {{-- Por tipo de pago --}}
              <div class="col-sm-4  col-md-4 col-lg-4 spi spd">
                   <div class="caja_contenido">
                      <div class="col-sm-12 spd spi">
                       <h1>Tipo de pago</h1>
                    </div>
                     <div class="col-sm-12 spd spi">
                           <div class="col-sm-12 col-md-12 col-lg-12 spd">
                             
                              <highcharts chart='@{{renderPago}}'></highcharts>
                             </div>
                     </div>
                   </div>
              </div>
             <div class="col-sm-12 spd spi">
             {{-- Ventas por producto --}}
                   <div class="col-sm-6  col-md-6 col-lg-6 spi mtop">
                       <div class="caja_contenido">
                          <div class="col-sm-12 spd spi">
                           <h1>Ventas por producto</h1>
                        </div>
                         <div class="col-sm-12 spd spi">
                               <div class="col-sm-12 col-md-12 col-lg-12 table_height">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Producto</th>
                                          <th>Cantidad</th>
                                          <th>Total</th>
                                          <th>Costo</th>
                                          <th>Utilidad</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr ng-repeat="producto in vproducto">
                                          <td><span class="label label-success">@{{producto.codigo}}</span> <small>@{{producto.nombre}}</small></td>
                                          <td>@{{producto.cantidad}}</td>
                                          <td class="tot_venta">@{{producto.total  | currency: 'Q'}}</td>
                                           <td>@{{producto.costo  | currency: 'Q'}}</td>
                                           <td>@{{producto.total-producto.costo  | currency: 'Q'}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                 </div>
                         </div>
                       </div>
                  </div>
                     {{-- Ventas por producto --}}
                   <div class="col-sm-6  col-md-6 col-lg-6 spi mtop">
                       <div class="caja_contenido">
                          <div class="col-sm-12 spd spi">
                           <h1>Ventas por linea</h1>
                        </div>
                         <div class="col-sm-12 spd spi">
                               <div class="col-sm-12 col-md-12 col-lg-12 table_height">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Linea de producto</th>
                                          <th>Cantidad</th>
                                          <th>Total</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr ng-repeat="linea in vlinea">
                                          <td>@{{linea.nombre}}</td>
                                          <td>@{{linea.cantidad}}</td>
                                          <td class="tot_venta">@{{linea.total  | currency: 'Q'}}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                 </div>
                         </div>
                       </div>
                  </div>

             </div>

            {{-- Ordenes por dia --}}
            <div class="col-sm-12 col-md-12 col-lg-12 spd spi mtop">
              <div class="caja_contenido">
              <div class="col-sm-12 spd spi">
                       <h1>Ordenes por dia</h1>
                    </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 spd">
                             
                              <highcharts chart='@{{renderOdia}}'></highcharts>
                             </div>
              </div>
            </div>
             {{-- Ordenes por hora --}}
            <div class="col-sm-12 col-md-12 col-lg-12 spd spi mtop">
              <div class="caja_contenido">
              <div class="col-sm-12 spd spi">
                       <h1>Ordenes por hora</h1>
                    </div>
                      <div class="col-sm-12 col-md-12 col-lg-12 spd">
                             
                              <highcharts chart='@{{renderOhora}}'></highcharts>
                             </div>
              </div>
            </div>
      </div>
     </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ReporteVentasCtrl.js"></script>
@endpush