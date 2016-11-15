@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="DevolucionesCtrl">
 {{-- Nueva devolucion --}}
      <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Devolución</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Devolución existente!</strong> Intenta de nuevo con la devolución.</div>
                         <form class="form-horizontal" name="frm" role="form" ng-submit="enviarDevolucion()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                    <label for="name">Hacia:</label>
                                       <ol class="nya-bs-select" ng-model="devolucion.hacia" data-live-search="true"  title="Selecciona hacia bodega..." required>
                                                          <li nya-bs-option="bodega in bodegas" data-value="bodega.id">
                                                            <a>
                                                             <span>
                                                                  @{{ bodega.nombre }}
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                          </ol>
                                        
                                    </div>
                               </div>
                              
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="descripcion">Descripción</label>
                                         <input id="descripcion" type="text" class="form-control" name="descripcion" ng-model="devolucion.descripcion">
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

  {{-- Area devoluciones --}}
               <div id="area_mas" ng-if="mas_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Devolución No.@{{exisDevolucion.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                          <div class="col-sm-12">
                          <div class="col-sm-6 spi">
                              <h3>De sucursal</h3>
                              <h2> @{{exisDevolucion.d_sucursal.nombre}}</h2>
                          </div>
                          <div class="col-sm-6 spd">
                              <h3>Hacia Bodega</h3>
                              <h2  ng-switch="exisDevolucion.hacia">
                                  <span ng-switch-when="3">Central</span>
                               <span ng-switch-when="5">Defectuoso</span>
                              </h2>
                          </div>
                      </div>

                      {{-- Devolución de productos --}}
                      <div class="col-sm-12 middle" ng-if="exisDevolucion.estado_devolucion==1">
                           <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProDevolucion()" >
                                          <div class="form-group">
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                     <label for="cantidad">Cant.</label>
                                                     <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="prodevolucion.cantidad" required>
                                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req.</div>
                                           </div>
                                                </div>
                                                <div class="col-sm-8 col-md-8 col-lg-9">
                                                    <label for="name">Producto</label>
                                                     <ol class="nya-bs-select" ng-model="prodevolucion.id_producto" data-live-search="true"  title="Selecciona un producto..." required  data-size="10">
                                                          <li nya-bs-option="producto in productos" data-value="producto.id">
                                                            <a>
                                                             <span>
                                                              <small class="label label-success">@{{ producto.codigo }}</small>
                                                                  @{{ producto.nombre }}-<strong> Q@{{ producto.costo }} </strong>
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                                        </ol>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-lg-1 spi">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid"><span class="ico_agregar"></span></button>
                                                </div>
                                           </div>
                                     </form>
                      </div>

                         {{-- Productos agregados a devolución --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisDevolucion.estado_devolucion==1">
                      <div class="col-sm-12">
                          <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
                      </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th class="td_opciones">Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="prodevo in prodevolucion">
                                                   <td><small class="label label-success">@{{ prodevo.nombre_producto.codigo }}</small> @{{prodevo.nombre_producto.nombre}}</td>
                                                   <td>@{{prodevo.cantidad}} </td>
                                                   <td class="td_opciones">
                                                       <div class="area_opciones">
                                                           <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(prodevo)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="btn_proeditar()" >
                                                                                       <div class="col-sm-9 ">
                                                                                           <input id="name" type="number" class="form-control" name="nombre" ng-model="existePro.cantidad" min="1" required>
                                                                                       </div>
                                                                                       <div class="col-sm-3 spd spi">
                                                                                        <button type="submit" class="btn_g btn_editarg" ng-disabled="frmed.$invalid"></button>
                                                                                       </div>
                                                                                </form>
                                                                                </div>
                                                                         </li>
                                                               <li class="op_drop"  uib-dropdown>
                                                                     <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                                                     <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                         <div class="col-sm-8 spd">
                                                                           <p>Eliminar <strong>@{{prodevo.nombre_producto.nombre}}</strong></p>
                                                                         </div>
                                                                         <div class="col-sm-4 spd spi">
                                                                           <a href="" ng-click="btn_proeliminar(prodevo.id)" class=" btn_g ico_eliminarg"></a>
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

                       {{-- Totales y Acciones --}}
                      <div class="col-sm-12 footer">
                       
                        <div class="col-sm-12" ng-if="exisDevolucion.estado_devolucion==1 && prodevolucion.length > 0">
                               <form class="form-horizontal" name="frm" role="form" ng-submit="enviarDevolucion()" >
                                          <div class="form-group">
                                              <div class="col-sm-8">
                                                <p class="info_paso"><strong>PASO 1</strong> Envio de los productos para devolver hacia bodega</p>
                                              </div>
                                              <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Enviar Devolución</button>
                                              </div>
                                           </div>
                                     </form>
                        </div>
                       
                        {{-- Estado de Orden 2 --}}
                             <div class="col-sm-8" ng-if="exisDevolucion.estado_devolucion>1 && exisDevolucion.estado_devolucion<4" >
                                   <form class="form-horizontal" name="frm" role="form" ng-submit="finalizarDevolucion()" >
                                              <div class="form-group">
                                                  <div class="col-sm-7">
                                                    <p class="info_paso"><strong>PASO 2</strong> Todos los productos han sido agregados a la bodega</p>
                                                  </div>
                                                  <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Finalizar Devolución</button>
                                                  </div>
                                               </div>
                                         </form>
                            </div>
                           

                      </div>


                    </div>
               </div>               

  {{-- Devoluciones --}}

   <div class="header_conte">
            <h1>Devoluciones</h1>
              <div class="btn_nuevo">
                  <a href="" ng-click="btn_nuevo()">Nueva Devolución</a>
              </div>
   </div>

    <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Devolución nueva</strong> guardado correctamente.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Devolución borrada</strong> No se podrá recuperar los datos.</div> 
   <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Devolución enviadoa</strong> Puedes ver en el listado de devoluciones realizadas.</div>

    <div class="caja_contenido">
                <table class="table">
                 <thead>
                     <th>#</th>
                     <th>De Sucursal</th>
                     <th>Enviado por</th>
                     <th>Fecha Entrega</th>
                     <th>Hacia Bodega</th>
                     <th>Opciones</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="devolucion in devoluciones  | orderBy:'-id'" ng-class="{'trc_ver':devolucion.estado_devolucion==1}">
                        <td ng-click="abrirdevolucion(devolucion)">@{{devolucion.id}}</td>
                          <td  ng-click="abrirdevolucion(devolucion)">@{{devolucion.d_sucursal.nombre}}</td>
                          <td  ng-click="abrirdevolucion(devolucion)">@{{devolucion.d_usuario.nombre}} @{{devolucion.d_usuario.apellido}}</td>
                         <td  ng-click="abrirdevolucion(devolucion)">@{{devolucion.fecha_entrega}}</td>
                          <td  ng-switch="devolucion.hacia">
                              <span ng-switch-when="3">Central</span>
                           <span ng-switch-when="5">Defectuoso</span>
                          </td>
                         <td ng-if="devolucion.estado_devolucion==1">
                             <div class="area_opciones">
                                 <ul>
                                      <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Devolución <strong>#@{{devolucion.id}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(devolucion.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                 </ul>
                             </div>
                         </td>
                          <td ng-if="devolucion.estado_devolucion==2">
                          <small class="label label-success">Realizado</small>
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
    <script src="/js/controller/DevolucionesCtrl.js"></script>
@endpush