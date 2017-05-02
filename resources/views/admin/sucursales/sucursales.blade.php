@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
  <div class="col-md-12 top_conte" ng-controller="SucursalesCtrl" ng-cloak>
{{-- Nueva Sucursal --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Sucursal</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Sucursal existente!</strong> Intenta de nuevo con otro nombre de sucursal.</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarSucursal()" >
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="codigo_esta">Cod.Establecimiento</label>
                                         <input id="codigo_esta" type="number" class="form-control" name="codigo_esta" ng-model="sucursal.codigo_esta" placeholder="1 a ?" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.codigo_esta.$dirty && frm.codigo_esta.$error.required">Campo requerido</div>
                                         </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="sucursal.nombre" placeholder="Nombre de la sucursal" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="ubicacion">Ubicación</label>
                                       <input id="ubicacion" type="text" class="form-control" name="ubicacion" ng-model="sucursal.ubicacion" placeholder="Direccion de la ubicacion" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.ubicacion.$dirty && frm.ubicacion.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                  
                               </div>
                                <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Factura</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_sat">Código Sat</label>
                                               <input id="codigo_sat" type="number" class="form-control" name="codigo_sat" ng-model="sucursal.codigo_sat"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_sat.$dirty && frm.codigo_sat.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie">Serie</label>
                                               <input id="serie" type="text" class="form-control" name="serie" ng-model="sucursal.serie" placeholder="Serie de factura" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie.$dirty && frm.serie.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion">No.Resolución</label>
                                               <input id="resolucion" type="text" class="form-control" name="resolucion" ng-model="sucursal.resolucion" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion.$dirty && frm.resolucion.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion">Fecha de Resolución</label>
                                               <input id="fresolucion" type="text" class="form-control" name="fresolucion" ng-model="sucursal.fresolucion" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion.$dirty && frm.fresolucion.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>
                               <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Nota de Crédito</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_satnce">Código Sat NCE</label>
                                               <input id="codigo_satnce" type="number" class="form-control" name="codigo_satnce" ng-model="sucursal.codigo_satnce"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_satnce.$dirty && frm.codigo_satnce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie_nce">Serie NCE</label>
                                               <input id="serie_nce" type="text" class="form-control" name="serie_nce" ng-model="sucursal.serie_nce" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie_nce.$dirty && frm.serie_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion_nce">No.Resolución NCE</label>
                                               <input id="resolucion_nce" type="text" class="form-control" name="resolucion_nce" ng-model="sucursal.resolucion_nce" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion_nce.$dirty && frm.resolucion_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion_nce">Fecha de Resolución</label>
                                               <input id="fresolucion_nce" type="text" class="form-control" name="fresolucion_nce" ng-model="sucursal.fresolucion_nce" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion_nce.$dirty && frm.fresolucion_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>
                               {{-- Nota de debito --}}
                               <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Nota de Débito</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_satnde">Código Sat NDE</label>
                                               <input id="codigo_satnde" type="number" class="form-control" name="codigo_satnde" ng-model="sucursal.codigo_satnde"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_satnde.$dirty && frm.codigo_satnde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie_nde">Serie NDE</label>
                                               <input id="serie_nde" type="text" class="form-control" name="serie_nde" ng-model="sucursal.serie_nde" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie_nde.$dirty && frm.serie_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion_nde">No.Resolución NDE</label>
                                               <input id="resolucion_nde" type="text" class="form-control" name="resolucion_nde" ng-model="sucursal.resolucion_nde" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion_nde.$dirty && frm.resolucion_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion_nde">Fecha de Resolución</label>
                                               <input id="fresolucion_nde" type="text" class="form-control" name="fresolucion_nde" ng-model="sucursal.fresolucion_nde" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion_nde.$dirty && frm.fresolucion_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>

                               <div class="form-group">
                                         <div class="col-sm-12">
                                          <h5>Usuarios</h5>
                                        </div>
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado principal</label>
                                       <ol class="nya-bs-select" ng-model="sucursal.id_user" title="Selecciona un usuario..." required>
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id'" data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

                                  </div>
                                  </div>
                                       <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado secundario</label>
                                       <ol class="nya-bs-select" ng-model="sucursal.id_user2" title="Selecciona un usuario...">
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id' | filter: { id: '!' + sucursal.id_user }" data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

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

 {{-- Editar sucursales --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Sucursal @{{existeSucu.nombrer}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Sucursal existente!</strong> Intenta de nuevo con nombre</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarSucursal()" >
                                <div class="form-group">
                                  <div class="col-sm-4">
                                        <label for="codigo_esta">Cod.Establecimiento</label>
                                         <input id="codigo_esta" type="number" class="form-control" name="codigo_esta" ng-model="existeSucu.codigo_esta" placeholder="1 a ?" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.codigo_esta.$dirty && frm.codigo_esta.$error.required">Campo requerido</div>
                                         </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="nombre">Nombre</label>
                                         <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existeSucu.nombre" placeholder="Nombre de la sucursal" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="ubicacion">Ubicación</label>
                                       <input id="ubicacion" type="text" class="form-control" name="ubicacion" ng-model="existeSucu.ubicacion" placeholder="Direccion de la ubicacion" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.ubicacion.$dirty && frm.ubicacion.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                  
                               </div>
                               {{-- Factura --}}
                                <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Factura</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_sat">Código Sat</label>
                                               <input id="codigo_sat" type="number" class="form-control" name="codigo_sat" ng-model="existeSucu.codigo_sat"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_sat.$dirty && frm.codigo_sat.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie">Serie</label>
                                               <input id="serie" type="text" class="form-control" name="serie" ng-model="existeSucu.serie" placeholder="Serie de factura" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie.$dirty && frm.serie.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion">No.Resolución</label>
                                               <input id="resolucion" type="text" class="form-control" name="resolucion" ng-model="existeSucu.resolucion" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion.$dirty && frm.resolucion.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion">Fecha de Resolución</label>
                                               <input id="fresolucion" type="text" class="form-control" name="fresolucion" ng-model="existeSucu.fresolucion" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion.$dirty && frm.fresolucion.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>
                               <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Nota de Crédito</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_satnce">Código Sat NCE</label>
                                               <input id="codigo_satnce" type="number" class="form-control" name="codigo_satnce" ng-model="existeSucu.codigo_satnce"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_satnce.$dirty && frm.codigo_satnce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie_nce">Serie NCE</label>
                                               <input id="serie_nce" type="text" class="form-control" name="serie_nce" ng-model="existeSucu.serie_nce" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie_nce.$dirty && frm.serie_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion_nce">No.Resolución NCE</label>
                                               <input id="resolucion_nce" type="text" class="form-control" name="resolucion_nce" ng-model="existeSucu.resolucion_nce" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion_nce.$dirty && frm.resolucion_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion_nce">Fecha de Resolución</label>
                                               <input id="fresolucion_nce" type="text" class="form-control" name="fresolucion_nce" ng-model="existeSucu.fresolucion_nce" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion_nce.$dirty && frm.fresolucion_nce.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>
                               {{-- Nota de debito --}}
                               <div class="form-group dcontrol">
                                        <div class="col-sm-12">
                                          <h5>Información de Nota de Débito</h5>
                                        </div>
                                        <div class="col-sm-4">
                                               <label for="codigo_satnde">Código Sat NDE</label>
                                               <input id="codigo_satnde" type="number" class="form-control" name="codigo_satnde" ng-model="existeSucu.codigo_satnde"  required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.codigo_satnde.$dirty && frm.codigo_satnde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-8">
                                                <label for="serie_nde">Serie NDE</label>
                                               <input id="serie_nde" type="text" class="form-control" name="serie_nde" ng-model="existeSucu.serie_nde" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.serie_nde.$dirty && frm.serie_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="resolucion_nde">No.Resolución NDE</label>
                                               <input id="resolucion_nde" type="text" class="form-control" name="resolucion_nde" ng-model="existeSucu.resolucion_nde" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.resolucion_nde.$dirty && frm.resolucion_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                                        <div class="col-sm-6">
                                               <label for="fresolucion_nde">Fecha de Resolución</label>
                                               <input id="fresolucion_nde" type="text" class="form-control" name="fresolucion_nde" ng-model="existeSucu.fresolucion_nde" placeholder="DD/MM/YYYY" required>
                                                <div class="col-sm-12 spd spi">
                                                    <div class="alert alert-danger" ng-show="frm.fresolucion_nde.$dirty && frm.fresolucion_nde.$error.required">Campo requerido</div>
                                                 </div>
                                        </div>
                               </div>

                               <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado principal</label>
                                       <ol class="nya-bs-select" ng-model="existeSucu.id_user" title="Selecciona un usuario..." required>
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id'" data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

                                  </div>
                                  </div>

                                   <div class="form-group">
                                  <div class="col-md-12">
                                       <label for="rol">Usuario asignado secundario</label>
                                       <ol class="nya-bs-select" ng-model="existeSucu.id_user2" title="Selecciona un usuario...">
                                            <li nya-bs-option="usuario in usuarios | orderBy:'-id' | filter: { id: '!' + existeSucu.id_user }"  data-value="usuario.id">
                                              <a>
                                               <span>
                                                <small class="label label-success">@{{ usuario.rol_usuario.el_rol.name }}</small> @{{ usuario.name }}
                                               </span>
                                              
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

                                  </div>
                                  </div>

                              
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frmed.$invalid">GUARDAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_editar()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>
{{-- Area sucursal --}}
               <div id="area_mas" ng-if="mas_obj">
               		 <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Sucursal @{{exisSucursal.nombre}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
                    </div>
                     <div class="conte_nuevo">
                     	<div class="col-sm-12">
                          <div class="col-sm-3 ">
                              <h3>Sucursal</h3>
                              <h2> @{{exisSucursal.nombre}}</h2>
                          </div>
                          <div class="col-sm-3">
                              <h3>Usuario Asignado</h3>
                              <h2> @{{exisSucursal.perfil_usuario.nombre}} @{{exisSucursal.perfil_usuario.apellido}}</h2>
                          </div>
                           <div class="col-sm-3">
                              <h3>Usuario Secundario</h3>
                              <h2> @{{exisSucursal.perfil_usuario.nombre}} @{{exisSucursal.perfil_usuario.apellido}}</h2>
                          </div>
                          <div class="col-sm-3">
                              <h3>Dirección</h3>
                              <h2> @{{exisSucursal.ubicacion}}</h2>
                          </div>
                          
                         
                          
                      </div>
                      
                        {{-- Productos de stock en sucursal --}}
                         <div class="col-sm-12 mtop">
                                   <div class="busqueda_texto col-sm-4 spd spi">
                                  <input type="text" id="query" ng-model="query"  onfocus="pxtrack.emit('counter', '1')" placeholder="Busqueda de productos.." />
                                   </div>
                        </div>
                      <div class="col-sm-12 conte table_height">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  

                                  <div class="alert alert-info" role="alert" ng-if="alertaEditadoProA"> <strong>Producto Ajustado</strong> Puedes ver en el listado de productos las modificaciones realizadas.</div>
                            </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Costo</th>
                                               <th>Precio Publico</th>
                                               <th>Stock</th>
                                               <th>Subtotal</th>
                                               <th>Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="prosucursal in prosucursales  | filter: query">
                                                   <td> <small class="label label-success">@{{ prosucursal.nombre_producto.codigo }}</small>
                                                      @{{prosucursal.nombre_producto.nombre}}</td>
                                                     <td >Q@{{prosucursal.nombre_producto.costo | number:2 }}</td>
                                                     <td>Q@{{prosucursal.nombre_producto.preciop | number:2}}</td>
                                                   <td>@{{prosucursal.stock}} </td>
                                                   <td>
                                                   <small class="label label-info" ng-init="$parent.totalcosto = $parent.totalcosto + (prosucursal.nombre_producto.costo * prosucursal.stock); $parent.totalprecio = $parent.totalprecio + (prosucursal.nombre_producto.preciop * prosucursal.stock) ">Q@{{(prosucursal.nombre_producto.costo*prosucursal.stock) | number:2}}</small>
                                                     Q@{{(prosucursal.nombre_producto.preciop*prosucursal.stock) | number:2}}
                                                   </td>
                                                   <td>
                                                          <div class="area_opciones">
                                                               <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_ajustar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editaraj(prosucursal)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="ajustarStock()" >
                                                                                       <div class="col-sm-9 ">
                                                                                       <label>@{{ prosucursal.nombre_producto.codigo }} - Stock @{{prosucursal.stock}} </label>
                                                                                           <input id="name" type="number" class="form-control" name="nombre" ng-model="existeProA.stock"  required>
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
                                    <h3>Total Público</h3>
                                    <h1><small>Q@{{totalprecio  | number:2}}</small></h1>
                              </div>
                              <div class="col-sm-4">
                                    <h3>Total Costo</h3>
                                    <h1><small>Q@{{totalcosto  | number:2}}</small></h1>
                              </div>
                              <div class="col-sm-4">
                                    <h3>Cantidad</h3>
                                    <h1><small>@{{prosucursales | SumaCanti:'stock'}} unidades</small></h1>
                              </div>
                      </div>



                     </div>		
               </div>

               {{-- Nueva Orden de Envio --}}
                 <div id="area_nuevo" ng-if="opcion_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva orden de envio</h1>
                              <a class="btn_cerrar" ng-click="btn_cerraro()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                        <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Envio existente!</strong> Intenta de nuevo con otro nombre de envio</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarEnvio()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Sucursal</label>
                                         <ol class="nya-bs-select" ng-model="envio.id_sucursal" title="Selecciona una sucursal..." name="id_sucursal" required>
                                            <li nya-bs-option="sucursal in sucursales" data-value="sucursal.id">
                                              <a>
                                                @{{ sucursal.nombre }}
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
                              <h1>Orden de envio #@{{exisEnvio.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarab()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                        <div class="col-sm-12">
                              <div class="col-sm-12">
                                  <div class="col-sm-6 spi">
                                      <h3>Sucursal</h3>
                                      <h2> @{{exisEnvio.nombre_sucursal.nombre}}</h2>
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

                                    {{-- Productos pendientes de recibir --}}
                                    <div class="col-sm-12">
                                      <h2 class="h2_top" ng-if="(proenvios | filter:{estado_producto:3}).length > 0" ><strong>Productos Pendientes de recibir</strong></h2>
                                      <table class="table" ng-if="(proenvios | filter:{estado_producto:3}).length > 0">
                                         <thead>
                                           
                                         </thead>
                                         <tbody>
                                                          <tr  ng-repeat="proenvio in proenvios" ng-if="proenvio.estado_producto==3">
                                                          
                                                        
                                                              <td> <small class="label label-success">@{{proenvio.nombre_producto.codigo}}</small> @{{proenvio.nombre_producto.nombre}}</td>
                                                               <td>Cant: @{{proenvio.pendiente_producto.cantidad}} </td>
                                                              <td>
                                                              </td>
                                                        </tr>
                                         </tbody>
                                      </table>
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
                                               <th>Costo</th>
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

                              {{-- Productos enviados --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisEnvio.estado_orden==2">
                          <div class="col-sm-12">
                              <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
                          </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th>Costo</th>
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
                                                        Enviado
                                                      </p>
                                                      <p class="label label-primary" ng-switch-when="2">
                                                        Agregado
                                                      </p>
                                                       <p class="label label-default" ng-switch-when="3">
                                                        Pendiente
                                                      </p>
                                                   </td>
                                               </tr>
                                              
                                           </tbody>
                                       </table>
                      </div>
                       {{-- Productos y compra terminada --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisEnvio.estado_orden==4">
                             <div class="col-sm-12 spd spi">
                          <div class="agre_pro">
                         <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th>Costo</th>
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
                                                        Enviado
                                                      </p>
                                                      <p class="label label-primary" ng-switch-when="2">
                                                        Agregado
                                                      </p>
                                                       <p class="label label-default" ng-switch-when="3">
                                                        Pendiente
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
                                                <p class="info_paso"><strong>PASO 1</strong> Envio de los productos hacia la sucursal</p>
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
                              <div class="col-sm-8" ng-if="exisEnvio.estado_orden==2 && (proenvios | filter:{estado_producto:3}).length < 1 && (proenvios | filter:{estado_producto:1}).length < 1">
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

{{-- Sucursales --}}

	 	<div class="header_conte">
	      <h1>Sucursales</h1>
          <div class="btn_nuevo">
              <a href="" ng-click="btn_nuevo()">Nueva Sucursal</a>
          </div>
            <div class="btn_opcion2">
              <a href="" ng-click="btn_envio()">Nuevo Envio</a>
          </div>
	 	 </div>
		<div class="col-sm-12">
			    <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Sucursal nueva</strong> guardado correctamente, creado por administradores.</div>
		        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Sucursal borrada</strong> No se podrá recuperar los datos.</div>	
			    <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Sucursal editada</strong> Puedes ver en el listado de sucursales las modificaciones realizadas.</div>

        {{-- Todas las sucursales --}}  
			 <div class="caja_contenido">
			 		 <table class="table">
			 		  <thead>
	                       <th>Cod.</th>
                         <th>Nombre</th>
	                       <th>Ubicación</th>
	                       <th>Usuario</th>
                         <th>Usuario 2</th>
	                       <th>Opciones</th>
	                   </thead>
	                   <tbody>
	                   		<tr ng-repeat="sucursal in sucursales | orderBy: 'codigo_esta'">
                        <td ng-click="abrirsucursal(sucursal)">@{{sucursal.codigo_esta}}</td>
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.nombre}}</td>
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.ubicacion}}</td>
	                   		<td ng-click="abrirsucursal(sucursal)">@{{sucursal.perfil_usuario.nombre}} @{{sucursal.perfil_usuario.apellido}}</td>
                        <td ng-click="abrirsucursal(sucursal)">@{{sucursal.perfil_usuario2.nombre}} @{{sucursal.perfil_usuario2.apellido}}</td>
	                   		<td>
	                   			<div class="area_opciones">
	                                 <ul>
	                                     <li><a href="" class="ico_editar" ng-click="btn_editar(sucursal)"></a></li>
	                                     <li class="op_drop"  uib-dropdown ng-if="sucursal.codigo_esta!=1">
	                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
	                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
	                                               <div class="col-sm-8 spd">
	                                                 <p>Eliminar Sucursal <strong>@{{sucursal.nombre}}</strong></p>
	                                               </div>
	                                               <div class="col-sm-4 spd spi">
	                                                 <a href="" ng-click="btn_eliminar(sucursal.id)" class=" btn_g ico_eliminarg"></a>
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
                      <li><span class="color_encom"></span> <p>Productos Agregados</p></li>
                      <li><span class="color_falcom"></span> <p>Productos faltantes</p></li>
                      <li><span class="color_tercom"></span> <p>Envio Terminado</p></li>
                    </ul>
                  </div>
                </div> 
              <div class="caja_contenido">
                 <div class="col-sm-12 bus_tabla">
                   <h3>Por Sucursal</h3>
                   <div class="col-sm-3">
                      <ol class="nya-bs-select" ng-model="busfiltro" title="Selecciona una sucursal..." name="id_sucursal" required>
                      <li ng-click="deselec()"><a>
                      Todos
                         <span class="glyphicon glyphicon-ok check-mark"></span>
                      </a></li>
                      <li nya-bs-option="sucursal in sucursales" data-value="sucursal.nombre">
                        <a>
                          @{{ sucursal.nombre }}
                          <span class="glyphicon glyphicon-ok check-mark"></span>
                        </a>
                      </li>
                    </ol>
                   </div>
                  
                 </div>
                 <table class="table">
                  <thead>
                              <th></th>
                              <th>#Envio</th>
                               <th>Sucursal</th>
                               <th>Total</th>
                               <th>Fecha de Entrega</th>
                               <th>Fecha de Movimiento</th>
                               <th>Opciones</th>
                           </thead>
                           <tbody>
                              <tr ng-repeat="envio in envios | filter: busfiltro | orderBy:'-id'" ng-class="{'trc_ama':envio.estado_orden==1,'trc_ver':envio.estado_orden==2,'trc_fus':envio.estado_orden==3}">
                              <td class="td_first"></td>
                              <td ng-click="abrirorden(envio)"><strong>@{{envio.id}}</strong></td>
                              <td ng-click="abrirorden(envio)">@{{envio.nombre_sucursal.nombre}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.total_compra | currency: 'Q'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.fecha_entrega  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                              <td ng-click="abrirorden(envio)">@{{envio.updated_at  | amDateFormat: 'DD/MM/YYYY HH:mm:ss'}}</td>
                              <td>
                                <div class="area_opciones">
                                         <ul>
                                             <li class="op_drop"  uib-dropdown>
                                                   <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                                   <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                       <div class="col-sm-8 spd">
                                                         <p>Eliminar Sucursal <strong>@{{sucursal.nombre}}</strong></p>
                                                       </div>
                                                       <div class="col-sm-4 spd spi">
                                                         <a href="" ng-click="btn_eliminar(sucursal.id)" class=" btn_g ico_eliminarg"></a>
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
    <script src="/js/controller/SucursalesCtrl.js"></script>
@endpush