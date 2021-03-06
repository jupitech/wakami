@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

        <div class="col-md-12 top_conte" ng-controller="UsuariosCtrl" ng-cloak>
        {{-- Nuevo usuario --}}
          @role('admin|developer') 
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
                                       <input id="password2"  type="password" class="form-control" name="password2"  ng-model="usuario.password2" ng-minlength="8" placeholder="" required compare-to="usuario.password">
                                        <div class="col-sm-12 spd spi">
                                          <div class="alert alert-danger" ng-show="frm.password2.$dirty && frm.password2.$error.required">Campo requerido</div>
                                          <div class="alert alert-danger" ng-show="frm.password2.$dirty && frm.password2.$error.minlength">Contraseña corta</div>
                                           <div class="alert alert-danger" ng-show="frm.password2.$dirty && frm.password2.$error.compareTo ">No coincide contraseña</div>
                                       </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="rol">Rol de Usuario</label>
                                       <ol class="nya-bs-select" ng-model="usuario.role_id" title="Selecciona un rol..."  required>
                                            <li nya-bs-option="rol in roles | orderBy:'-id' | filter:{ id: '!4'} " data-value="rol.id">
                                              <a>
                                                @{{ rol.name }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol>   

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
               @endrole
              {{-- Editar Usuario --}}
           @role('admin|developer') 
                <div id="area_nuevo" ng-if="editar_obj">
                    <div class="header_nuevo">

                    <div class="col-sm-12">
                          <h1>Editar Usuario @{{existeUser.name}}</h1>
                          <a class="btn_cerrar" ng-click="btn_editar()"></a>
                    </div>
                    </div>
                    <div class="conte_nuevo">
                      <div class="col-sm-12">
                      <div class="alert alert-warning" role="alert" ng-if="alertaExiste"> <strong>Usuario existente!</strong> Intenta de nuevo con otro usuario y E-mail</div>
                        <form class="form-horizontal" name="frmed" role="form" ng-submit="editarUsuario()" >
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="name">Usuario</label>
                                         <input id="name" type="text" class="form-control" name="name" ng-model="existeUser.name" placeholder="Usuario" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.name.$dirty && frmed.name.$error.required">Campo requerido</div>
                                         </div>
                                        
                                    </div>
                               </div>
                               <div class="form-group">
                                  <div class="col-md-6">
                                       <label for="nombre">Nombre</label>
                                       <input id="nombre" type="text" class="form-control" name="nombre" ng-model="existeUser.perfil_usuario.nombre" placeholder="Nombre" required>
                                        <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.nombre.$dirty && frmed.nombre.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                                   <div class="col-md-6">
                                       <label for="nombre">Apellido</label>
                                       <input id="apellido" type="text" class="form-control" name="apellido" ng-model="existeUser.perfil_usuario.apellido" placeholder="Apellido" required>
                                         <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.apellido.$dirty && frmed.apellido.$error.required">Campo requerido</div>
                                         </div>
                                  </div>
                               </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">E-mail</label>
                                         <input id="email" type="email" class="form-control" name="email" ng-model="existeUser.email" placeholder="Correo Electrónico" required>
                                           <div class="col-sm-12 spd spi">
                                            <div class="alert alert-danger" ng-show="frmed.email.$dirty && frmed.email.$error.required">Campo requerido</div>
                                            <div class="alert alert-danger" ng-show="frmed.email.$dirty && frmed.email.$error.email">Email Invalido</div>
                                         </div>
                                    </div>
                               </div>
                              
                                <div class="form-group">
                                  <div class="col-md-12">
                                       <div class="col-sm-12 spd spi">
                                        <label for="rol">Rol de Usuario</label>
                                       </div>
                                       <div class="col-sm-6 spi">
                                         <p class="p_rol">@{{existeUser.rol_usuario.el_rol.name}}</p>
                                         <div class="onoffswitch">
                                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ng-click="act_rol()">
                                            <label class="onoffswitch-label" for="myonoffswitch">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div> 
                                       </div>
                                       <div class="col-sm-6 spd">
                                         <ol class="nya-bs-select"  ng-if="acti_rol" ng-model="existeUser.role_id" title="Cambiar a..">
                                            <li nya-bs-option="rol in roles | orderBy:'-id' | filter:{ id: '!4'}" data-value="rol.id">
                                              <a>
                                                @{{ rol.name }}
                                                <span class="glyphicon glyphicon-ok check-mark"></span>
                                              </a>
                                            </li>
                                          </ol> 
                                       </div>

                                  </div>

                               </div>
                                <div class="form-group">
                                      <div class="col-md-12">
                                           <div class="col-sm-3 spi">
                                           <label for="rol">Contraseña?</label>
                                             <div class="onoffswitch">
                                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch2" ng-click="act_cla()">
                                                <label class="onoffswitch-label" for="myonoffswitch2">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div> 
                                           </div>
                                           <div class="col-sm-9 spd">
                                               <div class="col-sm-6 spi" ng-if="acti_cla">
                                                   <label for="password">Nueva</label>
                                                   <input id="password" type="password" class="form-control" name="password" ng-model="existeUser.password" placeholder="Mínimo 8 caracteres" ng-minlength="8" required>
                                                    <div class="col-sm-12 spd spi">
                                                      <div class="alert alert-danger" ng-show="frmed.password.$dirty && frmed.password.$error.required">Campo requerido</div>
                                                      <div class="alert alert-danger" ng-show="frmed.password.$dirty && frmed.password.$error.minlength">Contraseña corta</div>
                                                   </div>
                                              </div>
                                               <div class="col-sm-6 spd" ng-if="acti_cla">
                                                   <label for="password2">Repetir</label>
                                                   <input id="password2"  type="password" class="form-control" name="password2"  ng-model="existeUser.password2" ng-minlength="8" placeholder="" required compare-to="existeUser.password">
                                                    <div class="col-sm-12 spd spi">
                                                      <div class="alert alert-danger" ng-show="frmed.password2.$dirty && frmed.password2.$error.required">Campo requerido</div>
                                                      <div class="alert alert-danger" ng-show="frmed.password2.$dirty && frmed.password2.$error.minlength">Contraseña corta</div>
                                                       <div class="alert alert-danger" ng-show="frmed.password2.$dirty && frmed.password2.$error.compareTo ">No coincide contraseña</div>
                                                   </div>
                                              </div>
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
             @endrole
            <div class="header_conte">
              <h1>Usuarios</h1>
               @role('admin|developer')   
                  <div class="btn_nuevo">
                      <a href="" ng-click="btn_nuevo()">Nuevo Usuario</a>
                  </div>
                   
                   <div class="btn_eliminados">
                      <a href="" ng-click="btn_eliminados()"></a>
                  </div>
                 @endrole
            </div>
           
            <div class="col-sm-12">
              <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Usuario nuevo</strong> guardado correctamente, creado por administradores.</div>
                <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Usuario borrado</strong> Revisa en area de usuarios borrados si desean restaurar.</div>
               <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Usuario editado</strong> Puedes ver en el listado de usuarios las modificaciones realizadas.</div>
            {{-- Usuarios borrados --}}
              @role('admin|developer') 
                <div class="caja_contenidob" ng-if="ver_eli">
                       <table class="table">
                           <thead>
                               <th>Usuario</th>
                               <th>Nombre y Apellido</th>
                               <th>E-mail</th>
                               <th>Role</th>
                               <th>Eliminado el</th>
                               <th>Opciones</th>
                           </thead>
                           <tbody>
                               <tr ng-repeat="usuario in usuarioseli">
                                   <td>@{{usuario.name}}</td>
                                   <td>@{{usuario.perfil_usuario.nombre}} @{{usuario.perfil_usuario.apellido}} </td>
                                   <td>@{{usuario.email}}</td>
                                   <td>@{{usuario.rol_usuario.el_rol.name}}</td>
                                   <td>@{{usuario.deleted_at}}</td>
                                   <td>
                                       <div class="area_opciones">
                                           <ul>
                                               <li><a href="" class="ico_restaurar" ng-click="btn_restaurar(usuario.id)"></a></li>
                                              
                                           </ul>
                                       </div>
                                   </td>
                               </tr>
                              
                           </tbody>
                       </table>
                  
              </div>
              @endrole
            {{-- Usuarios activos --}}
              <div class="caja_contenido">
                       <table class="table">
                           <thead>
                               <th>Usuario</th>
                               <th>Nombre y Apellido</th>
                               <th>E-mail</th>
                               <th>Role</th>
                               <th>Modificado</th>
                                @role('admin|developer') 
                               <th>Opciones</th>
                                @endrole
                           </thead>
                           <tbody>
                               <tr ng-repeat="usuario in usuarios">
                                   <td>@{{usuario.name}}</td>
                                   <td>@{{usuario.perfil_usuario.nombre}} @{{usuario.perfil_usuario.apellido}} </td>
                                   <td>@{{usuario.email}}</td>
                                   <td>@{{usuario.rol_usuario.el_rol.name}}</td>
                                   <td>@{{usuario.updated_at | amDateFormat: 'dddd, MMMM Do YYYY, h:mm a'}}</td>
                                    @role('admin|developer') 
                                   <td>
                                       <div class="area_opciones">
                                           <ul>
                                               <li><a href="" class="ico_editar" ng-click="btn_editar(usuario)"></a></li>
                                               <li ng-if="usuario.id!=1" class="op_drop"  uib-dropdown>
                                                     <a href="" class="ico_eliminar" id="simple-dropdown" uib-dropdown-toggle></a>
                                                     <div class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                         <div class="col-sm-8 spd">
                                                           <p>Eliminar <strong>@{{usuario.name}}</strong></p>
                                                         </div>
                                                         <div class="col-sm-4 spd spi">
                                                           <a href="" ng-click="btn_eliminar(usuario.id)" class=" btn_g ico_eliminarg"></a>
                                                         </div>
                                                      </div>
                                               </li>
                                           </ul>
                                       </div>
                                   </td>
                                   @endrole
                               </tr>
                              
                           </tbody>
                       </table>
                  
              </div>
            </div>
            
        </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ConfiguracionCtrl.js"></script>
@endpush