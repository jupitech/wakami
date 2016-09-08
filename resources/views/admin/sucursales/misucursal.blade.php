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
                         {{-- Productos para enviar a bodega --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisEnvio.estado_orden>1 && exisEnvio.estado_orden<4">
                        <div class="col-sm-12">
                             <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Producto agregado</strong> a bodega central.</div>
                        </div>
                        <div class="col-sm-12 spd spi">
                          <div class="agre_pro">
                          {{-- Productos pendientes de recibir --}}
                          <h2 ng-if="(proenvios | filter:{estado_producto:3}).length > 0" ><strong>Productos Pendientes de recibir</strong></h2>
                          <table class="table" ng-if="(proenvios | filter:{estado_producto:3}).length > 0">
                             <thead>
                               
                             </thead>
                             <tbody>
                                              <tr  ng-repeat="proenvio in proenvios" ng-if="proenvio.estado_producto==3">
                                              
                                              <form class="form-horizontal" name="frm" role="form">
                                                  <td> <small class="label label-success">@{{proenvio.nombre_producto.codigo}}</small> @{{proenvio.nombre_producto.nombre}}</td>
                                                  <td class="maxtd_long">
                                                      <div class="form-group">
                                                        <div class="col-md-12 spd spi">
                                                             <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="proenvio.pendiente_producto.cantidad"  ng-init="maxcantidad = proenvio.pendiente_producto.cantidad" min="0" max="@{{maxcantidad}}" required>
                                                             <div class="col-sm-12 spd spi">
                                                                <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req</div>
                                                             </div>
                                                              <input type="hidden" ng-model="proenvio.id_producto"/>
                                                              <input type="hidden" ng-model="proenvio.id_orden"/>
                                                              <input type="hidden" ng-model="proenvio.id"/>
                                                        </div>
                                                   </div>
                                                  </td>
                                                  <td>
                                                
                                                     <div class="op_elim">
                                                          <a href="" class="btn_delitem" id="simple-dropdown"><span class="ico_del" ng-click="btn_proeliminar2(proenvio.id)"></span></a>
                                                     </div>
                                                      <div class="op_elim">
                                                          <a href="" class="btn_additem" id="simple-dropdown" ng-disabled="frm.$invalid"  ng-click="agregarProBodegaPen(proenvio)"><span class="ico_check"></span></a>
                                                     </div>

                                                   
                                                  </td>

                                              </form>
                                            </tr>
                             </tbody>
                          </table>

                            {{-- Productos agregados y por agregar --}}
                          <table  class="table">
                           <thead>
                                           <tr>
                                           <th rowspan="2">Producto</th>
                                             <th colspan="2">Cantidad</th>
                                             <th rowspan="2">Opciones</th>
                                           </tr>
                                            <th>Ent 1</th>
                                            <th>Ent 2</th>
                                           <tr>
                                             
                                           </tr>
                                              
                           </thead>
                            <tbody>
                              <tr  ng-repeat="proenvio in proenvios" ng-if="proenvio.estado_producto==1">
                                <form class="form-horizontal" name="frm" role="form">
                                    <td> <small class="label label-success">@{{proenvio.nombre_producto.codigo}}</small> @{{proenvio.nombre_producto.nombre}}</td>
                                    <td class="maxtd_long">
                                        <div class="form-group">
                                          <div class="col-md-12 spd spi">
                                               <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="proenvio.cantidad"  ng-init="maxcantidad = proenvio.cantidad" min="0" max="@{{maxcantidad}}" required>
                                               <div class="col-sm-12 spd spi">
                                                  <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req</div>
                                               </div>
                                                <input type="hidden" ng-model="proenvio.id_producto"/>
                                                <input type="hidden" ng-model="proenvio.id_orden"/>
                                                <input type="hidden" ng-model="proenvio.id"/>
                                          </div>
                                     </div>
                                    </td>
                                    <td></td>
                                    <td>
                                  
                                       <div class="op_elim">
                                            <a href="" class="btn_delitem" id="simple-dropdown"><span class="ico_del" ng-click="btn_proeliminar2(proenvio.id)"></span></a>
                                       </div>
                                        <div class="op_elim">
                                            <a href="" class="btn_additem" id="simple-dropdown" ng-disabled="frm.$invalid"  ng-click="agregarProBodega(proenvio)"><span class="ico_check"></span></a>
                                       </div>

                                     
                                    </td>

                                </form>
                              </tr>
                              <tr ng-repeat="proenvio in proenvios" ng-if="proenvio.estado_producto!=1" class="fondo_acep">
                                <td> <small class="label label-success">@{{proenvio.nombre_producto.codigo}}</small> @{{proenvio.nombre_producto.nombre}} <small class="label label-primary">Q@{{proenvio.nombre_producto.preciop | number:2}}</small></td>
                                <td>@{{proenvio.cantidad}}</td>
                                <td>@{{proenvio.pendiente_producto.cantidad}}</td>
                                <td>En bodega</td>
                              </tr>
                            </tbody>
                          </table>
                     
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