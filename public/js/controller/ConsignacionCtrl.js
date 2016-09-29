

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
       $scope.consignacion={};
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
          $http.get('/api/productosas').success(

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

             $http.get('/api/proconsignacion/'+$scope.miid).success(
                function(proconsignaciones) {
                          $scope.proconsignaciones = proconsignaciones.datos;
              }).error(function(error) {
                   $scope.error = error;
              });
   };


   
      //Envios
        $http.get('/api/enviosconsignaciones').success(

          function(envios) {
                    $scope.envios = envios.datos;
        }).error(function(error) {
             $scope.error = error;
        });



       //Nuevo Envio
    $scope.btn_envio= function(){
          $scope.opcion_obj = !$scope.opcion_obj;


             $scope.btn_cerraro=function(){
             $scope.opcion_obj = false;
           };


   };


      //Nuevo Envio
      $scope.envio={};
      $scope.guardarEnvio = function(){
           $scope.opcion_obj = false;

           $scope.proenvio={};

           var dataenvio = {
              id_consignacion: $scope.envio.id_consignacion
            };

           $http.post('/api/envioconsignacion/create', dataenvio)
            .success(function (data, status, headers) {
                console.log("Orden de envio creada correctamente");
                    $http.get('/api/enviosconsignaciones').success(

                        function(envios) {
                                  $scope.envios = envios.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
                  $timeout(function () { $scope.alertaNuevo = true; }, 1000);
                   $timeout(function () { $scope.alertaNuevo = false; }, 5000);
               })
            .error(function (data, status, header, config) {
                console.log("Parece que el envio ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });
      };


    //Area de envios
    $scope.abrirorden= function(envio){
          $scope.abmas_obj = !$scope.abmas_obj;


             $scope.btn_cerrarab=function(){
                 $scope.abmas_obj = false;
            };

           $scope.exisEnvio=envio;
           $scope.miorden=envio.id;


            //Productos
              $http.get('/api/proenviosconsignacion/'+$scope.miorden).success(
                    function(proenvios) {
                              $scope.proenvios = proenvios.datos;
                             // console.log($scope.proenvios);
                  }).error(function(error) {
                       $scope.error = error;
                  });

           //Agregar producto
           $scope.proenvio={};
           $scope.guardarProEnvio = function(){

                    var dataproenvio={
                          id_orden:  $scope.miorden,
                          id_producto: $scope.proenvio.id_producto,
                          cantidad: $scope.proenvio.cantidad,
                    };
                     $http.post('/api/proenvioconsignacion/create', dataproenvio)
                        .success(function (data, status, headers) {
                               $http.get('/api/proenviosconsignacion/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                              //console.log($scope.proenvios);
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };

             //Editar Productos Envio
             $scope.btn_editarl = function(proenvio) {
                $scope.existePro= proenvio;
             };
              $scope.btn_proeditar = function(id){
                 var dataproenvio = {
                        cantidad: $scope.existePro.cantidad,
                        id_producto: $scope.existePro.id_producto
                    };

                $http.put('api/proenvioconsignacion/' +  $scope.existePro.id,dataproenvio)
                    .success(function (data, status, headers) {
                       console.log('Producto de Envio '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/proenviosconsignacion/'+$scope.miorden).success(

                                  function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                   $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadol = false; }, 5000);

                                   //Envios
                                  $http.get('/api/enviosconsignaciones').success(

                                    function(envios) {
                                              $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                          })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar el envio.');
                      });

              };

               //Eliminar Producto de envios
              $scope.btn_proeliminar = function(id){
                    $scope.idpro= id;
                    //console.log($scope.idpro);

                     $http.delete('api/proenvioconsignacion/destroy/' +  $scope.idpro)
                      .success(function (data, status, headers) {
                           console.log('Producto de envio #'+$scope.idpro+' borrado correctamente.');
                               $http.get('/api/proenviosconsignacion/'+$scope.miorden).success(

                                 function(proenvios) {
                                         $scope.proenvios = proenvios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                      })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar la sucursal.');
                      });
              };

              //Enviar orden a sucursal
              $scope.enviarEnvio= function(){
                     $http.post('api/envioconsignacion/p1/' +  $scope.miorden)
                      .success(function (data, status, headers) {
                           console.log('Orden enviada a Bodega de Consignacion #'+$scope.miorden);
                               $http.get('api/enviosconsignaciones/').success(

                                 function(envios) {
                                         $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                  $scope.abmas_obj = false;
                      })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar la sucursal.');
                      });
              };

               //Finalizar Envio
             /*  $scope.completarEnvio=function(){
                     $http.put('/api/envio/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Envio No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('api/envios/').success(

                                 function(envios) {
                                         $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                   $scope.abmas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });
               }; */


   };//Termina abrirorden



});
