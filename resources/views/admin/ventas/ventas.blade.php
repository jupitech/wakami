@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="VentasCtrl">

   {{-- Area de venta seleccionada --}}
      <div id="area_mas" ng-if="mas_obj">
           <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Venta No.@{{exisVenta.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
            </div>
            <div class="conte_nuevo">
                    <div class="col-sm-6">
                      <div class="info_cliente">
                           <h2>Cliente</h2>
                           <p><strong>Nombre: </strong>@{{exisVenta.info_clientes.nombre}}-@{{exisVenta.info_clientes.empresa}} </p>
                           <p><strong>NIT: </strong>@{{exisVenta.info_clientes.nit}}</p>
                           <p><strong>Dirección: </strong>@{{exisVenta.info_clientes.direccion}}</p>
                           <p><strong>Teléfono: </strong>@{{exisVenta.info_clientes.telefono}} / @{{exisVenta.info_clientes.celular}}</p>
                           <p ng-switch="exisVenta.info_clientes.tipo_cliente"><strong>Tipo de cliente: </strong>
                            <span ng-switch-when="1">Individual</span>
                             <span ng-switch-when="2">Empresa</span>
                           </p>
                      </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="info_cliente">
                           <h2>Datos de factura</h2>
                           <p><strong>No.Factura: </strong>@{{exisVenta.dte}} </p>
                            <p><strong>Sucursal: </strong>@{{exisVenta.nombre_sucursal.nombre}}</p>
                           <p  ng-switch="exisVenta.pago_venta.tipo_pago"><strong>Tipo de pago: </strong>
                               <span ng-switch-when="1">Efectivo</span>
                               <span ng-switch-when="2">POS</span>
                               <span ng-switch-when="3">Cheque</span>
                               <span ng-switch-when="4">Crédito</span>
                            - Ref: @{{exisVenta.pago_venta.referencia}}
                           </p>
                           <p><strong>Fecha de factura: </strong>@{{exisVenta.fecha_factura | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</p>
                      </div>
                    </div>

                    <div class="col-sm-12">
                     <div class="info_cliente">
                     <h2>Poductos</h2>
                     <div class="col-sm-12 conte table_height">
                       <table class="table">
                          <thead>
                            <tr>
                              <th>Cod.</th>
                              <th>Producto</th>
                              <th>Precio</th>
                              <th>Cantidad</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr  ng-repeat="miproducto in misproductos">
                                <td>@{{miproducto.nombre_producto.codigo}}</td>
                                <td>@{{miproducto.nombre_producto.nombre}}</td>
                                <td ng-if="miproducto.venta.descuentos_ventas==null">@{{miproducto.nombre_producto.preciop | currency: 'Q'}}</td>
                                <td ng-if="miproducto.venta.descuentos_ventas!=null">@{{(miproducto.nombre_producto.preciop-((miproducto.nombre_producto.preciop*miproducto.venta.descuentos_ventas.porcentaje)/100)) | currency: 'Q'}}</td>
                                <td>X @{{miproducto.cantidad}}</td>
                                 <td ng-if="miproducto.venta.descuentos_ventas==null">@{{miproducto.nombre_producto.preciop*miproducto.cantidad | currency: 'Q' }}</td>
                                 <td ng-if="miproducto.venta.descuentos_ventas!=null">@{{(miproducto.nombre_producto.preciop-((miproducto.nombre_producto.preciop*miproducto.venta.descuentos_ventas.porcentaje)/100))*miproducto.cantidad | currency: 'Q' }}</td>
                            </tr>
                          </tbody>
                        </table>
                     </div>
                      <div class="col-sm-12 footer">
                              <div class="col-sm-4">
                                    <h3>Total</h3>
                                    <h1>@{{exisVenta.total | currency: 'Q' }} <small>@{{misproductos | SumaCanti:'cantidad'}} uni.</small></h1>
                              </div>
                      </div>
                        

                     </div>
                    </div>

            </div>

      </div>

	{{-- Ventas --}}
	
	 <div class="header_conte">
              <h1>Ventas</h1>
                <div class="btn_nuevo">
                    <a href="{{ URL::to('/nuevaventa') }}">Nueva Venta</a>
                </div>
     </div>
	<div class="col-sm-12">
      <div class="filtros col-sm-12 spd spi">
            <a class="btn_filtro" ng-click="btn_dia()" ng-class="{'btn_active': act_btn==1}">Día</a>
            <a class="btn_filtro" ng-click="btn_mes()" ng-class="{'btn_active': act_btn==2}">Mes</a>
            <a class="btn_filtro" ng-click="btn_anio()"  ng-class="{'btn_active': act_btn==3}">Año</a>
            
      </div>
      
      <div class="filtros col-sm-12 spd spi" ng-if="ca_dias">
              <div class="col-sm-4">
                <form class="form-horizontal" name="frm" role="form" ng-submit="filtrarDia()" >
                       <div class="form-group">
                               <div class="col-sm-8 spi">
                                        <input type="date" class="form-control" name="dia" ng-model="mifecha.dia" required>
                               </div>
                               <div class="col-sm-4 spd spi">
                                  <button type="submit" class="btn btn-primary btn_peq btn_regis" ng-disabled="frm.$invalid">FILTRAR</button>
                               </div>
                       </div>
                </form>
              </div>
      </div>
      <div class="filtros col-sm-12 spd spi" ng-if="ca_meses">
            <div class="col-sm-4">
                <form class="form-horizontal" name="frm" role="form" ng-submit="filtrarMes()" >
                       <div class="form-group">
                               <div class="col-sm-8 spi">
                                        <ol class="nya-bs-select ol_peq" ng-model="mifecha.mes" title="Selecciona un mes..." required>
                                            <li nya-bs-option="mes in meses" data-value="mes.id">
                                              <a>
                                                @{{ mes.mes }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                               </div>
                               <div class="col-sm-4 spd spi">
                                  <button type="submit" class="btn btn-primary btn_peq btn_regis" ng-disabled="frm.$invalid">FILTRAR</button>
                               </div>
                       </div>
                </form>
              </div>
      </div>
      <div class="filtros col-sm-12 spd spi" ng-if="ca_anios">
             <div class="col-sm-4">
                <form class="form-horizontal" name="frm" role="form" ng-submit="filtrarAnio()" >
                       <div class="form-group">
                               <div class="col-sm-8 spi">
                                        <ol class="nya-bs-select ol_peq" ng-model="mifecha.anio" title="Selecciona un anio..." required>
                                            <li nya-bs-option="anio in anios" data-value="anio.id">
                                              <a>
                                                @{{ anio.id }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                               </div>
                               <div class="col-sm-4 spd spi">
                                  <button type="submit" class="btn btn-primary btn_peq btn_regis" ng-disabled="frm.$invalid">FILTRAR</button>
                               </div>
                       </div>
                </form>
              </div>
      </div>

      <div class="ventasdia col-sm-12 spd spi">
        <div class="col-sm-7  col-md-7 col-lg-6 spi">
            <div class="caja_contenido">
              <h1>Tipo de pago</h1>
              <table class="table tablepago">
                <thead>
                  <tr>
                    <th>Pago</th>
                    <th ng-repeat="sucursal in ventadiasucu  | orderBy:'codigo_esta'">@{{sucursal.nombre}}</th>
                    <th> Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr  ng-repeat="(key, value) in ventadiapago | groupBy: 'tipo_pago'">
                    <td  ng-switch="key">
                     <span ng-switch-when="1">Efectivo</span>
                     <span ng-switch-when="2">Tarjeta/POS</span>
                     <span ng-switch-when="3">Cheque</span>
                     <span ng-switch-when="4">Al Crédito</span>
                     <span ng-switch-when="5">Depósito</span>
                    </td>
                    <td ng-repeat="sucursal in ventadiasucu | orderBy:'codigo_esta'" class="td_2col" ng-click="selecventa(key,sucursal.id)">
                         <div ng-repeat="diapago in value | orderBy:'codigo_esta'" ng-if=" sucursal.codigo_esta==diapago.codigo_esta">
                           <div class="col-sm-4 spd spi"><span>@{{diapago.cantidad}}</span> </div>
                            <div class="col-sm-8  spd spi"> <p>@{{diapago.total| currency: 'Q'}}</p></div>
                        </div>
                       

                    </td>
                    {{-- Subtotales --}}
                    <td  class="td_2col" >
                            <div class="col-sm-4 spd spi"><span>@{{value | SumaCanti:'cantidad'}}</span> </div>
                            <div class="col-sm-8  spd spi"> <p>@{{value | SumaItem:'total' | currency: 'Q'}}</p></div>
                     </td>
                   

                  </tr>
                </tbody>
                 {{-- Totales --}}
                  <tfoot>
                    <tr>
                        <td>Totales</td>
                          <td ng-repeat="sucursal in ventadiasucu | orderBy:'codigo_esta'"  class="td_2col" >
                            <div class="col-sm-4 spd spi"><span>@{{sucursal.cantidad}}</span> </div>
                                <div class="col-sm-8  spd spi"> <p>@{{sucursal.total| currency: 'Q'}}</p></div>
                          </td>
                          <td class="td_2col" >
                            <div class="col-sm-4 spd spi"><span>@{{ventadiasucu | SumaCanti:'cantidad'}}</span> </div>
                            <div class="col-sm-8  spd spi"> <strong><p>@{{ventadiasucu | SumaItem:'total' | currency: 'Q'}}</p></strong></div>
                          </td>
                  </tr>
                  </tfoot>
              </table>
            </div>
          </div>
          <div class="col-sm-5  col-md-5 col-lg-3 spi">
            <div class="caja_contenido">
              <h1>Ventas por sucursal</h1>
              <ul class="lisdia">
                  <li ng-repeat="sucursaldia in ventadiasucursal" class="col-sm-4">
                  <h2>@{{sucursaldia.nombre_sucursal.nombre}}</h2>
                  <h3>@{{sucursaldia.cantidad}}</h3>
                  <p>@{{sucursaldia.total| currency: 'Q'}}</p>
                  </li>
              </ul>
            </div>
          </div>
          <div class="mtop9 col-sm-6  col-md-6 col-lg-3">
            <div class="caja_contenido">
              <h1>Facturas</h1>
                <table class="table">
                  <tbody>
                    <tr ng-repeat="estado in ventadiafac">
                      <td ng-switch="estado.estado_ventas">
                        <span ng-switch-when="1" class="ico_esta ico_borrador">Borrador</span>
                        <span ng-switch-when="2" class="ico_esta ico_completada">Completadas</span>
                        <span ng-switch-when="3" class="ico_esta ico_pcredito">Al Crédito</span>
                        <span ng-switch-when="4" class="ico_esta ico_cancelada">Canceladas</span>
                      </td>
                      <td>@{{estado.cantidad}}</td>
                      <td>@{{estado.total| currency: 'Q'}}</td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>

          {{-- Por vendedor --}}
          <div class="col-sm-12 spi">
             <div class="caja_fil">
             <h1>Por Vendedor</h1>
                   <div class="graf_vendedor">
                        <highcharts chart='@{{renderVende}}' class="altu_graf"></highcharts>
                   </div>
             </div>
          </div>
      </div>
	    <div class="col-sm-12 spd spi" ng-if="actlis">
                 <div class="busqueda_texto col-sm-4 spd spi">
                <input type="text" id="query" ng-model="query"  onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de ventas.." />
                 </div>
      </div>
	   <div class="info_colores" ng-if="actlis">
		      <ul>
		        <li><span class="color_ncom"></span> <p>Venta no completada</p></li>
             <li><span class="color_encom"></span> <p>Venta al crédito</p></li>
		        <li><span class="color_tercom"></span> <p>Venta facturada</p></li>
            <li><span class="color_cancom"></span> <p>Facturas Canceladas</p></li>
		      </ul>
    </div>
	  <div class="caja_contenido" ng-if="actlis">
	           <table class="table">
	               <thead>
	               <th></th>
	                   <th>No.Factura</th>
                     	<th>Total</th>
               		  <th>Pago</th>
	                   <th>Sucursal</th>
	                   <th>Nombre</th>
	                   <th>NIT</th>
                     <th>Dirección</th>
                     <th>Vendido por</th>
                     <th>Fecha Factura</th>
	                   <th>Opciones</th>
	               </thead>
	               <tbody infinite-scroll="masventas()">
	                   <tr ng-repeat="venta in fventas =(ventas | filter: query )" ng-class="{'trc_ama':venta.estado_ventas==1,'trc_ver':venta.estado_ventas==3,'trc_fca':venta.estado_ventas==4}">
	                     <td class="td_first"></td>
                         <td ng-click="abrirventa(venta)"><small>@{{venta.dte}}</small></td>

                         <td class="tot_venta" ng-click="abrirventa(venta)">@{{venta.total | currency: 'Q'}}</td>
                          <td ng-click="abrirventa(venta)" ng-switch="venta.pago_venta.tipo_pago">
                               <span ng-switch-when="1" class="ico_td ico_pefectivo">Efectivo</span>
                               <span ng-switch-when="2" class="ico_td ico_ppos">POS</span>
                               <span ng-switch-when="3" class="ico_td ico_pcheque">Cheque</span>
                               <span ng-switch-when="4" class="ico_td ico_pcredito">Crédito</span>
                               <span ng-switch-when="5" class="ico_td ico_pdeposito">Deposito</span>
                         </td>
                         <td ng-click="abrirventa(venta)">@{{venta.nombre_sucursal.nombre}}</td>
	                       <td ng-click="abrirventa(venta)">@{{venta.info_clientes.nombre}} <small>@{{venta.info_clientes.empresa}}</small></td>
	                       <td ng-click="abrirventa(venta)">@{{venta.info_clientes.nit}} </td>
	                       <td ng-click="abrirventa(venta)">@{{venta.info_clientes.direccion}} - @{{venta.info_clientes.telefono}}</td>
                            <td>@{{venta.perfil_usuario.nombre}} @{{venta.perfil_usuario.apellido}}</td>
                          <td>@{{venta.fecha_factura  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>

                          
	                       <td>
	                           <div class="area_opciones">
                                 <ul>
                                    <li class="ed_drop" ng-if="venta.estado_ventas==1">
                                           <a ng-click="editarventa(venta.id)" class="ico_editar" ></a>
                                           
                                     </li>
                                 <li class="ed_drop"  uib-dropdown  ng-if="venta.estado_ventas==2">
                                           <a href="" class="ico_ncredito" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Nota de Crédito <strong>@{{venta.dte}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="notacredito(venta.id)" class=" btn_g btn_ncreditog"></a>
                                               </div>
                                            </div>
                                     </li>
                                      <li class="ed_drop"  uib-dropdown  ng-if="venta.estado_ventas==4">
                                           <a href="" class="ico_ndebito" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Nota de Débito <strong>@{{venta.dte}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="notadebito(venta.id)" class=" btn_g btn_ndebitog"></a>
                                               </div>
                                            </div>
                                     </li>
                                     <li class="op_drop"  uib-dropdown  ng-if="venta.estado_ventas==1">
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
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/VentasCtrl.js"></script>
@endpush