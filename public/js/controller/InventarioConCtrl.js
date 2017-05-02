//************************************Traslados**********************************************//
wApp.controller('InventarioConCtrl',function($scope, $http, $timeout, $log,$uibModal){
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

 
      //Productos
          $http.get('/api/inventario/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;

                        /*  $scope.totalCentral= function(){
                                  var total=0;
                                  for(i=0; i< $scope.productos.length; i++){
                                      for(e=0; e<($scope.productos[i].stock_producto)
                                    total+= parseInt($scope.productos[i].stock_producto.stock,10);
                                  }
                                  return total;
                           }; */


            }).error(function(error) {
                 $scope.error = error;
            });

       //Sucursales
          $http.get('/api/inventario/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });  

             $http.get('/api/inventario/sumsucursal').success(

              function(sumsucursal) {
                        $scope.sumsucursal = sumsucursal.datos;
            }).error(function(error) {
                 $scope.error = error;
            });  

        //Consignacion
          $http.get('/api/inventario/consignacion').success(

              function(consignacion) {
                        $scope.consignacion = consignacion.datos;
            }).error(function(error) {
                 $scope.error = error;
            }); 

               $http.get('/api/inventario/sumconsignacion').success(

              function(sumconsignacion) {
                        $scope.sumconsignacion = sumconsignacion.datos;
            }).error(function(error) {
                 $scope.error = error;
            });      

            //Lineas de productos
       $http.get('/api/lineaproductos').success(

              function(lineas) {
                        $scope.lineas = lineas.datos;
            }).error(function(error) {
                 $scope.error = error;
            });        


              //Exportar Excel
    $scope.exportData = function () {
         var blob = new Blob([document.getElementById('exportable').innerHTML], {
             type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
         });
         saveAs(blob, "InventarioConsolidado.xls");
     };  
   

});