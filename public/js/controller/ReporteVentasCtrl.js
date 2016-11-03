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
                           
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });


           
           	 //Total de ventas
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
                           
							    
                  }).error(function(error) {
                       $scope.error = error;
                  });

 	   };// Fin busqueda reportes por fecha

});
