//************************************Cuentas por Cobrar**********************************************//
wApp.controller('CuentasCobrarCtrl',function($scope, $http, $timeout, $log,$uibModal,$window){

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


     //Todos los cuentascobrar
      $http.get('/api/cuentascobrarac').success(

              function(cuentascobrar) {
                        $scope.cuentascobrar = cuentascobrar.datos;
            }).error(function(error) {
                 $scope.error = error;
     });

     //Fecha Actual       
     $scope.Fecha = new Date();
     $scope.Fecha.toISOString();
     console.log($scope.Fecha);

          //Cambiar tipo de pago
          $scope.cambiar_obj = false;
          $scope.cambiarpago = function(venta){

                    $scope.cambiar_obj = !$scope.cambiar_obj;   

                    $scope.exiscVenta=venta;
                    $scope.miventa=venta.id;

                      $scope.btn_cerrarca=function(){
                         $scope.cambiar_obj = false;
                       };
    
          }; 

         //PDF Ventas
          $scope.btn_pdf = function(id){
             $scope.idventa= id;
             $window.location.href = '/api/pdfventa/'+ $scope.idventa;
          };  


         $scope.tpagos=[
          {id:'1',pago:'Efectivo'},
          {id:'2',pago:'POS'},
          {id:'3',pago:'Cheque'},
          {id:'5',pago:'Depósito'},
         ];

         $scope.tpagado=[
          {id:'1',pago:'Efectivo'},
          {id:'2',pago:'POS'},
          {id:'3',pago:'Cheque'},
          {id:'5',pago:'Depósito'},
         ];


       $scope.predicate = 'name';
  
        $scope.sort = function(predicate) {
             $scope.predicate = predicate;
        }
        
        $scope.isSorted = function(predicate) {
             return ($scope.predicate == predicate)
        }


        $scope.comparaFecha= function(fecha){
                $scope.fechaah=new Date(fecha);
                $scope.fechaah.toISOString();

               $scope.Fecha = new Date();
               $scope.Fecha.toISOString();

               if($scope.Fecha > $scope.fechaah){
                     return '1';
                      console.log('Fecha: 1');
               }else{
                     return '0';
                      console.log('Fecha: 0');
               }
        }

             



      $scope.pago={};
       $scope.tipo={};
      $scope.btn_cambiar1= function(idtpago){

        console.log('ID Pago #1:',idtpago);

           var data = {
            tipo_pago: $scope.pago.tipo_pago,
            referencia: $scope.pago.referencia
        };
         console.log('Datos para cambiar pago:',data);

        $http.put('/api/cambiarpago/'+idtpago, data)
            .success(function (data, status, headers) {             
                
              console.log('Tipo de pago cambiado correctamente');
                $scope.cambiar_obj = false;
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el producto.');
            });


      }



       $scope.btn_cambiar2= function(idtpago){
        console.log('ID Pago #2:',idtpago);

            var data = {
            tipo_pago: $scope.pago.tipo_pago,
            referencia: $scope.pago.referencia
        };
         console.log('Datos para cambiar pago:',data);

        $http.put('/api/cambiarpago/'+idtpago, data)
            .success(function (data, status, headers) {             
                
              console.log('Tipo de pago cambiado correctamente');
                $scope.cambiar_obj = false;
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el producto.');
            });

      }


      $scope.crearexcel= function(){
                 $http.get('/api/cuentascobrar/crearexcel/') 
                 .success(function (data, status, headers) {
                  $scope.urlexcel=data.datos;
                   console.log('Excel creado correctamente....| ',$scope.urlexcel);
                    $window.location.href = '/exports/cuentasporcobrar/'+  $scope.urlexcel+'.xlsx';
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al guardar el excel.');
                });

              }

     

});
