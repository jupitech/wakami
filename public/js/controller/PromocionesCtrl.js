

//************************************Promociones**********************************************//
wApp.controller('PromocionesCtrl',function($scope, $http,ApiPromocionNuevo, $timeout, $log,$uibModal, moment){

   $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.mifecha={};
   $scope.Fecha = new Date();

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false; //Nuevo proveedor
   $scope.editar_obj = false; // Editar proveedor
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.promocion={};
     };


    $scope.hoy = moment();

     //Todos las promociones
      $http.get('/api/promociones').success(

              function(promociones) {
                        $scope.promociones = promociones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

       //Productos
          $http.get('/api/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;
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
            
            //Tipo Promoción
       $scope.tipopromocion=[
         {'id': '1','nombre': 'Por Cantidad'},
         {'id': '2','nombre': 'Por Producto'},
         {'id': '3','nombre': 'Por Linea'}
      ];         


      //Nueva promocion

      $scope.promocion={};
      $scope.guardarPromocion = function(){
         console.log($scope.promocion);
 
           var datapromocion = {
              nombre: $scope.promocion.nombre,
              tipo_promocion: $scope.promocion.tipo_promocion,
              id_producto: $scope.promocion.id_producto,
              id_linea: $scope.promocion.id_linea,
              por_cantidad: $scope.promocion.por_cantidad,
              porcentaje_producto: $scope.promocion.porcentaje_producto,
              porcentaje_linea: $scope.promocion.porcentaje_linea,
              fecha_inicio: $scope.promocion.fecha_inicio,
              fecha_fin: $scope.promocion.fecha_fin
            };


          $http.post('/api/promocion/create', datapromocion)
            .success(function (data, status, headers) {
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/promociones').success(

              function(promociones) {
                        $scope.promociones = promociones.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que el proveedor ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };

       //Eliminar Promocion
      $scope.btn_eliminar = function(id){
        $scope.idpromocion= id;
        console.log($scope.idpromocion);

         $http.delete('api/promocion/destroy/' +  $scope.idpromocion)
            .success(function (data, status, headers) {
               console.log('Promoción '+$scope.idpromocion+' borrado correctamente.');
                   $http.get('/api/promociones').success(

                        function(promociones) {
                        $scope.promociones = promociones.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la promoción.');
            });
      };

       //Editar Promocion
        $scope.btn_editar = function(promocion) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existePromo= promocion;
          
            $scope.Mdate = function ($fecha) {
            return new Date($fecha);
          };
          $scope.Fdate = function ($fecha) {
            return new Date($fecha);
          };
       };
      
      

      $scope.editarPromocion = function(){
                var data = {
                  nombre: $scope.existePromo.nombre,
                  tipo_promocion: $scope.existePromo.tipo_promocion,
                  id_producto: $scope.existePromo.id_producto,
                  id_linea: $scope.existePromo.id_linea,
                  por_cantidad: $scope.existePromo.por_cantidad,
                  porcentaje_producto: $scope.existePromo.porcentaje_producto,
                  porcentaje_linea: $scope.existePromo.porcentaje_linea,
                  fecha_inicio: $scope.existePromo.fini,
                  fecha_fin: $scope.existePromo.ffin
                };
                // console.log(data);
                $http.put('api/promocion/' +  $scope.existePromo.id, data)
                .success(function (data, status, headers) {
                   console.log('Promoción '+$scope.existePromo.nombre+' modificado correctamente.');
                       $http.get('/api/promociones').success(
                          function(promociones) {
                                    $scope.promociones = promociones.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la promoción.');
                });

        };


});
