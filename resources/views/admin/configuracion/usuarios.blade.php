@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
        <div class="col-md-12" ng-controller="UsuariosCtrl">
            <div class="header_conte">
            	<h1>Usuarios</h1>
                <div class="btn_nuevo">
                    <a href="">Nuevo Usuario</a>
                </div>
            </div>
            <div class="col-sm-12">
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