//************************************Reporte de Ventas**********************************************//
wApp.controller('ReporteVentasCtrl',function($scope, $http, $timeout, $log,$uibModal,moment){

		$scope.mifecha={};


		$scope.toggleDropdown = function($event) {
		  $event.preventDefault();
		  $event.stopPropagation();
		  $scope.status.isopen = !$scope.status.isopen;
		};

		$scope.hoy = moment();
		$scope.mes = moment();
		$scope.hmes = $scope.mes.subtract(30, 'days');
		 //Fecha Hoy
		 $scope.mifecha.fin=$scope.hoy._d;
		 $scope.mifecha.inicio=$scope.hmes._d;
		   $scope.mifecha.sucursal=3;
        
     

		 //Total de ventas
		 $http.get('/api/reportes/ventasmes', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(

				   //Pie de Ventas por sucursal
                    function(ventas) {
                              $scope.ventas = ventas.data;
                          	  $scope.totalneto = ventas.tneto;
                          	  $scope.totalventas = ventas.treal;
                          	  $scope.descuentosventas = ventas.des;
                          	  $scope.ordenesdia = ventas.odia;
                          	   $scope.ordeneshora = ventas.ohora;
							    $scope.renderChart = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'pie'
						            },
					                title: {
							            text: ''
							        },
							         tooltip: {
							                pointFormat: '{series.name}: <b>Q{point.y:,.2f}</b>'
							            },
						             plotOptions: {
								                pie: {
								                    allowPointSelect: true,
								                    cursor: 'pointer',
								                    dataLabels: {
								                        enabled: false
								                    },
								                    showInLegend: true
								                }
								            },
							        series: [{
							        	name: 'Total',
							            data:  $scope.ventas
							        }]
							    };



					//Linear por ordenes del dia

					   var yorden = [];
								    for (var i = 0; i <  $scope.ordenesdia.length; i++) {
								        yorden.push( $scope.ordenesdia[i].y);   
								    }
					   var xorden = [];
						    for (var i = 0; i <  $scope.ordenesdia.length; i++) {
						        xorden.push( $scope.ordenesdia[i].name);   
						    }		    

							 $scope.renderOdia = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'area'
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
							                text: 'Ordenes'
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
							        	name: '# Ordenes',
							            data:  yorden
							        }]
							    };    

							    //Linear por ordenes por hora

					   var yordenh = [];
								    for (var i = 0; i <  $scope.ordeneshora.length; i++) {
								        yordenh.push( $scope.ordeneshora[i].y);   
								    }
					   var xordenh = [];
						    for (var i = 0; i <  $scope.ordeneshora.length; i++) {
						        xordenh.push( $scope.ordeneshora[i].name);   
						    }		    

							 $scope.renderOhora = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'area'
						            },
					                title: {
							            text: ''
							        },
							       xAxis: {
							       	 title: {
							                text: 'Hora'
							            },
								           categories:xordenh
								        },
							        yAxis: {
							        	  title: {
							                text: 'Ordenes'
							            },
							            categories:yordenh
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
							        	name: '# Ordenes',
							            data:  yordenh
							        }]
							    };    
                           
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });


		 //Total de ventas por producto
		 $http.get('/api/reportes/ventasproducto', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(
                    function(vproducto) {

                    	   $scope.vproducto = vproducto.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });


		 //Total de ventas por linea
		 $http.get('/api/reportes/ventaslinea', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(
                    function(vlinea) {

                    	   $scope.vlinea = vlinea.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });

           
           	 //Total de ventas por pago
		 $http.get('/api/reportes/ventaspago', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(

                    function(ventasp) {
                              $scope.ventasp = ventasp.data;

                                var ydata = [];
								    for (var i = 0; i <  $scope.ventasp.length; i++) {
								        ydata.push( $scope.ventasp[i].y);   
								    }

                               var categoria = [];
								    for (var i = 0; i <  $scope.ventasp.length; i++) {
								    	if($scope.ventasp[i].name==1){
								    	    categoria.push( 'Efectivo');
								    	} else if ($scope.ventasp[i].name==2){
								    		 categoria.push( 'POS/Tarjeta');
								    	} else if ($scope.ventasp[i].name==3){
								    		 categoria.push( 'Cheque');
								    	} else if ($scope.ventasp[i].name==4){
								    		 categoria.push( 'Crédito');
								    	} else if ($scope.ventasp[i].name==5){
								    		 categoria.push( 'Depósito');
								    	}
								    }
							    $scope.renderPago = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'bar'
						            },
					                title: {
							            text: ''
							        },
							         xAxis: {
							            categories:categoria,
							            title: {
							                text: null
							            }
							        },
							        yAxis: {
							            min: 0,
							            title: {
							                text: null,
							                align: 'high'
							            },
							            labels: {
							                overflow: 'justify'
							            }
							        },
							         tooltip: {
							                pointFormat: '{series.name}: <b>Q{point.y:,.2f}</b>'
							            },
						              plotOptions: {
											            bar: {
											                dataLabels: {
											                    enabled: true
											                }
											            }
											        },
							        series: [{
							        	name: 'Totales',
							            data:  ydata
							        }]
							    };
                           
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });
       

                  
 	   $scope.buscarreporte= function(){
 	   			 var datafecha={
                        fecha_inicio: $scope.mifecha.inicio,
                        fecha_fin: $scope.mifecha.fin
                   };
                 console.log(datafecha);

                 	 //Total de ventas
		 $http.get('/api/reportes/ventasmes', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(

                    function(ventas) {
                              $scope.ventas = ventas.data;
                          	  $scope.totalneto = ventas.tneto;
                          	  $scope.totalventas = ventas.treal;
                          	  $scope.descuentosventas = ventas.des;
                          	  $scope.ordenesdia = ventas.odia;
                          	  $scope.ordeneshora = ventas.ohora;	

                          	  //Por ventas y sucursales
							    $scope.renderChart = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'pie'
						            },
					                title: {
							            text: ''
							        },
							         tooltip: {
							                pointFormat: '{series.name}: <b>Q{point.y:,.2f}</b>'
							            },
						             plotOptions: {
								                pie: {
								                    allowPointSelect: true,
								                    cursor: 'pointer',
								                    dataLabels: {
								                        enabled: false
								                    },
								                    showInLegend: true
								                }
								            },
							        series: [{
							        	name: 'Total',
							            data:  $scope.ventas
							        }]
							    };
                           
                           		//Linear por ordenes del dia

					   var yorden = [];
								    for (var i = 0; i <  $scope.ordenesdia.length; i++) {
								        yorden.push( $scope.ordenesdia[i].y);   
								    }
					   var xorden = [];
						    for (var i = 0; i <  $scope.ordenesdia.length; i++) {
						        xorden.push( $scope.ordenesdia[i].name);   
						    }		    

							 $scope.renderOdia = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'area'
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
							                text: 'Ordenes'
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
							        	name: '# Ordenes',
							            data:  yorden
							        }]
							    };    


							       //Linear por ordenes por hora

					   var yordenh = [];
								    for (var i = 0; i <  $scope.ordeneshora.length; i++) {
								        yordenh.push( $scope.ordeneshora[i].y);   
								    }
					   var xordenh = [];
						    for (var i = 0; i <  $scope.ordeneshora.length; i++) {
						        xordenh.push( $scope.ordeneshora[i].name);   
						    }		    

							 $scope.renderOhora = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'area'
						            },
					                title: {
							            text: ''
							        },
							       xAxis: {
							       	 title: {
							                text: 'Hora'
							            },
								           categories:xordenh
								        },
							        yAxis: {
							        	  title: {
							                text: 'Ordenes'
							            },
							            categories:yordenh
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
							        	name: '# Ordenes',
							            data:  yordenh
							        }]
							    };    
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });



           	 //Total de ventas por pago
		 $http.get('/api/reportes/ventaspago', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(

                    function(ventasp) {
                              $scope.ventasp = ventasp.data;

                                var ydata = [];
								    for (var i = 0; i <  $scope.ventasp.length; i++) {
								        ydata.push( $scope.ventasp[i].y);   
								    }

                               var categoria = [];
								    for (var i = 0; i <  $scope.ventasp.length; i++) {
								    	if($scope.ventasp[i].name==1){
								    	    categoria.push( 'Efectivo');
								    	} else if ($scope.ventasp[i].name==2){
								    		 categoria.push( 'POS/Tarjeta');
								    	} else if ($scope.ventasp[i].name==3){
								    		 categoria.push( 'Cheque');
								    	} else if ($scope.ventasp[i].name==4){
								    		 categoria.push( 'Crédito');
								    	} else if ($scope.ventasp[i].name==5){
								    		 categoria.push( 'Depósito');
								    	}
								    }
							    $scope.renderPago = {
							        chart: {
						                plotBackgroundColor: null,
						                plotBorderWidth: null,
						                plotShadow: false,
						                type: 'bar'
						            },
					                title: {
							            text: ''
							        },
							         xAxis: {
							            categories:categoria,
							            title: {
							                text: null
							            }
							        },
							        yAxis: {
							            min: 0,
							            title: {
							                text: null,
							                align: 'high'
							            },
							            labels: {
							                overflow: 'justify'
							            }
							        },
							         tooltip: {
							                pointFormat: '{series.name}: <b>Q{point.y:,.2f}</b>'
							            },
						              plotOptions: {
											            bar: {
											                dataLabels: {
											                    enabled: true
											                }
											            }
											        },
							        series: [{
							        	name: 'Totales',
							            data:  ydata
							        }]
							    };
                           
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });

          
		 //Total de ventas por producto
		 $http.get('/api/reportes/ventasproducto', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(
                    function(vproducto) {

                    	   $scope.vproducto = vproducto.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });


		 //Total de ventas por linea
		 $http.get('/api/reportes/ventaslinea', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin
				      }
				   }).success(
                    function(vlinea) {

                    	   $scope.vlinea = vlinea.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  }); 


                   //Libro de ventas
		 $http.get('/api/reportes/ventasl', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin,
				          sucursal: $scope.mifecha.sucursal
				      }
				   }).success(
                    function(ventasl) {

                    	   $scope.ventasl = ventasl.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });                	 


 	   };// Fin busqueda reportes por fecha
        
    
          //Todos las sucursales
      $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

            
 	    //Libro de ventas
		 $http.get('/api/reportes/ventasl', {
				      params: {
				          fecha_inicio:$scope.mifecha.inicio,
				          fecha_fin: $scope.mifecha.fin,
				          sucursal: $scope.mifecha.sucursal
				      }
				   }).success(
                    function(ventasl) {

                    	   $scope.ventasl = ventasl.datos;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });   

          //Exportar Excel
		$scope.exportData = function () {
		     var blob = new Blob([document.getElementById('exportable').innerHTML], {
		         type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
		     });
		     saveAs(blob, "LibroVentas.xls");
		 };               	 




});
