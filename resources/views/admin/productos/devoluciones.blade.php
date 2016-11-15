@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="DevolucionesCtrl">
 {{-- Nueva devolucion --}}
      <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                        <div class="col-sm-12">
                              <h1>Nueva Devolución</h1>
                              <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                        </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Devolución existente!</strong> Intenta de nuevo con la devolución.</div>
                         <form class="form-horizontal" name="frm" role="form" ng-submit="enviarDevolucion()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                    <label for="name">Hacia:</label>
                                       <ol class="nya-bs-select" ng-model="devolucion.hacia" data-live-search="true"  title="Selecciona hacia bodega..." required>
                                                          <li nya-bs-option="bodega in bodegas" data-value="bodega.id">
                                                            <a>
                                                             <span>
                                                                  @{{ bodega.nombre }}
                                                                </span>
                                                              <span class="glyphicon glyphicon-ok check-mark"></span>
                                                            </a>
                                                          </li>
                                          </ol>
                                        
                                    </div>
                               </div>
                              
                               <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="descripcion">Descripción</label>
                                         <input id="descripcion" type="text" class="form-control" name="descripcion" ng-model="devolucion.descripcion">
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

  {{-- Traslados --}}

   <div class="header_conte">
            <h1>Devoluciones</h1>
              <div class="btn_nuevo">
                  <a href="" ng-click="btn_nuevo()">Nueva Devolución</a>
              </div>
   </div>

    <div class="col-sm-12">
     <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Devolución nueva</strong> guardado correctamente.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Devolución borrada</strong> No se podrá recuperar los datos.</div> 
   <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Devolución enviadoa</strong> Puedes ver en el listado de devoluciones realizadas.</div>

    <div class="caja_contenido">
            
        
    </div>
   

  </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/DevolucionesCtrl.js"></script>
@endpush