@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="MiSucursalCtrl">
    
  {{-- Area de ordenes --}}

     <div id="area_mas" ng-if="abmas_obj">
         <div class="header_nuevo">

                <div class="col-sm-12">
                      <h1>Orden de envio #@{{exisEnvio.id}}</h1>
                      <a class="btn_cerrar" ng-click="btn_cerrarab()"></a>
                </div>
         </div>
         <div class="conte_nuevo">
                  <div class="col-sm-12">
                          <div class="col-sm-12">
                              <div class="col-sm-6 spi">
                                  <h3>Sucursal</h3>
                                  <h2> @{{exisEnvio.nombre_sucursal.nombre}}</h2>
                              </div>
                              <div class="col-sm-6 spd">
                                  <h3>Fecha de entrega</h3>
                                  <h2> @{{exisEnvio.fecha_entrega  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</h2>
                              </div>
                          </div>
                    </div>
         </div>
      
     </div>
  
  {{-- Sucursal --}}


     <div class="header_conte">
              <h1>Mi Sucursal</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nuevo Gasto</a>
                </div>
     </div>
    <div class="col-sm-12"  ng-if="!miusuario.sucursal_usuario.id">
         <div class="caja_contenido">
               <div class="col-sm-12">
                  <h3 class="h3_noasig">No tienes asignado Sucursal a tu usuario, pide al administrador el acceso</h3>
               </div>
           
         </div>
          
     </div>
     <div class="col-sm-12" ng-if="miusuario.sucursal_usuario.id">
               {{-- Todos los envios --}}
              <div class="col-sm-12 spd spi">
                <h4 class="h4_tit">Ordenes de envio</h4>
              </div>
              <div class="col-sm-12 spd spi">
                  <div class="info_colores">
                    <ul>
                      <li><span class="color_ncom"></span> <p>Nuevo Envio</p></li>
                      <li><span class="color_encom"></span> <p>Productos Agregados</p></li>
                      <li><span class="color_falcom"></span> <p>Productos faltantes</p></li>
                      <li><span class="color_tercom"></span> <p>Envio Terminado</p></li>
                    </ul>
                  </div>
                </div> 
              <div class="caja_contenido">
                 <table class="table">
                  <thead>
                              <th></th>
                              <th>#Envio</th>
                               <th>Total</th>
                               <th>Fecha de Entrega</th>
                               <th>Enviado por</th>
                           </thead>
                           <tbody>
                                <tr ng-repeat="envio in misenvios | orderBy:'-id'" ng-class="{'trc_ama':envio.estado_orden==1,'trc_ver':envio.estado_orden==2,'trc_fus':envio.estado_orden==3}">
                                  <td class="td_first"></td>
                                  <td ng-click="abrirorden(envio)"><strong>@{{envio.id}}</strong></td>
                                  <td ng-click="abrirorden(envio)">@{{envio.total_compra | currency: 'Q'}}</td>
                                  <td ng-click="abrirorden(envio)">@{{envio.fecha_entrega | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                                  <td ng-click="abrirorden(envio)">@{{envio.perfil_usuario.nombre}} @{{envio.perfil_usuario.apellido}}</td>
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