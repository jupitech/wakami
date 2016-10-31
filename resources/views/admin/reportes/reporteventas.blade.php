@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ReporteVentasCtrl">
	<div class="header_conte">
              <h1>Reporte de Ventas</h1>
     </div>
     <div class="col-sm-12">
       {{-- Busqueda por fecha especifica --}}
     	<div class="col-sm-8 col-md-7 col-lg-6 spi">
     		        <div class="area_fecha">
                          <form class="form_fecha" name="forma" ng-submit="buscarOrden()">
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
                                              <input type="date" class="form-control" name="fin" ng-model="mifecha.fin" max="hoy" ng-max="hoy" required>
                                        </div>
                                        <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="forma.fin.$error.max">Fecha máxima hoy: @{{hoy | amDateFormat:'DD/MM/YYYY'}}</span>
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
            {{-- Por sucursal --}}
            <div class="col-sm-6  col-md-6 col-lg-5 spi">
                  <div class="caja_contenido">
                    <div class="col-sm-12 spd spi">
                       <h1>Total de ventas</h1>
                    </div>
                     <div class="col-sm-12 spd spi">
                     <div class="col-sm-12 col-md-12 col-lg-7 spd">
                     
                      <highcharts chart='@{{renderChart}}'></highcharts>
                     </div>
                     <div class=" col-sm-12 col-md-12 col-lg-5 spd">
                       
                     </div>
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