@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="PromocionesCtrl" ng-cloak>
	 {{-- Nueva Promocion --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Promoción</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Promoción existente!</strong> Intenta de nuevo con otro nombre de promocion.</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarPromocion()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="promocion.nombre" placeholder="Nombre de la promoción" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="tipo_promocion">Tipo de promoción</label>
                                       <ol class="nya-bs-select" ng-model="promocion.tipo_promocion" title="Selecciona una promocion..." required>
                                            <li nya-bs-option="tipopro in tipopromocion" data-value="tipopro.id">
                                              <a>
                                                @{{ tipopro.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   
                               </div>
								 <div class="form-group" ng-if="promocion.tipo_promocion==1">
                                    <div class="col-md-12">
                                        <label for="por_cantidad">Por cantidad</label>
                                         <input id="por_cantidad" type="number" class="form-control" name="por_cantidad" ng-model="promocion.por_cantidad" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.por_cantidad.$dirty && frm.por_cantidad.$error.required">Campo requerido</div>
                                         </div>
                                    </div>
                 </div>
								 <div class="form-group" ng-if="promocion.tipo_promocion==2">
                                  <div class="col-md-6">
                                       <label for="nombre">Por Producto</label>
                                       <ol class="nya-bs-select" ng-model="promocion.id_producto" data-live-search="true" title="Selecciona un producto..."  data-size="10" required>
                                            <li nya-bs-option="producto in productos" data-value="producto.id">
                                              <a>
                                                <span><small class="label label-success">@{{ producto.codigo }}</small>@{{ producto.nombre }}</span>
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="porcentaje_producto">% Producto</label>
                                       <input id="porcentaje_producto" type="text" class="form-control" name="porcentaje_producto" ng-model="promocion.porcentaje_producto"  required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.porcentaje_producto.$dirty && frm.porcentaje_producto.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                   </div>	

                 <div class="form-group" ng-if="promocion.tipo_promocion==3">
                                  <div class="col-md-6">
                                       <label for="nombre">Por Linea</label>
                                       <ol class="nya-bs-select" ng-model="promocion.id_linea" data-live-search="true" title="Selecciona una linea..." data-size="10"  required>
                                            <li nya-bs-option="linea in lineas" data-value="linea.id">
                                              <a>
                                                @{{ linea.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="porcentaje_linea">% Producto</label>
                                       <input id="porcentaje_linea" type="text" class="form-control" name="promocion.porcentaje_linea" ng-model="promocion.porcentaje_linea" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.porcentaje_linea.$dirty && frm.porcentaje_linea.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                   </div>


                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="email">Fecha Inicio</label>
                                           <input type="date" class="form-control" name="inicio" ng-model="promocion.fecha_inicio" max="promocion.fecha_fin" ng-max="promocion.fecha_fin" required>
                                            <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="frm.inicio.$error.max">Fecha máxima: @{{promocion.fecha_fin | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label for="email">Fecha Fin</label>
                                           <input type="date" class="form-control" name="fin" ng-model="promocion.fecha_fin" max="hoy" ng-max="hoy" required>
                                            <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="frm.fin.$error.max">Fecha máxima: @{{hoy | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                    </div>
                               </div>
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">GUARDAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

   {{-- Editar promoción --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Promoción @{{existePromo.empresa}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Proveedor existente!</strong> Intenta de nuevo con otro proveedor cambiando NIT</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="editarPromocion()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existePromo.nombre" placeholder="Nombre de la promoción" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="tipo_promocion">Tipo de promoción</label>
                                       <ol class="nya-bs-select" ng-model="existePromo.tipo_promocion" title="Selecciona una promocion..." required>
                                            <li nya-bs-option="tipopro in tipopromocion" data-value="tipopro.id">
                                              <a>
                                                @{{ tipopro.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   
                               </div>
                 <div class="form-group" ng-if="promocion.tipo_promocion==1">
                                    <div class="col-md-12">
                                        <label for="por_cantidad">Por cantidad</label>
                                         <input id="por_cantidad" type="number" class="form-control" name="por_cantidad" ng-model="existePromo.por_cantidad" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.por_cantidad.$dirty && frm.por_cantidad.$error.required">Campo requerido</div>
                                         </div>
                                    </div>
                 </div>
                 <div class="form-group" ng-if="promocion.tipo_promocion==2">
                                  <div class="col-md-6">
                                       <label for="nombre">Por Producto</label>
                                       <ol class="nya-bs-select" ng-model="existePromo.id_producto" data-live-search="true" title="Selecciona un producto..."  data-size="10" required>
                                            <li nya-bs-option="producto in productos" data-value="producto.id">
                                              <a>
                                                <span><small class="label label-success">@{{ producto.codigo }}</small>@{{ producto.nombre }}</span>
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="porcentaje_producto">% Producto</label>
                                       <input id="porcentaje_producto" type="text" class="form-control" name="porcentaje_producto" ng-model="existePromo.porcentaje_producto"  required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.porcentaje_producto.$dirty && frm.porcentaje_producto.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                   </div> 

                 <div class="form-group" ng-if="promocion.tipo_promocion==3">
                                  <div class="col-md-6">
                                       <label for="nombre">Por Linea</label>
                                       <ol class="nya-bs-select" ng-model="existePromo.id_linea" data-live-search="true" title="Selecciona una linea..." data-size="10"  required>
                                            <li nya-bs-option="linea in lineas" data-value="linea.id">
                                              <a>
                                                @{{ linea.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="porcentaje_linea">% Producto</label>
                                       <input id="porcentaje_linea" type="text" class="form-control" name="existePromo.porcentaje_linea" ng-model="promocion.porcentaje_linea" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.porcentaje_linea.$dirty && frm.porcentaje_linea.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                   </div>


                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="email">Fecha Inicio</label>
                                           <input type="date" class="form-control" name="inicio" data-date-format="dd/mm/yyyy" ng-model="existePromo.fini" ng-init="existePromo.fini=Mdate(existePromo.fecha_inicio)" max="existePromo.fecha_fin" ng-max="existePromo.fecha_fin" required>
                                            <div class="col-sm-12 spi spd">
                                            <span class="label label-danger" ng-show="frm.inicio.$error.max">Fecha máxima: @{{existePromo.fecha_fin | amDateFormat:'DD/MM/YYYY'}}</span>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label for="email">Fecha Fin</label>
                                           <input type="date" class="form-control" name="fin" ng-model="existePromo.ffin" max="hoy" ng-max="hoy" data-date-format="dd/mm/yyyy" ng-init="existePromo.ffin=Fdate(existePromo.fecha_fin)"required>
                                    </div>
                               </div>
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frmed.$invalid">GUARDAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_editar()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

	
	{{-- Promociones --}}
	
	 <div class="header_conte">
              <h1>Promociones</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nueva Promoción</a>
                </div>
     </div>
	<div class="col-sm-12">
	   <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Promoción nueva</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Promoción borrada</strong> No se podrá recuperar los datos.</div>	
	 <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Promoción editada</strong> Puedes ver en el listado de promociones las modificaciones realizadas.</div>

	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
	                   <th>Nombre</th>
	                   <th>Promoción</th>
	                   <th>En el producto #</th>
	                   <th>Producto</th>
	                   <th>Linea</th>
	                   <th>Fecha Inicio</th>
	                   <th>Fecha Fin</th>
	                   <th>Opciones</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="promocion in promociones">
	                       <td>@{{promocion.nombre}}</td>
	                       <td ng-switch="promocion.tipo_promocion">
                               <span  ng-switch-when="1">Por Cantidad</span>
                               <span  ng-switch-when="2">Por Producto</span>
                               <span  ng-switch-when="3">Por Linea</span>
                         </td>
                         <td>@{{promocion.por_cantidad}} </td>
	                       <td><span ng-if="promocion.id_producto>0"><small class="label label-success"> @{{promocion.nombre_producto.codigo}}</small>@{{promocion.nombre_producto.nombre}}-@{{promocion.porcentaje_producto}}%</span></td>
	                       <td><span ng-if="promocion.id_linea>0">@{{promocion.nombre_linea.nombre}}-@{{promocion.porcentaje_linea}}%</span></td>
	                       <td>@{{promocion.fecha_inicio}}</td>
	                       <td>@{{promocion.fecha_fin}}</td>
	                       <td>
	                           <div class="area_opciones">
	                               <ul>
	                                   <li><a href="" class="ico_editar" ng-click="btn_editar(promocion)"></a></li>
	                                   <li class="op_drop"  uib-dropdown>
	                                         <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
	                                         <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
	                                             <div class="col-sm-8 spd">
	                                               <p>Eliminar <strong>@{{promocion.nombre}}</strong></p>
	                                             </div>
	                                             <div class="col-sm-4 spd spi">
	                                               <a href="" ng-click="btn_eliminar(promocion.id)" class=" btn_g ico_eliminarg"></a>
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
    <script src="/js/controller/PromocionesCtrl.js"></script>
@endpush