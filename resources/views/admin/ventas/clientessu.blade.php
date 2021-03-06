@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ClientesCtrl" ng-cloak>
	 {{-- Nuevo cliente --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nuevo Cliente</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Cliente existente!</strong> Intenta de nuevo con otro cliente cambiando NIT</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarCliente()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Nombre Comercial</label>
                                         <input id="name" type="text" class="form-control" name="empresa" ng-model="cliente.empresa" placeholder="Nombre de la empresa">
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.empresa.$dirty && frm.empresa.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Nombre de factura</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="cliente.nombre" placeholder="Nombre del cliente" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nit">NIT</label>
                                       <input id="nit" type="text" class="form-control" name="nit" ng-model="cliente.nit" placeholder="XXXXXX-X" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="contacto">Contacto</label>
                                         <input id="contacto" type="text" class="form-control" name="contacto" ng-model="cliente.contacto" placeholder="Nombre del contacto">
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.contacto.$dirty && frm.contacto.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
								 <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Dirección</label>
                                         <input id="name" type="text" class="form-control" name="direccion" ng-model="cliente.direccion" placeholder="Ubicación exacta">
                                    </div>
                               </div>
								 <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Télefono</label>
                                       <input id="nombre" type="text" class="form-control" name="telefono" ng-model="cliente.telefono" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="celular">Celular</label>
                                       <input id="celular" type="text" class="form-control" name="celular" ng-model="cliente.celular">
                                  </div>
                               </div>	
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                         <input id="email" type="email" class="form-control" name="email" ng-model="cliente.email">
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.email">Email Invalido</div>
                                         </div>
                                    </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Tipo Cliente</label>
                                         <ol class="nya-bs-select" ng-model="cliente.tipo_cliente" title="Selecciona tipo...">
                                            <li nya-bs-option="tipo in tipos" data-value="tipo.id">
                                              <a>
                                                @{{ tipo.cliente }}
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

   {{-- Editar cliente --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Cliente @{{existeCliente.empresa}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Cliente existente!</strong> Intenta de nuevo con otro cleinte cambiando NIT</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarCliente()" >
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Nombre Comercial</label>
                                         <input id="name" type="text" class="form-control" name="empresa" ng-model="existeCliente.empresa" placeholder="Nombre de la empresa">
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.empresa.$dirty && frm.empresa.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Nombre de factura</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existeCliente.nombre" placeholder="Nombre del encargado" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">NIT</label>
                                       <input id="nit" type="text" class="form-control" name="nit" ng-model="existeCliente.nit" placeholder="XXXXXX-X" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="contacto">Contacto</label>
                                         <input id="contacto" type="text" class="form-control" name="contacto" ng-model="existeCliente.contacto" placeholder="Nombre del contacto">
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.contacto.$dirty && frm.contacto.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Dirección</label>
                                         <input id="name" type="text" class="form-control" name="direccion" ng-model="existeCliente.direccion" placeholder="Ubicación exacta">
                                    </div>
                               </div>
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Télefono</label>
                                       <input id="nombre" type="text" class="form-control" name="telefono" ng-model="existeCliente.telefono" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="celular">Celular</label>
                                       <input id="celular" type="text" class="form-control" name="celular" ng-model="existeCliente.celular">
                                  </div>
                               </div> 
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                         <input id="email" type="email" class="form-control" name="email" ng-model="existeCliente.email">
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.email">Email Invalido</div>
                                         </div>
                                    </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Tipo Cliente</label>
                                         <ol class="nya-bs-select" ng-model="existeCliente.tipo_cliente" title="Selecciona un cliente...">
                                            <li nya-bs-option="tipo in tipos" data-value="tipo.id">
                                              <a>
                                                @{{ tipo.cliente }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                        
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

	
	{{-- Cliente --}}
	
	 <div class="header_conte">
              <h1>Cliente</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nuevo Cliente</a>
                </div>
     </div>
	<div class="col-sm-12">

       <div class="col-sm-12 spd spi">
                     <div class="busqueda_texto col-sm-4">
                    <input type="text" id="query" ng-model="query" onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de clientes.." />
                     </div>
                </div>

	   <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Cliente nuevo</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Cliente borrado</strong> No se podrá recuperar los datos.</div>	
	 <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Cliente editado</strong> Puedes ver en el listado de cliente las modificaciones realizadas.</div>
  
	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
	                   <th>Cliente</th>
	                   <th>NIT</th>
	                   <th>Dirección</th>
	                   <th>Teléfono / Celular</th>
	                   <th>Contacto</th>
                      <th>%</th>
	                   <th class="td_opciones">Opciones</th>
	               </thead>
                    <tbody>
                     <tr ng-repeat="cliente in clientes| filter: query | filter:{tipo_cliente:'1'}  | orderBy:'-id'">
                         <td>@{{cliente.nombre}} <small>@{{cliente.empresa}}</small></td>
                         <td>@{{cliente.nit}} </td>
                         <td>@{{cliente.direccion}}</td>
                         <td>@{{cliente.telefono}} / @{{cliente.celular}}</td>
                         <td>@{{cliente.email}}</td>
                         <td><span ng-if="cliente.porcentaje_cliente.porcentaje" class="por_ac">@{{cliente.porcentaje_cliente.porcentaje}}%</span></td>
                         <td class="td_opciones">
                             <div class="area_opciones">
                                 <ul>
                                     @role('admin|operativo|developer') 
                                     <li class="op_drop"  uib-dropdown >
                                           <a href="" class="ico_porcentaje" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_porcen(cliente)"></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown" ng-if="!cliente.porcentaje_cliente.porcentaje"  > 
                                          <form class="form-horizontal" name="frmed" role="form" ng-submit="nuevo_porcen()" >
                                                 <div class="col-sm-8 adap_op">
                                                     <input id="name" type="number" class="form-control" name="nombre" ng-model="porcen.cantidad" min="1" required>
                                                 </div>
                                                 <div class="col-sm-4 spd spi">
                                                  <input type="hidden" ng-model="cliente.id"/>
                                                  <input type="hidden" ng-model="cliente.tipo_cliente"/>
                                                  <button type="submit" class="btn_g btn_nuevog" ng-disabled="frmed.$invalid"></button>
                                                 </div>
                                          </form>
                                          </div>

                                          <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown" ng-if="cliente.porcentaje_cliente.porcentaje"  > 
                                          <form class="form-horizontal" name="frmed" role="form" ng-submit="editar_porcen(exisPor)" >
                                                 <div class="col-sm-8 adap_op">
                                                     <input id="name" type="number" class="form-control" name="nombre" ng-model="exisPor.cantidad" ng-init="exisPor.cantidad=cliente.porcentaje_cliente.porcentaje" min="1" required>
                                                 </div>
                                                 <div class="col-sm-4 spd spi">
                                                  <input type="hidden" ng-model="cliente.id"/>
                                                  <input type="hidden" ng-model="cliente.tipo_cliente"/>
                                                  <button type="submit" class="btn_g btn_editarg" ng-disabled="frmed.$invalid"></button>
                                                 </div>
                                          </form>
                                          </div>
                                     </li>
                                      @endrole
                                     <li><a href="" class="ico_editar" ng-click="btn_editar(cliente)"></a></li>
                                      @role('admin|operativo|developer') 
                                     <li class="op_drop"  uib-dropdown >
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle ></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar <strong>@{{cliente.nombre}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(cliente.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                      @endrole
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
    <script src="/js/controller/VentasCtrl.js"></script>
@endpush