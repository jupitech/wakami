//************************************Traslados**********************************************//
wApp.controller('TrasladosCtrl',function($scope, $http, $timeout, $log,$uibModal){
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
       $scope.traslado={};
     };
 

    //MiUsuario
      $http.get('api/mi/miusuario').success(

              function(miusuario) {
                        $scope.miusuario = miusuario.datos;
                        $scope.idusuario=$scope.miusuario.sucursal_usuario;
                        $scope.idusuario2=$scope.miusuario.sucursal_usuario2;

                        if($scope.idusuario!=null){
                          $scope.actsucu($scope.miusuario.sucursal_usuario.id);
                        } else{
                           $scope.actsucu($scope.miusuario.sucursal_usuario2.id);
                        }
                        
            }).error(function(error) {
                 $scope.error = error;
            });


   $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu; 


           //Productos
          $http.get('/api/mi/productosas/'+ $scope.misucu).success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

               //Sucursal
          $http.get('/api/mi/misucursal/'+ $scope.misucu).success(

              function(misucursal) {
                        $scope.misucursal = misucursal.datos;
            }).error(function(error) {
                 $scope.error = error;
            });   


          //Sucursales
          $http.get('/api/mi/traslados/sucursales/'+ $scope.misucu).success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            }); 

              //Traslados enviados
          $http.get('/api/mi/trasladosen/'+ $scope.misucu).success(

              function(trasladosen) {
                        $scope.trasladosen = trasladosen.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

              //Traslados recibidos
          $http.get('/api/mi/trasladosre/'+ $scope.misucu).success(

              function(trasladosre) {
                        $scope.trasladosre = trasladosre.datos;
            }).error(function(error) {
                 $scope.error = error;
            });   
  


      //Nuevo traslado

      $scope.traslado={};
      $scope.enviarTraslado = function(){
         // 

          var datatraslado = {
              desde_sucursal: $scope.misucu,
              a_sucursal: $scope.traslado.a_sucursal,
              id_producto: $scope.traslado.id_producto,
              cantidad: $scope.traslado.cantidad,
            };

            console.log(datatraslado);

        $http.post('/api/mi/traslados/create', datatraslado)
          .success(function (data, status, headers) {
           console.log("Traslado Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/mi/traslados').success(

              function(traslados) {
                        $scope.traslados = traslados.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
           })
            .error(function (data, status, header, config) {
                console.log("Parece que el cliente ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });

        };  



   };

});