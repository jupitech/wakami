@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="InventarioConCtrl" ng-cloak>

  {{-- Traslados --}}

   <div class="header_conte">
            <h1>Inventario Consolidado</h1>
             
   </div>

    <div class="col-sm-12">
           <div class="col-sm-12">
                     <div class="busqueda_linea col-sm-4 spi">
                                
                                    <ol class="nya-bs-select" ng-model="buslinea" title="Buscar por linea" name="id_linea" data-size="10" onfocus="pxtrack.emit('counter', '1')" >
                                    <li ng-click="deselecli()"><a>
                                    Todos
                                       <span class="glyphicon glyphicon-ok check-mark"></span>
                                    </a></li>
                                    <li nya-bs-option="linea in lineas" data-value="linea.nombre">
                                      <a>
                                        @{{ linea.nombre }}
                                        <span class="glyphicon glyphicon-ok check-mark"></span>
                                      </a>
                                    </li>
                                  </ol>
                     </div> 
                    
                     <div class="busqueda_texto col-sm-5">
                    <input type="text" id="query" ng-model="query" onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de productos.." />
                     </div>
                     <div class="col-sm-3 spd">
                      <div class=" btn_seg">
                          <a ng-click="exportData()"><span class="glyphicon glyphicon-save"></span> A Excel</a>
                      </div>
                            
                      </div>
                </div>
    <div id="exportable" class="caja_contenido table150">
             <table class="table">
                 <thead>
                     <th>Codigo</th>
                     <th>Linea</th>
                     <th>Producto</th>
                     <th>Costo</th>
                     <th>Central</th>
                     <th ng-repeat="sucursal in sucursales">@{{sucursal.nombre}}</th>
                     <th ng-repeat="consig in consignacion">@{{consig.info_cliente.nombre}}</th>
                     <th>Total</th>
                     <th>Total Q.</th>

                 </thead>
                 <tbody>
                     <tr ng-repeat="producto in productos  | filter: query | filter: buslinea" ng-init="total = 0 ; totalf=0">
                        <td><strong>@{{producto.codigo}}</strong></td>
                        <td>@{{producto.nombre_linea.nombre}}</td>
                         <td>@{{producto.nombre}} </td>
                         <td>@{{producto.costo | number:2}}</td>
                         <td ng-init="$parent.total = $parent.total + producto.stock_producto.stock">@{{producto.stock_producto.stock}}</td>
                         <td ng-repeat="sucursal in sucursales">
                           <span ng-repeat="stock in producto.stock_sucursal" ng-if="sucursal.id == stock.id_sucursal">@{{stock.stock}}</span>
                         </td>
                          <td ng-repeat="consig in consignacion">
                           <span ng-repeat="stock in producto.stock_consignacion" ng-if="consig.id == stock.id_consignacion">@{{stock.stock}}</span>
                         </td>
                         <td><strong>@{{producto.stock_producto.stock+(producto.stock_sucursal | SumaCanti:'stock')+(producto.stock_consignacion | SumaCanti:'stock')}}</strong></td>

                         <td ng-init="$parent.totalf = $parent.totalf + ((producto.stock_producto.stock+(producto.stock_sucursal | SumaCanti:'stock')+(producto.stock_consignacion | SumaCanti:'stock'))*producto.costo)">
                         <strong>@{{((producto.stock_producto.stock+(producto.stock_sucursal | SumaCanti:'stock')+(producto.stock_consignacion | SumaCanti:'stock'))*producto.costo) | number:2}}</strong></td>
                       
                     </tr>
                     <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td>@{{total}}</td>
                       <td ng-repeat="sucursal in sucursales">
                         <span ng-repeat="total in sumsucursal" ng-if="sucursal.id == total.id_sucursal">@{{total.total}}</span>
                       </td>

                       <td ng-repeat="consig in consignacion">
                         <span ng-repeat="total in sumconsignacion" ng-if="consig.id == total.id_consignacion">@{{total.total}}</span>
                       </td>
                       <td>
                         <strong>@{{total+(sumconsignacion | SumaCanti:'total')+(sumsucursal | SumaCanti:'total')}}</strong>
                       </td>
                       <td class="coama">@{{totalf | number:2}}</td>


                     </tr>
                    
                 </tbody>
             </table>
        
    </div>

  </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/InventarioConCtrl.js"></script>
@endpush