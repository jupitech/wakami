@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="VentaNCtrl">

	{{-- Nueva Venta --}}
	
	 <div class="header_conte">
              <h1>Nueva Venta</h1>
     </div>
	<div class="col-sm-12" ng-if="acti_venta">
   {{-- Venta Activada --}}
        	      <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Cliente nuevo</strong> guardado correctamente, creado por administradores.</div>
                <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Cliente borrado</strong> No se podrá recuperar los datos.</div>	
        	      <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Cliente editado</strong> Puedes ver en el listado de cliente las modificaciones realizadas.</div>

        	  <div class="caja_contenido sinheight">
        	       <div class="header_caja">
                      <div class="header_cliente" ng-if="!acti_areapro">
                        <p>Nuevo Cliente?</p>
                          <div class="onoffswitch">
                          <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ng-click="act_rol()">
                          <label class="onoffswitch-label" for="myonoffswitch">
                              <span class="onoffswitch-inner"></span>
                              <span class="onoffswitch-switch"></span>
                          </label>
                      </div> 
                     </div>
                     <div class="header_nofactura">
                        <p>Posible No.Factura</p>
                        <h3></h3>
                     </div>
        	      
        	      </div>

                {{-- Cliente Existente --}}

                <div class="middle_caja conte_nuevo" ng-if="!acti_rol && !acti_areapro">
                 <div class="col-sm-12">
                 <form class="form-horizontal" name="frm" role="form" ng-submit="nuevaVenta()" >
                       <div class="form-group">
                             <div class="col-sm-8 topinput">
                               <ol class="nya-bs-select" ng-model="venta.cliente" title="Seleccionar Cliente.." data-live-search="true" data-size="10">
                                    <li nya-bs-option="cliente in clientes | orderBy:'empresa'" data-value="cliente" ng-click="act_cliente()">
                                      <a>
                                        <span>
                                        <small class="label label-success">@{{ cliente.nit }}</small> 
                                             @{{ cliente.nombre }}-<strong>@{{ cliente.empresa }} </strong>
                                             <small class="label label-default">Direccion: @{{ cliente.direccion }}</small> 
                                             <small class="label label-warning">Teléfono: @{{ cliente.telefono }}</small> 
                                          </span>
                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                      </a>
                                    </li>
                                </ol> 
                             </div>
                             <div class="col-sm-4" ng-if="acti_cliente">
                                <label for="nit">NIT</label>
                                 <input id="nit" type="text" class="form-control" name="nit" ng-model="venta.cliente.nit" required disabled>
                                <div class="col-sm-12 spd spi">
                                         <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Req.</div>
                                 </div>
                            </div> 
                        </div>  
                          <div class="form-group" ng-if="acti_cliente">
                            <div class="col-sm-4">
                                <label for="nombre">Nombre Cliente</label>
                                 <input id="nombre" type="text" class="form-control" name="nombre" ng-model="venta.cliente.nombre" required disabled>
                                <div class="col-sm-12 spd spi">
                                         <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Req.</div>
                                 </div>
                            </div> 
                             <div class="col-sm-4">
                                <label for="direccion">Dirección</label>
                                 <input id="direccion" type="text" class="form-control" name="direccion" ng-model="venta.cliente.direccion" required disabled>
                                <div class="col-sm-12 spd spi">
                                         <div class="alert alert-danger" ng-show="frm.direccion.$dirty && frm.direccion.$error.required">Req.</div>
                                 </div>
                            </div> 
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono</label>
                                 <input id="telefono" type="text" class="form-control" name="telefono" ng-model="venta.cliente.telefono" required disabled>
                                <div class="col-sm-12 spd spi">
                                         <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Req.</div>
                                 </div>
                            </div> 
                          </div>       
                       <div class="form-group" ng-if="acti_cliente">
                         <div class="col-sm-4 col-md-offset-8">
                             <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">CREAR VENTA</button>
                          </div>
                       </div>  

                  </form>
                 </div>
                </div>


                {{-- Cliente Nuevo --}}
                <div class="middle_caja conte_nuevo" ng-if="acti_rol && !acti_areapro">
                               <div class="col-sm-12 ">
                                        <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Cliente existente!</strong> Intenta de nuevo con otro cliente cambiando NIT</div>
                                          <form class="form-horizontal" name="frm" role="form" ng-submit="guardarClienteCrear()" >
                                                  <div class="form-group">
                                                      <div class="col-sm-6">
                                                          <label for="name">Empresa</label>
                                                           <input id="name" type="text" class="form-control" name="empresa" ng-model="cliente.empresa" placeholder="Nombre de la empresa">
                                                          
                                                      </div>
                                                     <div class="col-sm-6">
                                                         <label for="nombre">Nombre</label>
                                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="cliente.nombre" placeholder="Nombre del cliente" required>
                                                          <div class="col-sm-12 spd spi">
                                                              <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                                           </div>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <div class="col-sm-3">
                                                         <label for="nit">NIT</label>
                                                         <input id="nit" type="text" class="form-control" name="nit" ng-model="cliente.nit" placeholder="XXXXXX-X" required>
                                                           <div class="col-sm-12 spd spi">
                                                              <div class="alert alert-danger" ng-show="frm.nit.$dirty && frm.nit.$error.required">Campo requerido</div>
                                                           </div>
                                                    </div>
                                                     <div class="col-sm-3">
                                                         <label for="nombre">Télefono</label>
                                                         <input id="nombre" type="text" class="form-control" name="telefono" ng-model="cliente.telefono" required>
                                                          <div class="col-sm-12 spd spi">
                                                              <div class="alert alert-danger" ng-show="frm.telefono.$dirty && frm.telefono.$error.required">Campo requerido</div>
                                                           </div>
                                                    </div>
                                                     <div class="col-sm-3">
                                                         <label for="celular">Celular</label>
                                                         <input id="celular" type="text" class="form-control" name="celular" ng-model="cliente.celular">
                                                    </div>
                                                     <div class="col-sm-3">
                                                          <label for="name">Tipo Cliente</label>
                                                           <ol class="nya-bs-select" ng-model="cliente.tipo_cliente" title="Selecciona un cliente...">
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
                                                          <label for="name">Dirección</label>
                                                           <input id="name" type="text" class="form-control" name="direccion" ng-model="cliente.direccion" placeholder="Ubicación exacta">
                                                      </div>
                                                      <div class="col-sm-6">
                                                          <label for="email">Email</label>
                                                           <input id="email" type="email" class="form-control" name="email" ng-model="cliente.email">
                                                             <div class="col-sm-12 spd spi">
                                                              <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.email">Email Invalido</div>
                                                           </div>
                                                      </div>
                                                 </div>
                                                 <div class="form-group">
                                                   <div class="col-sm-4 col-md-offset-8">
                                                       <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">GUARDAR Y CREAR</button>
                                                    </div>
                                                    
                                                 </div>
                                                
                                          </form>
                              </div>
                </div>
                {{-- Cliente Asignado --}}
                <div class="middle_caja estilo_middle" ng-if="acti_areapro">
                      <div class="col-sm-12">
                        <div class="col-sm-8">
                          <h3>Nombre</h3>
                          <p>@{{miventa.info_clientes.nombre }} - <small>@{{miventa.info_clientes.empresa }}</small></p>
                        </div>
                        <div class="col-sm-4">
                           <h3>NIT</h3>
                           <p>@{{miventa.info_clientes.nit}}</p>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="col-sm-8">
                          <h3>Dirección</h3>
                          <p>@{{miventa.info_clientes.direccion}}</p>
                        </div>
                        <div class="col-sm-4">
                           <h3>Teléfono</h3>
                           <p>@{{miventa.info_clientes.telefono}}</p>
                        </div>
                      </div>
                </div>
        	   </div>
                
             {{-- Area de Ingreso de productos --}}
             <div class="col-sm-12">
                                  <div class="alert alert-warning" role="alert" ng-if="alertaExistePro"> <strong>Producto Existente</strong> El producto ya esta agregado a la venta</div>  
                              </div>
             <div class="caja_contenido top_conte" ng-if="acti_areapro">
                <div class="agregar_pro conte_nuevo">
                            <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProVenta()" >
                                                  <div class="form-group">
                                                     <div class="col-sm-10 col-md-10 col-lg-11 topinput">
                                                             <ol class="nya-bs-select" ng-model="proventa.id_producto" data-live-search="true"  title="Selecciona un producto..." required data-size="10">
                                                                  <li nya-bs-option="producto in productos" data-value="producto.id">
                                                                    <a>
                                                                     <span>
                                                                      <small class="label label-success">@{{ producto.codigo }}</small>
                                                                          @{{ producto.nombre }}-<strong> Q@{{ producto.preciop | number:2 }} </strong>
                                                                           <small class="label label-info">Stock @{{ producto.stock_producto.stock }}</small>
                                                                          <small class="label label-gris">@{{ producto.codigo_barra }}</small>
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
                <div class="col-sm-12 conte">
                 <table class="table">
                     <thead>
                         <th>Producto</th>
                         <th>Precio</th>
                         <th>Cantidad</th>
                         <th ng-if="mides!=''">Descuento</th>
                         <th>Subtotal</th>
                         <th>Opciones</th>
                     </thead>
                     <tbody>
                        <tr ng-repeat="mipro in misproductos">
                        <td>@{{mipro.nombre_producto.codigo}} - @{{mipro.nombre_producto.nombre}}</td>
                        <td>Q@{{mipro.nombre_producto.preciop | number:2}}</td>
                         <td>@{{mipro.cantidad}}</td>
                         <td ng-if="mides!=''"> <small>Q@{{(mipro.nombre_producto.preciop*mipro.cantidad) | number:2}}</small> - Q@{{((mipro.venta.descuentos_ventas.porcentaje*(mipro.nombre_producto.preciop*mipro.cantidad))/100) | number:2}}</td>
                         <td ng-if="mides==''">Q@{{(mipro.nombre_producto.preciop*mipro.cantidad) | number:2}}</td>
                         <td ng-if="mides!=''">Q@{{((mipro.nombre_producto.preciop*mipro.cantidad)-((mipro.venta.descuentos_ventas.porcentaje*(mipro.nombre_producto.preciop*mipro.cantidad))/100) ) | number:2}}</td>
                         <td>
                                 <div class="area_opciones">
                                                     <ul>
                                                            <li class="ed_drop"  uib-dropdown>
                                                                   <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(mipro)"></a>
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
                                                                     <p>Eliminar <strong>@{{mipro.nombre_producto.codigo}}</strong></p>
                                                                   </div>
                                                                   <div class="col-sm-4 spd spi">
                                                                     <a href="" ng-click="btn_proeliminar(mipro.id)" class=" btn_g ico_eliminarg"></a>
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
                {{-- Area total --}}
                <div class="area_total" ng-if="acti_areapro && misproductos.length > 0" >
                 <div class="col-sm-6 col-md-5 spi">
                   <div class="descuento_venta" ng-if="mides==''">
                             <div class="col-sm-10 spi">
                               <p><strong>Descuento </strong></p>
                               <p> @{{miventa.info_clientes.nombre }}- @{{miventa.info_clientes.porcentaje_cliente.porcentaje}}%</p>
                             </div>
                             <div class="col-sm-2 spd spi">
                                    <a ng-click="aplides(miventa.id_cliente)" class="btn btn-primary btn_porcen"><span class="ico_porcenbtn"></span></a>
                             </div>
                   </div>
                   <div class="descuento_venta" ng-if="mides!=''">
                             <div class="col-sm-10 spi">
                               <p><strong>Descuento Aplicado</strong></p>
                               <p> Deseas quitar el descuento?</p>
                             </div>
                             <div class="col-sm-2 spd spi">
                                    <a ng-click="deldes()" class="btn btn-primary btn_porcenx"><span class="ico_porcenbtnx"></span></a>
                             </div>
                   </div>
                 </div>
                 <div class="col-sm-6 col-md-7" ng-if="mides!=''">
                    <div class="col-sm-6">
                       <h4>Q@{{(miventa.total+miventa.descuentos_ventas.descuento) | number:2 }}</h4>
                       <span>(@{{miventa.descuentos_ventas.porcentaje}}%-Q@{{miventa.descuentos_ventas.descuento | number:2}})</span>
                    </div>
                    <div class="col-sm-6">
                       <p>Q@{{miventa.total | number:2}}</p>
                       <h3>Total</h3>
                    </div>
                 </div>
                  <div class="col-sm-6 col-md-7" ng-if="mides==''">
                        <p>Q@{{miventa.total | number:2}}</p>
                       <h3>Total</h3>
                  </div>
               </div>
             </div>
              
              {{-- Tipo de pago --}}
              <div class="caja_contenido top_conte conte_nuevo sinheight mbotom" ng-if="acti_areapro && misproductos.length > 0">
                   <div class="col-sm-12 tfactura ">
                      <form class="form-horizontal" name="frm" role="form" ng-submit="btn_facturar()" >
                          <div class="form-group">
                                  <div class="col-sm-4">
                                                           <ol class="nya-bs-select" ng-model="factura.tipo_pago" title="Tipo de pago..." required>
                                                              <li nya-bs-option="tpago in tpagos" data-value="tpago.id">
                                                                <a>
                                                                  @{{ tpago.pago }}
                                                                  <span class="glyphicon glyphicon-ok check-mark"></span>
                                                                </a>
                                                              </li>
                                                            </ol>
                                                          
                                  </div>
                                  <div class="col-sm-5" ng-if="factura.tipo_pago!=4">
                                      <label for="name">Referencia</label>
                                       <input id="referencia" type="text" class="form-control" name="referencia" ng-model="factura.referencia" placeholder="# Ref POS ó No.Cheque">
                                  </div>

                                  <div class="col-sm-5" ng-if="factura.tipo_pago==4">
                                          <div class="col-sm-6">
                                                <ol class="nya-bs-select" ng-model="factura.dias_credito" title="Dias de crédito" required>
                                                              <li nya-bs-option="dia in diascre" data-value="dia.dias">
                                                                <a>
                                                                  @{{ dia.nombre }}
                                                                  <span class="glyphicon glyphicon-ok check-mark"></span>
                                                                </a>
                                                              </li>
                                                            </ol>
                                          </div>
                                          <div class="col-sm-6">
                                              <label for="name">Referencia</label>
                                       <input id="referencia" type="text" class="form-control" name="referencia" ng-model="factura.referencia" placeholder="# Ref POS ó No.Cheque">
                                          </div>
                                    
                                  </div>

                                <div class="col-sm-3">
                                   <input type="hidden" ng-model="idventa"/>
                                  <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">FACTURAR</button>
                                </div>
                          </div>
                      </form>
                   </div>
              </div>
   </div>



    <div class="col-sm-12" ng-if="termi_venta">
    {{-- Venta Terminada --}}
              <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                 <div class="caja_contenido top_conte">
                       <div class="info_final">
                              <h3>Wakami Guatemala S.A.</h3>
                              <h4>12 av. 14-68 Zona 10, Guatemala</h4>
                                  {{-- Información de cliente --}}
                               <div class="info_finalusuario" ng-if="acti_areapro" ng-repeat="mi in miventa">
                                  <div class="col-sm-12">
                                      <p>Nombre:@{{mi.info_clientes.empresa }}</p>
                                       <p>NIT: @{{mi.info_clientes.nit}}</p>
                                  </div>
                                  <div class="col-sm-12">
                                      <p>Dirección: @{{mi.info_clientes.direccion}}</p>
                                       <p>Teléfono: @{{mi.info_clientes.telefono}}</p>
                                  </div>
                             </div>
                                  {{-- Información de productos --}}
                              <div class="info_finalproductos" ng-if="acti_areapro">
                                    <table>
                                      <thead>
                                        <tr>
                                          <th>Cant.</th>
                                          <th>Descripción</th>
                                          <th>Subtotal</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                       <tr ng-repeat="mipro in misproductos">
                                            <td>@{{mipro.cantidad}}</td>
                                            <td>@{{mipro.nombre_producto.nombre}}</td>
                                            <td>Q@{{(mipro.nombre_producto.preciop*mipro.cantidad) | number:2}}</td>
                                        </tr>     
                                      </tbody>
                                    </table>
                              </div>
                              <div class="info_finaltotal">
                                   <div class="eltotal">
                                     <p ng-repeat="mi in miventa">Total <strong>Q@{{mi.total | number:2}}</strong></p>
                                   </div>
                              </div>
                              <div class="col-sm-12 spd spi">
                                <div class="col-sm-6">
                                    <a class="btn btn-primary btn_regis">IMPRIMIR</a>
                                </div>
                                <div class="col-sm-6">
                                  <a class="btn btn_cancelar" ng-click="iraventas()">IR A VENTAS</a>
                                </div>
                              </div>
                       </div>
                 </div>
              </div>

    </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/VentasCtrl.js"></script>
@endpush