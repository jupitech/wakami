@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
   <div class="col-md-12 top_conte" ng-controller="MisProductosCtrl">



	{{-- Productos --}}
	
	 <div class="header_conte">
              <h1>Productos</h1>
                                  <div class="btn_seg">

                    <a ng-click="descargaexcel()"><span class="glyphicon glyphicon-save"></span> Descargar Stock</a>
                </div>
     </div>
     <div class="col-sm-12"  ng-if="miusuario.sucursal_usuario.id===null || miusuario.sucursal_usuario2.id===null">
         <div class="caja_contenido">
               <div class="col-sm-12">
                  <h3 class="h3_noasig">No tienes asignado Sucursal a tu usuario, pide al administrador el acceso</h3>
               </div>
           
         </div>
          
     </div>
      <div class="col-sm-12" ng-if="miusuario.sucursal_usuario.id || miusuario.sucursal_usuario2.id">
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
                                   <a href=""></a>
                                </div>
                                
                                <div ng-if="producto.imagen_id != 0 " class="con_imagen">
                                  <img src="@{{producto.nombre_producto.nombre_imagen.ruta}}" alt="">
                                </div>

                                </div>
                                <div class="box_middle">
                                   <h1>@{{producto.nombre_producto.nombre}}</h1>
                                   <h2>@{{producto.nombre_producto.nombre_linea.nombre}}</h2>
                                   <p>@{{producto.nombre_producto.codigo}}</p>
                                   <h3>@{{producto.nombre_producto.codigo_barra}}</h3>
                                </div>
                                <div class="box_footer">
                                   <p class="p_costo">Q@{{producto.nombre_producto.costo | number:2}}</p>
                                   <p class="p_preciop">Q@{{producto.nombre_producto.preciop | number:2}}</p>
                                </div>
                                <div class="box_opciones">
                                <div class="col-sm-6 spd spi">
                                  <p class="p_stock" ><strong>@{{producto.stock}}</strong> uni</p>
                                </div>
                                <div class="col-sm-6 spd spi">
                                      <div class="area_opciones">
                                            <ul>
                                           
                                          </ul>
                                      </div>
                                </div>
                              
                                  
                                  
                                </div>
                             
                          </div>
                        </li>
                      </ul>
              </div>
      </div>
   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ProductosCtrl.js"></script>
@endpush