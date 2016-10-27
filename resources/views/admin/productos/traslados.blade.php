@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="TrasladosCtrl">
 {{-- Nuevo traslado --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nuevo Traslado</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                        <form class="form-horizontal" name="frm" role="form" ng-submit="enviarTraslado()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                    <label for="name">Enviar a:</label>
                                       <ol class="nya-bs-select" ng-model="traslado.a_sucursal" data-live-search="true"  title="Selecciona una sucursal..." required>
                                                          <li nya-bs-option="sucursal in sucursales" data-value="sucursal.id">
                                                            <a>
                                                             <span>
                                                                  @{{ sucursal.nombre }}
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                          </ol>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-sm-12">
                                       <ol class="nya-bs-select" ng-model="traslado.id_producto" data-live-search="true"  title="Selecciona un producto..." required>
                                                          <li nya-bs-option="producto in productos" data-value="producto.id_producto">
                                                            <a>
                                                             <span>
                                                              <small class="label label-success">@{{ producto.nombre_producto.codigo }}</small>
                                                                  @{{ producto.nombre_producto.nombre }}-<strong> Q@{{ producto.nombre_producto.preciop | number:2 }} </strong>
                                                                   <small class="label label-info">Stock @{{ producto.stock }}</small>
                                                                  <small class="label label-gris">@{{ producto.nombre_producto.codigo_barra }}</small>
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                                        </ol>
                                  </div>
                               </div>
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Cantidad</label>
                                         <input id="name" type="number" class="form-control" name="cantidad" ng-model="traslado.cantidad">
                                    </div>
                               </div>
                               
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">ENVIAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

  {{-- Traslados --}}

   <div class="header_conte">
            <h1>Traslados</h1>
              <div class="btn_nuevo">
                  <a href="" ng-click="btn_nuevo()">Nuevo Traslado</a>
              </div>
   </div>

    <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Traslado nuevo</strong> guardado correctamente.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Traslado borrado</strong> No se podrá recuperar los datos.</div> 
   <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Traslado enviado</strong> Puedes ver en el listado de traslados realizadas.</div>
    <div class="col-sm-12 spd spi">
          <h4 class="h4_tit">Traslados recibidos</h4>
    </div>
    <div class="caja_contenido">
             <table class="table">
                 <thead>
                     <th>#</th>
                     <th>De Sucursal</th>
                     <th>Producto</th>
                     <th>Cantidad</th>
                     <th>Fecha Entrega</th>
                     <th>Enviado por</th>
                     <th>Recibido por</th>
                     <th>Opciones</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="traslado in trasladosre  | orderBy:'-id'" ng-class="{'trc_ver':traslado.estado_traslado==1}">
                        <td>@{{traslado.id}}</td>
                          <td>@{{traslado.ha_sucursal.nombre}}</td>
                         <td>@{{traslado.nombre_producto.nombre}} </td>
                         <td>@{{traslado.cantidad}}</td>
                         <td>@{{traslado.fecha_entrega}}</td>
                          <td>@{{traslado.d_usuario.nombre}} @{{traslado.d_usuario.apellido}}</td>
                         <td>@{{traslado.ha_usuario.nombre}} @{{traslado.ha_usuario.apellido}}</td>
                         <td ng-if="traslado.estado_traslado==1">
                             <div class="area_opciones">
                                 <ul>
                                       <li class="ed_drop"  uib-dropdown>
                                           <a href="" class="ico_traslado" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Traslado de <strong>@{{traslado.nombre_producto.nombre}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_trasladar(traslado.id)" class=" btn_g btn_traslado"></a>
                                               </div>
                                            </div>
                                     </li>
                                      <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Traslado de <strong>@{{traslado.nombre_producto.nombre}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(traslado.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                 </ul>
                             </div>
                         </td>
                          <td ng-if="traslado.estado_traslado==2">
                          <small class="label label-success">Realizado</small>
                          </td>
                     </tr>
                    
                 </tbody>
             </table>
        
    </div>
    <div class="col-sm-12 spd spi">
          <h4 class="h4_tit">Traslados enviados</h4>
    </div>

     <div class="caja_contenido">
             <table class="table">
                 <thead>
                 <th>#</th>
                     <th>A Sucursal</th>
                     <th>Producto</th>
                     <th>Cantidad</th>
                     <th>Fecha Entrega</th>
                     <th>Enviado por</th>
                     <th>Opciones</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="traslado in trasladosen | orderBy:'-id'" ng-class="{'trc_ver':traslado.estado_traslado==1}">
                         <td><strong>@{{traslado.id}}</strong></td>
                         <td>@{{traslado.ha_sucursal.nombre}}</td>
                         <td>@{{traslado.nombre_producto.nombre}} </td>
                         <td>@{{traslado.cantidad}}</td>
                         <td>@{{traslado.fecha_entrega}}</td>
                         <td>@{{traslado.d_usuario.nombre}} @{{traslado.d_usuario.apellido}}</td>
                         <td>
                             <div class="area_opciones">
                                 <ul>
                                     <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Traslado de <strong>@{{traslado.nombre_producto.nombre}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(traslado.id)" class=" btn_g ico_eliminarg"></a>
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
    <script src="/js/controller/TrasladosCtrl.js"></script>
@endpush