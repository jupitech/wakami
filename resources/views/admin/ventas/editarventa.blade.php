@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="VentaECtrl" ng-cloak>

	{{-- Editar Venta --}}
	
	 <div class="header_conte">
              <h1>Editar Venta</h1>
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
                        <p ng-if="mitipo==1">Cliente Individual</p>
                        <p ng-if="mitipo==2">Cliente de Consignación</p>
                        <p ng-if="mitipo==3">Cliente de Contado</p>
                        <p ng-if="mitipo==4">Cliente al Crédito</p>
                        <h3></h3>
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
                                                     <div class="col-sm-10 col-md-10 col-lg-11 topinput" ng-if="mitipo!=2">
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

                                                         <div class="col-sm-10 col-md-10 col-lg-11 topinput" ng-if="mitipo==2">
                                                             <ol class="nya-bs-select" ng-model="proventa.id_producto" data-live-search="true"  title="Selecciona un producto..." required data-size="10">
                                                                  <li nya-bs-option="producto in productos" data-value="producto.id_producto">
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
      {{-- Tipo de pago --}}
            <div class="caja_contenido top_conte conte_nuevo sinheight mbotom" ng-if="acti_areapro && misproductos.length > 0">
                <div class="col-sm-12 tfactura ">
                    <form class="form-horizontal" name="frm" role="form" ng-submit="btn_facturar()" >
                        <div class="form-group">
                            <div class="col-sm-3">
                                          <div class="col-sm-12 spd spi">
                                               <ol class="nya-bs-select" ng-model="factura.tipo_pago" title="Tipo de pago..." required>
                                                <li nya-bs-option="tpago in tpagos" data-value="tpago.id">
                                                    <a>
                                                        @{{ tpago.pago }}
                                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                                    </a>
                                                </li>
                                            </ol>
                                          </div>

                                          <div class="col-sm-12 spd spi" ng-if="factura.elmonto>0 && factura.elmonto<miventa.total">
                                               <ol class="nya-bs-select" ng-model="factura.tipo_pago2" title="Tipo de pago..." required>
                                                <li nya-bs-option="tpago in tpagado" data-value="tpago.id">
                                                    <a>
                                                        @{{ tpago.pago }}
                                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                                    </a>
                                                </li>
                                            </ol>
                                          </div>
                               

                            </div>
                            <div class="col-sm-3">
                                     <div class="col-sm-12 spd spi">
                                        <div class="col-sm-6 spi">
                                         <label for="name">Total</label>
                                             <input id="total" type="text" class="form-control" name="total" ng-model="miventa.total"  ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" readonly>
                                        </div>
                                        <div class="col-sm-6 spd">
                                         <label for="name">Aporte</label>
                                             <input id="elmonto" type="text" class="form-control" name="elmonto" ng-model="factura.elmonto"  min="1" ng-min="1"  ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01">
                                        </div>
                                         
                                       
                                     </div>
                                    <div class="col-sm-12 spd spi" ng-if="factura.elmonto>0 && factura.elmonto<miventa.total">
                                          <label for="name">Ajuste total</label>
                                        <input id="elmonto2" type="text" class="form-control" name="elmonto2" ng-model="factura.elmonto2" ng-value="miventa.total-factura.elmonto" ng-pattern="/^[0-9]*$/" readonly>
                                        <p>@{{factura.elmonto2}}</p>
                                     </div>
                               
                            </div>
                            <div class="col-sm-4" ng-if="factura.tipo_pago!=4">
                                        {{-- Cheque o Deposito --}}
                                        <div class="col-sm-12 spd spi" ng-if="factura.tipo_pago==3 || factura.tipo_pago==5">
                                             <label for="name">Referencia</label>
                                            <input id="referencia" type="text" class="form-control" name="referencia" ng-model="factura.referencia" placeholder="# Ref POS ó No.Cheque">
                                        </div>
                                        {{-- POS/Tarjeta --}}
                                        <div class="col-sm-12 spd spi" ng-if="factura.tipo_pago==2">
                                             <label for="name">Referencia</label>
                                            <div class="col-sm-6 spi">
                                              <ol class="nya-bs-select" ng-model="factura.tarjeta" title="Tarjeta Crédito..." required>
                                                    <li nya-bs-option="tarjeta in ttarjetas" data-value="tarjeta.nombre">
                                                        <a>
                                                            @{{ tarjeta.nombre }}
                                                            <span class="glyphicon glyphicon-ok check-mark"></span>
                                                        </a>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-6 spd">
                                                 <input id="referencia" type="text" class="form-control" name="referencia" ng-model="factura.referencia" placeholder="# Ref POS ó No.Cheque">
                                            </div>
                                           
                                        </div>
                                        <div class="col-sm-12 spd spi" ng-if="factura.elmonto>0 && factura.elmonto<miventa.total">
                                             {{-- Cheque o Deposito --}}
                                                    <div class="col-sm-12 spd spi" ng-if="factura.tipo_pago==3 || factura.tipo_pago==5">
                                                         <label for="name">Referencia</label>
                                                        <input id="referencia" type="text" class="form-control" name="referencia2" ng-model="factura.referencia2" placeholder="# Ref POS ó No.Cheque">
                                                    </div>
                                                    {{-- POS/Tarjeta --}}
                                                    <div class="col-sm-12 spd spi" ng-if="factura.tipo_pago2==2">
                                                         <label for="name">Referencia</label>
                                                        <div class="col-sm-6 spi">
                                                          <ol class="nya-bs-select" ng-model="factura.tarjeta2" title="Tarjeta Crédito..." required>
                                                                <li nya-bs-option="tarjeta in ttarjetas2" data-value="tarjeta.nombre">
                                                                    <a>
                                                                        @{{ tarjeta.nombre }}
                                                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                                                    </a>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                        <div class="col-sm-6 spd">
                                                             <input id="referencia" type="text" class="form-control" name="referencia2" ng-model="factura.referencia2" placeholder="# Ref POS ó No.Cheque">
                                                        </div>
                                                 </div>
                                           
                                        </div>
                             </div>
                            <div class="col-sm-4" ng-if="factura.tipo_pago==4">
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

                            <div class="col-sm-2">
                                <input type="hidden" ng-model="idventa"/>
                                <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid || loading" button-spinner="loading" >FACTURAR</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
   </div>



    <div class="col-sm-12" ng-if="termi_venta">
    {{-- Venta Terminada --}}
              <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                 <div class="caja_contenido top_conte" >
                       <div id="areaimpresion" class="info_final">
                            <table width="100%" ng-if="acti_areapro">
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
                            <div class="info_finalusuario" ng-if="acti_areapro">
                                  <table>
                                      <tr><td><p>Fecha: @{{miventa.fecha_factura}}</p>
                                      <tr><td><p ng-if="miventa.info_clientes.empresa!=''">Nombre:@{{miventa.info_clientes.empresa }}</p></td></tr>
                                     <tr><td> <p ng-if="miventa.info_clientes.empresa==''">Nombre:@{{miventa.info_clientes.nombre }}</p></td></tr>
                                      <tr><td> <p>NIT: @{{miventa.info_clientes.nit}}</p></td></tr>
                                      <tr><td> <p>Dirección: @{{miventa.info_clientes.direccion}}</p></td></tr>
                                 </table>
                             </div>
                                  {{-- Información de productos --}}
                              <div class="info_finalproductos" ng-if="acti_areapro">
                              <div class="col-sm-12 spd spi">
                                   <p class="ptit">Productos</p>
                              </div>
                              <div class="col-sm-12 spd spi">
                                       <div class="col-sm-12 spd spi" ng-repeat="mipro in misproductos">
                                            <p><strong>@{{mipro.nombre_producto.codigo}}</strong> @{{mipro.nombre_producto.nombre}}-Q@{{mipro.nombre_producto.preciop | number:2}} X  @{{mipro.cantidad}}- <strong>Q@{{(mipro.nombre_producto.preciop*mipro.cantidad) | number:2}}</strong></p>
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
                                      <h5>No se aceptan cambios ni devoluciones, exceptuando por defectos de producción 30 dias después de la compra presentando esta factura.</h5>
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
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/VentasCtrl.js"></script>
@endpush