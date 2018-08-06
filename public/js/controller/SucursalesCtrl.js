

//************************************Sucursales**********************************************//
wApp.controller('SucursalesCtrl',function($scope, $http,ApiSucursalNuevo, $timeout, $log,$uibModal){

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
   $scope.alertaEditadoProA=false;
   $scope.Total = 0;
   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.sucursal={};
     };
  $scope.deselec=function(){
    $scope.busfiltro='';
  }

     //Todos las sucursales
      $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

         //Todos los usuarios
      $http.get('/api/sucursales/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
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
                   $http.get('/api/sucursales/stockproducto/'+$scope.idpro).success(

                    function(stock) {
                              $scope.stock = stock.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });
            };

      //Envios
        $http.get('/api/envios').success(

          function(envios) {
                    $scope.envios = envios.datos;
        }).error(function(error) {
             $scope.error = error;
        });

      //Nueva Sucursal

      $scope.sucursal={};
      $scope.guardarSucursal = function(){
         // console.log($scope.usuario);

        ApiSucursalNuevo.save($scope.sucursal, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que la sucursal ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };

       //Eliminar Sucursal
      $scope.btn_eliminar = function(id){
        $scope.idsucursal= id;
        console.log($scope.idsucursal);

         $http.delete('api/sucursal/destroy/' +  $scope.idsucursal)
            .success(function (data, status, headers) {
               console.log('Sucursal '+$scope.idsucursal+' borrado correctamente.');
                   $http.get('/api/sucursales').success(

                        function(sucursales) {
                        $scope.sucursales = sucursales.datos;
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

       //Editar Sucursal
        $scope.btn_editar = function(sucursal) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeSucu= sucursal;
       };


      $scope.editarSucursal = function(){
                var data = {
                  codigo_esta: $scope.existeSucu.codigo_esta,
                  nombre: $scope.existeSucu.nombre,
                  ubicacion: $scope.existeSucu.ubicacion,
                  telefono: $scope.existeSucu.telefono,
                  codigo_sat: $scope.existeSucu.codigo_sat,
                  serie: $scope.existeSucu.serie,
                  resolucion: $scope.existeSucu.resolucion,
                  fresolucion: $scope.existeSucu.fresolucion, 

                  codigo_satnce: $scope.existeSucu.codigo_satnce,
                  serie_nce: $scope.existeSucu.serie_nce,
                  resolucion_nce: $scope.existeSucu.resolucion_nce,
                  fresolucion_nce: $scope.existeSucu.fresolucion_nce, 

                  codigo_satnde: $scope.existeSucu.codigo_satnde,
                  serie_nde: $scope.existeSucu.serie_nde,
                  resolucion_nde: $scope.existeSucu.resolucion_nde,
                  fresolucion_nde: $scope.existeSucu.fresolucion_nde, 

                  id_user: $scope.existeSucu.id_user,
                  id_user2: $scope.existeSucu.id_user2
                };
                 console.log(data);
                $http.put('api/sucursal/' +  $scope.existeSucu.id, data)
                .success(function (data, status, headers) {
                   console.log('Sucursal '+$scope.existeSucu.nombre+' modificada correctamente.');
                       $http.get('/api/sucursales').success(
                          function(sucursales) {
                                    $scope.sucursales = sucursales.datos;
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

    //Abrir Sucursal
    $scope.abrirsucursal= function(sucursal){
          $scope.mas_obj = !$scope.mas_obj;

           $scope.exisSucursal=sucursal;
           $scope.miid=sucursal.id;

             $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

           $scope.prosucursal={};

             $http.get('/api/prosucursales/'+$scope.miid).success(
                function(prosucursales) {
                          $scope.prosucursales = prosucursales.datos;
              }).error(function(error) {
                   $scope.error = error;
              });


             $scope.btn_editaraj = function(prosucursal) {
                $scope.existeProA= prosucursal;
                console.log($scope.existeProA);

                             $scope.ajustarStock = function(){
                var data = {
                  id_sucursal: $scope.existeProA.id_sucursal,
                  stock_actual: $scope.existeProA.stock,
                  justificacion: $scope.existeProA.justificacion
                };
                 console.log(data);
                $http.post('api/sucursal/ajuste/' +  $scope.existeProA.id_producto, data)
                .success(function (data, status, headers) {
                   console.log('Ajuste de producto '+$scope.existeProA.id_producto+' modificado correctamente.');
                        $timeout(function () { $scope.alertaEditadoProA = true; }, 1000);
                        $timeout(function () { $scope.alertaEditadoProA = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el producto.');
                });

                 };
             };
         
   };

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
              id_sucursal: $scope.envio.id_sucursal
            };

           $http.post('/api/envio/create', dataenvio)
            .success(function (data, status, headers) {
                console.log("Orden de envio creada correctamente");
                    $http.get('/api/envios').success(

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
              $http.get('/api/proenvios/'+$scope.miorden).success(
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
                     $http.post('/api/proenvio/create', dataproenvio)
                        .success(function (data, status, headers) {
                               $http.get('/api/proenvios/'+$scope.miorden).success(
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


                //Agregar producto
             //Editar Productos Envio
            

             //Editar Productos Envio
             $scope.btn_editarl = function(proenvio) {
                $scope.existePro= proenvio;
             };
              $scope.btn_proeditar = function(id){
                 var dataproenvio = {
                        cantidad: $scope.existePro.cantidad,
                        id_producto: $scope.existePro.id_producto
                    };

                $http.put('api/proenvio/' +  $scope.existePro.id,dataproenvio)
                    .success(function (data, status, headers) {
                       console.log('Producto de Envio '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/proenvios/'+$scope.miorden).success(

                                  function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                   $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadol = false; }, 5000);

                                   //Envios
                                  $http.get('/api/envios').success(

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

                     $http.delete('api/proenvio/destroy/' +  $scope.idpro)
                      .success(function (data, status, headers) {
                           console.log('Producto de envio #'+$scope.idpro+' borrado correctamente.');
                               $http.get('/api/proenvios/'+$scope.miorden).success(

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
                     $http.post('api/envio/p1/' +  $scope.miorden)
                      .success(function (data, status, headers) {
                           console.log('Orden enviada a Sucursal #'+$scope.miorden);
                               $http.get('api/envios/').success(

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
               $scope.completarEnvio=function(){
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
               }; 


   };//Termina abrirorden

});




//************************************Mi Sucursal**********************************************//
wApp.controller('MiSucursalCtrl',function($scope, $http, $timeout, $log,$uibModal){

    $scope.abmas_obj = false;
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

            $http.get('api/mi/misenvios/'+$scope.misucu).success(

              function(misenvios) {
                        $scope.misenvios = misenvios.datos;
                       //console.log($scope.misenvios);
            }).error(function(error) {
                 $scope.error = error;
            });

        //Abrir Envios
        $scope.abrirorden= function(envio){

               $scope.abmas_obj = !$scope.abmas_obj;


                 $scope.btn_cerrarab=function(){
                     $scope.abmas_obj = false;
                };

                 $scope.exisEnvio=envio;
                    //console.log($scope.exisEnvio);
                 $scope.miorden=envio.id;

              //Productos
              $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                    function(proenvios) {
                              $scope.proenvios = proenvios.datos;
                              //console.log($scope.proenvios);
                  }).error(function(error) {
                       $scope.error = error;
                  });

              //Enviar Producto a bodega

              $scope.proenvio={};
              $scope.agregarProBodega=function(proenvio){
                $scope.proenvio=proenvio;
                  var envpro={
                      id_sucursal: $scope.misucu,
                      id_orden:$scope.proenvio.id_orden,
                      id_producto:$scope.proenvio.id_producto,
                      cantidad: $scope.proenvio.cantidad,
                      id_proenvio: $scope.proenvio.id
                  };
                  console.log(envpro);
                   $http.post('/api/mi/proenvio/envioproducto', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };//Fin agregarprobodega

               $scope.agregarProBodegaPen=function(proenvio){
                $scope.proenvio=proenvio;
                  var envpro={
                      id_sucursal: $scope.misucu,
                      id_orden:$scope.proenvio.id_orden,
                      id_producto:$scope.proenvio.id_producto,
                      cantidad: $scope.proenvio.cantidad,
                      id_proenvio: $scope.proenvio.id
                  };
                  //console.log(envpro);
                   $http.post('/api/mi/proenvio/envioproductopen', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };//Fin agregarprobodegaPen

              //Finalizar Envio
               $scope.completarEnvio=function(){
                     $http.put('/api/mi/envio/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Envio No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('/api/mi/misenvios/'+$scope.misucu).success(

                                      function(misenvios) {
                                                $scope.misenvios = misenvios.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.abmas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });
               }; 

                 //Eliminar Productos Envio restando el total en la Orden
                $scope.btn_proeliminar2 = function(id){
                  $scope.idproenvio= id;
                   $http.delete('api/mi/proenvio/destroy/' +  $scope.idproenvio)
                      .success(function (data, status, headers) {
                         console.log('Producto de Envio '+$scope.idproenvio+' borrado correctamente.');

                              $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
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

          };   


       };      


});
