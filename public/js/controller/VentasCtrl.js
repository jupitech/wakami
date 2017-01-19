

//************************************Clientes**********************************************//
wApp.controller('ClientesCtrl',function($scope, $http, $timeout, $log,$uibModal){

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
   $scope.activecentral=true;
   $scope.activesucursal=false;
    $scope.act_btn=1;

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.cliente={};
     };

     $scope.cliecentral = function() {
        $scope.activecentral=true;
        $scope.activesucursal=false;
       $scope.act_btn=1;
     };

     $scope.cliesucu = function() {
        $scope.activesucursal=true;
        $scope.activecentral=false;
       $scope.act_btn=2;
     };

       $scope.deselecli=function(){
          $scope.buslinea='';
          $scope.busprove='';
       }
  

   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Consignación'},
        {id:'3',cliente:'Contado'},
        {id:'4',cliente:'Crédito'},
        {id:'5',cliente:'Independiente'},
        ];

       $scope.tipos2=[
        {id:'2',cliente:'Consignación'},
        {id:'3',cliente:'Contado'},
        {id:'4',cliente:'Crédito'},
        {id:'5',cliente:'Independiente'},
        ];    


     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Nuevo Cliente

      $scope.cliente={};
      $scope.guardarCliente = function(){
         // console.log($scope.usuario);

          var datacliente = {
              empresa: $scope.cliente.empresa,
              nombre: $scope.cliente.nombre,
              nit: $scope.cliente.nit,
              direccion: $scope.cliente.direccion,
              telefono: $scope.cliente.telefono,
              celular: $scope.cliente.celular,
              email: $scope.cliente.email,
              tipo_cliente: $scope.cliente.tipo_cliente,
              contacto: $scope.cliente.contacto,
            };

        $http.post('/api/cliente/create', datacliente)
          .success(function (data, status, headers) {
           console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
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

       //Eliminar Cliente
      $scope.btn_eliminar = function(id){
        $scope.idcliente= id;
        console.log($scope.idcliente);

         $http.delete('/api/cliente/destroy/' +  $scope.idcliente)
            .success(function (data, status, headers) {
               console.log('Cliente '+$scope.idcliente+' borrado correctamente.');
                   $http.get('/api/clientes').success(

                        function(clientes) {
                        $scope.clientes = clientes.datos;
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

       //Editar Cliente
        $scope.btn_editar = function(cliente) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeCliente= cliente;
       };


      $scope.editarCliente = function(){
                var data = {
                  empresa: $scope.existeCliente.empresa,
                  nombre: $scope.existeCliente.nombre,
                  nit: $scope.existeCliente.nit,
                  direccion: $scope.existeCliente.direccion,
                  telefono: $scope.existeCliente.telefono,
                  celular: $scope.existeCliente.celular,
                  email: $scope.existeCliente.email,
                  contacto: $scope.existeCliente.contacto,
                  tipo_cliente: $scope.existeCliente.tipo_cliente
                };
                // console.log(data);
                $http.put('/api/cliente/' +  $scope.existeCliente.id, data)
                .success(function (data, status, headers) {
                   console.log('Cliente '+$scope.existeCliente.nombre+' modificado correctamente.');
                       $http.get('/api/clientes').success(
                          function(clientes) {
                                    $scope.clientes = clientes.datos;
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

        //Porcentaje
        $scope.btn_porcen=function(cliente){
          $scope.micliente=cliente;
           $scope.porcen={};
           $scope.exisPor={};
                //Asignar Porcentaje
                $scope.nuevo_porcen=function(){
                    var datapor={
                      id_cliente:$scope.micliente.id,
                      tipo_cliente:$scope.micliente.tipo_cliente,
                      porcentaje:$scope.porcen.cantidad,
                    }

                    console.log(datapor);

                     $http.post('/api/cliente/porcentaje', datapor)
                    .success(function (data, status, headers) {
                       console.log('Cliente #'+$scope.micliente.id+' agregado porcentaje correctamente.');
                           $http.get('/api/clientes').success(
                              function(clientes) {
                                        $scope.clientes = clientes.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al modificar el usuario.');
                    });
               };

               //Editar Porcentaje 
                $scope.editar_porcen=function(exisPor){
                   $scope.exisPor=exisPor;
                    var edipor={
                      porcentaje:$scope.exisPor.cantidad,
                    }

                    console.log(edipor);

                     $http.put('/api/cliente/porcentaje/'+$scope.micliente.id, edipor)
                    .success(function (data, status, headers) {
                       console.log('Cliente #'+$scope.micliente.id+' editado porcentaje correctamente.');
                           $http.get('/api/clientes').success(
                              function(clientes) {
                                        $scope.clientes = clientes.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al modificar el usuario.');
                    });
               };
        };


       


});




//************************************Venta**********************************************//
wApp.controller('VentasCtrl',function($scope, $http, $timeout, $log,$uibModal,$location,$window,moment){
    $scope.deselecpago=function(){
    $scope.busfiltropago='';
  }

  $scope.act_btn=1;
        $scope.hoy=moment();

        $scope.mifecha={};
        $scope.mifecha.dia=$scope.hoy._d;
          $scope.actlis=false;

       $scope.mas_obj = false; //Nuevo proveedor
       $scope.urldia='/api/ventasdia';
       $scope.urlmes='/api/ventasmes';
       $scope.urlanio='/api/ventasanio';
       
        $scope.urlac= $scope.urldia;
        

        var datafecha={
              fecha: $scope.mifecha.dia
        };

        $scope.cod1=1;


      //Selecciona de ventas del dia por tipo de pago y sucursal 
        
          $scope.selecventa= function(pago,sucursal){

            $scope.actlis=true;
               $scope.urlac= $scope.urldia;
           
            //Todos las ventas
            $http.get($scope.urlac+'/'+pago+'/'+sucursal).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

          }


             //Ventas por sucursal del dia
            $http.get('/api/ventaahorasucursal').success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.get('/api/ventaahorapago').success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                                $scope.ventadiasucu = ventadiapago.sucursales;
                                console.log('Sucursales: ',$scope.ventadiasucu);
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

            
               //Ventas por sucursal del dia
            $http.get('/api/ventaahorafac').success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                }); 

       //Filtrar los dias
        $scope.filtrarDia=function(){
                var datafecha={
                      fecha: $scope.mifecha.dia
                };

               
           //Selecciona de ventas del dia por tipo de pago y sucursal 
          $scope.actlis=false;
          $scope.selecventa= function(pago,sucursal){

            $scope.actlis=true;
               $scope.urlac= $scope.urldia;
           
            //Todos las ventas
            $http.post('/api/ventasdiaf/'+pago+'/'+sucursal,datafecha).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

          }

                //Ventas por sucursal del dia
            $http.post('/api/ventadiasucursal',datafecha).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });  

                  //Ventas por sucursal de ayer
            $http.post('/api/ventadiapago',datafecha).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                                    $scope.ventadiasucu = ventadiapago.sucursales;
                                console.log('Sucursales: ',$scope.ventadiasucu);
                    }).error(function(error) {
                         $scope.error = error;
                    });  

                 //Ventas por sucursal del dia
            $http.post('/api/ventadiafac',datafecha).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                }); 

            
        };


          $scope.ca_dias=true;
         $scope.ca_meses=false;
         $scope.ca_anios=false;

          $scope.act_dbtn=moment().format("DD"); //Dia Actual
          $scope.act_mbtn=moment().format("MM"); //Mes Actual
          $scope.act_abtn=moment().format("YYYY"); //Año Actual



        $scope.meses=[
          {id:'01',mes:'Enero'},{id:'02',mes:'Febrero'},{id:'03',mes:'Marzo'},{id:'04',mes:'Abril'},{id:'05',mes:'Mayo'},{id:'06',mes:'Junio'},
          {id:'07',mes:'Julio'},{id:'08',mes:'Agosto'},{id:'09',mes:'Septiembre'},{id:'10',mes:'Octubre'},{id:'11',mes:'Noviembre'},{id:'12',mes:'Diciembre'},
         ];

        $scope.anios=[
         {id:'2016'},{id:'2017'},{id:'2018'},{id:'2019'},{id:'2020'},{id:'2021'},{id:'2022'},{id:'2023'},{id:'2024'},{id:'2025'},
         ];
           
        
      
       $scope.btn_edia=function(e){
           $scope.act_dbtn=e;
          
          }              
      
       $scope.btn_dia=function(){
          $scope.act_btn=1;

         $scope.ca_dias=true;
         $scope.ca_meses=false;
         $scope.ca_anios=false;

           $scope.btn_edia=function(e){
           $scope.act_dbtn=e;
          }

           var datafecha={
              fecha: $scope.mifecha.dia
           };


         
          //Selecciona de ventas del dia por tipo de pago y sucursal 
        
          $scope.selecventa= function(pago,sucursal){

            $scope.actlis=true;
               $scope.urlac= $scope.urldia;
           
            //Todos las ventas
            $http.post('/api/ventasdiaf/'+pago+'/'+sucursal,datafecha).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

          }
           




             //Ventas por sucursal del dia
            $http.post('/api/ventadiasucursal',datafecha).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.post('/api/ventadiapago',datafecha).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                                  $scope.ventadiasucu = ventadiapago.sucursales;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

                //Ventas por sucursal del dia
            $http.post('/api/ventadiafac',datafecha).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });   

       };


        $scope.btn_mes=function(){
          $scope.act_btn=2;


         $scope.ca_dias=false;
         $scope.ca_meses=true;
         $scope.ca_anios=false;

         $scope.mifecha.mes=moment().format("MM"); //Mes Actual
         

          $scope.btn_emes=function(e){
           $scope.act_mbtn=e;
          
          }   

          var datames={
              mes:$scope.mifecha.mes
          }; 

         $scope.urlac= $scope.urlmes;
     
            //Selecciona de ventas del dia por tipo de pago y sucursal 
          $scope.actlis=false;
          $scope.selecventa= function(pago,sucursal){

            $scope.actlis=true;
           
            //Todos las ventas
            $http.get($scope.urlac+'/'+pago+'/'+sucursal).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

          }

             //Ventas por sucursal del dia
            $http.post('/api/ventamessucursal',datames).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.post('/api/ventamespago',datames).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                                  $scope.ventadiasucu = ventadiapago.sucursales;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

            //Ventas por estado de factura
            $http.post('/api/ventamesfac',datames).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });  

            $scope.filtrarMes=function(){

                  var datames={
                      mes:$scope.mifecha.mes
                  }; 



                          //Selecciona de ventas del dia por tipo de pago y sucursal 
                          $scope.actlis=false;
                          $scope.selecventa= function(pago,sucursal){

                            $scope.actlis=true;
                           
                            //Todos las ventas
                            $http.post('/api/ventasmesf/'+pago+'/'+sucursal,datafecha).success(

                                    function(ventas) {
                                              $scope.ventas = ventas.datos.slice(0, 15);
                                              $scope.masventas = function () {
                                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                                              }
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });

                          }

                          //Ventas por sucursal del dia
                    $http.post('/api/ventamessucursal',datames).success(

                          function(ventadiasucursal) {
                                    $scope.ventadiasucursal = ventadiasucursal.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        }); 

                           //Ventas por sucursal de ayer
                    $http.post('/api/ventamespago',datames).success(

                              function(ventadiapago) {
                                        $scope.ventadiapago = ventadiapago.datos;
                                           $scope.ventadiasucu = ventadiapago.sucursales;
                            }).error(function(error) {
                                 $scope.error = error;
                            }); 

                    //Ventas por estado de factura
                    $http.post('/api/ventamesfac',datames).success(

                          function(ventadiafac) {
                                    $scope.ventadiafac = ventadiafac.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });  
 

            };            
       };

         $scope.btn_anio=function(){
            $scope.act_btn=3;

              $scope.mifecha.anio=moment().format("YYYY"); //Mes Actual


         $scope.ca_dias=false;
         $scope.ca_meses=false;
         $scope.ca_anios=true;

         
          $scope.btn_eanio=function(e){
           $scope.act_abtn=e;
          
          }   


                  var dataanio={
                      anio:$scope.mifecha.anio
                  }; 

         $scope.urlac= $scope.urlanio;
     
            //Selecciona de ventas del dia por tipo de pago y sucursal 
                $scope.actlis=false;
                $scope.selecventa= function(pago,sucursal){

                  $scope.actlis=true;
                 
                  //Todos las ventas
                  $http.get($scope.urlac+'/'+pago+'/'+sucursal).success(

                          function(ventas) {
                                    $scope.ventas = ventas.datos.slice(0, 15);
                                    $scope.masventas = function () {
                                        $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                                    }
                        }).error(function(error) {
                             $scope.error = error;
                        });

                }

             //Ventas por sucursal del dia
            $http.post('/api/ventaaniosucursal',dataanio).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.post('/api/ventaaniopago',dataanio).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                                  $scope.ventadiasucu = ventadiapago.sucursales;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

                //Ventas por estado de factura
            $http.post('/api/ventaaniofac',dataanio).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });  

            $scope.filtrarAnio=function(){


                                  var dataanio={
                                anio:$scope.mifecha.anio
                            }; 



                          //Selecciona de ventas del dia por tipo de pago y sucursal 
                          $scope.actlis=false;
                          $scope.selecventa= function(pago,sucursal){

                            $scope.actlis=true;
                           
                            //Todos las ventas
                            $http.post('/api/ventasaniof/'+pago+'/'+sucursal,dataanio).success(

                                    function(ventas) {
                                              $scope.ventas = ventas.datos.slice(0, 15);
                                              $scope.masventas = function () {
                                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                                              }
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });

                          }



                               //Ventas por sucursal del dia
                      $http.post('/api/ventaaniosucursal',dataanio).success(

                            function(ventadiasucursal) {
                                      $scope.ventadiasucursal = ventadiasucursal.datos;
                          }).error(function(error) {
                               $scope.error = error;
                          });    

                       //Ventas por sucursal de ayer
                      $http.post('/api/ventaaniopago',dataanio).success(

                                function(ventadiapago) {
                                          $scope.ventadiapago = ventadiapago.datos;
                                            $scope.ventadiasucu = ventadiapago.sucursales;
                              }).error(function(error) {
                                   $scope.error = error;
                              }); 

                          //Ventas por estado de factura
                      $http.post('/api/ventaaniofac',dataanio).success(

                            function(ventadiafac) {
                                      $scope.ventadiafac = ventadiafac.datos;
                          }).error(function(error) {
                               $scope.error = error;
                          }); 
            };        
       };




     

        $scope.tpagos=[
          {id:'1',pago:'Efectivo'},
          {id:'2',pago:'POS'},
          {id:'3',pago:'Cheque'},
          {id:'4',pago:'Crédito'},
          {id:'5',pago:'Depósito'},
         ];

          $scope.tpagado=[
          {id:'1',pago:'Efectivo'},
          {id:'2',pago:'POS'},
          {id:'3',pago:'Cheque'},
          {id:'5',pago:'Depósito'},
         ];


        
      

       //Eliminar Venta borrador
      $scope.btn_eliminar = function(id){
        $scope.idventa= id;
        console.log($scope.idventa);

         $http.delete('/api/venta/destroy/' +  $scope.idventa)
            .success(function (data, status, headers) {
               console.log('Venta '+$scope.idventa+' borrada correctamente.');
                   $http.get($scope.urlac).success(

                        function(ventas) {
                                  $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
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

       $scope.abrirventa= function(venta){
          $scope.mas_obj = !$scope.mas_obj;   

          //Datos de la venta
           $scope.exisVenta=venta;
             $scope.miventa=venta.id;

          // console.log($scope.exisVenta);
         
          $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

        $http.get('/api/miproducto/'+$scope.miventa).success(

                                  function(misproductos) {
                                            $scope.misproductos = misproductos.datos;
                                          //  console.log($scope.misproductos);
                                }).error(function(error) {
                                     $scope.error = error;
                                });


      };  

          $scope.notacredito = function(id) {
          $scope.idventa=id;

                   $http.post('/api/notacredito/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Nota de credito creada correctamente");
                              
                                      //Todos las ventas
                                          $http.get($scope.urlac).success(

                                                  function(ventas) {
                                                              $scope.ventas = ventas.datos.slice(0, 15);
                                                              $scope.masventas = function () {
                                                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                                                              }
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                });

                                       //Ventas por sucursal del dia
                                            $http.get('/api/ventadiasucursal').success(

                                                    function(ventadiasucursal) {
                                                              $scope.ventadiasucursal = ventadiasucursal.datos;
                                                  }).error(function(error) {
                                                       $scope.error = error;
                                                  }); 

                                         //Ventas por sucursal de ayer
                                          $http.get('/api/ventadiapago').success(

                                                    function(ventadiapago) {
                                                              $scope.ventadiapago = ventadiapago.datos;
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

           $scope.notadebito = function(id) {
          $scope.idventa=id;

                   $http.post('/api/notadebito/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Nota de debito creada correctamente");
                              
                                      //Todos las ventas
                                          $http.get($scope.urlac).success(

                                                  function(ventas) {
                                                              $scope.ventas = ventas.datos.slice(0, 15);
                                                              $scope.masventas = function () {
                                                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                                                              }
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                });

                                       //Ventas por sucursal del dia
                                            $http.get('/api/ventadiasucursal').success(

                                                    function(ventadiasucursal) {
                                                              $scope.ventadiasucursal = ventadiasucursal.datos;
                                                  }).error(function(error) {
                                                       $scope.error = error;
                                                  }); 

                                         //Ventas por sucursal de ayer
                                          $http.get('/api/ventadiapago').success(

                                                    function(ventadiapago) {
                                                              $scope.ventadiapago = ventadiapago.datos;
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

           //PDF Ventas
      $scope.btn_pdf = function(id){
        $scope.idventa= id;

         $window.location.href = '/api/pdfventa/'+ $scope.idventa;
      };   

      //Editar venta
        $scope.editarventa=function(id){
          $scope.idmiv=id;
            $window.location.href = '/editarventa/'+ $scope.idmiv;
      }



});
//************************************Venta N**********************************************//


wApp.controller('VentaNCtrl',function($scope, $http, $timeout, $log,$uibModal, $location,$window){
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
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaExistePro = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.acti_venta=true;
   $scope.termi_venta=false;
   $scope.acti_rol=false;
   $scope.acti_cliente=false;
      $scope.no_encon =false;
   $scope.acti_areapro=false;
    $scope.loading = false;


     $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
           $scope.acti_cliente=false;
       };

      $scope.act_cliente = function(nit) {
        var datanit={
          nit:nit,
        }
          $http.post('/api/bclientes/',datanit)
              .success(function(clientes) {
                  $scope.venta.cliente = clientes.datos;
                  $scope.venta.bnit = '';
                   $scope.acti_cliente =true;
                    $scope.no_encon =false;
              })
              .error(function (data, status, header, config) {
                  console.log("Nit incorrecto o inexistente");
                  $scope.no_encon =true;
                  $scope.acti_cliente =false;
                  $timeout(function () { $scope.alertaExiste = true; }, 100);
                  $timeout(function () { $scope.alertaExiste = false; }, 5000);
              });


         
       };
  
  $scope.apcf=function(){
      $scope.venta.bnit='C/F';
       $scope.no_encon =false;
       $scope.act_cliente( $scope.venta.bnit);
  }

   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Empresa'},
   ];

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


     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      //Promocion
      $http.get('/api/mipromocion').success(

              function(promocion) {
                        $scope.promocion = promocion.datos;
                        $scope.existepromo = promocion.codigo;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Nuevo Cliente

      $scope.cliente={};
      $scope.guardarClienteCrear = function(){

               var dataventa={
                        empresa: $scope.cliente.empresa,
                        nombre: $scope.cliente.nombre,
                        nit: $scope.cliente.nit,
                        direccion: $scope.cliente.direccion,
                        telefono: $scope.cliente.telefono,
                        celular: $scope.cliente.celular,
                        email: $scope.cliente.email,
                        tipo_cliente: $scope.cliente.tipo_cliente
                    };
                   // console.log(dataventa);
                    $http.post('/api/ventacliente/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };


       //Productos
          $http.get('/api/productosas').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      $scope.elstock=function(id){
            $scope.idpro=id;
                 $http.get('/api/ventas/stockproducto/'+$scope.idpro).success(

                  function(stock) {
                            $scope.stock = stock.datos;
                }).error(function(error) {
                     $scope.error = error;
                });
        };

         //Sucursal
          $http.get('/api/misucursal/'+ 3).success(

              function(misucursal) {
                        $scope.misucursal = misucursal.datos;
            }).error(function(error) {
                 $scope.error = error;
            });    


        //Nueva Venta

      $scope.venta={};
      $scope.nuevaVenta = function(){

                    var dataventa={
                          id_cliente:  $scope.venta.cliente.id
                    };
                    //console.log(dataventa);
                    $http.post('/api/ventacentral/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };
      $scope.agregarProductos=function(idventa){
        $scope.idventa=idventa;
        console.log('ID Venta: ',$scope.idventa);

               //Mi Venta
                $http.get('/api/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });

                 //Mi Descuento
                $http.get('/api/midescuento/'+$scope.idventa).success(

                        function(mides) {
                                  $scope.mides = mides.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      }); 

                       //Mi Promocion
                      $http.get('/api/productomin/'+$scope.idventa).success(

                              function(productomin) {
                                        $scope.productomin = productomin.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            }); 

                     $http.get('/api/mipromocion/'+$scope.idventa).success(

                      function(mipromo) {
                                $scope.mipromo = mipromo.datos;
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
                  $http.post('/api/ventades/create', datapor)
                        .success(function (data, status, headers) {
                              console.log("Descuento agregado correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                          //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });


              
                           });    
              };


              //Aplicar promocion           
              $scope.aplipromo= function(promocion,producto,venta){
                  var datapromo={
                           id_promociones:promocion,
                           id_producto:producto,
                           id_ventas: venta
                      };
                    console.log(datapromo);
                  $http.post('/api/ventapromo/create', datapromo)
                        .success(function (data, status, headers) {
                              console.log("Promoción agregada correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                          //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });

                                //Mi Promocion
                                    $http.get('/api/productomin/'+$scope.idventa).success(

                                            function(productomin) {
                                                      $scope.productomin = productomin.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });  

                                  $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });                   
              
                           });    
              };



              //Eliminar descuento           
              $scope.deldes= function(){
                      // console.log(datapor);
                  $http.delete('/api/descuento/destroy/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Descuento eliminado correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                         //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });  

                                        $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });               
                           });    
              };


               //Eliminar promoción           
              $scope.delpromo= function(){
                      // console.log(datapor);
                  $http.delete('/api/promocion/destroy/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Promocion eliminado correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                         //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });  

                                   //Mi Promocion
                                    $http.get('/api/productomin/'+$scope.idventa).success(

                                            function(productomin) {
                                                      $scope.productomin = productomin.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });   

                                             $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
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

                       $http.post('/api/ventaproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                        //Mi Promocion
                                          $http.get('/api/productomin/'+$scope.idventa).success(

                                                  function(productomin) {
                                                            $scope.productomin = productomin.datos;
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                }); 

                                         $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
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
                $http.put('/api/proventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });


      
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                   //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });  

                                      //Mi Promocion
                                          $http.get('/api/productomin/'+$scope.idventa).success(

                                                  function(productomin) {
                                                            $scope.productomin = productomin.datos;
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                });     

                                      $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
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

                 $http.delete('/api/proventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/midescuento/'+$scope.idventa).success(

                                      function(mides) {
                                                $scope.mides = mides.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                              //Mi Promocion
                                          $http.get('/api/productomin/'+$scope.idventa).success(

                                                  function(productomin) {
                                                            $scope.productomin = productomin.datos;
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                });  


                                      $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });                         
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };
      };



      $scope.factura={};
      $scope.btn_facturar=function(){

          $scope.loading = true;
          $timeout(function() { 
            $scope.loading = false;
          }, 10000);
            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_ventas: $scope.idventa,
                dias_credito: $scope.factura.dias_credito,
            };
            //console.log(datafact);

              $http.post('/api/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                               $scope.acti_venta=false;
                               $scope.termi_venta=true;
                               //  $window.location.href = '/ventas';

                                      //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/midescuento/'+$scope.idventa).success(

                                      function(mides) {
                                                $scope.mides = mides.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    }); 

                                      //Mi Promocion
                                          $http.get('/api/productomin/'+$scope.idventa).success(

                                                  function(productomin) {
                                                            $scope.productomin = productomin.datos;
                                                }).error(function(error) {
                                                     $scope.error = error;
                                                });  

                                                
                                      $http.get('/api/mipromocion/'+$scope.idventa).success(

                                          function(mipromo) {
                                                    $scope.mipromo = mipromo.datos;
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




});



//************************************Venta N**********************************************//
wApp.controller('MiVentaNCtrl',function($scope, $http, $timeout, $log,$uibModal, $location,$window){
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
   $scope.alertaExistePro = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.acti_venta=true;
   $scope.termi_venta=false;
   $scope.acti_rol=false;
    $scope.acti_cliente=false;
    $scope.acti_areapro=false;
     $scope.loading = false;
      $scope.no_encon =false;

     $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
           $scope.acti_cliente=false;
       };

  $scope.act_cliente = function(nit) {
        var datanit={
          nit:nit,
        }
          $http.post('/api/bclientes/',datanit)
              .success(function(clientes) {
                  $scope.venta.cliente = clientes.datos;
                  $scope.venta.bnit = '';
                   $scope.acti_cliente =true;
                    $scope.no_encon =false;
              })
              .error(function (data, status, header, config) {
                  console.log("Nit incorrecto o inexistente");
                  $scope.no_encon =true;
                  $scope.acti_cliente =false;
                  $timeout(function () { $scope.alertaExiste = true; }, 100);
                  $timeout(function () { $scope.alertaExiste = false; }, 5000);
              });


         
       };
  
  $scope.apcf=function(){
      $scope.venta.bnit='C/F';
       $scope.no_encon =false;
       $scope.act_cliente( $scope.venta.bnit);
  }



   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Empresa'},
        ];

   $scope.tpagos=[
        {id:'1',pago:'Efectivo'},
        {id:'2',pago:'POS/Tarjeta'},
        {id:'5',pago:'Depósito'},
  ];

  

     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


     //Promocion
      $http.get('/api/mi/mipromocion').success(

              function(promocion) {
                        $scope.promocion = promocion.datos;
                        $scope.existepromo = promocion.codigo;
            }).error(function(error) {
                 $scope.error = error;
            });
      

   //MiUsuario
      $http.get('/api/mi/miusuario').success(

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


      //Nuevo Cliente

        $scope.cliente={};
        $scope.guardarClienteCrear = function(){

               var dataventa={
                        nombre: $scope.cliente.nombre,
                        nit: $scope.cliente.nit,
                        direccion: $scope.cliente.direccion,
                        telefono: $scope.cliente.telefono,
                        email: $scope.cliente.email
                    };
                    console.log(dataventa);
                    $http.post('/api/mi/ventacliente/create/'+$scope.misucu, dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

          };


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

      $scope.elstock=function(id){
            $scope.idpro=id;
                 $http.get('/api/mi/ventas/stockproducto/'+$scope.misucu+'/'+$scope.idpro).success(

                  function(stock) {
                            $scope.stock = stock.datos;
                }).error(function(error) {
                     $scope.error = error;
                });
        };



        //Nueva Venta

      $scope.venta={};
      $scope.nuevaVenta = function(){

                    var dataventa={
                          id_cliente:  $scope.venta.cliente.id,
                          id_sucursal:  $scope.misucu
                    };
                    console.log(dataventa);
                    $http.post('/api/mi/venta/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };
      $scope.agregarProductos=function(idventa){
        $scope.idventa=idventa;
        console.log($scope.idventa);

               //Mi Venta
                $http.get('/api/mi/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });

                  //Mi Promocion
                      $http.get('/api/mi/productomin/'+$scope.idventa).success(

                              function(productomin) {
                                        $scope.productomin = productomin.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            }); 

                    /* $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                      function(mipromo) {
                                $scope.mipromo = mipromo.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    });    */     


              
                 //Aplicar promocion           
              $scope.aplipromo= function(promocion,producto,venta){
                  var datapromo={
                           id_promociones:promocion,
                           id_producto:producto,
                           id_ventas: venta
                      };
                    console.log(datapromo);
                  $http.post('/api/mi/ventapromo/create', datapromo)
                        .success(function (data, status, headers) {
                              console.log("Promoción agregada correctamente");
                                //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                    $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
      

                                     //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });                
              
                           });    
              }; 


               //Eliminar promoción           
              $scope.delpromo= function(){
                      // console.log(datapor);
                  $http.delete('/api/mi/promocion/destroy/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Promocion eliminado correctamente");
                                //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                  $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });

                                     //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
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
                           cantidad: 1,
                      };
                      console.log(datapro);

                       $http.post('/api/mi/ventaproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                     //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
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
                console.log(data);
                $http.put('/api/mi/proventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });

                                     //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                           //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
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
                console.log($scope.idproventa);

                 $http.delete('/api/mi/proventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                 //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });             
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };
      };
      $scope.factura={};
      $scope.btn_facturar=function(){
         $scope.loading = true;
          $timeout(function() { 
              $scope.loading = false;
            }, 10000);

            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_ventas: $scope.idventa,
            };
            console.log(datafact);

             /*  console.log("Factura creada correctamente");
                                 $scope.acti_venta=false;
                                 $scope.termi_venta=true;*/


                                                

             $http.post('/api/mi/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                                 $scope.acti_venta=false;
                                 $scope.termi_venta=true;

                                   //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                               $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });
    

                                     //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });           
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al enviar la factura");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });

                            
                              /*  $scope.acti_venta=false;
                                 $scope.termi_venta=true;
                           //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                               $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                      function(misproductos) {
                                      $scope.misproductos = misproductos.datos;
                                          }).error(function(error) {
                                               $scope.error = error;
                                          });
    

                                     //Mi Promocion
                                        $http.get('/api/mi/productomin/'+$scope.idventa).success(

                                                function(productomin) {
                                                          $scope.productomin = productomin.datos;
                                              }).error(function(error) {
                                                   $scope.error = error;
                                              }); 

                                       $http.get('/api/mi/mipromocion/'+$scope.idventa).success(

                                        function(mipromo) {
                                                  $scope.mipromo = mipromo.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });     */      
      };


      $scope.iraventas=function(){
            $window.location.href = '/misventas';
      };


  };
      
});


//************************************Venta**********************************************//
wApp.controller('MisVentasCtrl',function($scope, $http, $timeout, $log,$uibModal, $location,$window){

     $scope.mas_obj = false; //Nuevo proveedor
  $scope.act_btn=1;
   //MiUsuario
      $http.get('/api/mi/miusuario').success(

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



      $scope.urldia='/api/mi/ventasdia/'+$scope.misucu;
       $scope.urlmes='/api/mi/ventasmes/'+$scope.misucu;
       $scope.urlanio='/api/mi/ventasanio/'+$scope.misucu;
       
        $scope.urlac= $scope.urldia;

        //Todos las ventas
            $http.get($scope.urlac).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

             //Ventas por sucursal del dia
            $http.get('/api/mi/ventadiasucursal/'+$scope.misucu).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.get('/api/mi/ventadiapago/'+$scope.misucu).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

            
               //Ventas por sucursal del dia
            $http.get('/api/mi/ventadiafac/'+$scope.misucu).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                }); 
              
               //Ventas por usuario del dia
            $http.get('/api/mi/ventadiauser/'+$scope.misucu).success(

                  function(ventadiauser) {
                            $scope.ventadiauser = ventadiauser.datos;
                }).error(function(error) {
                     $scope.error = error;
                }); 


        $scope.btn_dia=function(){
          $scope.act_btn=1;
         $scope.urlac= $scope.urldia;
     
            //Todos las ventas
            $http.get($scope.urlac).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

             //Ventas por sucursal del dia
            $http.get('/api/mi/ventadiasucursal/'+$scope.misucu).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.get('/api/mi/ventadiapago/'+$scope.misucu).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

                //Ventas por sucursal del dia
            $http.get('/api/mi/ventadiafac/'+$scope.misucu).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });  


               //Ventas por usuario del dia
            $http.get('/api/mi/ventadiauser/'+$scope.misucu).success(

                  function(ventadiauser) {
                            $scope.ventadiauser = ventadiauser.datos;
                }).error(function(error) {
                     $scope.error = error;
                });  

       };


        $scope.btn_mes=function(){
          $scope.act_btn=2;
         $scope.urlac= $scope.urlmes;
     
            //Todos las ventas
            $http.get($scope.urlac).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

             //Ventas por sucursal del mes
            $http.get('/api/mi/ventamessucursal/'+$scope.misucu).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal del mes
            $http.get('/api/mi/ventamespago/'+$scope.misucu).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

            //Ventas por estado de factura
            $http.get('/api/mi/ventamesfac/'+$scope.misucu).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });


               //Ventas por usuario del mes
            $http.get('/api/mi/ventamesuser/'+$scope.misucu).success(

                  function(ventadiauser) {
                            $scope.ventadiauser = ventadiauser.datos;
                }).error(function(error) {
                     $scope.error = error;
                });                
       };

         $scope.btn_anio=function(){
            $scope.act_btn=3;
         $scope.urlac= $scope.urlanio;
     
            //Todos las ventas
            $http.get($scope.urlac).success(

                    function(ventas) {
                              $scope.ventas = ventas.datos.slice(0, 15);
                              $scope.masventas = function () {
                                  $scope.ventas = ventas.datos.slice(0, $scope.ventas.length + 15);
                              }
                  }).error(function(error) {
                       $scope.error = error;
                  });

             //Ventas por sucursal del dia
            $http.get('/api/mi/ventaaniosucursal/'+$scope.misucu).success(

                  function(ventadiasucursal) {
                            $scope.ventadiasucursal = ventadiasucursal.datos;
                }).error(function(error) {
                     $scope.error = error;
                });    

             //Ventas por sucursal de ayer
            $http.get('/api/mi/ventaaniopago/'+$scope.misucu).success(

                      function(ventadiapago) {
                                $scope.ventadiapago = ventadiapago.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    }); 

                //Ventas por estado de factura
            $http.get('/api/mi/ventaaniofac/'+$scope.misucu).success(

                  function(ventadiafac) {
                            $scope.ventadiafac = ventadiafac.datos;
                }).error(function(error) {
                     $scope.error = error;
                });   


               //Ventas por usuario del año
            $http.get('/api/mi/ventaaniouser/'+$scope.misucu).success(

                  function(ventadiauser) {
                            $scope.ventadiauser = ventadiauser.datos;
                }).error(function(error) {
                     $scope.error = error;
                });             
       };


    





       //Eliminar venta 
      $scope.btn_eliminar = function(id){
        $scope.idventa= id;
        console.log($scope.idventa);

         $http.delete('/api/mi/venta/destroy/' +  $scope.idventa)
            .success(function (data, status, headers) {
               console.log('Venta '+$scope.idventa+' borrada correctamente.');
                   $http.get('/api/mi/ventas/'+ $scope.misucu).success(

                        function(ventas) {
                        $scope.ventas = ventas.datos;
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

       $scope.abrirventa= function(venta){
          $scope.mas_obj = !$scope.mas_obj;   

          //Datos de la venta
           $scope.exisVenta=venta;
             $scope.miventa=venta.id;

          // console.log($scope.exisVenta);
         
          $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

        $http.get('/api/mi/miproducto/'+$scope.miventa).success(

                                  function(misproductos) {
                                            $scope.misproductos = misproductos.datos;
                                            //console.log($scope.misproductos);
                                }).error(function(error) {
                                     $scope.error = error;
                                });


      };

          //PDF Ventas
      $scope.btn_pdf = function(id){
        $scope.idventa= id;

         $window.location.href = '/api/mi/pdfventa/'+ $scope.idventa;
      };         

  };        

});

//************************************Editar Venta**********************************************//


wApp.controller('VentaECtrl',function($scope, $http, $timeout, $log,$uibModal, $location,$window){
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
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaExistePro = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.acti_venta=true;
   $scope.termi_venta=false;
   $scope.acti_rol=false;
   $scope.acti_cliente=false;
   $scope.acti_areapro=true;
    $scope.loading = false;


     $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
           $scope.acti_cliente=false;
       };

      $scope.act_cliente = function() {
          $scope.acti_cliente =true;
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



   


       //Productos
          $http.get('/api/productosas').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      $scope.elstock=function(id){
            $scope.idpro=id;
                 $http.get('/api/ventas/stockproducto/'+$scope.idpro).success(

                  function(stock) {
                            $scope.stock = stock.datos;
                }).error(function(error) {
                     $scope.error = error;
                });
        };

         //Sucursal
          $http.get('/api/misucursal/'+ 3).success(

              function(misucursal) {
                        $scope.misucursal = misucursal.datos;
            }).error(function(error) {
                 $scope.error = error;
            });    



        $scope.miurl = $location.absUrl();

        //console.log('URL',$scope.url);
       
        $scope.idventa= $scope.miurl.split('/')[4];
        console.log('ID Venta: ',$scope.idventa);

               //Mi Venta
                $http.get('/api/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });

                 //Mi Descuento
                $http.get('/api/midescuento/'+$scope.idventa).success(

                        function(mides) {
                                  $scope.mides = mides.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      }); 

                      //Mis productos

                  $http.get('/api/miproducto/'+$scope.idventa).success(

                                  function(misproductos) {
                                            $scope.misproductos = misproductos.datos;
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
                  $http.post('/api/ventades/create', datapor)
                        .success(function (data, status, headers) {
                              console.log("Descuento agregado correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                          //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

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
                  $http.delete('/api/descuento/destroy/'+$scope.idventa)
                        .success(function (data, status, headers) {
                              console.log("Descuento eliminado correctamente");
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

                                          function(mides) {
                                                    $scope.mides = mides.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                                         //Mis Productos
                                  $http.get('/api/miproducto/'+$scope.idventa).success(

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

                       $http.post('/api/ventaproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                    //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

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
                $http.put('/api/proventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });


      
                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                                   //Mi Descuento
                                  $http.get('/api/midescuento/'+$scope.idventa).success(

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

                 $http.delete('/api/proventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/midescuento/'+$scope.idventa).success(

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
    



      $scope.factura={};
      $scope.btn_facturar=function(){

          $scope.loading = true;
          $timeout(function() { 
            $scope.loading = false;
          }, 10000);
            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_ventas: $scope.idventa,
                dias_credito: $scope.factura.dias_credito,
            };
            //console.log(datafact);

              $http.post('/api/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                               $scope.acti_venta=false;
                               $scope.termi_venta=true;
                               //  $window.location.href = '/ventas';

                                      //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                            //Mi Descuento
                              $http.get('/api/midescuento/'+$scope.idventa).success(

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





});



