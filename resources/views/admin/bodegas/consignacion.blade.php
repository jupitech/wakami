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


             {{-- Nueva Orden de Envio --}}
                 <div id="area_nuevo" ng-if="opcion_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva orden de envio consignación</h1>
                              <a class="btn_cerrar" ng-click="btn_cerraro()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                        <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Envio existente!</strong> Intenta de nuevo con otro nombre de envio</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarEnvio()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Consignación</label>
                                         <ol class="nya-bs-select" ng-model="envio.id_consignacion" title="Selecciona una bodega..." name="id_consignacion" required>
                                            <li nya-bs-option="consignacion in consignaciones" data-value="consignacion.id">
                                              <a>
                                              <span>
                                                <small class="label label-success">#@{{ consignacion.id }}</small> @{{ consignacion.info_cliente.nombre }}-@{{ consignacion.info_cliente.empresa }}
                                              </span>
                                                
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                    </div>
                               </div>
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">CREAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_envio()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
                 </div>


                 {{-- Area de ordenes --}}

                 <div id="area_mas" ng-if="abmas_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Orden de envio consignación #@{{exisEnvio.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarab()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                        <div class="col-sm-12">
                              <div class="col-sm-12">
                                  <div class="col-sm-6 spi">
                                      <h3>Consignacion</h3>
                                      <h2> @{{exisEnvio.nombre_consignacion.info_cliente.nombre}}</h2>
                                  </div>
                                  <div class="col-sm-6 spd">
                                      <h3>Fecha de creación</h3>
                                      <h2> @{{exisEnvio.created_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</h2>
                                  </div>
                              </div>
                        </div>
                        {{-- Agregando productos de la orden de envio --}}
                         <div class="col-sm-12 middle" ng-if="exisEnvio.estado_orden==1">
                           <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProEnvio()" >
                                          <div class="form-group">
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                     <label for="cantidad">Cant.</label>
                                                     <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="proenvio.cantidad" required>
                                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req.</div>
                                           </div>
                                                </div>
                                                <div class="col-sm-8 col-md-8 col-lg-9">
                                                    <label for="name">Producto</label>
                                                     <ol class="nya-bs-select" ng-model="proenvio.id_producto" data-live-search="true"  title="Selecciona un producto..." required>
                                                          <li nya-bs-option="producto in productos" data-value="producto.id">
                                                            <a>
                                                             <span>
                                                              <small class="label label-success">@{{ producto.codigo }}</small>
                                                                  @{{ producto.nombre }}-<strong>@{{ producto.preciop  | currency: 'Q' }} </strong>
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

                                     {{-- Productos agregados a envios --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisEnvio.estado_orden==1">
                          <div class="col-sm-12">
                              <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
                          </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th>Costo</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proenvio in proenvios">
                                                   <td><small class="label label-success">@{{ proenvio.nombre_producto.codigo }}</small> @{{proenvio.nombre_producto.nombre}}</td>
                                                   <td>@{{proenvio.cantidad}} </td>
                                                   <td>@{{proenvio.precio_producto  | currency: 'Q'}}</td>
                                                   <td ng-init="ProTotal = ProTotal+proenvio.subtotal">@{{proenvio.subtotal  | currency: 'Q'}}</td>
                                                   <td>
                                                       <div class="area_opciones">
                                                           <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(proenvio)"></a>
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
                                                                           <p>Eliminar <strong>@{{proenvio.nombre_producto.nombre}}</strong></p>
                                                                         </div>
                                                                         <div class="col-sm-4 spd spi">
                                                                           <a href="" ng-click="btn_proeliminar(proenvio.id)" class=" btn_g ico_eliminarg"></a>
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

                       {{-- Productos y compra terminada --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisEnvio.estado_orden==2">
                             <div class="col-sm-12 spd spi">
                          <div class="agre_pro">
                         <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th>Costo</th>
                                               <th>Subtotal</th>
                                               <th>Estado</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proenvio in proenvios">
                                                   <td><small class="label label-success">@{{ proenvio.nombre_producto.codigo }}</small> @{{proenvio.nombre_producto.nombre}}</td>
                                                   <td>@{{proenvio.cantidad}} <span class="label label-default" >@{{proenvio.pendiente_producto.cantidad}}</span> </td>
                                                   <td>@{{proenvio.precio_producto  | currency: 'Q'}}</td>
                                                   <td ng-init="ProTotal = ProTotal+proenvio.subtotal">@{{proenvio.subtotal  | currency: 'Q'}}</td>
                                                   <td ng-switch="proenvio.estado_producto">
                                                      <p class="label label-warning" ng-switch-when="1">
                                                        Agregado
                                                      </p>
                                                   </td>
                                               </tr>
                                              
                                           </tbody>
                             </table>
                          
                          </div>
                        </div>
                      </div>
                         {{-- Totales y opciones --}}
                          <div class="col-sm-12 footer">
                              <div class="col-sm-4">
                                    <h3>Total</h3>
                                    <h1>Q@{{proenvios | SumaItem:'subtotal'}}</h1>
                              </div>
                               <div class="col-sm-8" ng-if="exisEnvio.estado_orden==1 && proenvios.length > 0">
                                     <form class="form-horizontal" name="frm" role="form" ng-submit="enviarEnvio()" >
                                          <div class="form-group">
                                              <div class="col-sm-7">
                                                <p class="info_paso"><strong>PASO 1</strong> Envio de los productos hacia la bodega de consignación</p>
                                              </div>
                                              <div class="col-sm-5">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Enviar Productos</button>
                                              </div>
                                           </div>
                                     </form>
                             </div>
                             <div class="col-sm-8" ng-if="exisEnvio.estado_orden==1 && proenvios.length < 1">
                                 <p class="info_paso"><strong>AGREGA PRODUCTOS</strong> Cuando se agreguen productos podrán enviarlo a la sucursal asignada.</p>
                             </div>
                              <div class="col-sm-8" ng-if="exisEnvio.estado_orden==2 && (proenvios | filter:{estado_producto:1}).length < 1">
                                                 <form class="form-horizontal" name="frm" role="form" ng-submit="completarEnvio()" >
                                                      <div class="form-group">
                                                          <div class="col-sm-7">
                                                            <p class="info_paso"><strong>PASO 2</strong> Terminar orden para completar datos</p>
                                                          </div>
                                                          <div class="col-sm-5">
                                                                <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Completar Orden</button>
                                                          </div>
                                                       </div>
                                                 </form>
                                         </div>
                          </div>     
                    </div>
                 </div>                 

{{-- Area de consignacion selecccionada --}}
   <div id="area_mas" ng-if="mas_obj">
          <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Cosignación para @{{exisConsignacion.info_cliente.nombre}} - @{{exisConsignacion.info_cliente.empresa}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
          </div>
          <div class="conte_nuevo">
                <div class="col-sm-12 spd spi">
                       <div class="col-sm-4">
                           <h3>Nombre/Empresa</h3>
                           <p>@{{exisConsignacion.info_cliente.nombre}}-@{{exisConsignacion.info_cliente.empresa}} </p>
                      </div>
                      <div class="col-sm-4">
                                  <h3>NIT</h3>
                                   <p>@{{exisConsignacion.info_cliente.nit}}</p>
                      </div>
                      <div class="col-sm-4">
                                   <h3>DIRECCIÓN</h3>
                                   <p>@{{exisConsignacion.info_cliente.direccion}}</p>
                      </div>
                      <div class="col-sm-4">
                                  <h3>TELÉFONO</h3>
                                   <p>@{{exisConsignacion.info_cliente.telefono}} / @{{exisConsignacion.info_cliente.celular}}</p>
                      </div>
                      <div class="col-sm-4">
                                   <h3>TIPO DE CLIENTE</h3>
                                   <p ng-switch="exisConsignacion.info_cliente.tipo_cliente">
                                    <span ng-switch-when="1">Individual</span>
                                     <span ng-switch-when="2">Empresa</span>
                                   </p>
                      </div>
                </div>
                {{-- Productos de stock en bodgea --}}
                      <div class="col-sm-12 conte table_height">
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Costo</th>
                                               <th>Precio Publico</th>
                                               <th>Stock</th>
                                               <th>Subtotal</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proconsignacion in proconsignaciones">
                                                   <td> <small class="label label-success">@{{ proconsignacion.nombre_producto.codigo }}</small>
                                                      @{{proconsignacion.nombre_producto.nombre}}</td>
                                                     <td>Q@{{proconsignacion.nombre_producto.costo | number:2 }}</td>
                                                     <td>Q@{{proconsignacion.nombre_producto.preciop | number:2}}</td>
                                                   <td>@{{proconsignacion.stock}} </td>
                                                   <td>
                                                   <small class="label label-info">Q@{{(proconsignacion.nombre_producto.costo*proconsignacion.stock) | number:2}}</small>
                                                     Q@{{(proconsignacion.nombre_producto.preciop*proconsignacion.stock) | number:2}}
                                                   </td>
                                               </tr>
                                              
                                           </tbody>
                                       </table>
                      </div>
            
          </div>

   </div>



{{-- Consignacion --}}

	 	<div class="header_conte">
	      <h1>Consignación</h1>
          <div class="btn_nuevo">
              <a href="" ng-click="btn_nuevo()">Nueva Consignación</a>
          </div>
          <div class="btn_opcion2">
              <a href="" ng-click="btn_envio()">Nuevo Envio Consignación</a>
          </div>
	 	 </div>
		<div class="col-sm-12">
			    <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Consignación nueva</strong> guardado correctamente, creado por administradores.</div>
		        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Consignación borrada</strong> No se podrá recuperar los datos.</div>	
			    <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Consignación editada</strong> Puedes ver en el listado de consignaciones las modificaciones realizadas.</div>

        {{-- Todas las consignaciones --}}  
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
	                   		<td ng-click="abrirconsignacion(consignacion)">@{{consignacion.info_cliente.nombre}}-@{{consignacion.info_cliente.empresa}}</td>
                        <td ng-click="abrirconsignacion(consignacion)">@{{consignacion.info_cliente.nit}}</td>
	                   		<td ng-click="abrirconsignacion(consignacion)">@{{consignacion.info_cliente.telefono}}</td>
                        <td ng-click="abrirconsignacion(consignacion)">@{{consignacion.created_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
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

               {{-- Todos los envios --}}
              <div class="col-sm-12 spd spi">
                <h4 class="h4_tit">Ordenes de envio</h4>
              </div>
              <div class="col-sm-12 spd spi">
                  <div class="info_colores">
                    <ul>
                      <li><span class="color_ncom"></span> <p>Nuevo Envio</p></li>
                      <li><span class="color_tercom"></span> <p>Envio Terminado</p></li>
                    </ul>
                  </div>
                </div> 
              <div class="caja_contenido">
                 <div class="col-sm-12 bus_tabla">
                   <h3>Por Consignación</h3>
                   <div class="col-sm-3">
                      <ol class="nya-bs-select" ng-model="busfiltro" title="Selecciona una bodega..." name="id_consignacion" required>
                      <li ng-click="deselec()"><a>
                      Todos
                         <span class="glyphicon glyphicon-ok check-mark"></span>
                      </a></li>
                      <li nya-bs-option="consignacion in consignaciones" data-value="consignacion.info_cliente.nombre">
                        <a>
                          @{{ consignacion.info_cliente.nombre }}
                          <span class="glyphicon glyphicon-ok check-mark"></span>
                        </a>
                      </li>
                    </ol>
                   </div>
                  
                 </div>
                 <table class="table">
                  <thead>
                              <th></th>
                              <th>#Envio</th>
                               <th>Sucursal</th>
                               <th>Total</th>
                               <th>Fecha de Entrega</th>
                               <th>Fecha de Movimiento</th>
                           </thead>
                           <tbody>
                              <tr ng-repeat="envio in envios | filter: busfiltro | orderBy:'-id'" ng-class="{'trc_ama':envio.estado_orden==1}">
                              <td class="td_first"></td>
                              <td ng-click="abrirorden(envio)"><strong>@{{envio.id}}</strong></td>
                              <td ng-click="abrirorden(envio)">@{{envio.nombre_consignacion.info_cliente.nombre}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.total_compra | currency: 'Q'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.fecha_entrega  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.updated_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
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