@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
   <div class="col-md-12 top_conte" ng-controller="ProductosCtrl">
	  {{-- Linea Producto --}}
               <div id="area_nuevo" ng-if="linea_obj">
                      <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Linea Productos</h1>
                              <a class="btn_cerrar" ng-click="btn_linea()"></a>
                        </div>
                       </div>
                       <div class="conte_nuevo">
                                <div class="col-sm-12">
                                  <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Linea de producto existente!</strong></div>
                                     <form class="form-horizontal" name="frm" role="form" ng-submit="guardarLinea()" >
                                          <div class="form-group">
                                                <div class="col-md-8">
                                                    <label for="name">Nueva Linea de Producto</label>
                                                     <input id="name" type="text" class="form-control" name="nombre" ng-model="linea.nombre" placeholder="Nombre de la linea" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">AGREGAR</button>
                                                </div>
                                           </div>
                                     </form>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert alert-info" role="alert" ng-if="alertaEditadol"> <strong>Linea editada correctamente!</strong></div>
                                        <div class="alert alert-danger" role="alert" ng-if="alertaEliminadol"> <strong>Linea borrada correctamente!</strong></div>
                                </div>
                                <div class="col-sm-12 table_height">

                                      <table class="table ">
                                                     <thead>
                                                         <th>Linea</th>
                                                         <th>Opciones</th>
                                                     </thead>
                                                     <tbody>
                                                         <tr ng-repeat="linea in lineas">
                                                             <td>@{{linea.nombre}}</td>
                                                             <td>
                                                                 <div class="area_opciones">
                                                                     <ul>
                                                                         <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(linea)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="editarLinea()" >
                                                                                       <div class="col-sm-9 ">
                                                                                           <input id="name" type="text" class="form-control" name="nombre" ng-model="existeLinea.nombre" required>
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
                                                                                     <p>Eliminar <strong>@{{linea.nombre}}</strong></p>
                                                                                   </div>
                                                                                   <div class="col-sm-4 spd spi">
                                                                                     <a href="" ng-click="btn_eliminar(linea.id)" class=" btn_g ico_eliminarg"></a>
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

   {{-- Nuevo Producto --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nuevo Producto</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Producto existente!</strong> Intenta de nuevo con otro código de producto</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProducto()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="codigo">Codigo</label>
                                         <input id="codigo" type="text" class="form-control" name="codigo" ng-model="producto.codigo" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.codigo.$dirty && frm.codigo.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                     <div class="col-md-12">
                                         <label for="rol">Linea</label>
                                       <ol class="nya-bs-select" ng-model="producto.linea" data-live-search="true"  title="Selecciona una linea...">
                                            <li nya-bs-option="linea in lineas" data-value="linea.id">
                                              <a>
                                                @{{ linea.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                  <div class="col-md-12">
                                       <label for="nombre">Nombre</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="producto.nombre" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="costo">Costo</label>
                                       <input id="costo" type="text" class="form-control" name="costo" ng-model="producto.costo" placeholder="00.00" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.costo.$dirty && frm.costo.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="preciop">Precio Público</label>
                                       <input id="preciop" type="text" class="form-control" name="preciop" ng-model="producto.preciop"  placeholder="00.00" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.preciop.$dirty && frm.preciop.$error.required">Campo requerido</div>
                                         </div>
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

  {{-- Editar Producto --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Producto @{{existeProducto.codigo}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Producto existente!</strong> Intenta de nuevo con otro producto</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarProducto()" >
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Código</label>
                                         <input id="codigo" type="text" class="form-control" name="codigo" ng-model="existeProducto.codigo" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.codigo.$dirty && frm.codigo.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                         <label for="rol">Linea</label>
                                       <ol class="nya-bs-select" ng-model="existeProducto.linea" data-live-search="true">
                                            <li nya-bs-option="linea in lineas" data-value="linea.id">
                                              <!-- the text content of anchor element will be used for search -->
                                              <a>
                                                @{{ linea.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>
                                  </div>
                                  <div class="col-md-12">
                                       <label for="nombre">Nombre</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existeProducto.nombre" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="costo">Costo</label>
                                       <input id="costo" type="text" class="form-control" name="costo" ng-model="existeProducto.costo" placeholder="00.00" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.costo.$dirty && frm.costo.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="preciop">Precio Público</label>
                                       <input id="preciop" type="text" class="form-control" name="preciop" ng-model="existeProducto.preciop"  placeholder="00.00" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.preciop.$dirty && frm.preciop.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div> 
                               

                              
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frmed.$invalid">EDITAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_editar()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

  


	{{-- Productos --}}
	
	 <div class="header_conte">
              <h1>Productos</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nuevo Producto</a>
                </div>
                <div class="btn_seg">
                    <a href="" ng-click="btn_linea()">Linea de Producto</a>
                </div>
     </div>
     <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Producto nuevo</strong> guardado correctamente, creado por administradores.</div>
     <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
       <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Producto editado</strong> Puedes ver en el listado de productos las modificaciones realizadas.</div>
     </div>

                <div class="caja_productos">
                <div class="col-sm-12">
                     <div class="busqueda_texto col-sm-4">
                    <input type="text" id="query" ng-model="query" onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de productos.." />
                     </div>
                </div>
               
                      <ul>
                        <li ng-repeat="producto in productos | filter: query | orderBy:'-id'">
                          <div class="box_pro">
                                <div class="box_header">

                                <div ng-if="producto.imagen_id == 0 " class="sin_imagen">
                                   <a href="producto/imagen/@{{producto.id}}"></a>
                                </div>
                                
                                <div ng-if="producto.imagen_id != 0 " class="con_imagen">
                                  <img src="@{{producto.nombre_imagen.ruta}}" alt="">
                                </div>

                                </div>
                                <div class="box_middle">
                                   <h1>@{{producto.nombre}}</h1>
                                   <h2>@{{producto.nombre_linea.nombre}}</h2>
                                   <p>@{{producto.codigo}}</p>
                                </div>
                                <div class="box_footer">
                                   <p class="p_costo">Q@{{producto.costo | number:2}}</p>
                                   <p class="p_preciop">Q@{{producto.preciop | number:2}}</p>
                                </div>
                                <div class="box_opciones">
                                <div class="col-sm-6 spd spi">
                                  <p class="p_stock" ng-init="mistock(producto)"><strong>@{{producto.stock.stock}}</strong> uni</p>
                                </div>
                                <div class="col-sm-6 spd spi">
                                      <div class="area_opciones">
                                            <ul>
                                            <li><a href="" class="ico_editar" ng-click="btn_editar(producto)"></a></li>
                                            <li class="op_drop"  uib-dropdown>
                                               <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                               <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                   <div class="col-sm-8 spd">
                                                     <p>Eliminar <strong>@{{producto.codigo}}</strong></p>
                                                   </div>
                                                   <div class="col-sm-4 spd spi">
                                                     <a href="" ng-click="btn_eliminarpro(producto.id)" class=" btn_g ico_eliminarg"></a>
                                                   </div>
                                                </div>
                                         </li>
                                          </ul>
                                      </div>
                                </div>
                              
                                  
                                  
                                </div>
                             
                          </div>
                        </li>
                      </ul>
              </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush