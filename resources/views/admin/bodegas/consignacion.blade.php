@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
  <div class="col-md-12 top_conte" ng-controller="ConsignacionCtrl" ng-cloak>
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
                                       <ol class="nya-bs-select" ng-model="consignacion.id_cliente" data-live-search="true" title="Selecciona un cliente..." required>
                                            <li nya-bs-option="cliente in clientes | orderBy:'-id' " data-value="cliente.id">
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
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid || loading" button-spinner="loading" >GUARDAR</button>
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
                          {{-- Busqueda de productos de envio --}}
                            <div class="col-sm-12 mtop">
                                   <div class="busqueda_texto col-sm-4 spd spi">
                                  <input type="text" id="query" ng-model="query"  onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de productos.." />
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
                                               <th>Distribuidor</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proenvio in proenvios | filter:query">
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
                                               <th>Distribuidor</th>
                                               <th>Subtotal</th>
                                               <th>Estado</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proenvio in proenvios | filter:query">
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
                                    <h1>Q@{{proenvios | SumaItem:'subtotal'}} <small>@{{proenvios | SumaCanti:'cantidad'}} uni.</small></h1>
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
   <div id="area_mas" ng-if="nuevafac_obj">
          <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Factura para @{{miconsigna.info_cliente.nombre}} de consignación</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarf()"></a>
                        </div>
          </div>
          <div class="conte_nuevo">
              <div class="col-sm-12 spd spi">
                      <div class="col-sm-3">
                           <h3>Nombre</h3>
                           <p>@{{miconsigna.info_cliente.nombre}}</p>
                      </div>
                      <div class="col-sm-3">
                                  <h3>NIT</h3>
                                   <p>@{{miconsigna.info_cliente.nit}}</p>
                      </div>
                      <div class="col-sm-3">
                                   <h3>DIRECCIÓN</h3>
                                   <p>@{{miconsigna.info_cliente.direccion}}</p>
                      </div>
                      <div class="col-sm-3">
                                  <h3>TELÉFONO</h3>
                                   <p>@{{miconsigna.info_cliente.telefono}}</p>
                      </div>
              </div>
              {{-- Crear venta --}}
              <div class="col-sm-12" ng-if="active_crear">
                     <div class="btn_nuevo">
                        <a href="" ng-click="crearventa(miconsigna.id_cliente)">Crear venta</a>
                    </div>
                  
              </div>
              {{-- Agregar productos de consignación --}}

               <div class="col-sm-12">
                  <div class="alert alert-warning" role="alert" ng-if="alertaExistePro"> <strong>Producto Existente</strong> El producto ya esta agregado a la venta</div> 
                 
              </div>
              <div class="col-sm-12 top_conte" ng-if="active_venta">
                       <div class="agregar_pro conte_nuevo">
                                <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProVenta()" >
                                                      <div class="form-group">
                                                         <div class="col-sm-10 col-md-10 col-lg-11 topinput">
                                                                 <ol class="nya-bs-select" ng-model="proventa.id_producto" data-live-search="true"  title="Selecciona un producto..." required data-size="10">
                                                                      <li nya-bs-option="producto in proconsignaciones" data-value="producto.id_producto">
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
                                                           
                                                            <div class="col-sm-2 col-md-2 col-lg-1 spi">
                                                                <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid"><span class="ico_agregar"></span></button>
                                                            </div>
                                                       </div>
                                                 </form>
                    </div>
                    {{-- Listado de producto para la venta --}}
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
                <div class="area_total" ng-if="active_venta && misproductos.length > 0" >
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
                       <h5>Total</h5>
                    </div>
                 </div>
                  <div class="col-sm-6 col-md-7" ng-if="mides==''">
                        <p>Q@{{miventa.total | number:2}}</p>
                       <h5>Total</h5>
                  </div>
               </div>

              </div>

              {{-- Tipo de pago --}}
              <div class="top_conte sinheight mbotom" ng-if="active_venta && misproductos.length > 0">
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
                                    <input type="hidden" ng-model="idventa"/>
                                  <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid || loading" button-spinner="loading" >FACTURAR</button>
                                </div>
                          </div>
                      </form>
                   </div>
              </div>

              <div class="col-sm-12" ng-if="termi_venta">
                              {{-- Venta Terminada --}}
                                        <div class="col-sm-12">
                                           <div class="top_conte" >
                                                 <div id="areaimpresion" class="info_final">
                                                      <table width="100%">
                                                              <tr><td><h3>FILUM COPROPIEDAD</h3></td></tr>
                                                              <tr><td><h3>Wakami</h3></td></tr>
                                                              <tr><td><h4>@{{misucursal.ubicacion}}</h4></td></tr>
                                                              <tr><td><h4 ng-if="misucursal.id==2">TEL: 2336-7398</h4><h4 ng-if="misucursal.id==4">TEL: 2472-8610</h4></td></tr>
                                                              <tr><td><h4>NIT: 8150406-3</h4></td></tr>
                                                              <tr><td><h4>Serie: FACE-@{{misucursal.serie}}</h4></td></tr>
                                                              <tr><td><h4>Del 1 Al 1000000</h4></td></tr>
                                                              <tr><td><h4>De Fecha: @{{misucursal.fresolucion}}</h4></td></tr>
                                                               <tr><td><h4><strong>FACTURA ELECTRÓNICA</strong></h4></td></tr>
                                                               <tr><td><h4><strong>@{{miventa.dte}}</strong></h4></td></tr>
                                                         </table>
                                                            {{-- Información de cliente --}}
                                                      <div class="info_finalusuario">
                                                            <table>
                                                                <tr><td><p>Fecha: @{{miventa.fecha_factura}}</p>
                                                                <tr><td><p ng-if="miventa.info_clientes.empresa!=''">Nombre:@{{miventa.info_clientes.empresa }}</p></td></tr>
                                                               <tr><td> <p ng-if="miventa.info_clientes.empresa==''">Nombre:@{{miventa.info_clientes.nombre }}</p></td></tr>
                                                                <tr><td> <p>NIT: @{{miventa.info_clientes.nit}}</p></td></tr>
                                                                <tr><td> <p>Dirección: @{{miventa.info_clientes.direccion}}</p></td></tr>
                                                           </table>
                                                       </div>
                                                            {{-- Información de productos --}}
                                                        <div class="info_finalproductos">
                                                        <div class="col-sm-12 spd spi">
                                                             <p class="ptit">Productos</p>
                                                        </div>
                                                        <div class="col-sm-12 spd spi">
                                                                 <div class="col-sm-12 spd spi" ng-repeat="mipro in misproductos">
                                                                      <p ng-if="miventa.descuentos_ventas==null"><strong>@{{mipro.nombre_producto.codigo}}</strong> @{{mipro.nombre_producto.nombre}}-Q@{{mipro.precio_producto | number:2}} X  @{{mipro.cantidad}}- <strong>Q@{{(mipro.precio_producto*mipro.cantidad) | number:2}}</strong></p>

                                                                      <p ng-if="miventa.descuentos_ventas!=null"><strong>@{{mipro.nombre_producto.codigo}}</strong> @{{mipro.nombre_producto.nombre}}-Q@{{(mipro.precio_producto-((mipro.precio_producto*miventa.descuentos_ventas.porcentaje)/100)) | number:2}} X  @{{mipro.cantidad}}- <strong>Q@{{((mipro.precio_producto-((mipro.precio_producto*miventa.descuentos_ventas.porcentaje)/100)) *mipro.cantidad) | number:2}}</strong></p>
                                                                  </div>  
                                                        </div>
                                                             
                                                           
                                                        </div>
                                                        <div class="info_finaltotal">
                                                             <div class="eltotal">
                                                               <p>Total <strong>Q@{{miventa.total | number:2}}</strong></p>
                                                             </div>
                                                             <div class="footerimp">
                                                                <span>Documento Tributario Electrónico Según Resolución SAT</span>
                                                                <span>@{{misucursal.resolucion}}</span>
                                                                <span>De Fecha: 21-SEP-16 Serie: FOAK Del 1 Al 1000000 </span>
                                                                <span>GFACE: INFILE,S.A. NIT: 1252133-7 </span>
                                                                <h4>SUJETO A PAGOS TRIMESTRALES</h4>
                                                                <h5>No se aceptan cambios ni devoluciones, exceptuando por defectos de producción 2 meses después de la compra presentando esta factura.</h5>
                                                             </div>
                                                        </div>
                                                       
                                                 </div>
                                                  <div class="col-sm-12 spd spi">
                                                          <div class="col-sm-6">
                                                              <a class="btn btn-primary btn_regis" ng-print print-element-id="areaimpresion">IMPRIMIR</a>
                                                          </div>
                                                          <div class="col-sm-6">
                                                            <a class="btn btn_cancelar" ng-click="iraventas()">IR A VENTAS</a>
                                                          </div>
                                                  </div>
                                           </div>
                                        </div>


                              </div>
          </div>
   </div>   

   {{-- Area de ventas por consignacion --}}

   <div id="area_mas" ng-if="ven_obj">   
          <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Cosignación para @{{exisConsignacion.info_cliente.nombre}} - @{{exisConsignacion.info_cliente.empresa}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarv()"></a>
                        </div>
          </div>
          <div class="conte_nuevo">
              <div class="col-sm-12 spd spi table_height">
                     <table class="table">
                         <thead>
                         <th></th>
                             <th>No.Factura</th>
                             <th>Total</th>
                              <th>Pago</th>
                             <th>Fecha Factura</th>
                             <th>Opciones</th>
                         </thead>
                         <tbody>
                             <tr ng-repeat="venta in ventas | filter: query | orderBy:'-id'"  ng-class="{'trc_ama':venta.estado_ventas==1,'trc_ver':venta.estado_ventas==3}">
                               <td class="td_first"></td>
                                   <td ng-click="abrirventa(venta)"><small>@{{venta.dte}}</small></td>
                                 <td class="tot_venta" ng-click="abrirventa(venta)">@{{venta.total | currency: 'Q'}}</td>
                                  <td ng-switch="venta.pago_venta.tipo_pago" ng-click="abrirventa(venta)">
                                       <span ng-switch-when="1" class="ico_td ico_pefectivo">Efectivo</span>
                                       <span ng-switch-when="2" class="ico_td ico_ppos">POS</span>
                                       <span ng-switch-when="3" class="ico_td ico_pcheque">Cheque</span>
                                       <span ng-switch-when="4" class="ico_td ico_pcredito">Crédito</span>
                                 </td>
                                  <td>@{{venta.fecha_factura  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                                 
                                 <td>
                                     <div class="area_opciones" >
                                         <ul>
                                             <li class="op_drop"  uib-dropdown ng-if="venta.estado_ventas==1">
                                                   <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                                   <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                       <div class="col-sm-8 spd">
                                                         <p>Eliminar Venta No.Fac <strong>@{{venta.id}}</strong></p>
                                                       </div>
                                                       <div class="col-sm-4 spd spi">
                                                         <a href="" ng-click="btn_eliminar(venta.id)" class=" btn_g ico_eliminarg"></a>
                                                       </div>
                                                    </div>
                                             </li>
                                              <li><a href="" class="ico_pdf" ng-if="venta.estado_ventas==2 || venta.estado_ventas==3  || venta.estado_ventas==4" ng-click="btn_pdf(venta.id)"></a></li>
                                         </ul>
                                     </div>
                                 </td>
                             </tr>
                            
                         </tbody>
                     </table>
              </div>
          </div>
   </div>                        

{{-- Area de consignacion selecccionada --}}
   <div id="area_mas" ng-if="mas_obj">
          <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Consignación para @{{exisConsignacion.info_cliente.nombre}} - @{{exisConsignacion.info_cliente.empresa}}</h1>
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
                 <div class="col-sm-12">
                                   <div class="busqueda_texto col-sm-4 spd spi">
                                  <input type="text" id="query" ng-model="query"  onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de productos.." />
                                   </div>
                  <div class="btn_nuevo">
                        <a href="" ng-click="nuevafactura(exisConsignacion)">Nueva Factura</a>
                    </div>
                       <div class="btn_nuevo">
                        <a href="" ng-if="creandoexcel" ng-click="crearexcel(exisConsignacion.id)">Crear excel</a>
                        <a href="/exports/consignaciones/Consignacion-No@{{exisConsignacion.id}}.xlsx"  ng-if="descargarexcel" >Descargar Excel</a> 
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="alert alert-warning" role="alert" ng-if="alertaCreaExcel"> <strong>Excel creado para</strong> @{{exisConsignacion.info_cliente.nombre}}</div>          <div class="alert alert-info" role="alert" ng-if="alertaEditadoProA"> <strong>Producto Ajustado</strong> Puedes ver en el listado de productos las modificaciones realizadas.</div>  
                </div>
                {{-- Productos de stock en bodgea --}}

                      <div class="col-sm-12 conte table_height">
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Costo</th>
                                               <th>Distribuidor</th>
                                               <th>Precio Publico</th>
                                               <th>Stock</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="proconsignacion in proconsignaciones | filter: query">
                                                   <td> <small class="label label-success">@{{ proconsignacion.nombre_producto.codigo }}</small>
                                                      @{{proconsignacion.nombre_producto.nombre}}</td>
                                                     <td>Q@{{proconsignacion.nombre_producto.costo | number:2 }}</td>
                                                       <td>Q@{{(proconsignacion.nombre_producto.preciop-((exisConsignacion.info_cliente.porcentaje_cliente.porcentaje*proconsignacion.nombre_producto.preciop)/100)) | number:2}}</td>
                                                     <td>Q@{{proconsignacion.nombre_producto.preciop | number:2}}</td>
                                                   <td>@{{proconsignacion.stock}} </td>
                                                   <td ng-init="$parent.totalcosto = $parent.totalcosto + (proconsignacion.nombre_producto.costo * proconsignacion.stock); $parent.totalprecio = $parent.totalprecio + (proconsignacion.nombre_producto.preciop * proconsignacion.stock) ">
                                                   <small class="label label-info">Q@{{(proconsignacion.nombre_producto.costo*proconsignacion.stock) | number:2}}</small>
                                                     Q@{{(proconsignacion.nombre_producto.preciop*proconsignacion.stock) | number:2}}
                                                   </td>
                                                   <td>
                                                     <div class="area_opciones">
                                                               <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_ajustar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editaraj(proconsignacion)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="ajustarStock()" >
                                                                                       <div class="col-sm-9 ">
                                                                                       <label>@{{ proconsignacion.nombre_producto.codigo }} - Stock @{{proconsignacion.stock}} </label>
                                                                                           <input id="name" type="number" class="form-control" name="nombre" ng-model="existeProA.stock" required>
                                                                                       </div>
                                                                                       <div class="col-sm-9 ">
                                                                                           <input id="name" type="text" class="form-control" name="nombre" ng-model="existeProA.justificacion"  required>
                                                                                       </div>
                                                                                       <div class="col-sm-3 spd spi">
                                                                                        <button type="submit" class="btn_g btn_ajustarg" ng-disabled="frmed.$invalid"></button>
                                                                                       </div>
                                                                                </form>
                                                                                </div>
                                                                         </li>
                                                              
                                                           </ul>
                                                         </div> 
                                                   </td>
                                               </tr>
                                              
                                           </tbody>
                                       </table>
                      </div>
                        <div class="col-sm-12 footer">
                              <div class="col-sm-4">
                                    <h3>Total Consignación</h3>
                                    <h1><small>Q@{{totalprecio  | number:2}}</small></h1>
                              </div>
                              <div class="col-sm-4">
                                    <h3>Total Costo</h3>
                                    <h1><small>Q@{{totalcosto  | number:2}}</small></h1>
                              </div>
                              <div class="col-sm-4">
                                    <h3>Cantidad</h3>
                                    <h1><small>@{{proconsignaciones | SumaCanti:'stock'}} unidades</small></h1>
                              </div>
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
	                                     <li><a href="" class="ico_factura" ng-click="abrirventascon(consignacion)"></a></li>
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
                             
                               <th>Consignación</th>
                               <th>Distribuidor</th>
                               <th>Público</th>
                               <th>Fecha de Entrega</th>
                               <th>Fecha de Movimiento</th>
                               <th></th>
                           </thead>
                           <tbody>
                              <tr ng-repeat="envio in envios | filter: busfiltro | orderBy:'-id'" ng-class="{'trc_ama':envio.estado_orden==1}">
                              <td class="td_first"></td>
                              <td ng-click="abrirorden(envio)">@{{envio.nombre_consignacion.info_cliente.nombre}}</td>
                              <td ng-click="abrirorden(envio)">@{{(envio.total_compra-((envio.nombre_consignacion.info_cliente.porcentaje_cliente.porcentaje*envio.total_compra)/100)) | currency: 'Q'}}</td>
                               <td ng-click="abrirorden(envio)">@{{(envio.total_compra) | currency: 'Q'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.fecha_entrega  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.updated_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                               <td>
                                     <div class="area_opciones" >
                                         <ul>
                                            
                                              <li><a href="" class="ico_pdf" ng-if="envio.estado_orden==2" ng-click="btn_pdfenvio(envio.id)"></a></li>
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