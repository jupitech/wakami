
@extends('layouts.app')
@extends('layouts.menu')
@section('content')
    <div class="col-sm-12">
        @yield('menu')
    </div>
    <div class="col-md-12 top_conte" ng-controller="CierreCajaCtrl">
        {{-- Nuevo cierre --}}
               <div id="area_mas" ng-if="nuevo_obj && !imprimir" style="width: 100% !important;">
                    <div class="header_nuevo">
                        <div class="col-sm-12">
                              <h1>Cierre de Caja</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12" ng-if="cierre_p1">
                      <h1><strong>Saldo Actual: </strong>Q@{{bsaldo.efectivo | number:2}}</h1>
                          <form class="form-horizontal" name="frm" role="form" ng-submit="guardarCierrep1()" >
                              <div class="form-group">
                                  <div class="col-md-6">
                                      <div class="col-sm-6">
                                          <label for="monto_efectivo">Monto Efectivo: <strong>@{{efectivo | number:2}}</strong></label>
                                          <input id="monto_efectivo" min="0" type="text" class="form-control monto_cierre" name="monto_efectivo" ng-disabled="efec_habilitado" ng-model="cierres.efectivo" ng-init="cierres.efectivo=efectivo" placeholder="Monto al cierre." step="any" max="@{{efectivo}}" ng-max="@{{efectivo}}" ng-click="agr_montoef()" required>
                                          <div class="col-sm-12 spd spi">
                                              <div class="alert alert-danger" ng-show="frm.monto_efectivo.$dirty && frm.monto_efectivo.$error.required">Campo requerido</div>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <label for="gasto_efectivo">Gastos Diarios en Efectivo</label>
                                        <input id="gasto_efectivo" min="0" type="text" class="form-control gasto_cierre" name="gasto_efectivo" ng-disabled="efec_habilitado" ng-model="gasto_efectivo" ng-init="cierres.efectivo=efectivo" placeholder="Monto al cierre." step="any" ng-click="agr_gastoef()" >
                                          <div class="col-sm-12 spd spi">
                                              <div class="alert alert-danger" ng-show="frm.gasto_efectivo.$dirty && frm.gasto_efectivo.$error.required">Campo requerido</div>
                                          </div>
                                      </div>

                                      <div class="col-sm-6"  style="margin-top: 40px;">
                                          <label for="monto_tarjeta">Monto Tarjeta: <strong>@{{tarjeta | number:2}}</strong></label>
                                          <input id="monto_tarjeta" min="0" type="text" class="form-control monto_cierre" name="monto_tarjeta" ng-disabled="tarj_habilitado" ng-model="cierres.tarjeta" ng-init="cierres.tarjeta=tarjeta" placeholder="Monto al cierre." step="any" max="@{{tarjeta}}" ng-max="@{{tarjeta}}" ng-click="agr_montota()" >
                                          <div class="col-sm-12 spd spi">
                                              <div class="alert alert-danger" ng-show="frm.monto_tarjeta.$dirty && frm.monto_tarjeta.monto_tarjeta.required">Campo requerido</div>
                                          </div>
                                      </div>

                                      <div class="col-sm-6" style="margin-top: 40px;">
                                          
                                      </div>
                                  </div>

                               
                                  <div class="col-md-12">
                                      <div class="col-md-8">
                                          <label for="justificacion">Justificaci&oacute;n</label>
                                          <textarea class="form-control" rows="3" id="justificacion" ng-model="cierres.justificacion" ng-init="cierres.justificacion=''" placeholder="Justifique si se realizaron gastos y por qué"></textarea>
                                          {{--<div class="col-sm-12 spd spi">--}}
                                              {{--<div class="alert alert-danger" ng-show="frm.justificacion.$dirty && frm.justificacion.$error.required">Campo requerido</div>--}}
                                          {{--</div>--}}
                                      </div>
                                      <div class="col-md-4">
                                        {{-- <div class="col-xs-6"></div>
                                        <div class="col-xs-6"></div> --}}
                                        <div class="">
                                            <ul class="botones_cierre">
                                               <li ng-click="btn_saldo()" ng-if="mandardepo">
                                                   Mandar a Saldo
                                               </li>

                                               <li ng-click="btn_saldo()" class="btn_tpa" ng-if="!mandardepo">
                                                   Mandar a Saldo
                                               </li>

                                               <li ng-click="btn_depositar()"  ng-if="mandarsaldo">
                                                   Depositar
                                               </li>

                                               <li ng-click="btn_depositar()" class="btn_tpa" ng-if="!mandarsaldo">
                                                   Depositar
                                               </li>                                               
                                           </ul>
                                        </div>
                                      </div>
                                  </div>
                                  
                              </div>
                              <button type="submit" class="btn btn-primary btn_regis" ng-click="" ng-disabled="frm.$invalid">Generar Cierre</button>
                          </form>
                      </div>
                    </div>
              </div>



        {{-- Cierre Caja --}}
        <div class="header_conte" ng-if="!imprimir">
            <h1>Cierre Caja</h1>
        </div>

        <div class="col-sm-12 area_enhead" ng-if="!imprimir">
            <div class="caja_dash" ng-if="!existeCierre">
                <a href="" ng-click="btn_nuevo()">APLICAR CIERRE AHORA!</a>
            </div>
        </div>




        <div class="col-sm-12" ng-if="!imprimir">
            <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Proveedor nuevo</strong> guardado correctamente, creado por administradores.</div>
            <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Proveedor borrado</strong> No se podrá recuperar los datos.</div>
            <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Proveedor editado</strong> Puedes ver en el listado de proveedores las modificaciones realizadas.</div>

            <div class="col-sm-12 spd spi">
                <div class="col-sm-5  col-md-5 col-lg-6 spi">
                    <div class="porusuario">
                          <div class="col-sm-8">
                            Saldo Actual
                          </div>
                          <div class="col-sm-4">
                           <span> Q@{{bsaldo.efectivo | number:2}}</span>
                          </div>
                    </div>
                </div>
            </div>
            <div class="ventasdia col-sm-12 spd spi">
                <div class="col-sm-5  col-md-5 col-lg-6 spi">
                    <div class="caja_contenido">
                        <h1>&Uacute;ltimo cierre</h1>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Cierre ID</th>
                                <th>Vendedor</th>
                                <th>Monto Cierre Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>@{{ cierres_hoy.id }}</td>
                                <td>@{{cierres_hoy.nombre}}</td>
                                <td>Q@{{cierres_hoy.total_saldo | number:2}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="info_colores">
                <ul>
                    <li><span class="color_ncom"></span> <p>Cierre no completado.</p></li>
                    <li><span class="color_tercom"></span> <p>Cierre completado.</p></li>
                </ul>
            </div>
            <div class="caja_contenido">
                <table class="table">
                    <thead>
                        <th>Cierre ID</th>
                        <th>Usuario</th>
                        <th>Monto Cierre</th>
                        <th>Saldo Efectivo</th>
                        <th>Crédito/Deposito</th>
                        <th>Fecha</th>
                        <th>Tipo de Cierre</th>
                    </thead>
                    <tbody>
                    <tr ng-repeat="cierre in cierres" ng-class="{'trc_ama':cierre.estado_caja==1}">
                        <td ng-click="editar_cierre(cierre)">@{{ cierre.id }}</td>
                        <td ng-click="editar_cierre(cierre)">@{{cierre.nombre}} @{{cierre.apellido}}</td>
                        <td ng-click="editar_cierre(cierre)">Q@{{cierre.total_saldo | number:2}} </td>
                        <td ng-click="editar_cierre(cierre)">Q@{{cierre.saldo_efectivo | number:2}} </td>
                          <td ng-click="editar_cierre(cierre)">Q@{{cierre.total_saldo-cierre.saldo_efectivo | number:2}} </td>
                        <td>@{{cierre.created_at}}</td>
                        <td>
                          <p ng-if="cierre.estado_caja == 1">Mandado a Saldo</p>
                          <p ng-if="cierre.estado_caja == 2">Depositado</p>
                        </td>
                        
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        {{-- <div class="col-sm-12" ng-if="cierre_terminado"> --}}
        <div class="col-sm-12" ng-if="imprimir">
            {{-- Cierre Determinado --}}
            <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-4 col-lg-offset-4">
                <div class="caja_contenido top_conte" >
                    <div class="col-sm-12 spd spi">
                        <div class="col-sm-6">
                            <a class="btn btn-primary btn_regis" ng-print print-element-id="areaimpresion">IMPRIMIR</a>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn_cancelar" ng-click="ircierres()">Ir a Cierres</a>
                        </div>
                    </div>
                    <div id="areaimpresion" class="info_final">
                        <table width="100%">
                            <tr><td><h3>@{{datasucursal.nombre}}</h3></td></tr>
                            <tr><td><h4>@{{datasucursal.ubicacion}}</h4></td></tr>
                             <tr><td><h4>GRUPO TOBRA S.A.</h4></td></tr>
                            {{-- <tr><td><h4>NIT: 8451822-7</h4></td></tr>
                            <tr><td><h4>Factura Serie: @{{misucursal.serie}} No. @{{miventa.correlativo}} </h4></td></tr>
                            <tr><td><h4>Del 1 Al 1000000</h4></td></tr>
                            <tr><td><h4>Autorización según resolución No.@{{misucursal.fresolucion}} del 28-10-2016 del 1 al 30000</h4></td></tr>
                            <tr><td><h4><strong> Resolución vence 28-10-2018</strong></h4></td></tr> --}}
                        </table>
                        {{-- Información de cliente --}}
                        <div class="info_finalusuario">
                            <table>
                                <tr><td><p>Fecha: @{{miventa.fecha_factura}}</p>
                                {{-- <tr><td><p ng-if="miventa.info_clientes.empresa!=''">Nombre:</p></td></tr>
                                <tr><td> <p ng-if="miventa.info_clientes.empresa==''">Nombre:</p></td></tr>
                                <tr><td> <p>NIT:</p></td></tr>
                                <tr><td> <p>Dirección:</p></td></tr> --}}
                            </table>
                        </div>
                        {{-- Información de productos --}}
                        <div class="info_finalproductos">
                            <div class="col-sm-12 spd spi">
                                <p class="ptit pro_ven">Ventas</p>
                            </div>
                            <div class="col-sm-12 spd spi">
                                <div class="col-sm-12 spd spi" ng-repeat="venta in ventasdia">
                                    <p><strong>@{{venta.id}}</strong> - @{{venta.fecha_factura}} <strong ng-if="venta.pago_venta.tipo_pago == 1">Efectivo</strong><strong ng-if="venta.pago_venta.tipo_pago == 2">POS</strong> Total: <strong>Q@{{venta.total | number:2}}</strong></p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="info_finaltotal">
                            <div class="eltotal">
                                {{-- <p>Total <strong>Q@{{totaltotal | number:2}}</strong></p> --}}
                                <p class="mar_top_cero"><br>Total Cierre: <strong>Q@{{cierres_hoy.saldo_efectivo | number:2}}</strong></p>
                                <p class="mar_top_cero"><br>Total Gastos del día: <strong>Q@{{gasto_efectivo | number:2}}</strong></p>
                            </div>
                            {{-- <div class="eltotal">                                
                                <p ng-if="tipopago==1" class="mar_top_cero"><br>Pago: <strong>Q@{{pagoef | number:2}}</p>                                
                            </div><div class="eltotal">                                
                                <p ng-if="tipopago==1" class="mar_top_cero"><br>Cambio: <strong>Q@{{devolucionef | number:2}}</p>                                
                            </div> --}}
                            <div class="footerimp">
                            <p ng-if="estadoMandar == 1">Estado de cierre: Mandar a Saldo</p>
                            <p ng-if="estadoMandar == 2">Estado de cierre: Depositar</p>
                                {{-- <h4>SUJETO A PAGOS TRIMESTRALES</h4> --}}
                                <h4>Cierre de Caja</h4>
                                <h5>@{{datasucursal.nombre}}</h5>
                                {{-- <h5>No se aceptan cambios ni devoluciones, exceptuando por defectos de producción 30 dias después de la compra presentando esta factura.</h5> --}}
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{URL::asset('/js/script.js')}}"></script>
    <script src="{{URL::asset('/js/controller/CierreCajaCtrl.js')}}"></script>
@endpush