@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ProveedoresCtrl">
	 {{-- Nuevo proveedor --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nuevo Proveedor</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Proveedor existente!</strong> Intenta de nuevo con otro nombre de proveedor cambiando NIT</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProveedor()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Empresa</label>
                                         <input id="name" type="text" class="form-control" name="empresa" ng-model="proveedor.empresa" placeholder="Nombre de la empresa" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.empresa.$dirty && frm.empresa.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Encargado</label>
                                       <input id="nombre" type="text" class="form-control" name="encargado" ng-model="proveedor.encargado" placeholder="Nombre del encargado" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.encargado.$dirty && frm.encargado.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">NIT</label>
                                       <input id="apellido" type="text" class="form-control" name="nit" ng-model="proveedor.nit" placeholder="XXXXXX-X" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
								 <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Dirección</label>
                                         <input id="name" type="text" class="form-control" name="direccion" ng-model="proveedor.direccion" placeholder="Ubicación exacta">
                                    </div>
                               </div>
								 <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Télefono Empresa</label>
                                       <input id="nombre" type="text" class="form-control" name="telefono" ng-model="proveedor.telefono" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">Télefono Encargado</label>
                                       <input id="telefono_encargado" type="text" class="form-control" name="telefono_encargado" ng-model="proveedor.telefono_encargado">
                                  </div>
                               </div>	
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email Encargado</label>
                                         <input id="email" type="email" class="form-control" name="email_encargado" ng-model="proveedor.email_encargado" required>
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.email_encargado.$dirty && frm.email_encargado.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frm.email_encargado.$dirty && frm.email.$error.email_encargado">Email Invalido</div>
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

   {{-- Editar proveedor --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Proveedor @{{existeProve.empresa}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Proveedor existente!</strong> Intenta de nuevo con otro proveedor cambiando NIT</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarProveedor()" >
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Empresa</label>
                                         <input id="name" type="text" class="form-control" name="empresa" ng-model="existeProve.empresa" placeholder="Nombre de la empresa" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.empresa.$dirty && frm.empresa.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Encargado</label>
                                       <input id="nombre" type="text" class="form-control" name="encargado" ng-model="existeProve.encargado" placeholder="Nombre del encargado" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.encargado.$dirty && frm.encargado.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">NIT</label>
                                       <input id="nit" type="text" class="form-control" name="nit" ng-model="existeProve.nit" placeholder="XXXXXX-X" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Dirección</label>
                                         <input id="name" type="text" class="form-control" name="direccion" ng-model="existeProve.direccion" placeholder="Ubicación exacta">
                                    </div>
                               </div>
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Télefono Empresa</label>
                                       <input id="nombre" type="text" class="form-control" name="telefono" ng-model="existeProve.telefono" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">Télefono Encargado</label>
                                       <input id="telefono_encargado" type="text" class="form-control" name="telefono_encargado" ng-model="existeProve.telefono_encargado">
                                  </div>
                               </div> 
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email Encargado</label>
                                         <input id="email" type="email" class="form-control" name="email_encargado" ng-model="existeProve.email_encargado" required>
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.email_encargado.$dirty && frm.email_encargado.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frm.email_encargado.$dirty && frm.email.$error.email_encargado">Email Invalido</div>
                                         </div>
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

	
	{{-- Proveedores --}}
	
	 <div class="header_conte">
              <h1>Proveedores</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nuevo Proveedor</a>
                </div>
     </div>
	<div class="col-sm-12">
	   <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Proveedor nuevo</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Proveedor borrado</strong> No se podrá recuperar los datos.</div>	
	 <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Proveedor editado</strong> Puedes ver en el listado de proveedores las modificaciones realizadas.</div>

	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
	                   <th>Empresa</th>
	                   <th>NIT</th>
	                   <th>Dirección</th>
	                   <th>Teléfono</th>
	                   <th>Encargado</th>
	                   <th>Teléfono Encargado</th>
	                   <th>Email Encargado</th>
	                   <th>Opciones</th>
	               </thead>
	               <tbody>
	                   <tr ng-repeat="proveedor in proveedores">
	                       <td>@{{proveedor.empresa}}</td>
	                       <td>@{{proveedor.nit}} </td>
	                       <td>@{{proveedor.direccion}}</td>
	                       <td>@{{proveedor.telefono}}</td>
	                       <td>@{{proveedor.encargado}}</td>
	                       <td>@{{proveedor.telefono_encargado}}</td>
	                       <td>@{{proveedor.email_encargado}}</td>
	                       <td>
	                           <div class="area_opciones">
	                               <ul>
	                                   <li><a href="" class="ico_editar" ng-click="btn_editar(proveedor)"></a></li>
	                                   <li class="op_drop"  uib-dropdown>
	                                         <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
	                                         <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
	                                             <div class="col-sm-8 spd">
	                                               <p>Eliminar <strong>@{{proveedor.empresa}}</strong></p>
	                                             </div>
	                                             <div class="col-sm-4 spd spi">
	                                               <a href="" ng-click="btn_eliminar(proveedor.id)" class=" btn_g ico_eliminarg"></a>
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