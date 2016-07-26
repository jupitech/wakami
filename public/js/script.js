/*AngularJS*/
var wApp= angular.module('wApp', ['ngRoute', 'ngCookies','ngAnimate','ngResource','ui.select', 'ngSanitize','ui.bootstrap','angularMoment']);
wApp.factory('ApiUsuarioNuevo', function($resource){
  return $resource("/api/usuario/create");
});

wApp.factory('ApiProveedorNuevo', function($resource){
  return $resource("/api/proveedor/create");
});

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

      }


      //Nuevo Usuario
         
      $scope.usuario={};
      $scope.guardarUsuario = function(){
         // console.log($scope.usuario);
    
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
       }; 

       $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
       };

      $scope.editarUsuario = function(){
            
            if($scope.acti_rol){
                var data = {
                name: $scope.existeUser.name,
                nombre: $scope.existeUser.perfil_usuario.nombre,
                apellido: $scope.existeUser.perfil_usuario.apellido,
                email: $scope.existeUser.email,
                role_id: $scope.existeUser.role_id
                };
                
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


            }else{
               var data = {
                name: $scope.existeUser.name,
                nombre: $scope.existeUser.perfil_usuario.nombre,
                apellido: $scope.existeUser.perfil_usuario.apellido,
                email: $scope.existeUser.email
                };
                
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
            }
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


//************************************Proveedores**********************************************//
wApp.controller('ProveedoresCtrl',function($scope, $http,ApiProveedorNuevo, $timeout, $log,$uibModal){

   $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false; //Nuevo proveedor
   $scope.editar_obj = false; // Editar proveedor
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.proveedor={};
     };


     //Todos los proveedores
      $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
            }).error(function(error) {
                 $scope.error = error;
            });  


      //Nuevo Proveedor
         
      $scope.proveedor={};
      $scope.guardarProveedor = function(){
         // console.log($scope.usuario);
    
        ApiProveedorNuevo.save($scope.proveedor, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);  
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);  
          },
          function(error){
            console.log("Parece que el proveedor ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);  
            $timeout(function () { $scope.alertaExiste = false; }, 5000);  
          });
           
      };    

       //Eliminar Proveedor
      $scope.btn_eliminar = function(id){
        $scope.idproveedor= id;
        console.log($scope.idproveedor);

         $http.delete('api/proveedor/destroy/' +  $scope.idproveedor)
            .success(function (data, status, headers) {
               console.log('Proveedor '+$scope.idproveedor+' borrado correctamente.');
                   $http.get('/api/proveedores').success(

                        function(proveedores) {
                        $scope.proveedores = proveedores.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);  
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);  
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el proveedor.');
            });
      };  

       //Editar Proveedor
        $scope.btn_editar = function(proveedor) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeProve= proveedor; 
       }; 


      $scope.editarProveedor = function(){
                var data = {
                  empresa: $scope.existeProve.empresa,
                  encargado: $scope.existeProve.encargado,
                  nit: $scope.existeProve.nit,
                  direccion: $scope.existeProve.direccion,
                  telefono: $scope.existeProve.telefono,
                  telefono_encargado: $scope.existeProve.telefono_encargado,
                  email_encargado: $scope.existeProve.email_encargado
                };
                // console.log(data);
                $http.put('api/proveedor/' +  $scope.existeProve.id, data)
                .success(function (data, status, headers) {
                   console.log('Proveedor '+$scope.existeProve.empresa+' modificado correctamente.');
                       $http.get('/api/proveedores').success(
                          function(proveedores) {
                                    $scope.proveedores = proveedores.datos;
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


});


//************************************Menu Dos*************************************************//
wApp.controller('menuDos',function($scope, $timeout){
  $scope.btn_menu = function() {
        $scope.menudos = !$scope.menudos;
    };
   $scope.Fecha = new Date();
    //Fecha y Hora actual
                  $scope.clock = "..."; // initialise the time variable
                  $scope.tickInterval = 1000 //ms

                  var tick = function() {
                      $scope.clock = Date.now() // get the current time
                      $timeout(tick, $scope.tickInterval); // reset the timer
                  }
                  $timeout(tick, $scope.tickInterval);          
});