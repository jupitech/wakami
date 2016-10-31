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
		 	//Pie de Totales
		 $http.get('/api/reportes/ventasmes').success(

                    function(ventas) {
                              $scope.ventas = ventas.data;
                             /*   var score = [];
							    for (var i = 0; i <  $scope.ventas.length; i++) {
							        score.push( $scope.ventas[i].data);   
							    }

							    var name = [];
							    for (var i = 0; i <  $scope.ventas.length; i++) {
							        name.push( $scope.ventas[i].name);
							    }*/

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


                  //Total Ventas
                   $http.get('/api/reportes/totalventas').success(
                    function(totalventas) {
                    	  $scope.totalventas = totalventas.data;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });

                    	    //Total Neto
                   $http.get('/api/reportes/totalneto').success(
                    function(totalneto) {
                    	  $scope.totalneto = totalneto.data;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });

                   //Descuentos ventas
                   $http.get('/api/reportes/descuentosventas').success(
                    function(descuentosventas) {
                    	  $scope.descuentosventas = descuentosventas.data;

                    	 }).error(function(error) {
                       $scope.error = error;
                  });
 	

});
