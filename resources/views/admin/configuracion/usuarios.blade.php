@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

        <div class="col-md-12 top_conte" ng-controller="UsuariosCtrl">
               <div id="area_nuevo" ng-if="nuevo_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Nuevo Usuario</h1>
                          <a class="btn_cerrar" ng-click="btn_nuevo()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Usuario existente!</strong> Intenta de nuevo con otro usuario y E-mail</div>
                        <form class="form-horizontal" name="frm" role="form" ng-submit="guardarUsuario()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Usuario</label>
                                         <input id="name" type="text" class="form-control" name="name" ng-model="usuario.name" placeholder="Usuario" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.name.$dirty && frm.name.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Nombre</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="usuario.nombre" placeholder="Nombre" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.nombre.$dirty && frm.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">Apellido</label>
                                       <input id="apellido" type="text" class="form-control" name="apellido" ng-model="usuario.apellido" placeholder="Apellido" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.apellido.$dirty && frm.apellido.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">E-mail</label>
                                         <input id="email" type="email" class="form-control" name="email" ng-model="usuario.email" placeholder="Correo Electrónico" required>
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frm.email.$dirty && frm.email.$error.email">Email Invalido</div>
                                         </div>
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="password">Contraseña</label>
                                       <input id="password" type="password" class="form-control" name="password" ng-model="usuario.password" placeholder="Mínimo 8 caracteres" ng-minlength="8" required>
                                        <div class="col-sm-12 spd spi">
                                          <div class="alert alert-danger" ng-show="frm.password.$dirty && frm.password.$error.required">Campo requerido</div>
                                          <div class="alert alert-danger" ng-show="frm.password.$dirty && frm.password.$error.minlength">Contraseña corta</div>
                                       </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="password2">Repetir Contraseña</label>
                                       <input id="password2" type="password" class="form-control" name="password2" placeholder="">
                                  </div>
                               </div>
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="rol">Rol de Usuario</label>
                                       <select class="form-control" ng-model="usuario.role_id">
                                            <option ng-repeat="rol in roles | orderBy:'-id'" value="@{{rol.id}}" selected="selected">@{{rol.name}}</option>
                                          </select>

                                  </div>

                               </div>
                               <div class="form-group">
                                 <div class="col-sm-6">
                                     <button type="submit" class="btn btn-primary btn_regis" ng-disabled="frm.$invalid">REGISTRAR</button>
                                  </div>
                                   <div class="col-sm-6">
                                     <a class="btn btn_cancelar" ng-click="btn_nuevo()">CANCELAR</a>
                                  </div>
                               </div>
                              
                        </form>
                      </div>
                    </div>
              </div>
            <div class="header_conte">
              <h1>Usuarios</h1>
                <div class="btn_nuevo">
                    <a href="" ng-click="btn_nuevo()">Nuevo Usuario</a>
                </div>
            </div>
           
            <div class="col-sm-12">
              <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Usuario nuevo</strong> guardado correctamente, creado por administradores.</div>
              <div class="caja_contenido">
                       <table class="table">
                           <thead>
                               <th>Usuario</th>
                               <th>Nombre y Apellido</th>
                               <th>E-mail</th>
                               <th>Role</th>
                               <th>Modificado</th>
                               <th>Opciones</th>
                           </thead>
                           <tbody>
                               <tr ng-repeat="usuario in usuarios">
                                   <td>@{{usuario.name}}</td>
                                   <td>@{{usuario.perfil_usuario.nombre}} @{{usuario.perfil_usuario.apellido}} </td>
                                   <td>@{{usuario.email}}</td>
                                   <td>@{{usuario.rol_usuario.el_rol.name}}</td>
                                   <td>@{{usuario.updated_at}}</td>
                                   <td>
                                       <div class="area_opciones">
                                           <ul>
                                              <li><a href="" class="ico_activado"></a></li>
                                               <li><a href="" class="ico_cambiar"></a></li>
                                               <li><a href="" class="ico_editar"></a></li>
                                               <li><a href="" class="ico_eliminar"></a></li>
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