/*AngularJS*/
var wApp= angular.module('wApp', ['ngRoute', 'ngCookies','ngAnimate','ngResource','ui.select', 'ngSanitize','ui.bootstrap','angularMoment']);
wApp.factory('ApiUsuarioNuevo', function($resource){
  return $resource("/api/usuario/create");
});


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


   $scope.nuevo_obj = false;
   $scope.editar_obj = false;
   $scope.ver_eli = false;
   $scope.alertaNuevo = false;
   $scope.alertaExiste = false;
   $scope.alertaEliminado = false;
   
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
     }; 
      $scope.editarUsuario = function(){
            

              var data = {
                name: $scope.existeUser.name,
                nombre: $scope.existeUser.perfil_usuario.nombre,
                apellido: $scope.existeUser.perfil_usuario.apellido,
                email: $scope.existeUser.email
            };
              console.log(data);
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

wApp.controller('menuDos',function($scope){
  $scope.btn_menu = function() {
        $scope.menudos = !$scope.menudos;
    };
            
});