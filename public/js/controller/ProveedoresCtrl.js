

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
