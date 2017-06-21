

//************************************Proveedores**********************************************//
wApp.controller('CierresCtrl',function($scope, $http,ApiProveedorNuevo, $timeout, $log,$uibModal){

   $scope.status = {
    isopen: false
  };

    $scope.mifecha={};
    $scope.mifecha.por={'id': '1','nombre': 'Todas'};

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



    $scope.hoy = moment();
    $scope.mes = moment();
    $scope.hmes = $scope.mes.subtract(60, 'days');
     //Fecha Hoy
     $scope.mifecha.fin=$scope.hoy._d;
     $scope.mifecha.inicio=$scope.hmes._d;
       $scope.mifecha.sucursal=1;


   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.proveedor={};
     };

         $scope.filsucu=[
         {'id': '1','nombre': 'Todas'},
         {'id': '2','nombre': 'Por Sucursal'}
      ];

                    //Todos las sucursales
      $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


     //Todos los proveedores
      $http.get('/api/cierres').success(

              function(cierres) {
                        $scope.cierres = cierres.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

          //Todos los proveedores
      $http.get('/api/saldoactual').success(

              function(saldos) {
                        $scope.saldos = saldos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });    


          $scope.reportesucu= function(sucu){

             //Todos los saldos por sucursales
                $http.get('/api/reporsu/'+sucu, {
                        params: {
                            fecha_inicio:$scope.mifecha.inicio,
                            fecha_fin: $scope.mifecha.fin
                        }
                     }).success(

                        function(reporsu) {
                                  $scope.reporsu = reporsu.datos;


                                    //Linear por ordenes del dia

                                       var yorden = [];
                                              for (var i = 0; i <  $scope.reporsu.length; i++) {
                                                  yorden.push( $scope.reporsu[i].y);   
                                              }
                                       var xorden = [];
                                          for (var i = 0; i <  $scope.reporsu.length; i++) {
                                              xorden.push( $scope.reporsu[i].name);   
                                          }       
                                          $scope.renderOdia=[];
                                         $scope.renderOdia[sucu] = {
                                                chart: {
                                                      plotBackgroundColor: null,
                                                      plotBorderWidth: null,
                                                      plotShadow: false,
                                                      type: 'area',
                                                      height: '180px',
                                                  },
                                                    title: {
                                                    text: ''
                                                },
                                               xAxis: {
                                                 title: {
                                                        text: 'Dias'
                                                    },
                                                     categories:xorden
                                                  },
                                                yAxis: {
                                                    title: {
                                                        text: 'Saldo'
                                                    },
                                                    categories:yorden
                                                },
                                                   plotOptions: {
                                                    area: {
                                                        marker: {
                                                          pointStart: 02,
                                                            enabled: false,
                                                            symbol: 'circle',
                                                            radius: 2,
                                                            states: {
                                                                hover: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        }
                                                    }
                                                },
                                                series: [{
                                                  name: 'Saldos Q',
                                                    data:  yorden
                                                }]
                                            };    


                                   return   $scope.renderOdia;         
                      }).error(function(error) {
                           $scope.error = error;
                      });       

            
          }

          $scope.reportedesucu= function(sucu){

   //Todos los saldos por sucursales
      $http.get('/api/repordesu/'+sucu, {
              params: {
                  fecha_inicio:$scope.mifecha.inicio,
                  fecha_fin: $scope.mifecha.fin
              }
           }).success(

              function(repordesu) {
                        $scope.repordesu = repordesu.datos;


                          //Linear por ordenes del dia

                             var yorden = [];
                                    for (var i = 0; i <  $scope.repordesu.length; i++) {
                                        yorden.push( $scope.repordesu[i].y);   
                                    }
                             var xorden = [];
                                for (var i = 0; i <  $scope.repordesu.length; i++) {
                                    xorden.push( $scope.repordesu[i].name);   
                                }       
                                $scope.renderOdep=[];
                               $scope.renderOdep[sucu] = {
                                      chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'area',
                                            height: '180px',
                                        },
                                          title: {
                                          text: ''
                                      },
                                     xAxis: {
                                       title: {
                                              text: 'Dias'
                                          },
                                           categories:xorden
                                        },
                                      yAxis: {
                                          title: {
                                              text: 'Saldo'
                                          },
                                          categories:yorden
                                      },
                                         plotOptions: {
                                          area: {
                                              marker: {
                                                pointStart: 02,
                                                  enabled: false,
                                                  symbol: 'circle',
                                                  radius: 2,
                                                  states: {
                                                      hover: {
                                                          enabled: true
                                                      }
                                                  }
                                              }
                                          }
                                      },
                                      series: [{
                                        name: 'Saldos Q',
                                          data:  yorden
                                      }]
                                  };    


                         return   $scope.renderOdia;         
            }).error(function(error) {
                 $scope.error = error;
            });       

  
}
   

   $scope.buscarreporte= function(){

                        //Todos las sucursales
      $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


                $scope.reportesucu= function(sucu){

             //Todos los saldos por sucursales
                $http.get('/api/reporsu/'+sucu, {
                        params: {
                            fecha_inicio:$scope.mifecha.inicio,
                            fecha_fin: $scope.mifecha.fin
                        }
                     }).success(

                        function(reporsu) {
                                  $scope.reporsu = reporsu.datos;


                                    //Linear por ordenes del dia

                                       var yorden = [];
                                              for (var i = 0; i <  $scope.reporsu.length; i++) {
                                                  yorden.push( $scope.reporsu[i].y);   
                                              }
                                       var xorden = [];
                                          for (var i = 0; i <  $scope.reporsu.length; i++) {
                                              xorden.push( $scope.reporsu[i].name);   
                                          }       
                                          $scope.renderOdia=[];
                                         $scope.renderOdia[sucu] = {
                                                chart: {
                                                      plotBackgroundColor: null,
                                                      plotBorderWidth: null,
                                                      plotShadow: false,
                                                      type: 'area',
                                                      height: '180px',
                                                  },
                                                    title: {
                                                    text: ''
                                                },
                                               xAxis: {
                                                 title: {
                                                        text: 'Dias'
                                                    },
                                                     categories:xorden
                                                  },
                                                yAxis: {
                                                    title: {
                                                        text: 'Saldo'
                                                    },
                                                    categories:yorden
                                                },
                                                   plotOptions: {
                                                    area: {
                                                        marker: {
                                                          pointStart: 02,
                                                            enabled: false,
                                                            symbol: 'circle',
                                                            radius: 2,
                                                            states: {
                                                                hover: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        }
                                                    }
                                                },
                                                series: [{
                                                  name: 'Saldos Q',
                                                    data:  yorden
                                                }]
                                            };    


                                   return   $scope.renderOdia;         
                      }).error(function(error) {
                           $scope.error = error;
                      });       

            
          }

    $scope.reportedesucu= function(sucu){

   //Todos los saldos por sucursales
      $http.get('/api/repordesu/'+sucu, {
              params: {
                  fecha_inicio:$scope.mifecha.inicio,
                  fecha_fin: $scope.mifecha.fin
              }
           }).success(

              function(repordesu) {
                        $scope.repordesu = repordesu.datos;


                          //Linear por ordenes del dia

                             var yorden = [];
                                    for (var i = 0; i <  $scope.repordesu.length; i++) {
                                        yorden.push( $scope.repordesu[i].y);   
                                    }
                             var xorden = [];
                                for (var i = 0; i <  $scope.repordesu.length; i++) {
                                    xorden.push( $scope.repordesu[i].name);   
                                }       
                                $scope.renderOdep=[];
                               $scope.renderOdep[sucu] = {
                                      chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'area',
                                            height: '180px',
                                        },
                                          title: {
                                          text: ''
                                      },
                                     xAxis: {
                                       title: {
                                              text: 'Dias'
                                          },
                                           categories:xorden
                                        },
                                      yAxis: {
                                          title: {
                                              text: 'Saldo'
                                          },
                                          categories:yorden
                                      },
                                         plotOptions: {
                                          area: {
                                              marker: {
                                                pointStart: 02,
                                                  enabled: false,
                                                  symbol: 'circle',
                                                  radius: 2,
                                                  states: {
                                                      hover: {
                                                          enabled: true
                                                      }
                                                  }
                                              }
                                          }
                                      },
                                      series: [{
                                        name: 'Saldos Q',
                                          data:  yorden
                                      }]
                                  };    


                         return   $scope.renderOdia;         
            }).error(function(error) {
                 $scope.error = error;
            });       

  
}
   



   }

     

});
