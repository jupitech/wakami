/*AngularJS*/
var wApp= angular.module('wApp', ['ngRoute', 'ngCookies','ngAnimate','ngResource', 'ngSanitize','ui.bootstrap','angularMoment','nya.bootstrap.select','angularLazyImg','ngPrint','angular-button-spinner','angular.filter','infinite-scroll']);

wApp.config(['lazyImgConfigProvider', function(lazyImgConfigProvider){
    var scrollable = document.querySelector('#scrollable');
    lazyImgConfigProvider.setOptions({
      offset: 200, // how early you want to load image (default = 100)
      errorClass: 'error', // in case of loading image failure what class should be added (default = null)
      successClass: 'success', // in case of loading image success what class should be added (default = null)
      onError: function(image){}, // function fired on loading error
      onSuccess: function(image){}, // function fired on loading success
      container: angular.element(scrollable) // if scrollable container is not $window then provide it here
    });
}]);

wApp.factory('ApiUsuarioNuevo', function($resource){
  return $resource("/api/usuario/create");
});

wApp.factory('ApiProveedorNuevo', function($resource){
  return $resource("/api/proveedor/create");
});

wApp.factory('ApiLineaNuevo', function($resource){
  return $resource("/api/lineaproducto/create");
});

wApp.factory('ApiProductoNuevo', function($resource){
  return $resource("/api/producto/create");
});

wApp.factory('ApiCompraNuevo', function($resource){
  return $resource("/api/compra/create");
});

wApp.factory('ApiSucursalNuevo', function($resource){
  return $resource("/api/sucursal/create");
});

wApp.factory('ApiConsignacionNuevo', function($resource){
  return $resource("/api/consignacion/create");
});


 wApp.filter('SumaItem', function () {
    return function (data, key) {
        if (angular.isUndefined(data) && angular.isUndefined(key))
            return 0;
        var sum = 0;
        angular.forEach(data,function(value){
            sum = sum + parseFloat(value[key]);
        });
        return sum.toFixed(2);
    };
  });

 wApp.filter('SumaCanti', function () {
    return function (data, key) {
        if (angular.isUndefined(data) && angular.isUndefined(key))
            return 0;
        var sum = 0;
        angular.forEach(data,function(value){
            sum = sum + parseInt(value[key]);
        });
        return sum;
    };
  });

wApp.directive("compareTo", function ()
{
    return {
        require: "ngModel",
        scope:
        {
            confirmPassword: "=compareTo"
        },
        link: function (scope, element, attributes, modelVal)
        {
            modelVal.$validators.compareTo = function (val)
            {
                return val == scope.confirmPassword;
            };
            scope.$watch("confirmPassword", function ()
            {
                modelVal.$validate();
            });
        }
    };
});


//************************************Menu Dos*************************************************//
wApp.controller('menuDos',function($scope, $timeout){
  $scope.btn_menu = function() {
        $scope.menudos = !$scope.menudos;
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
});
