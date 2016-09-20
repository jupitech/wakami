
//**************************************Usuarios*************************************************//
wApp.controller('UsuariosCtrl',function($scope, $http,ApiUsuarioNuevo, $timeout, $log,$uibModal){

  $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false; //Nuevo usuario
   $scope.editar_obj = false; // Editar Usuario
   $scope.ver_eli = false; // Ver usuarios eliminados
   $scope.acti_rol = false; //Activar para cambiar roles
     $scope.acti_cla = false; //Activar para cambiar contraseña
   $scope.alertaNuevo = false; // Alerta de nuevo usuario registrado
   $scope.alertaExiste = false; // Alerta si el usuario ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de usuario eliminado
    $scope.alertaEditado = false; // Alerta de usuario editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
         $scope.usuario={};
     };


      $http.get('/api/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Roles

            $http.get('/api/roles').success(

              function(roles) {
                        $scope.roles = roles.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      //Restaurar usuarios

      $scope.btn_eliminados= function(){
         $scope.ver_eli = !$scope.ver_eli;
             $http.get('/api/usuarioseli').success(

              function(usuarioseli) {
                        $scope.usuarioseli = usuarioseli.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      };


      //Nuevo Usuario

      $scope.usuario={};
      $scope.guardarUsuario = function(){
         console.log($scope.usuario);

        ApiUsuarioNuevo.save($scope.usuario, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que el usuario ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };
      //Editar Usuario
        $scope.btn_editar = function(usuario) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeUser= usuario;
          $scope.acti_rol = false;
          $scope.acti_cla = false;
       };

       $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
       };

        $scope.act_cla = function() {
          $scope.acti_cla = !$scope.acti_cla;
       };

      $scope.editarUsuario = function(){

            if($scope.acti_rol){
               if($scope.acti_cla){
                          var data = {
                          name: $scope.existeUser.name,
                          nombre: $scope.existeUser.perfil_usuario.nombre,
                          apellido: $scope.existeUser.perfil_usuario.apellido,
                          email: $scope.existeUser.email,
                          role_id: $scope.existeUser.role_id,
                          password: $scope.existeUser.password
                          };
                }else{
                          var data = {
                          name: $scope.existeUser.name,
                          nombre: $scope.existeUser.perfil_usuario.nombre,
                          apellido: $scope.existeUser.perfil_usuario.apellido,
                          email: $scope.existeUser.email,
                          role_id: $scope.existeUser.role_id
                          };
                }
             }else{

                if($scope.acti_cla){
                       var data = {
                        name: $scope.existeUser.name,
                        nombre: $scope.existeUser.perfil_usuario.nombre,
                        apellido: $scope.existeUser.perfil_usuario.apellido,
                        email: $scope.existeUser.email,
                        password: $scope.existeUser.password
                        };
                  }else{

                        var data = {
                        name: $scope.existeUser.name,
                        nombre: $scope.existeUser.perfil_usuario.nombre,
                        apellido: $scope.existeUser.perfil_usuario.apellido,
                        email: $scope.existeUser.email
                        };
                  }
              }

                console.log(data);
                $http.put('api/usuario/' +  $scope.existeUser.id, data)
                .success(function (data, status, headers) {
                   console.log('Usuario '+$scope.existeUser.name+' modificado correctamente.');
                       $http.get('/api/usuarios').success(

                          function(usuarios) {
                                    $scope.usuarios = usuarios.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

        };


      //Eliminar Usuario
      $scope.btn_eliminar = function(id){
        $scope.idusuario= id;
        console.log($scope.idusuario);

         $http.delete('api/usuario/destroy/' +  $scope.idusuario)
            .success(function (data, status, headers) {
               console.log('Usuario '+$scope.idusuario+' borrado correctamente.');
                   $http.get('/api/usuarios').success(

                      function(usuarios) {
                                $scope.usuarios = usuarios.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el usuario.');
            });
      };

      //Regresar usuario
       $scope.btn_restaurar = function(id){
        $scope.idusuario= id;
        console.log($scope.idusuario);

         $http.put('api/usuario/restaurar/' +  $scope.idusuario)
            .success(function (data, status, headers) {
               console.log('Usuario '+$scope.idusuario+' restaurado correctamente.');
                   $http.get('/api/usuarios').success(

                      function(usuarios) {
                                $scope.usuarios = usuarios.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    });
                    //$timeout(function () { $scope.alertaEliminado = true; }, 1000);
                   // $timeout(function () { $scope.alertaEliminado = false; }, 5000);
                   $scope.ver_eli = false;
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el usuario.');
            });
      };


});