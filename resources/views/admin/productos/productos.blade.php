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
                                      <table class="table">
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
                                                                         <li><a href="" class="ico_editar" ng-click="btn_editar(proveedor)"></a></li>
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

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush