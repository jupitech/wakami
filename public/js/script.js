/*AngularJS*/
var wApp= angular.module('wApp', ['ngRoute', 'ngCookies']);

wApp.controller('UsuariosCtrl',function($scope, $http){
	/*var Usuario ={
		nombre: 'Carlos',
		apellido: 'Rodolfo',
		correo:'carlos.ruano@creationgt.com',
		role:'Administrador',
		modificado: '06/09/2016 8:50 am'
	}
	$scope.usuario=Usuario;*/
	
	    $http.get('/api/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            
});
