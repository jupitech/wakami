//************************************Donaciones**********************************************//
wApp.controller('DonacionesCtrl',function($scope, $http, $timeout, $log,$uibModal,$location,$window){

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
     $scope.mas_obj= false;
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.donacion={};
     };

     
      //Donaciones
          $http.get('/api/donaciones/').success(

              function(donaciones) {
                        $scope.donaciones = donaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


    //Nueva devolucion
      $scope.donacion={};
      $scope.crearDonacion = function(){

            var data= {
              para: $scope.donacion.para,
              descripcion: $scope.donacion.descripcion,
            };

        $http.post('/api/donacion/create', data)
          .success(function (data, status, headers) {
           console.log("donacion Guardada correctamente");
           $scope.nuevo_obj = false;
             //Devoluciones
          $http.get('/api/donaciones/').success(

              function(donaciones) {
                        $scope.donaciones = donaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

  
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
           })
            .error(function (data, status, header, config) {
                console.log("Parece que la donacion ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });

        };  

      //Eliminar Donacion
      $scope.btn_eliminar = function(id){
        $scope.iddonacion= id;

         $http.delete('api/donacion/destroy/' +  $scope.iddonacion)
            .success(function (data, status, headers) {
               console.log('Donacion '+$scope.iddonacion+' borrado correctamente.');
                                   //Devoluciones
                        $http.get('/api/donaciones/').success(

                            function(donaciones) {
                                      $scope.donaciones = donaciones.datos;
                          }).error(function(error) {
                               $scope.error = error;
                          });

                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la donacion.');
            });
      };


        //PDF Ventas
      $scope.btn_pdfenvio = function(id){
        $scope.idenvio= id;
         console.log("Creando PDF para orden de envio")
         $window.location.href = '/api/donacion/pdfenvio/'+ $scope.idenvio;
      };   


 //Area de devolución
  $scope.abrirdonacion= function(com){
          $scope.mas_obj = !$scope.mas_obj;
          
            $scope.exisDonacion=com;
             $scope.midonacion=com.id;

            $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

       
                  //Productos
              $http.get('/api/productos').success(

                  function(productos) {
                            $scope.productos = productos.datos;
                }).error(function(error) {
                     $scope.error = error;
                });

            
            //Productos en devoluciones
              $http.get('/api/prodonacion/'+$scope.midonacion).success(
                                    function(prodonacion) {
                                              $scope.prodonacion = prodonacion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });


        //Agregar producto
           $scope.prodonacion={};
            $scope.guardarProDonacion = function(){

                    var data={
                          id_donacion:  $scope.midonacion,
                          id_producto: $scope.prodonacion.id_producto,
                          cantidad: $scope.prodonacion.cantidad,
                    };
                     $http.post('/api/prodonacion/create', data)
                        .success(function (data, status, headers) {
                               $http.get('/api/prodonacion/'+$scope.midonacion).success(
                                    function(prodonacion) {
                                              $scope.prodonacion = prodonacion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.prodonacion={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };  

         //Editar Productos Devolucion
             $scope.btn_editarl = function(prodonacion) {
                $scope.existePro= prodonacion;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad,
                  id_producto: $scope.existePro.id_producto
                };
               // console.log(data);
                $http.put('api/prodonacion/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto de donacion '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/prodonacion/'+$scope.midonacion).success(

                                    function(prodonacion) {
                                              $scope.prodonacion = prodonacion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });


                               $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                               $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar la compra.');
                    });
              };

           //Eliminar Productos Devolución
              $scope.btn_proeliminar = function(id){
                $scope.idprodonacion= id;
                 $http.delete('api/prodonacion/destroy/' +  $scope.idprodonacion)
                    .success(function (data, status, headers) {
                       console.log('Producto de Donacion #'+$scope.idprodonacion+' borrado correctamente.');
                                 $http.get('/api/prodonacion/'+$scope.midonacion).success(

                                    function(prodonacion) {
                                              $scope.prodonacion = prodonacion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });

                            $timeout(function () { $scope.alertaEliminadoPro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadoPro = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar la compra.');
                    });
              };


               //Enviar Paso 1
              $scope.enviarDonacion=function(){
                     $http.put('api/donacion/p1/' + $scope.midonacion)
                        .success(function (data, status, headers) {
                           console.log('Donacion No.'+$scope.midonacion+' modificada correctamente en el paso 1.');
                               $http.get('/api/donaciones').success(

                                      function(donaciones) {
                                                $scope.donaciones = donaciones.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.mas_obj = false;

                                 /*  $timeout(function () { $scope.alertaEditadop1 = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadop1 = false; }, 5000);*/
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });

              };
        

  };       
  

});

