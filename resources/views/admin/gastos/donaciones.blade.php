@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="DonacionesCtrl" ng-cloak>
 {{-- Nueva donacion --}}
      <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Donación</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Donación existente!</strong> Intenta de nuevo con la donación.</div>
                         <form class="form-horizontal" name="frm" role="form" ng-submit="crearDonacion()" >
                               
                                 <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="para">Para</label>
                                         <input id="para" type="text" class="form-control" name="para" ng-model="donacion.para" required>
                                    </div>
                               </div>
                               
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="descripcion">Descripción</label>
                                         <input id="descripcion" type="text" class="form-control" name="descripcion" ng-model="donacion.descripcion" required>
                                    </div>
                               </div>
                               
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">ENVIAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>

  {{-- Area donaciones --}}
               <div id="area_mas" ng-if="mas_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Donación No.@{{exisDonacion.id}}</h1>
                              <a class="btn_cerrar" ng-click="btn_cerrarc()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                          <div class="col-sm-12">
                          <div class="col-sm-6 spi">
                              <h3>Para</h3>
                              <h2> @{{exisDonacion.para}}
                               
                              </h2>
                          </div>
                          <div class="col-sm-6 spd">
                              <h3>Descripción</h3>
                              <h2>
                                  @{{exisDonacion.descripcion}}
                              </h2>
                          </div>
                      </div>

                      {{-- Donacion de productos --}}
                      <div class="col-sm-12 middle" ng-if="exisDonacion.estado_donacion==1">
                           <form class="form-horizontal" name="frm" role="form" ng-submit="guardarProDonacion()" >
                                          <div class="form-group">
                                                <div class="col-sm-2 col-md-2 col-lg-2" ng-class="{'has-error': formus.nombre.$invalid, 'has-success': formus.nombre.$valid}">
                                                     <label for="cantidad">Cant.</label>
                                                     <input id="cantidad" type="number" min="1" ng-min="1" class="form-control" name="cantidad" ng-model="prodonacion.cantidad" required>
                                                        <div class="col-sm-12 spd spi">
                                                          <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.required">Requerido.</div>
                                                            <div class="alert alert-danger" ng-show="frm.cantidad.$dirty && frm.cantidad.$error.min">Mínimo 1</div>
                                                        </div>
                                                </div>
                                                <div class="col-sm-8 col-md-8 col-lg-9">
                                                    <label for="name">Producto</label>
                                                     <ol class="nya-bs-select" ng-model="prodonacion.id_producto" data-live-search="true"  title="Selecciona un producto..." required  data-size="10">
                                                          <li nya-bs-option="producto in productos" data-value="producto.id">
                                                            <a>
                                                             <span>
                                                              <small class="label label-success">@{{ producto.codigo }}</small>
                                                                  @{{ producto.nombre }}-<strong> Q@{{ producto.costo }} </strong>
                                                                   <small class="label label-info">@{{ producto.stock_producto.stock }}</small>
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

                         {{-- Productos agregados a donacion --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisDonacion.estado_donacion==1">
                      <div class="col-sm-12">
                          <div class="alert alert-danger" role="alert" ng-if="alertaEliminadoPro"> <strong>Producto borrado</strong> No se podrá recuperar los datos.</div>  
                      </div>
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th class="td_opciones">Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="prodevo in prodonacion">
                                                   <td><small class="label label-success">@{{ prodevo.nombre_producto.codigo }}</small> @{{prodevo.nombre_producto.nombre}}</td>
                                                   <td>@{{prodevo.cantidad}} </td>
                                                   <td class="td_opciones">
                                                       <div class="area_opciones">
                                                           <ul>
                                                                  <li class="ed_drop"  uib-dropdown>
                                                                         <a href="" class="ico_editar" id="simple-dropdown" uib-dropdown-toggle ng-click="btn_editarl(prodevo)"></a>
                                                                                <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                                                <form class="form-horizontal" name="frmed" role="form" ng-submit="btn_proeditar()" >
                                                                                       <div class="col-sm-9 ">
                                                                                           <input id="name" type="number" min="1" class="form-control" name="nombre" ng-model="existePro.cantidad" required>
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
                                                                           <p>Eliminar <strong>@{{prodevo.nombre_producto.nombre}}</strong></p>
                                                                         </div>
                                                                         <div class="col-sm-4 spd spi">
                                                                           <a href="" ng-click="btn_proeliminar(prodevo.id)" class=" btn_g ico_eliminarg"></a>
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


                         {{-- Productos agregados a donacion --}}
                      <div class="col-sm-12 conte table_height" ng-if="exisDonacion.estado_donacion==2">
                                  <table class="table">
                                           <thead>
                                               <th>Producto</th>
                                               <th>Cant.</th>
                                               <th class="td_opciones">Opciones</th>
                                           </thead>
                                             <tbody>
                                               <tr ng-repeat="prodevo in prodonacion">
                                                   <td><small class="label label-success">@{{ prodevo.nombre_producto.codigo }}</small> @{{prodevo.nombre_producto.nombre}}</td>
                                                   <td>@{{prodevo.cantidad}} </td>
                                                   <td class="td_opciones">
                                                       <small class="label label-success">Enviado</small>
                                                   </td>
                                               </tr>
                                              
                                           </tbody>
                                       </table>
                      </div>

                       {{-- Totales y Acciones --}}
                      <div class="col-sm-12 footer">
                       
                        <div class="col-sm-12" ng-if="exisDonacion.estado_donacion==1 && prodonacion.length > 0">
                               <form class="form-horizontal" name="frm" role="form" ng-submit="enviarDonacion()" >
                                          <div class="form-group">
                                              <div class="col-sm-8">
                                                <p class="info_paso"><strong>PASO 1</strong> Envio de los productos para donaciones</p>
                                              </div>
                                              <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">Enviar Donación</button>
                                              </div>
                                           </div>
                                     </form>
                        </div>
                       
                        {{-- Estado de Orden 2 --}}
                             <div class="col-sm-8" ng-if="exisDonacion.estado_donacion>1 && exisDonacion.estado_donacion<3" >
                                
                                              <div class="form-group">
                                                  <div class="col-sm-7">
                                                    <p class="info_paso"><strong>HAS TERMINADO!</strong> Todos los productos han sido reducidos de la bodega</p>
                                                  </div>
                                               </div>
                            </div>
                           

                      </div>


                    </div>
               </div>               

  {{-- Donaciones --}}

   <div class="header_conte">
            <h1>Donaciones</h1>
              <div class="btn_nuevo">
                  <a href="" ng-click="btn_nuevo()">Nueva Donación</a>
              </div>
   </div>

    <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Donación nueva</strong> guardado correctamente.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Donación borrada</strong> No se podrá recuperar los datos.</div> 
   <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Donación enviadoa</strong> Puedes ver en el listado de donaciones realizadas.</div>

    <div class="caja_contenido">
                <table class="table">
                 <thead>
                     <th>#</th>
                     <th>Para</th>
                     <th>Descripcion</th>
                     <th>Fecha Entrega</th>
                     <th>Opciones</th>
                 </thead>
                 <tbody>
                     <tr ng-repeat="donacion in donaciones  | orderBy:'-id'" ng-class="{'trc_ver':donacion.estado_donacion==1}">
                        <td ng-click="abrirdonacion(donacion)">@{{donacion.id}}</td>
                        
                          <td   ng-click="abrirdonacion(donacion)">@{{donacion.para}}</td>
                           <td   ng-click="abrirdonacion(donacion)">@{{donacion.descripcion}}</td>
                         <td   ng-click="abrirdonacion(donacion)">@{{donacion.fecha_entrega}}</td>
                         
                         <td ng-if="donacion.estado_donacion==1">
                             <div class="area_opciones">
                                 <ul>

                                      <li class="op_drop"  uib-dropdown>
                                           <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                           <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                               <div class="col-sm-8 spd">
                                                 <p>Eliminar Donación <strong>#@{{donacion.id}}</strong></p>
                                               </div>
                                               <div class="col-sm-4 spd spi">
                                                 <a href="" ng-click="btn_eliminar(donacion.id)" class=" btn_g ico_eliminarg"></a>
                                               </div>
                                            </div>
                                     </li>
                                 </ul>
                             </div>
                         </td>
                          <td ng-if="donacion.estado_donacion==2">
                           <div class="area_opciones" >
                                         <ul>
                                            
                                              <li><a href="" class="ico_pdf" ng-click="btn_pdfenvio(donacion.id)"></a></li>
                                         </ul>
                                     </div>
                          <small class="label label-success">Realizado</small>
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
    <script src="/js/controller/DonacionesCtrl.js"></script>
@endpush