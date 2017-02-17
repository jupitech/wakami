
//************************************Productos**********************************************//
wApp.controller('ProductosCtrl',function($scope, $http,ApiLineaNuevo,ApiProductoNuevo, $timeout, $log,$uibModal,$interval){

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
   $scope.movimiento_obj = false; //Ver Movimientos De Precio del Producto


   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.producto={};
     };

    $scope.btn_linea = function() {
        $scope.linea_obj = !$scope.linea_obj;
       $scope.linea={};
     };

       $scope.deselecli=function(){
          $scope.buslinea='';
          $scope.busprove='';
       }

      //Cargar Movimiento de Precios de Servicios
      $scope.btn_movimiento = function(producto){
        $scope.movimiento_obj = !$scope.movimiento_obj;
        $scope.existeProducto = producto;

          console.log("btn_movimiento clickeado");
        $http.get('api/movpreciopro/' +  $scope.existeProducto)
            .success(
            function(movimientoprecio){
              $scope.movimientoprecio = movimientoprecio.datos;
            }).error(function(error){
              $scope.error = error;
            });
      }

      //Boton Cerrar
        $scope.btn_cerrar = function() {
          $scope.editar_obj = !$scope.editar_obj;          
       };

       
        $scope.btn_cerrarM = function() {
          $scope.movimiento_obj = !$scope.movimiento_obj;          
       };


       //Lineas de productos
       $http.get('/api/lineaproductos').success(

              function(lineas) {
                        $scope.lineas = lineas.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

              //Lineas de productos
       $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
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

            //Stock Productos

            $scope.mistock=function(producto){
                $scope.mipro=producto.id;
                producto.stock={};
                      $http.get('/api/stockproducto/'+$scope.mipro).success(

                      function(stock) {
                               producto.stock = stock.datos;
                               //  console.log( producto.stock);
                    }).error(function(error) {
                         $scope.error = error;
                    });

            };


     //Nueva Linea

      $scope.linea={};
      $scope.guardarLinea = function(){
         // console.log($scope.usuario);

        ApiLineaNuevo.save($scope.linea, function(){
          console.log("Guardado correctamente");
           $scope.linea={};
           $http.get('/api/lineaproductos').success(

              function(lineas) {
                        $scope.lineas = lineas.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
          },
          function(error){
            console.log("Parece que la linea ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };

       //Editar Linea
        $scope.btn_editarl = function(linea) {
          $scope.existeLinea= linea;
       };
      $scope.editarLinea = function(){
                var data = {
                  nombre: $scope.existeLinea.nombre
                };
                // console.log(data);
                $http.put('api/lineaproducto/' +  $scope.existeLinea.id, data)
                .success(function (data, status, headers) {
                   console.log('Linea de Producto '+$scope.existeLinea.nombre+' modificado correctamente.');
                       $http.get('/api/lineaproductos').success(
                          function(lineas) {
                                    $scope.lineas = lineas.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                           $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la linea del producto.');
                });

        };

         //Eliminar Linea
      $scope.btn_eliminar = function(id){
        $scope.idlinea= id;
        console.log($scope.idlinea);

         $http.delete('api/lineaproducto/destroy/' +  $scope.idlinea)
            .success(function (data, status, headers) {
               console.log('Linea de producto '+$scope.idlinea+' borrado correctamente.');
                   $http.get('/api/lineaproductos').success(
                          function(lineas) {
                                    $scope.lineas = lineas.datos;
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

      //Nuevo producto

      $scope.producto={};
      $scope.guardarProducto = function(){
         // console.log($scope.usuario);

        ApiProductoNuevo.save($scope.producto, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que el producto ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };


       //Editar Producto
        $scope.btn_editar = function(producto) {
           $scope.editar_obj = !$scope.editar_obj;
          $scope.existeProducto= producto;
       };
      $scope.editarProducto = function(){
                var data = {
                  nombre: $scope.existeProducto.nombre,
                  codigo: $scope.existeProducto.codigo,
                  codigo_barra: $scope.existeProducto.codigo_barra,
                  linea: $scope.existeProducto.linea,
                  costo: $scope.existeProducto.costo,
                  preciop: $scope.existeProducto.preciop,
                  id_proveedor: $scope.existeProducto.id_proveedor
                };
                 //console.log(data);
                $http.put('api/producto/' +  $scope.existeProducto.id, data)
                .success(function (data, status, headers) {
                   console.log('Producto '+$scope.existeProducto.nombre+' modificado correctamente.');
                       $http.get('/api/productos').success(
                          function(productos) {
                                    $scope.productos = productos.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                         $scope.editar_obj = false;
                           $timeout(function () { $scope.alertaEditado = true; }, 1000);
                           $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el producto.');
                });

        };

       //Eliminar Producto
      $scope.btn_eliminarpro = function(id){
        $scope.idproducto= id;
        console.log($scope.idproducto);

         $http.delete('api/producto/destroy/' +  $scope.idproducto)
            .success(function (data, status, headers) {
               console.log('Producto '+$scope.idproducto+' borrado correctamente.');
                   $http.get('/api/productos').success(
                          function(productos) {
                                    $scope.productos = productos.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                           $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                           $timeout(function () { $scope.alertaEliminado = false; }, 5000);

            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el producto.');
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