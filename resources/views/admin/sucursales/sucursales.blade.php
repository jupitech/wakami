@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
  <div class="col-md-12 top_conte" ng-controller="SucursalesCtrl">
{{-- Nueva Sucursal --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Sucursal</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Sucursal existente!</strong> Intenta de nuevo con otro nombre de sucursal.</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarSucursal()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="sucursal.nombre" placeholder="Nombre de la sucursal" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="ubicacion">Ubicación</label>
                                       <input id="ubicacion" type="text" class="form-control" name="ubicacion" ng-model="sucursal.ubicacion" placeholder="Direccion de la ubicacion" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.ubicacion.$dirty && frm.ubicacion.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                  
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado</label>
                                       <ol class="nya-bs-select" ng-model="sucursal.id_user" title="Selecciona un usuario...">
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id'" data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

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

 {{-- Editar sucursales --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Sucursal @{{existeSucu.nombrer}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Sucursal existente!</strong> Intenta de nuevo con nombre</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarSucursal()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existeSucu.nombre" placeholder="Nombre de la sucursal" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="ubicacion">Ubicación</label>
                                       <input id="ubicacion" type="text" class="form-control" name="ubicacion" ng-model="existeSucu.ubicacion" placeholder="Direccion de la ubicacion" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.ubicacion.$dirty && frm.ubicacion.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                  
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado</label>
                                       <ol class="nya-bs-select" ng-model="existeSucu.id_user" title="Selecciona un usuario...">
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id'" data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

                                  </div>
                                  </div>
                              
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frmed.$invalid">EDITAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_editar()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>
{{-- Area sucursal --}}
               <div id="area_mas" ng-if="mas_obj">
               		 <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Sucursal @{{exisSucursal.nombre}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
                    </div>
                     <div class="conte_nuevo">
                     	<div class="col-sm-12">
                          <div class="col-sm-6 spi">
                              <h3>Ubicación</h3>
                              <h2> @{{exisSucursal.nombre}}</h2>
                          </div>
                          <div class="col-sm-6 spd">
                              <h3>Usuario Asignado</h3>
                              <h2> @{{exisSucursal.perfil_usuario.nombre}} @{{exisSucursal.perfil_usuario.apellido}}</h2>
                          </div>
                      </div>
                      <div class="col-sm-12 middle">
                      			<form class="form-horizontal" name="frm" role="form" ng-submit="guardarProSucursal()" >
                                          <div class="form-group">
                                           
                                                <div class="col-sm-8 col-md-8 col-lg-9">
                                                    <label for="name">Producto</label>
                                                     <ol class="nya-bs-select" ng-model="prosucursal.id_producto" data-live-search="true"  title="Selecciona un producto..." required>
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
                                                     <div class="col-sm-2 col-md-2 col-lg-2">
                                                     <label for="cantidad">Cant Max @{{stock.stock}}</label>
                                                     <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="prosucursal.cantidad" required ng-click="elstock(prosucursal.id_producto)" max="@{{stock.stock}}" min="1">
                                                        <div class="col-sm-12 spd spi">
			                                          	  <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req.</div>
			                                           </div>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-lg-1 spi">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid"><span class="ico_agregar"></span></button>
                                                </div>
                                           </div>
                                     </form>
                      </div>
                        {{-- Productos agregados a compras --}}
                      <div class="col-sm-12 conte table_height">
                      <div class="col-sm-12">
                          <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
                      </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Costo</th>
                                               <th>Precio Publico</th>
                                               <th>Stock</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="prosucursal in prosucursales">
                                                   <td> <small class="label label-success">@{{ prosucursal.nombre_producto.codigo }}</small>
                                                      @{{prosucursal.nombre_producto.nombre}}</td>
                                                     <td>Q@{{prosucursal.nombre_producto.costo | number:2 }}</td>
                                                     <td>Q@{{prosucursal.nombre_producto.preciop | number:2}}</td>
                                                   <td>@{{prosucursal.stock}} </td>
                                                   <td>
                                                   <small class="label label-info">Q@{{(prosucursal.nombre_producto.costo*prosucursal.stock) | number:2}}</small>
                                                     Q@{{(prosucursal.nombre_producto.preciop*prosucursal.stock) | number:2}}
                                                   </td>
                                                   <td>
                                                          <div class="area_opciones">
                                                             <ul>
                                                                    <li class="ed_drop"  uib-dropdown>
                                                                           <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(prosucursal)"></a>
                                                                                  <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                  <form class="form-horizontal" name="frmed" role="form" ng-submit="btn_proeditar()" >
                                                                                         <div class="col-sm-9 ">
                                                                                             <input id="name" type="number" class="form-control" name="nombre" ng-model="existePro.stock" min="1" required>
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
                                                                             <p>Eliminar <strong>@{{prosucursal.nombre_producto.codigo}}</strong></p>
                                                                           </div>
                                                                           <div class="col-sm-4 spd spi">
                                                                             <a href="" ng-click="btn_proeliminar(prosucursal.id)" class=" btn_g ico_eliminarg"></a>
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

{{-- Sucursales --}}

	 	<div class="header_conte">
	      <h1>Sucursales</h1>
	        <div class="btn_nuevo">
	            <a href="" ng-click="btn_nuevo()">Nueva Sucursal</a>
	        </div>
	 	 </div>
		<div class="col-sm-12">
			    <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Sucursal nueva</strong> guardado correctamente, creado por administradores.</div>
		        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Sucursal borrada</strong> No se podrá recuperar los datos.</div>	
			    <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Sucursal editada</strong> Puedes ver en el listado de sucursales las modificaciones realizadas.</div>
			 <div class="caja_contenido">
			 		 <table class="table">
			 		  <thead>
	                       <th>Nombre</th>
	                       <th>Ubicación</th>
	                       <th>Usuario</th>
	                       <th>Opciones</th>
	                   </thead>
	                   <tbody>
	                   		<tr ng-repeat="sucursal in sucursales">
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.nombre}}</td>
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.ubicacion}}</td>
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.perfil_usuario.nombre}} @{{sucursal.perfil_usuario.apellido}}</td>
	                   		<td>
	                   			<div class="area_opciones">
	                                 <ul>
	                                     <li><a href="" class="ico_editar" ng-click="btn_editar(sucursal)"></a></li>
	                                     <li class="op_drop"  uib-dropdown>
	                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
	                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
	                                               <div class="col-sm-8 spd">
	                                                 <p>Eliminar Sucursal <strong>@{{sucursal.nombre}}</strong></p>
	                                               </div>
	                                               <div class="col-sm-4 spd spi">
	                                                 <a href="" ng-click="btn_eliminar(sucursal.id)" class=" btn_g ico_eliminarg"></a>
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
@endpush