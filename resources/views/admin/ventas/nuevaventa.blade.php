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
	<div class="col-sm-12">
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
                       <ol class="nya-bs-select" ng-model="venta.cliente" title="Seleccionar Cliente.." data-live-search="true">
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
                        <label for="empresa">Nombre Cliente</label>
                         <input id="empresa" type="text" class="form-control" name="empresa" ng-model="venta.cliente.empresa" required disabled>
                        <div class="col-sm-12 spd spi">
                                 <div class="alert alert-danger" ng-show="frm.empresa.$dirty && frm.empresa.$error.required">Req.</div>
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
        <div class="middle_caja" ng-if="acti_rol">
         Hola
        </div>
        {{-- Cliente Asignado --}}
        <div class="middle_caja estilo_middle" ng-if="acti_areapro" ng-repeat="mi in miventa">
              <div class="col-sm-12">
                <div class="col-sm-8">
                  <h3>Nombre</h3>
                  <p>@{{mi.info_clientes.empresa}}</p>
                </div>
                <div class="col-sm-4">
                   <h3>NIT</h3>
                   <p>@{{mi.info_clientes.nit}}</p>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-8">
                  <h3>Dirección</h3>
                  <p>@{{mi.info_clientes.direccion}}</p>
                </div>
                <div class="col-sm-4">
                   <h3>Teléfono</h3>
                   <p>@{{mi.info_clientes.telefono}}</p>
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
                                             <div class="col-sm-8 col-md-8 col-lg-9 topinput">
                                                     <ol class="nya-bs-select" ng-model="proventa.id_producto" data-live-search="true"  title="Selecciona un producto..." required>
                                                          <li nya-bs-option="producto in productos" data-value="producto.id">
                                                            <a>
                                                             <span>
                                                              <small class="label label-success">@{{ producto.codigo }}</small>
                                                                  @{{ producto.nombre }}-<strong> Q@{{ producto.preciop | number:2 }} </strong>
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                                        </ol>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                     <label for="cantidad">Cant Max @{{stock.stock}}</label>
                                                     <input id="cantidad" type="number" class="form-control" name="cantidad" ng-model="proventa.cantidad" required ng-click="elstock(proventa.id_producto)" max="@{{stock.stock}}" min="1">
                                                        <div class="col-sm-12 spd spi">
                                                  <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Req.</div>
                                           </div>
                                                </div>
                                               
                                                <div class="col-sm-2 col-md-2 col-lg-1 spi">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid"><span class="ico_agregar"></span></button>
                                                </div>
                                           </div>
                                     </form>
        </div>
        <div class="col-sm-12 conte table_height">
         <table class="table">
             <thead>
                 <th>Producto</th>
                 <th>Precio</th>
                 <th>Cantidad</th>
                 <th>Subtotal</th>
                 <th>Opciones</th>
             </thead>
             <tbody>
                <tr ng-repeat="mipro in misproductos">
                <td>@{{mipro.nombre_producto.codigo}} - @{{mipro.nombre_producto.nombre}}</td>
                <td>Q@{{mipro.nombre_producto.preciop | number:2}}</td>
                 <td>@{{mipro.cantidad}}</td>
                 <td>Q@{{(mipro.nombre_producto.preciop*mipro.cantidad) | number:2}}</td>
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
     </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush