@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ComprasCtrl">
	 {{-- Nueva compra --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva compra</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Compra existente!</strong> Intenta de nuevo con otro nombre de compra</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarCompra()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Proveedor</label>
                                         <ol class="nya-bs-select" ng-model="compra.id_proveedor" title="Selecciona un proveedor...">
                                            <li nya-bs-option="proveedor in proveedores" data-value="proveedor.id">
                                              <a>
                                                @{{ proveedor.empresa }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="nombre">Hoy @{{Fecha | amDateFormat: 'DD/MM/YYYY'}} @{{ clock | date:'HH:mm:ss'}} para entregar en:</label>
                                      <ol class="nya-bs-select" ng-model="compra.fecha_entrega" title="Selecciona los dias...">
                                            <li nya-bs-option="estimada in estimadas" data-value="estimada.id">
                                              <a>
                                                @{{ estimada.nombre }}
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
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

{{-- Area compra --}}
               <div id="area_mas" ng-if="mas_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Compra No.@{{exisCompra.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                          <div class="col-sm-6 spi">
                              <h3>Proveedor</h3>
                              <h2> @{{exisCompra.nombre_proveedor.empresa}}</h2>
                          </div>
                          <div class="col-sm-6 spd">
                              <h3>Fecha de Entrega</h3>
                              <h2> @{{exisCompra.fecha_entrega  | amDateFormat: 'DD/MM/YYYY'}}</h2>
                          </div>
                      </div>
                      <div class="col-sm-12 middle" ng-if="exisCompra.estado_orden==1">
                           <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProCompra()" >
                                          <div class="form-group">
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                     <label for="cantidad">Cant.</label>
                                                     <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="procompra.cantidad" required>
                                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req.</div>
                                           </div>
                                                </div>
                                                <div class="col-sm-8 col-md-8 col-lg-9">
                                                    <label for="name">Producto</label>
                                                     <ol class="nya-bs-select" ng-model="procompra.id_producto" data-live-search="true"  title="Selecciona un producto..." required>
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
                      {{-- Productos agregados a compras --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisCompra.estado_orden==1">
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
                                               <tr ng-repeat="procompra in procompras">
                                                   <td>@{{procompra.nombre_producto.nombre}}</td>
                                                   <td>@{{procompra.cantidad}} </td>
                                                   <td>Q@{{procompra.precio_producto}}</td>
                                                   <td ng-init="ProTotal = ProTotal+procompra.subtotal">Q@{{procompra.subtotal}}</td>
                                                   <td>
                                                       <div class="area_opciones">
                                                           <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(procompra)"></a>
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
                                                                           <p>Eliminar <strong>@{{procompra.nombre_producto.nombre}}</strong></p>
                                                                         </div>
                                                                         <div class="col-sm-4 spd spi">
                                                                           <a href="" ng-click="btn_proeliminar(procompra.id)" class=" btn_g ico_eliminarg"></a>
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
                         {{-- Productos para enviar a bodega --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisCompra.estado_orden>1 && exisCompra.estado_orden<4">
                        <div class="col-sm-12">
                             <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Producto agregado</strong> a bodega central.</div>
                        </div>
                        <div class="col-sm-12 spd spi">
                          <div class="agre_pro">
                          {{-- Productos pendientes de recibir --}}
                          <h2 ng-if="(procompras | filter:{estado_producto:3}).length > 0" ><strong>Productos Pendientes de recibir</strong></h2>
                          <table class="table" ng-if="(procompras | filter:{estado_producto:3}).length > 0">
                             <thead>
                               
                             </thead>
                             <tbody>
                                              <tr  ng-repeat="propcompra in procompras" ng-if="propcompra.estado_producto==3">
                                              
                                              <form class="form-horizontal" name="frm" role="form">
                                                  <td> <small class="label label-success">@{{propcompra.nombre_producto.codigo}}</small> @{{propcompra.nombre_producto.nombre}}</td>
                                                  <td class="maxtd_long">
                                                      <div class="form-group">
                                                        <div class="col-md-12 spd spi">
                                                             <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="propcompra.pendiente_producto.cantidad"  ng-init="maxcantidad = propcompra.pendiente_producto.cantidad" min="0" max="@{{maxcantidad}}" required>
                                                             <div class="col-sm-12 spd spi">
                                                                <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req</div>
                                                             </div>
                                                              <input type="hidden" ng-model="propcompra.id_producto"/>
                                                              <input type="hidden" ng-model="propcompra.id_orden"/>
                                                              <input type="hidden" ng-model="propcompra.id"/>
                                                        </div>
                                                   </div>
                                                  </td>
                                                  <td>
                                                
                                                     <div class="op_elim">
                                                          <a href="" class="btn_delitem" id="simple-dropdown"><span class="ico_del" ng-click="btn_proeliminar2(propcompra.id)"></span></a>
                                                     </div>
                                                      <div class="op_elim">
                                                          <a href="" class="btn_additem" id="simple-dropdown" ng-disabled="frm.$invalid"  ng-click="agregarProBodegaPen(propcompra)"><span class="ico_check"></span></a>
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
                              <tr  ng-repeat="procompra in procompras" ng-if="procompra.estado_producto==1">
                                <form class="form-horizontal" name="frm" role="form">
                                    <td> <small class="label label-success">@{{procompra.nombre_producto.codigo}}</small> @{{procompra.nombre_producto.nombre}}</td>
                                    <td class="maxtd_long">
                                        <div class="form-group">
                                          <div class="col-md-12 spd spi">
                                               <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="procompra.cantidad"  ng-init="maxcantidad = procompra.cantidad" min="0" max="@{{maxcantidad}}" required>
                                               <div class="col-sm-12 spd spi">
                                                  <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req</div>
                                               </div>
                                                <input type="hidden" ng-model="procompra.id_producto"/>
                                                <input type="hidden" ng-model="procompra.id_orden"/>
                                                <input type="hidden" ng-model="procompra.id"/>
                                          </div>
                                     </div>
                                    </td>
                                    <td></td>
                                    <td>
                                  
                                       <div class="op_elim">
                                            <a href="" class="btn_delitem" id="simple-dropdown"><span class="ico_del" ng-click="btn_proeliminar2(procompra.id)"></span></a>
                                       </div>
                                        <div class="op_elim">
                                            <a href="" class="btn_additem" id="simple-dropdown" ng-disabled="frm.$invalid"  ng-click="agregarProBodega(procompra)"><span class="ico_check"></span></a>
                                       </div>

                                     
                                    </td>

                                </form>
                              </tr>
                              <tr ng-repeat="procompra in procompras" ng-if="procompra.estado_producto!=1" class="fondo_acep">
                                <td> <small class="label label-success">@{{procompra.nombre_producto.codigo}}</small> @{{procompra.nombre_producto.nombre}} <small class="label label-primary">Q@{{procompra.nombre_producto.costo | number:2}}</small></td>
                                <td>@{{procompra.entrega_producto.cantidad}}</td>
                                <td>@{{procompra.pendiente_producto.cantidad}}</td>
                                <td>En bodega</td>
                              </tr>
                            </tbody>
                          </table>
                     
                          </div>
                        </div>
                      </div>

                        {{-- Productos y compra terminada --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisCompra.estado_orden==4">
                             <div class="col-sm-12 spd spi">
                          <div class="agre_pro">
                          <table  class="table">
                           <thead>
                                               <th>Producto</th>
                                               <th>Costo</th>
                                               <th>Cant</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                            <tbody>
                            
                              <tr ng-repeat="procompra in procompras" ng-if="procompra.estado_producto==2" class="fondo_acep">
                                <td> <small class="label label-success">@{{procompra.nombre_producto.codigo}}</small> @{{procompra.nombre_producto.nombre}}</td>
                                <td>Q@{{procompra.precio_producto | number:2}}</td>
                                <td>@{{procompra.entrega_producto.cantidad}}</td>
                                <td>Q@{{procompra.subtotal | number:2}}</td>
                                <td>En bodega</td>
                              </tr>
                            </tbody>
                          </table>
                          
                          </div>
                        </div>
                      </div>

                      {{-- Totales y Acciones --}}
                      <div class="col-sm-12 footer">
                        <div class="col-sm-4">
                        <h3>Total</h3>
                          <h1>Q@{{procompras | SumaItem:'subtotal'}}</h1>
                        </div>
                        <div class="col-sm-8" ng-if="exisCompra.estado_orden==1 && procompras.length > 0">
                               <form class="form-horizontal" name="frm" role="form" ng-submit="enviarCompra()" >
                                          <div class="form-group">
                                              <div class="col-sm-7">
                                                <p class="info_paso"><strong>PASO 1</strong> Envio de los productos para solicitud de compra al proveedor</p>
                                              </div>
                                              <div class="col-sm-5">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Enviar Compra</button>
                                              </div>
                                           </div>
                                     </form>
                        </div>
                        <div class="col-sm-8" ng-if="exisCompra.estado_orden==1 && procompras.length < 1">
                           <p class="info_paso"><strong>AGREGA PRODUCTOS</strong> Cuando se agreguen productos podrán enviarlo al proveedor y proceder al PASO 2 para enviar productos recibidos a la bodega central</p>
                        </div>
                        {{-- Estado de Orden 2 --}}
                             <div class="col-sm-8" ng-if="exisCompra.estado_orden>1 && exisCompra.estado_orden<4 && procompras.length == (procompras | filter:{estado_producto:2}).length" >
                                   <form class="form-horizontal" name="frm" role="form" ng-submit="finalizarCompra()" >
                                              <div class="form-group">
                                                  <div class="col-sm-7">
                                                    <p class="info_paso"><strong>PASO 2</strong> Todos los productos han sido agregados a la bodega central</p>
                                                  </div>
                                                  <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Finalizar Compra</button>
                                                  </div>
                                               </div>
                                         </form>
                            </div>
                            <div class="col-sm-8" ng-if="exisCompra.estado_orden==2 && procompras.length != (procompras | filter:{estado_producto:2}).length" >
                                <div class="col-sm-12 spd spi" ng-if="(procompras | filter:{estado_producto:3}).length > 0">
                                          <form class="form-horizontal" name="frm" role="form" ng-submit="pendienteCompra()" >
                                              <div class="form-group">
                                                  <div class="col-sm-7">
                                                    <p class="info_paso"><strong>PENDIENTE</strong> Envio de los productos para solicitar de nuevo los restantes.</p>
                                                  </div>
                                                  <div class="col-sm-5">
                                                        <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Reenviar Compra</button>
                                                  </div>
                                               </div>
                                         </form>
                                </div>
                                <div class="col-sm-12 spd spi" ng-if="(procompras | filter:{estado_producto:3}).length < 1">
                                   <p class="info_paso"><strong>FALTAN PRODUCTOS</strong> por confirmar para agregar a la bodega central, o hacen falta productos que no fueron entregados por el proveedor</p>
                                </div>
                              
                            </div>

                      </div>
                    </div>
              </div>

 {{-- Editar Compra --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Compra @{{existeCompra.codigo}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Compra existente!</strong> Intenta de nuevo con otro nombre de compra</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="editarCompra()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Proveedor</label>
                                         <ol class="nya-bs-select" ng-model="existeCompra.id_proveedor" title="Selecciona un proveedor...">
                                            <li nya-bs-option="proveedor in proveedores" data-value="proveedor.id">
                                              <a>
                                                @{{ proveedor.empresa }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="nombre">Fecha Entrega @{{existeCompra.fecha_entrega | amDateFormat: 'DD/MM/YYYY'}} cambiar por:</label>
                                      <ol class="nya-bs-select" ng-model="existeCompra.fecha_entrega2" title="Selecciona los dias...">
                                            <li nya-bs-option="estimada in estimadas" data-value="estimada.id">
                                              <a>
                                                @{{ estimada.nombre }}
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
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

  


	
	{{-- Compras --}}
	
	 <div class="header_conte">
              <h1>Compras</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nueva Compra</a>
                </div>
     </div>
  <div class="col-sm-12">
    <div class="info_colores">
      <ul>
        <li><span class="color_ncom"></span> <p>Nueva Compra</p></li>
        <li><span class="color_encom"></span> <p>Compra Enviada</p></li>
        <li><span class="color_falcom"></span> <p>Productos faltantes</p></li>
        <li><span class="color_tercom"></span> <p>Compra Terminada</p></li>
      </ul>
    </div>
  </div>   
	<div class="col-sm-12">
	   <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Compra nueva</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Compra borrada</strong> No se podrá recuperar los datos.</div>	
	 <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Compra editada</strong> Puedes ver en el listado de compras las modificaciones realizadas.</div>

	  <div class="caja_contenido">
	           <table class="table">
	               <thead>
                     <th></th>
	                   <th class="td_no">No #</th>
	                   <th>Proveedor</th>
	                   <th>Fecha Entrega</th>
	                   <th>Total Compra</th>
	                   <th>Opciones</th>
	               </thead>
	                 <tbody>
                     <tr ng-repeat="compra in compras  | orderBy:'-id'" ng-class="{'trc_ama':compra.estado_orden==1,'trc_ver':compra.estado_orden==2,'trc_fus':compra.estado_orden==3}">
                     <td class="td_first"></td>
                         <td class="td_no" ng-click="abrircompra(compra,1)"><strong>@{{compra.id}}</strong></td>
                         <td ng-click="abrircompra(compra,1)">@{{compra.nombre_proveedor.empresa}} </td>
                         <td ng-click="abrircompra(compra,1)">@{{compra.fecha_entrega | amDateFormat: 'DD/MM/YYYY'}}</td>
                         <td>Q @{{compra.total_compra | number:2}}</td>
                         <td>
                             <div class="area_opciones">
                                 <ul>
                                 <li ng-if="compra.estado_orden==2"><a href="/exports/ordenes/OrdenCompra-No@{{compra.id}}.xlsx" class="ico_excelazul"></a></li>
                                     <li><a href="" class="ico_editar" ng-click="btn_editar(compra)"></a></li>
                                     <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Orden No.<strong>@{{compra.id}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(compra.id)" class=" btn_g ico_eliminarg"></a>
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