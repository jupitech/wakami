

//************************************Consignacion**********************************************//
wApp.controller('ConsignacionCtrl',function($scope, $http,ApiConsignacionNuevo, $timeout, $log,$uibModal,$location,$window){

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
   $scope.nuevafac_obj = false;
   $scope.editar_obj = false;
   $scope.mas_obj= false;
    $scope.ven_obj= false;
  $scope.abmas_obj= false;
   $scope.opcion_obj= false;
   $scope.ver_eli = false;
   $scope.alertaNuevo = false;
   $scope.alertaExiste = false;
   $scope.alertaEliminado = false;
   $scope.alertaEliminadopro = false;
   $scope.alertaEditado = false;
   $scope.loading = false;
    $scope.termi_venta=false;

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
      $http.get('/api/clientesconsignacion').success(

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
         $scope.loading = true;
         $timeout(function() { 
            $scope.loading = false;
          }, 3000);
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

    //Abrir Consignacion
    $scope.abrirventascon= function(consignacion){
          $scope.ven_obj = !$scope.ven_obj;

           $scope.exisConsignacion=consignacion;
           $scope.miid=consignacion.id;

             $scope.btn_cerrarv=function(){
             $scope.ven_obj = false;
           };

           $scope.proconsignacion={};

             $http.get('/api/consignacion/ventas/'+$scope.miid).success(
                function(ventas) {
                          $scope.ventas = ventas.datos;
              }).error(function(error) {
                   $scope.error = error;
              });

                //PDF Ventas
      $scope.btn_pdf = function(id){
        $scope.idventa= id;
         console.log("Creando PDF para factura")
         $window.location.href = '/api/consignacion/pdfventa/'+ $scope.idventa;
      };   

      

 
            
   };

    //PDF Ventas
      $scope.btn_pdfenvio = function(id){
        $scope.idenvio= id;
         console.log("Creando PDF para orden de envio")
         $window.location.href = '/api/consignacion/pdfenvio/'+ $scope.idenvio;
      };   

   //Factura para clientes en consignación
   $scope.miconsigna={};
      $scope.nuevafactura=function(consignacion){

              $scope.mas_obj = false;
              $scope.nuevafac_obj = true;
              $scope.active_crear=true;
              $scope.active_venta=false;

              $scope.btn_cerrarf=function(){
                   $scope.nuevafac_obj = false;
              };


               $scope.tpagos=[
                    {id:'1',pago:'Efectivo'},
                    {id:'2',pago:'POS/Tarjeta'},
                    {id:'3',pago:'Cheque'},
                    {id:'4',pago:'Crédito'},
                    {id:'5',pago:'Depósito'},
              ];

                 $scope.diascre=[
                    {dias:'15',nombre:'15 dias'},
                    {dias:'30',nombre:'30 dias'},
               ];


             $scope.miconsigna=consignacion;
             $scope.miid=$scope.miconsigna.id;  
             console.log($scope.miconsigna); 

           $scope.crearventa=function(idcliente){
            $scope.idcliente=idcliente;
                   $scope.active_crear=false;

               $http.post('api/consignacion/nuevaventa/' + $scope.idcliente)
                .success(function (data, status, headers) {
                   console.log('Venta de cliente #'+$scope.idcliente+' creada correctamente.');
                       $scope.idventa=data.id_venta;
                       console.log('ID Venta: ',$scope.idventa)
                        $scope.agregarProductos($scope.idventa);
                       $scope.active_crear=false;
                         $scope.active_venta=true;
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al guardar la venta.');
                });

           }

            $http.get('/api/proconsignacionas/'+$scope.miid).success(
              function(proconsignaciones) {
                        $scope.proconsignaciones = proconsignaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

               //Sucursal
          $http.get('/api/misucursal/'+ 3).success(

              function(misucursal) {
                        $scope.misucursal = misucursal.datos;
            }).error(function(error) {
                 $scope.error = error;
            });    

      //Agregar Productos
     $scope.agregarProductos=function(idventa){
        $scope.idventa=idventa;
        console.log('ID Venta: ',$scope.idventa);

               //Mi Venta
                $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });

                 //Mi Descuento
                $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                        function(mides) {
                                  $scope.mides = mides.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });      

              //Aplicar descuento           
              $scope.aplides= function(id_cliente){
                  var datapor={
                           id_ventas:$scope.idventa,
                           id_cliente: id_cliente
                      };
                      // console.log(datapor);
                  $http.post('/api/consignaciondes/create', datapor)
                        .success(function (data, status, headers) {
                              console.log("Descuento agregado correctamente");
                                  //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                          //Mis Productos
                                  $http.get('/api/consignacion/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });
              
                           });    
              };

              //Eliminar descuento           
              $scope.deldes= function(){
                      // console.log(datapor);
                  $http.delete('/api/consignaciondescuento/destroy/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Descuento eliminado correctamente");
                                  //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                         //Mis Productos
                                  $http.get('/api/consignacion/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });        
                           });    
              };

              $scope.proventa={};
              $scope.guardarProVenta=function(){
                      var datapro={
                           id_ventas:  $scope.idventa,
                           id_producto: $scope.proventa.id_producto,
                           cantidad:1,
                      };
                     // console.log(datapro);

                       $http.post('/api/consignacionproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/consignacion/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                    //Mi Descuento
                                  $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });        

                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar el producto");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });


              };

              //Editar Producto Venta
             $scope.btn_editarl = function(mipro) {
                $scope.existePro= mipro;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad
                };
                //console.log(data);
                $http.put('api/consignacionproventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/consignacion/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });


      
                                  //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                   //Mi Descuento
                                  $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });       

                               $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                               $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };


               //Eliminar Producto Venta
              $scope.btn_proeliminar = function(id){
                $scope.idproventa= id;
                //console.log($scope.idproventa);

                 $http.delete('api/consignacionproventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/consignacion/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                      function(mides) {
                                                $scope.mides = mides.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });              
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };
        };//Fin Agregar Producto

         $scope.factura={};
      $scope.btn_facturar=function(){

          $scope.loading = true;
          $timeout(function() { 
            $scope.loading = false;
          }, 3000);
            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_ventas: $scope.idventa,
                id_consignacion: $scope.idconsignacion,
                dias_credito: $scope.factura.dias_credito,
            };
            //console.log(datafact);

              $http.post('/api/consignacion/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                               $scope.active_venta=false;
                               $scope.termi_venta=true;
                               //  $window.location.href = '/ventas';

                                      //Mi Venta
                                  $http.get('/api/consignacion/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/consignacion/midescuento/'+$scope.idventa).success(

                                      function(mides) {
                                                $scope.mides = mides.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });     
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al enviar la factura");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });
      };


      $scope.iraventas=function(){
            $window.location.href = '/ventas';
      }


             

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
