@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
  <div class="col-md-12 top_conte" ng-controller="ConsignacionCtrl">
{{-- Nueva Consignacion --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Consignación</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Consignación existente!</strong> Intenta de nuevo con cliente.</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarConsignacion()" >
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Cliente</label>
                                       <ol class="nya-bs-select" ng-model="consignacion.id_cliente" title="Selecciona un cliente..." required>
                                            <li nya-bs-option="cliente in clientes | orderBy:'-id'" data-value="cliente.id">
                                              <a>
                                               <span> @{{ cliente.nombre }}-@{{ cliente.empresa }}
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


{{-- Sucursales --}}

	 	<div class="header_conte">
	      <h1>Consignación</h1>
          <div class="btn_nuevo">
              <a href="" ng-click="btn_nuevo()">Nueva Consignación</a>
          </div>
	 	 </div>
		<div class="col-sm-12">
			    <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Consignación nueva</strong> guardado correctamente, creado por administradores.</div>
		        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Consignación borrada</strong> No se podrá recuperar los datos.</div>	
			    <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Consignación editada</strong> Puedes ver en el listado de consignaciones las modificaciones realizadas.</div>

        {{-- Todas las consisgnaciones --}}  
			 <div class="caja_contenido">
			 		 <table class="table">
			 		  <thead>
	                       <th>Cliente</th>
                         <th>Nit</th>
	                       <th>Telefono</th>
	                       <th>Fecha</th>
	                       <th>Opciones</th>
	                   </thead>
	                   <tbody>
	                   		<tr ng-repeat="consignacion in consignaciones">
	                   		<td ng-click="abrirsucursal(consignacion)">@{{consignacion.info_cliente.nombre}}-@{{consignacion.info_cliente.empresa}}</td>
                        <td ng-click="abrirsucursal(consignacion)">@{{consignacion.info_cliente.nit}}</td>
	                   		<td ng-click="abrirsucursal(consignacion)">@{{consignacion.info_cliente.telefono}}</td>
                        <td ng-click="abrirsucursal(consignacion)">@{{consignacion.created_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
	                   		<td>
	                   			<div class="area_opciones">
	                                 <ul>
	                                     <li><a href="" class="ico_editar" ng-click="btn_editar(sucursal)"></a></li>
	                                     <li class="op_drop"  uib-dropdown>
	                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
	                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
	                                               <div class="col-sm-8 spd">
	                                                 <p>Eliminar Consignacion <strong>@{{consignacion.info_cliente.nombre}}</strong></p>
	                                               </div>
	                                               <div class="col-sm-4 spd spi">
	                                                 <a href="" ng-click="btn_eliminar(consignacion.id)" class=" btn_g ico_eliminarg"></a>
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
    <script src="/js/controller/ConsignacionCtrl.js"></script>
@endpush