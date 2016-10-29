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
        
     


		 $http.get('/api/reportes/ventasmes').success(

                    function(ventas) {
                              $scope.ventas = ventas.data;
                                  $scope.options = {
								            chart: {
								                type: 'pieChart',
								                height: 350,
								                donut: true,
								                x: function(d){return d.key;},
								                y: function(d){return d.y;},
								                showLabels: true,
								                duration: 500,
								                labelThreshold: 0.01,
								                labelSunbeamLayout: true,
								                legend: {
								                    margin: {
								                        top: 5,
								                        right: 35,
								                        bottom: 5,
								                        left: 0
								                    }
								                }
								            }
								        };

                  }).error(function(error) {
                       $scope.error = error;
                  });


 	

});
