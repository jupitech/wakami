

//************************************Gastos**********************************************//
wApp.controller('GastosCtrl',function($scope, $http,ApiLineaNuevo,ApiProductoNuevo, moment, $timeout, $log,$uibModal,$interval){

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
   $scope.linea_obj = false; // Editar proveedor
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.alertaEditadol = false; // Alerta de proveedor editado
     $scope.alertaEliminadol = false; // Alerta de proveedor editado


   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.categoria={};
     };

    $scope.btn_linea = function() {
        $scope.linea_obj = !$scope.linea_obj;
       $scope.linea={};
     };

       $scope.deselecli=function(){
          $scope.buslinea='';
          $scope.busprove='';
       }

       //Categoria de Gastos
       $http.get('/api/categoriagastos').success(

              function(categorias) {
                        $scope.categorias = categorias.datos;
            }).error(function(error) {
                 $scope.error = error;
            });




           //Gastos
       $http.get('/api/gastos').success(

              function(gastos) {
                        $scope.gastos = gastos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

           

     //Nueva categoria

      $scope.categoria={};
      $scope.guardarCategoria = function(){
            var datacate = {
                  nombre: $scope.categoria.nombre
                };
          //console.log(data);
        $http.post('api/categoriagastos/create/', datacate)
                .success(function (data, status, headers) {
          console.log("Guardado correctamente");
           $scope.categoria={};
               $http.get('/api/categoriagastos').success(

                    function(categorias) {
                              $scope.categorias = categorias.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });
          })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al guardar la categoria');
                });

      };

           //Nuevo gasto

      $scope.gasto={};
      $scope.guardarGasto = function(){
            var datagasto = {
                  id_categoria: $scope.gasto.id_categoria,
                  descripcion: $scope.gasto.descripcion,
                  costo: $scope.gasto.costo,
                  fecha_gasto: $scope.gasto.fecha_gasto,
                };
          //console.log(data);
        $http.post('api/gasto/create/', datagasto)
                .success(function (data, status, headers) {
          console.log("Guardado correctamente");
           $scope.gasto={};
               $http.get('/api/gastos').success(

                    function(gastos) {
                              $scope.gastos = gastos.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });
          })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al guardar la categoria');
                });

      };

       //Editar Categoria
        $scope.btn_editarl = function(categoria) {
          $scope.existeCategoria= categoria;
       };

         //Editar Gasto
         $scope.existeGasto={};
             $scope.btn_editar = function(gasto) {
                $scope.editar_obj = !$scope.editar_obj;
                $scope.existeGasto= gasto;
             };

            $scope.Mdate = function ($fecha) {
            return new Date($fecha);
          };
          $scope.Fdate = function ($fecha) {
            return new Date($fecha);
          };     

      $scope.editarCategoria = function(){
                var data = {
                  nombre: $scope.existeCategoria.nombre
                };
                // console.log(data);
                $http.put('api/categoriagastos/'+$scope.existeCategoria.id, data)
                .success(function (data, status, headers) {
                   console.log('Categoria '+$scope.existeCategoria.nombre+' modificado correctamente.');
                       $http.get('/api/categoriagastos').success(
                          function(categorias) {
                                    $scope.categorias = categorias.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                           $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la categoria.');
                });

        };

           $scope.editarGasto = function(){
                 var datagasto = {
                  id_categoria: $scope.existeGasto.id_categoria,
                  descripcion: $scope.existeGasto.descripcion,
                  costo: $scope.existeGasto.costo,
                  fecha_gasto: $scope.existeGasto.fgasto,
                };
                // console.log(data);
                $http.put('api/gasto/'+$scope.existeGasto.id, datagasto)
                .success(function (data, status, headers) {
                   console.log('Gasto '+$scope.existeGasto.descripcion+' modificado correctamente.');
                       $http.get('/api/gastos').success(
                          function(gastos) {
                                    $scope.gastos = gastos.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                           $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                             $scope.editar_obj=false;
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la categoria.');
                });

        };

         //Eliminar Linea
      $scope.btn_eliminar = function(id){
        $scope.idcate= id;
        console.log($scope.idcate);

         $http.delete('api/categoriagastos/destroy/' +  $scope.idcate)
            .success(function (data, status, headers) {
               console.log('Categoria # '+$scope.idcate+' borrado correctamente.');
                   $http.get('/api/categoriagastos').success(
                          function(categorias) {
                                    $scope.categorias = categorias.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEliminadol = true; }, 1000);
                           $timeout(function () { $scope.alertaEliminadol = false; }, 5000);

            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la linea de producto.');
            });
      };

        //Eliminar Gasto
      $scope.btn_eliminargas = function(id){
        $scope.idgasto= id;
        console.log($scope.idgasto);

         $http.delete('api/gasto/destroy/' +  $scope.idgasto)
            .success(function (data, status, headers) {
               console.log('Gasto # '+$scope.idgasto+' borrado correctamente.');
                   $http.get('/api/gastos').success(
                          function(gastos) {
                                    $scope.gastos = gastos.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEliminadol = true; }, 1000);
                           $timeout(function () { $scope.alertaEliminadol = false; }, 5000);

            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la linea de producto.');
            });
      };

   


});


//************************************Mis productos**********************************************//
wApp.controller('MisProductosCtrl',function($scope, $http,ApiLineaNuevo,ApiProductoNuevo, $timeout, $log,$uibModal,$interval, $location,$window){

   $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));

   //MiUsuario
      $http.get('api/mi/miusuario').success(

              function(miusuario) {
                        $scope.miusuario = miusuario.datos;
                        $scope.idusuario=$scope.miusuario.sucursal_usuario;
                        $scope.idusuario2=$scope.miusuario.sucursal_usuario2;

                        if($scope.idusuario!=null){
                          $scope.actsucu($scope.miusuario.sucursal_usuario.id);
                        } else{
                           $scope.actsucu($scope.miusuario.sucursal_usuario2.id);
                        }
                        
            }).error(function(error) {
                 $scope.error = error;
            });

  $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu;  

           //Productos
       $http.get('/api/mi/productos/'+$scope.misucu).success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


              $scope.descargaexcel=function(){
                 $window.location.href = '/api/mi/excelproductos/'+$scope.misucu;
              }



     };



});