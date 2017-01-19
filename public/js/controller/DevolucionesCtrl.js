//************************************Devoluciones**********************************************//
wApp.controller('DevolucionesCtrl',function($scope, $http, $timeout, $log,$uibModal,$location,$window){

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
       $scope.devolucion={};
     };

     //Desde
    
     $scope.desde=[
            {id:'3',nombre:'Central'},
            {id:'104',nombre:'Consignación'},
     ];

      //Todos las consignaciones
      $http.get('/api/consignaciones').success(

              function(consignaciones) {
                        $scope.consignaciones = consignaciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
 
    //Bodegas
    
     $scope.bodegas=[
           {id:'3',nombre:'Central'},
            {id:'105',nombre:'Defectuoso'},
     ]; 

      //Devoluciones
          $http.get('/api/devoluciones/').success(

              function(devoluciones) {
                        $scope.devoluciones = devoluciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


    //Nueva devolucion
      $scope.devolucion={};
      $scope.crearDevolucion = function(){

        if($scope.devolucion.desde==104){
          var datadevolucion = {
              desde: $scope.devolucion.desde,
              hacia: $scope.devolucion.hacia,
              descripcion: $scope.devolucion.descripcion,
              consignacion: $scope.devolucion.consignacion
            };
        }else{
            var datadevolucion = {
              desde: $scope.devolucion.desde,
              hacia: $scope.devolucion.hacia,
              descripcion: $scope.devolucion.descripcion,
            };
        }

        $http.post('/api/devolucion/create', datadevolucion)
          .success(function (data, status, headers) {
           console.log("Devolución Guardada correctamente");
           $scope.nuevo_obj = false;
             //Devoluciones
          $http.get('/api/devoluciones/').success(

              function(devoluciones) {
                        $scope.devoluciones = devoluciones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

  
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
           })
            .error(function (data, status, header, config) {
                console.log("Parece que la devolución ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });

        };  

      //Eliminar Devolución
      $scope.btn_eliminar = function(id){
        $scope.iddevolucion= id;

         $http.delete('api/devolucion/destroy/' +  $scope.iddevolucion)
            .success(function (data, status, headers) {
               console.log('Devolución '+$scope.iddevolucion+' borrado correctamente.');
                                   //Devoluciones
                        $http.get('/api/devoluciones/').success(

                            function(devoluciones) {
                                      $scope.devoluciones = devoluciones.datos;
                          }).error(function(error) {
                               $scope.error = error;
                          });

                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la devolución.');
            });
      };


        //PDF Ventas
      $scope.btn_pdfenvio = function(id){
        $scope.idenvio= id;
         console.log("Creando PDF para orden de envio")
         $window.location.href = '/api/devolucion/pdfenvio/'+ $scope.idenvio;
      };   


 //Area de devolución
  $scope.abrirdevolucion= function(com){
          $scope.mas_obj = !$scope.mas_obj;
          
            $scope.exisDevolucion=com;
             $scope.midevolucion=com.id;
             $scope.desdesucu=com.desde_sucursal;
              $scope.desdecon=com.desde_consignacion;

            $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

           if($scope.desdesucu!=104){

                  //Productos
              $http.get('/api/productos').success(

                  function(productos) {
                            $scope.productos = productos.datos;
                }).error(function(error) {
                     $scope.error = error;
                });


           } else{
                       //Productos
              $http.get('/api/devoluciones/consignacion/'+$scope.desdecon).success(

                  function(productos) {
                            $scope.productos = productos.datos;
                }).error(function(error) {
                     $scope.error = error;
                });

           }
            
            //Productos en devoluciones
              $http.get('/api/prodevolucion/'+$scope.midevolucion).success(
                                    function(prodevolucion) {
                                              $scope.prodevolucion = prodevolucion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });


        //Agregar producto
           $scope.prodevolucion={};
            $scope.guardarProDevolucion = function(){

                    var dataprodevolucion={
                          id_devolucion:  $scope.midevolucion,
                          id_producto: $scope.prodevolucion.id_producto,
                          cantidad: $scope.prodevolucion.cantidad,
                    };
                     $http.post('/api/prodevolucion/create', dataprodevolucion)
                        .success(function (data, status, headers) {
                               $http.get('/api/prodevolucion/'+$scope.midevolucion).success(
                                    function(prodevolucion) {
                                              $scope.prodevolucion = prodevolucion.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.prodevolucion={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };  

         //Editar Productos Devolucion
             $scope.btn_editarl = function(prodevolucion) {
                $scope.existePro= prodevolucion;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad,
                  id_producto: $scope.existePro.id_producto
                };
               // console.log(data);
                $http.put('api/prodevolucion/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto de devolución '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/prodevolucion/'+$scope.midevolucion).success(

                                    function(prodevolucion) {
                                              $scope.prodevolucion = prodevolucion.datos;
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
                $scope.idprodevolucion= id;
                 $http.delete('api/prodevolucion/destroy/' +  $scope.idprodevolucion)
                    .success(function (data, status, headers) {
                       console.log('Producto de Devolución #'+$scope.idprodevolucion+' borrado correctamente.');
                                 $http.get('/api/prodevolucion/'+$scope.midevolucion).success(

                                    function(prodevolucion) {
                                              $scope.prodevolucion = prodevolucion.datos;
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
              $scope.enviarDevolucion=function(){
                     $http.put('api/devolucion/p1/' + $scope.midevolucion)
                        .success(function (data, status, headers) {
                           console.log('Devolución No.'+$scope.midevolucion+' modificada correctamente en el paso 1.');
                               $http.get('/api/devoluciones').success(

                                      function(devoluciones) {
                                                $scope.devoluciones = devoluciones.datos;

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


/********************************Mis Devoluciones************************************************/

wApp.controller('MisDevolucionesCtrl',function($scope, $http, $timeout, $log,$uibModal,$location,$window){

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



         $scope.btn_nuevo = function() {
              $scope.nuevo_obj = !$scope.nuevo_obj;
             $scope.devolucion={};
           };


  $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu;   
     


           
       
          //Bodegas
          
           $scope.bodegas=[
                 {id:'3',nombre:'Central'},
           ]; 

            //Devoluciones
                $http.get('/api/mi/devoluciones/'+$scope.misucu).success(

                    function(devoluciones) {
                              $scope.devoluciones = devoluciones.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });


          //Nueva devolucion
            $scope.devolucion={};
            $scope.crearDevolucion = function(){

            
                  var datadevolucion = {
                    desde:   $scope.misucu,
                    hacia: $scope.devolucion.hacia,
                    descripcion: $scope.devolucion.descripcion,
                  };
              

              $http.post('/api/mi/devolucion/create', datadevolucion)
                .success(function (data, status, headers) {
                 console.log("Devolución Guardada correctamente");
                 $scope.nuevo_obj = false;
                   //Devoluciones
                $http.get('/api/mi/devoluciones/'+$scope.misucu).success(

                    function(devoluciones) {
                              $scope.devoluciones = devoluciones.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });

        
                  $timeout(function () { $scope.alertaNuevo = true; }, 1000);
                  $timeout(function () { $scope.alertaNuevo = false; }, 5000);
                 })
                  .error(function (data, status, header, config) {
                      console.log("Parece que la devolución ya existe");
                      $timeout(function () { $scope.alertaExiste = true; }, 100);
                      $timeout(function () { $scope.alertaExiste = false; }, 5000);
                  });

              };  

            //Eliminar Devolución
            $scope.btn_eliminar = function(id){
              $scope.iddevolucion= id;

               $http.delete('api/mi/devolucion/destroy/' +  $scope.iddevolucion)
                  .success(function (data, status, headers) {
                     console.log('Devolución '+$scope.iddevolucion+' borrado correctamente.');
                                         //Devoluciones
                              $http.get('/api/mi/devoluciones/'+$scope.misucu).success(

                                  function(devoluciones) {
                                            $scope.devoluciones = devoluciones.datos;
                                }).error(function(error) {
                                     $scope.error = error;
                                });

                          $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                          $timeout(function () { $scope.alertaEliminado = false; }, 5000);
                  })
                  .error(function (data, status, header, config) {
                      console.log('Parece que existe un error al borrar la devolución.');
                  });
            };


              //PDF Ventas
            $scope.btn_pdfenvio = function(id){
              $scope.idenvio= id;
               console.log("Creando PDF para orden de envio")
               $window.location.href = '/api/mi/devolucion/pdfenvio/'+ $scope.idenvio;
            };   


       //Area de devolución
        $scope.abrirdevolucion= function(com){
                $scope.mas_obj = !$scope.mas_obj;
                
                  $scope.exisDevolucion=com;
                   $scope.midevolucion=com.id;
                   $scope.desdesucu=com.desde_sucursal;
                    $scope.desdecon=com.desde_consignacion;

                  $scope.btn_cerrarc=function(){
                   $scope.mas_obj = false;
                 };

         
                             //Productos
                    $http.get('/api/mi/devoluciones/sucursales/'+$scope.misucu).success(

                        function(productos) {
                                  $scope.productos = productos.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });

                 
                  
                  //Productos en devoluciones
                    $http.get('/api/mi/prodevolucion/'+$scope.midevolucion).success(
                                          function(prodevolucion) {
                                                    $scope.prodevolucion = prodevolucion.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });


              //Agregar producto
                 $scope.prodevolucion={};
                  $scope.guardarProDevolucion = function(){

                          var dataprodevolucion={
                                id_devolucion:  $scope.midevolucion,
                                id_producto: $scope.prodevolucion.id_producto,
                                cantidad: $scope.prodevolucion.cantidad,
                          };
                           $http.post('/api/mi/prodevolucion/create', dataprodevolucion)
                              .success(function (data, status, headers) {
                                     $http.get('/api/mi/prodevolucion/'+$scope.midevolucion).success(
                                          function(prodevolucion) {
                                                    $scope.prodevolucion = prodevolucion.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                          $scope.prodevolucion={};
                                 })
                              .error(function (data, status, header, config) {
                                  console.log("Parece que el producto ya existe");
                                  $timeout(function () { $scope.alertaExiste = true; }, 100);
                                  $timeout(function () { $scope.alertaExiste = false; }, 5000);
                              });
                   };  

               //Editar Productos Devolucion
                   $scope.btn_editarl = function(prodevolucion) {
                      $scope.existePro= prodevolucion;
                   };
                    $scope.btn_proeditar = function(id){
                       var data = {
                        cantidad: $scope.existePro.cantidad,
                        id_producto: $scope.existePro.id_producto
                      };
                     // console.log(data);
                      $http.put('api/mi/prodevolucion/' +  $scope.existePro.id,data)
                          .success(function (data, status, headers) {
                             console.log('Producto de devolución '+$scope.existePro.id+' editado correctamente.');

                                $http.get('/api/mi/prodevolucion/'+$scope.midevolucion).success(

                                          function(prodevolucion) {
                                                    $scope.prodevolucion = prodevolucion.datos;
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
                      $scope.idprodevolucion= id;
                       $http.delete('api/mi/prodevolucion/destroy/' +  $scope.idprodevolucion)
                          .success(function (data, status, headers) {
                             console.log('Producto de Devolución #'+$scope.idprodevolucion+' borrado correctamente.');
                                       $http.get('/api/mi/prodevolucion/'+$scope.midevolucion).success(

                                          function(prodevolucion) {
                                                    $scope.prodevolucion = prodevolucion.datos;
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
                    $scope.enviarDevolucion=function(){
                           $http.put('api/mi/devolucion/p1/' + $scope.midevolucion)
                              .success(function (data, status, headers) {
                                 console.log('Devolución No.'+$scope.midevolucion+' modificada correctamente en el paso 1.');
                                     $http.get('/api/mi/devoluciones/'+$scope.misucu).success(

                                            function(devoluciones) {
                                                      $scope.devoluciones = devoluciones.datos;

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
  
   }; //Fin Mi sucu

});
