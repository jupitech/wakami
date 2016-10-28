
//************************************Compras**********************************************//
wApp.controller('ComprasCtrl',function($scope, $http,ApiCompraNuevo, $timeout, $log,$uibModal,moment){

   $scope.status = {
    isopen: false
  };

  $scope.mifecha={};


  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };


     $scope.Fecha = new Date();
    //Fecha y Hora actual
                  $scope.clock = "..."; // initialise the time variable
                  $scope.tickInterval = 1000; //ms

                  var tick = function() {
                      $scope.clock = Date.now(); // get the current time
                      $timeout(tick, $scope.tickInterval); // reset the timer
                  };
                  $timeout(tick, $scope.tickInterval);

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
       $scope.compra={};
     };


     //Todos los proveedores
      $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

       //Todas las compras
      $http.get('/api/compras').success(

              function(compras) {
                        $scope.compras = compras.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      $scope.estimadas=[
         {'id': '10','nombre': '10 dias'},
         {'id': '15','nombre': '15 dias'},
         {'id': '30','nombre': '30 dias'},
         {'id': '60','nombre': '60 dias'}
      ];
      //Nueva Compra

      $scope.compra={};

      $scope.hoy = moment();
      $scope.mes = moment();
      $scope.hmes = $scope.mes.subtract(30, 'days');
       //Fecha Hoy
       $scope.mifecha.compra=$scope.hoy._d;

      $scope.guardarCompra = function(){
           $scope.nuevo_obj = false;

           $scope.procompra={};

           var datacompra = {
              id_proveedor: $scope.compra.id_proveedor,
              fecha_entrega: $scope.mifecha.compra,
              nfactura: $scope.compra.nfactura,
              fecha_factura: $scope.compra.fecha_factura
            };

            console.log(datacompra);

         $http.post('/api/compra/create', datacompra)
            .success(function (data, status, headers) {
                  $scope.midata=data.id_user;
                   console.log($scope.midata);
                    $http.get('/api/compras').success(

                        function(compras) {
                                  $scope.compras = compras.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
                  $timeout(function () { $scope.alertaNuevo = true; }, 1000);
                   $timeout(function () { $scope.alertaNuevo = false; }, 5000);
               })
            .error(function (data, status, header, config) {
                console.log("Parece que el producto ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });




      };

      $scope.abrircompra= function(com,de){
          $scope.mas_obj = !$scope.mas_obj;

          $scope.de=de;
             $scope.exisCompra=com;
             $scope.miorden=com.id;


          $scope.ProTotal = 0;
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

         $http.get('/api/procompras/'+$scope.miorden).success(

            function(procompras) {
                      $scope.procompras = procompras.datos;
          }).error(function(error) {
               $scope.error = error;
              });

          //Agregar producto
           $scope.procompra={};
            $scope.guardarProCompra = function(){

                    var dataprocompra={
                          id_orden:  $scope.miorden,
                          id_producto: $scope.procompra.id_producto,
                          cantidad: $scope.procompra.cantidad,
                    };
                     $http.post('/api/procompra/create', dataprocompra)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };

             //Editar Productos Compra
             $scope.btn_editarl = function(procompra) {
                $scope.existePro= procompra;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad,
                  id_producto: $scope.existePro.id_producto
                };
               // console.log(data);
                $http.put('api/procompra/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
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

           //Eliminar Productos Compra
              $scope.btn_proeliminar = function(id){
                $scope.idprocompra= id;
                 $http.delete('api/procompra/destroy/' +  $scope.idprocompra)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.idprocompra+' borrado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
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

             //Eliminar Productos Compra restando el total en la Orden
              $scope.btn_proeliminar2 = function(id){
                $scope.idprocompra= id;
                 $http.delete('api/procompra/destroy2/' +  $scope.idprocompra)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.idprocompra+' borrado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
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
              $scope.enviarCompra=function(){
                     $http.post('api/compra/p1/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' modificada correctamente en el paso 1.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

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

               //Enviar productos pendientes
              $scope.pendienteCompra=function(){
                     $http.post('api/compra/pen/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' modificada correctamente en el paso 1.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

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

              //Enviar Producto a bodega

                $scope.procompra={};
              $scope.agregarProBodega=function(procompra){
                $scope.procompra=procompra;
                  var envpro={
                      id_orden:$scope.procompra.id_orden,
                      id_producto:$scope.procompra.id_producto,
                      cantidad: $scope.procompra.cantidad,
                      id_procompra: $scope.procompra.id
                  };
                  console.log(envpro);
                   $http.post('/api/procompra/envioproducto', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                                 console.log('Producto enviado a bodega central.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };

                 $scope.propcompra={};
              $scope.agregarProBodegaPen=function(propcompra){
                $scope.propcompra=propcompra;
                  var envpro={
                      id_orden:$scope.propcompra.id_orden,
                      id_producto:$scope.propcompra.id_producto,
                      cantidad: $scope.propcompra.pendiente_producto.cantidad,
                      id_procompra: $scope.propcompra.id
                  };
                  console.log(envpro);
                  $http.post('/api/procompra/envioproductopen', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                                 console.log('Producto enviado a bodega central.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };



              //Finalizar Compra
               $scope.finalizarCompra=function(){
                     $http.put('api/compra/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.mas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });

              };


      };

       //Eliminar Compra
      $scope.btn_eliminar = function(id){
        $scope.idcompra= id;
         $http.delete('api/compra/destroy/' +  $scope.idcompra)
            .success(function (data, status, headers) {
               console.log('Compra No.'+$scope.idcompra+' borrado correctamente.');
                   $http.get('/api/compras').success(

                        function(compras) {
                        $scope.compras = compras.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la compra.');
            });
      };



       //Editar Compra
        $scope.existeCompra={};
        $scope.btn_editar = function(compra) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeCompra= compra;
         /* console.log($scope.existeCompra);*/


          $scope.Mdate = function ($fecha) {
            return new Date($fecha);
          };
          $scope.Fdate = function ($fecha) {
            return new Date($fecha);
          };

       };

      $scope.editarCompra = function(){

                var data = {
                  id_proveedor: $scope.existeCompra.id_proveedor,
                  fecha_entrega: $scope.existeCompra.fentre,
                  nfactura: $scope.existeCompra.nfactura,
                  fecha_factura: $scope.existeCompra.ffac
                };
              //   console.log(data);
                $http.put('api/compra/' +  $scope.existeCompra.id, data)
                .success(function (data, status, headers) {
                   console.log('Compra #'+$scope.existeCompra.id+' modificado correctamente.');
                       $http.get('/api/compras').success(
                          function(compras) {
                                    $scope.compras = compras.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la compra.');
                });

        };


});