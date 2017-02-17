//**************************************Developer Controller*************************************************//
wApp.controller('DeveloperCtrl',function($scope, $http,ApiDeveloperNuevo, $timeout, $log,$uibModal){

  $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));

  $scope.nuevo_obj = false; //Nuevo objeto
  $scope.editar_obj = false; // Editar objeto  
  // $scope.acti_rol; //Activar para cambiar roles
  $scope.acti_cla = false; //Activar para cambiar contraseña
  $scope.alertaNuevo = false; // Alerta de nuevo usuario registrado
  $scope.alertaExiste = false; // Alerta si el usuario ya esta en existencia
  $scope.alertaEliminado = false; // Alerta de usuario eliminado
  $scope.alertaEditado = false; // Alerta de usuario editado

  $scope.dev;

  $scope.btn_nuevo = function() {
    $scope.nuevo_obj = !$scope.nuevo_obj;
    $scope.usuario={};
  };

   $http.get('/api/estado_pagina').success(
      function(developers) {
        $scope.developers = developers.estado;  

            if ($scope.developers == 2) {
                console.log('Developer');
                $scope.acti_rol = true;              
            } else {
                console.log('Produccion');
                $scope.acti_rol = false;              
            }  

                
    }).error(function(error) {
        $scope.error = error;
    });

    $scope.act_rol = function() {
      $scope.acti_rol = !$scope.acti_rol;  

      $http.put('/api/estado_pagina/actualizar', $scope.developers).success(function(){


          $http.get('/api/estado_pagina').success(
            function(developers) {
                $scope.developers = developers.estado;  

                if ($scope.developers == 2) {
                    console.log('Developer');
                    $scope.acti_rol = true;
                } else {
                    console.log('Produccion');
                    $scope.acti_rol = false;
                }   
            }).error(function(error) {
                $scope.error = error;
            });
                }).error(function(error){
                  $scope.error = error;
      });







/*
      if($scope.acti_rol == true){
        // Pasando a Modo Developer

        $http.put('api/estado_pagina/' + 1).success(function(){
          $http.get('/api/estado_pagina').success(
            function(developers) {
                $scope.developers = developers.estado;  

                if ($scope.developers == 2) {
                    console.log('Developer');
                    $scope.acti_rol = true;
                } else {
                    console.log('Produccion');
                    $scope.acti_rol = false;
                }   
            }).error(function(error) {
                $scope.error = error;
            });
                }).error(function(error){
                  $scope.error = error;
                });
      }else{
        // Pasando a Modo Producción

        $http.put('api/estado_pagina/' + 1).success(function(){
          $http.get('/api/estado_pagina').success(
              function(developers) {
               $scope.developers = developers.estado;  

                if ($scope.developers == 2) {
                    console.log('Developer');
                    $scope.acti_rol = true;
                } else {
                    console.log('Produccion');
                    $scope.acti_rol = false;
                }                  
              }).error(function(error) {
                  $scope.error = error;
              });
          }).error(function(error){
           $scope.error = error;
        });

      };
*/
    };
    

});