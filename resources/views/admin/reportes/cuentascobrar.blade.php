@extends('layouts.app')
@extends('layouts.menu')
@section('content')
    <div class="col-sm-12">
        @yield('menu')
    </div>
    <div class="col-md-12 top_conte" ng-controller="CuentasCobrarCtrl" ng-cloak>

   {{-- Cambiar tipo de pago --}}
      <div id="area_nuevo" ng-if="cambiar_obj">
           <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Venta No.@{{exiscVenta.id}}-@{{exiscVenta.dte}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarca()"></a>
                        </div>
            </div>
            <div class="conte_nuevo">
                <div class="col-sm-12">
                       <form class="form-horizontal" ng-repeat="tipo in exiscVenta.pago_venta" ng-if="$index==0" name="frm" role="form" ng-submit="btn_cambiar1(tipo.id)" >   
                        <div class="form-group">
                            <div class="col-sm-12" >
                                    <div class="col-sm-6 spd">
                                           <p  ng-switch="tipo.tipo_pago" class="pago_p">
                                             <span ng-switch-when ="1"><strong>Efectivo</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="2"><strong>Tarjeta/POS</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="3"><strong>Cheque</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="4"><strong>Al Crédito</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="5"></strong>Depósito</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="6"></strong>Gift Card</strong> Q@{{tipo.monto | number:2}}</span>
                                            </p>
                                      </div>
                                      <div class="col-sm-6  spi" >
                                           <label>Cambiar por:</label>
                                           <ol class="nya-bs-select" ng-model="pago.tipo_pago" title="Tipo de pago..." required>
                                              <li nya-bs-option="tpago in tpagos" data-value="tpago.id">
                                                  <a>
                                                      @{{ tpago.pago }}
                                                      <span class="glyphicon glyphicon-ok check-mark"></span>
                                                  </a>
                                              </li>
                                          </ol>
                                      </div>
                                       <div class="col-sm-12" ng-if="pago.tipo_pago!=4">
                                          <div class="col-sm-12 spd spi">
                                               <label for="name">Referencia</label>
                                              <input id="referencia" type="text" class="form-control" name="referencia" ng-model="pago.referencia" ng-init="pago.referencia=tipo.referencia" placeholder="# Ref POS ó No.Cheque">
                                          </div>
                                      </div>

                                       <div class="col-sm-12">
                                          <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid || loading" button-spinner="loading" >CAMBIAR PAGO</button>
                                      </div>

                            </div>

                           
                        </div>
                      </form>

                      {{-- Tipo de pago 2 --}}
                       <form class="form-horizontal" ng-repeat="tipo in exiscVenta.pago_venta" ng-if="$index==1" name="frm" role="form" ng-submit="btn_cambiar2(tipo.id)" >   
                        <div class="form-group">
                            <div class="col-sm-12" >
                                    <div class="col-sm-6 spd">
                                           <p  ng-switch="tipo.tipo_pago" class="pago_p">
                                             <span ng-switch-when ="1"><strong>Efectivo</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="2"><strong>Tarjeta/POS</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="3"><strong>Cheque</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="4"><strong>Al Crédito</strong> Q@{{tipo.monto | number:2}}</span>
                                             <span ng-switch-when="5"></strong>Depósito</strong> Q@{{tipo.monto | number:2}}</span>
                                               <span ng-switch-when="6"></strong>Gift Card</strong> Q@{{tipo.monto | number:2}}</span>
                                            </p>
                                      </div>
                                      <div class="col-sm-6  spi" >
                                           <label>Cambiar por:</label>
                                           <ol class="nya-bs-select" ng-model="pago.tipo_pago" title="Tipo de pago..." required>
                                              <li nya-bs-option="tpago in tpagado" data-value="tpago.id">
                                                  <a>
                                                      @{{ tpago.pago }}
                                                      <span class="glyphicon glyphicon-ok check-mark"></span>
                                                  </a>
                                              </li>
                                          </ol>
                                      </div>
                                       <div class="col-sm-12" ng-if="pago.tipo_pago!=4">
                                          <div class="col-sm-12 spd spi">
                                               <label for="name">Referencia</label>
                                              <input id="referencia" type="text" class="form-control" name="referencia" ng-model="pago.referencia" ng-init="pago.referencia=tipo.referencia" placeholder="# Ref POS ó No.Cheque">
                                          </div>
                                      </div>

                                       <div class="col-sm-12">
                                          <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid || loading" button-spinner="loading" >CAMBIAR PAGO</button>
                                      </div>

                            </div>

                           
                        </div>
                      </form>

                </div>
            </div>
      </div>


        {{-- Cuentas por Cobrar--}}


        <div class="header_conte">
            <h1>Cuentas por Cobrar</h1>
        </div>

      

        <div class="col-sm-12">
             <div class="col-sm-12 spd spi" >
                 <div class="busqueda_texto col-sm-4 spd spi">
                <input type="text" id="query" ng-model="query"  onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de ventas al crédito.." />
                 </div>
             </div>

            <div class="info_colores">
                <ul>
                    <li><span class="color_ncom"></span> <p>Cuenta vencida.</p></li>
                    <li><span class="color_tercom"></span> <p>Cuenta por vencer.</p></li>
                </ul>
            </div>
            <div class="op_descarga">
              <a ng-click="crearexcel()"  title="Descargar Excel" data-toggle="tooltip"></a>
            </div>
            <div class="caja_contenido">
                <table class="table">
                    <thead>
                           <th>No.Factura
                              <a href="#" ng-click="sort('ventas.dte')" class="sortDir" ng-class="{ active: isSorted('ventas.dte') }">&#x25B2;</a>
                              <a href="#" ng-click="sort('-ventas.dte')" class="sortDir" ng-class="{ active: isSorted('-ventas.dte' ) }">&#x25BC;</a>
                           </th>
                            <th>Total
                               <a href="#" ng-click="sort('ventas.total')" class="sortDir" ng-class="{ active: isSorted('ventas.total') }">&#x25B2;</a>
                              <a href="#" ng-click="sort('-ventas.total')" class="sortDir" ng-class="{ active: isSorted('-ventas.total' ) }">&#x25BC;</a>
                            </th>
                           <th>Sucursal</th>
                           <th>Nombre</th>
                           <th>Vendido por</th>
                           <th>Fecha Factura
                             <a href="#" ng-click="sort('ventas.fecha_factura')" class="sortDir" ng-class="{ active: isSorted('ventas.fecha_factura') }">&#x25B2;</a>
                              <a href="#" ng-click="sort('-ventas.fecha_factura')" class="sortDir" ng-class="{ active: isSorted('-ventas.fecha_factura' ) }">&#x25BC;</a>
                           </th>
                                <th>Fecha Vencimiento
                             <a href="#" ng-click="sort('fecha_limite')" class="sortDir" ng-class="{ active: isSorted('fecha_limite') }">&#x25B2;</a>
                              <a href="#" ng-click="sort('-fecha_limite')" class="sortDir" ng-class="{ active: isSorted('-fecha_limite' ) }">&#x25BC;</a>
                           </th>
                           <th>Opciones</th>
                    </thead>
                     <tbody>
                     <tr ng-repeat="cuentas in cuentascobrar | filter: query  | orderBy:predicate:reverse">
                     
                         <td ng-click="abrirventas(cuentas)"><small>@{{cuentas.ventas.dte}}</small></td>

                         <td class="tot_ventas" ng-click="abrirventas(cuentas.ventas)">@{{cuentas.ventas.total | currency: 'Q'}}</td>
                         
                         <td ng-click="abrirventas(cuentas.ventas)">@{{cuentas.ventas.nombre_sucursal.nombre}}</td>
                         <td ng-click="abrirventas(cuentas.ventas)">@{{cuentas.ventas.info_clientes.nombre}} <small>@{{cuentas.ventas.info_clientes.empresa}}-@{{cuentas.ventas.info_clientes.nit}}</small></td>
                            <td>@{{cuentas.ventas.perfil_usuario.nombre}} @{{cuentas.ventas.perfil_usuario.apellido}}</td>
                          <td>@{{cuentas.ventas.fecha_factura  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                             <td ng-class="{'trc_ama':comparaFecha(cuentas.fecha_limite)==1}" ng-init="comparaFecha(cuentas.fecha_limite)"><strong>@{{cuentas.fecha_limite  | amDateFormat: 'DD/MM/YYYY'}}</strong></td>
                          
                         <td>
                             <div class="area_opciones">
                                 <ul>
                                   
                                        <li class="ed_drop">
                                           <a ng-click="cambiarpago(cuentas.ventas)" class="ico_cpago" title="Crédito Pagado" data-toggle="tooltip"></a>
                                           
                                     </li>
                                
                                     <li class="op_drop"  uib-dropdown  ng-if="cuentas.ventas.estado_ventas==1" >
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar ventas No.Fac <strong>@{{cuentas.ventas.id}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(cuentas.ventas.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                      <li><a href="" class="ico_pdf" ng-if="cuentas.ventas.estado_ventas==2 || cuentas.ventas.estado_ventas==3  || cuentas.ventas.estado_ventas==4" ng-click="btn_pdf(cuentas.ventas.id)" title="Descargar PDF" data-toggle="tooltip"></a></li>
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
    <script src="/js/controller/CuentasCobrarCtrl.js"></script>
@endpush