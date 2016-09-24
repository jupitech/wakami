

//************************************Consignacion**********************************************//
wApp.controller('ConsignacionCtrl',function($scope, $http,ApiConsignacionNuevo, $timeout, $log,$uibModal){

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
   $scope.mas_obj= false;
     $scope.abmas_obj= false;
   $scope.opcion_obj= false;
   $scope.ver_eli = false;
   $scope.alertaNuevo = false;
   $scope.alertaExiste = false;
   $scope.alertaEliminado = false;
   $scope.alertaEliminadopro = false;
   $scope.alertaEditado = false;

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.sucursal={};
     };
  $scope.deselec=function(){
    $scope.busfiltro='';
  }

     //Todos las consignaciones
      $http.get('/api/consignaciones').success(

              function(consignaciones) {
                        $scope.consignaciones = consignaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
    

     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


     //Productos
          $http.get('/api/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

            $scope.elstock=function(id){
              $scope.idpro=id;
                   $http.get('/api/consignacion/stockproducto/'+$scope.idpro).success(

                    function(stock) {
                              $scope.stock = stock.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });
            };

     
      //Nueva Consignacion

      $scope.consignacion={};
      $scope.guardarConsignacion = function(){
         // console.log($scope.usuario);

        ApiConsignacionNuevo.save($scope.consignacion, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/consignaciones').success(

              function(consignaciones) {
                        $scope.consignaciones = consignaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que la consignacion ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };

       //Eliminar Consignacion
      $scope.btn_eliminar = function(id){
        $scope.idconsignacion= id;
        console.log($scope.idconsignacion);

         $http.delete('api/consignacion/destroy/' +  $scope.idconsignacion)
            .success(function (data, status, headers) {
               console.log('Consignacion '+$scope.idconsignacion+' borrado correctamente.');
                   $http.get('/api/consignaciones').success(

                        function(consignaciones) {
                        $scope.consignaciones = consignaciones.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la sucursal.');
            });
      };


    //Abrir Consignacion
    $scope.abrirconsignacion= function(consignacion){
          $scope.mas_obj = !$scope.mas_obj;

           $scope.exisConsignacion=consignacion;
           $scope.miid=consignacion.id;

             $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

           $scope.proconsignacion={};

             $http.get('/api/proconsignaciones/'+$scope.miid).success(
                function(proconsignaciones) {
                          $scope.proconsignaciones = proconsignaciones.datos;
              }).error(function(error) {
                   $scope.error = error;
              });
   };


});
