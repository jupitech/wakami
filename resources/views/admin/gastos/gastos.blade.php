@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="GastosCtrl">
    {{-- Categoria --}}
               <div id="area_nuevo" ng-if="nuevo_obj">
                      <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Categoria de Gastos</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                       </div>
                       <div class="conte_nuevo">
                                <div class="col-sm-12">
                                  <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Categoria de gasto existente!</strong></div>
                                     <form class="form-horizontal" name="frm" role="form" ng-submit="guardarCategoria()" >
                                          <div class="form-group">
                                                <div class="col-md-8">
                                                    <label for="name">Nueva Categoria</label>
                                                     <input id="name" type="text" class="form-control" name="nombre" ng-model="categoria.nombre" placeholder="Nombre de la linea" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">AGREGAR</button>
                                                </div>
                                           </div>
                                     </form>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert alert-info" role="alert" ng-if="alertaEditadol"> <strong>Categoria editada correctamente!</strong></div>
                                        <div class="alert alert-danger" role="alert" ng-if="alertaEliminadol"> <strong>Categoria borrada correctamente!</strong></div>
                                </div>
                                <div class="col-sm-12 table_height">

                                      <table class="table ">
                                                     <thead>
                                                         <th>Categoria</th>
                                                         <th>Opciones</th>
                                                     </thead>
                                                     <tbody>
                                                         <tr ng-repeat="categoria in categorias">
                                                             <td>@{{categoria.nombre}}</td>
                                                             <td>
                                                                 <div class="area_opciones">
                                                                     <ul>
                                                                         <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(categoria)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="editarCategoria()" >
                                                                                       <div class="col-sm-9 ">
                                                                                           <input id="name" type="text" class="form-control" name="nombre" ng-model="existeCategoria.nombre" required>
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
                                                                                     <p>Eliminar <strong>@{{categoria.nombre}}</strong></p>
                                                                                   </div>
                                                                                   <div class="col-sm-4 spd spi">
                                                                                     <a href="" ng-click="btn_eliminar(categoria.id)" class=" btn_g ico_eliminarg"></a>
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
  {{-- Editar Gasto --}}
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Gasto @{{existeGasto.descripcion}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Gasto existente!</strong> Intenta de nuevo con otra descripcion</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarGasto()" >
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Descripción</label>
                                         <input id="name" type="text" class="form-control" name="descripcion" ng-model="existeGasto.descripcion" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.descripcion.$dirty && frmed.descripcion.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Costo</label>
                                       <input id="nombre" type="text" class="form-control" name="costo" ng-model="existeGasto.costo" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.costo.$dirty && frmed.costo.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                           <label for="nombre">Fecha del gasto</label>
                                                      <input type="date" data-date-format="dd/mm/yyyy" class="form-control" name="fecha_gasto" ng-model="existeGasto.fgasto" ng-init="existeGasto.fgasto=Mdate(existeGasto.fecha_gasto)" required>   
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


  {{-- Gastos --}}

   <div class="header_conte">
            <h1>Gastos</h1>
              <div class="btn_seg">
                  <a href="" ng-click="btn_nuevo()">Categoria Gasto</a>
              </div>
   </div>

    <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Gasto nuevo</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Gasto borrado</strong> No se podrá recuperar los datos.</div> 
   <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Gasto editado</strong> Puedes ver en el listado de gastos las modificaciones realizadas.</div>

    <div class="caja_contenido">

     <div class="col-sm-12 conte_nuevo">
            <form class="form-horizontal" name="frm" role="form" ng-submit="guardarGasto()" >
                     <div class="col-sm-3">
                                        <label for="name">Categoria</label>
                                         <ol class="nya-bs-select" ng-model="gasto.id_categoria" title="Selecciona una categoria..." required>
                                            <li nya-bs-option="categoria in categorias" data-value="categoria.id">
                                              <a>
                                                @{{ categoria.nombre }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>

                                        
                      </div>
                      <div class="col-sm-3">
                         <label for="name">Descripción</label>
                                         <input id="descripcion" type="text" class="form-control" name="descripcion" ng-model="gasto.descripcion" placeholder="Descripción del gasto" required>
                      </div> 
                         <div class="col-sm-2">
                         <label for="name">Costo</label>
                                         <input id="costo" type="text" class="form-control" name="costo" ng-model="gasto.costo" placeholder="0.00" required>
                      </div> 
                       <div class="col-sm-2">
                                       <label for="nombre">Fecha del gasto</label>
                                      <input type="date"  class="form-control" name="fecha_gasto" ng-model="gasto.fecha_gasto" required>   
                                    
                      </div>   
                      <div class="col-sm-2">
                         <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">AGREGAR</button>
                      </div> 
            </form>
      </div>
             <table class="table">
                 <thead>
                     <th>Categoria</th>
                     <th>Descripción</th>
                     <th>Mes</th>
                     <th>Costo</th>
                     <th>Fecha Gasto</th>
                     <th>Opciones</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="gasto in gastos">
                         <td>@{{gasto.categoria.nombre}}</td>
                         <td>@{{gasto.descripcion}} </td>
                         <td>@{{gasto.mes}}</td>
                         <td>Q@{{gasto.costo | number:2}}</td>
                         <td>@{{gasto.fecha_gasto  | amDateFormat: 'DD/MM/YYYY'}}</td>
                         <td>
                             <div class="area_opciones">
                                 <ul>
                                     <li><a href="" class="ico_editar" ng-click="btn_editar(gasto)"></a></li>
                                     <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar <strong>@{{gasto.descripcion}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminargas(gasto.id)" class=" btn_g ico_eliminarg"></a>
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
    <script src="/js/controller/GastosCtrl.js"></script>
@endpush