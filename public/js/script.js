/*AngularJS*/
var wApp= angular.module('wApp', ['ngRoute', 'ngCookies','ngAnimate','ngResource', 'ngSanitize','ui.bootstrap','angularMoment','nya.bootstrap.select']);
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
//**************************************Usuarios*************************************************//
wApp.controller('UsuariosCtrl',function($scope, $http,ApiUsuarioNuevo, $timeout, $log,$uibModal){

  $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false; //Nuevo usuario
   $scope.editar_obj = false; // Editar Usuario
   $scope.ver_eli = false; // Ver usuarios eliminados
   $scope.acti_rol = false; //Activar para cambiar roles
     $scope.acti_cla = false; //Activar para cambiar contraseña
   $scope.alertaNuevo = false; // Alerta de nuevo usuario registrado
   $scope.alertaExiste = false; // Alerta si el usuario ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de usuario eliminado
    $scope.alertaEditado = false; // Alerta de usuario editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
         $scope.usuario={};
     };


      $http.get('/api/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Roles

            $http.get('/api/roles').success(

              function(roles) {
                        $scope.roles = roles.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      //Restaurar usuarios

      $scope.btn_eliminados= function(){
         $scope.ver_eli = !$scope.ver_eli;
             $http.get('/api/usuarioseli').success(

              function(usuarioseli) {
                        $scope.usuarioseli = usuarioseli.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      };


      //Nuevo Usuario

      $scope.usuario={};
      $scope.guardarUsuario = function(){
         console.log($scope.usuario);

        ApiUsuarioNuevo.save($scope.usuario, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que el usuario ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };
      //Editar Usuario
        $scope.btn_editar = function(usuario) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeUser= usuario;
          $scope.acti_rol = false;
          $scope.acti_cla = false;
       };

       $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
       };

        $scope.act_cla = function() {
          $scope.acti_cla = !$scope.acti_cla;
       };

      $scope.editarUsuario = function(){

            if($scope.acti_rol){
               if($scope.acti_cla){
                          var data = {
                          name: $scope.existeUser.name,
                          nombre: $scope.existeUser.perfil_usuario.nombre,
                          apellido: $scope.existeUser.perfil_usuario.apellido,
                          email: $scope.existeUser.email,
                          role_id: $scope.existeUser.role_id,
                          password: $scope.existeUser.password
                          };
                }else{
                          var data = {
                          name: $scope.existeUser.name,
                          nombre: $scope.existeUser.perfil_usuario.nombre,
                          apellido: $scope.existeUser.perfil_usuario.apellido,
                          email: $scope.existeUser.email,
                          role_id: $scope.existeUser.role_id
                          };
                }
             }else{

                if($scope.acti_cla){
                       var data = {
                        name: $scope.existeUser.name,
                        nombre: $scope.existeUser.perfil_usuario.nombre,
                        apellido: $scope.existeUser.perfil_usuario.apellido,
                        email: $scope.existeUser.email,
                        password: $scope.existeUser.password
                        };
                  }else{

                        var data = {
                        name: $scope.existeUser.name,
                        nombre: $scope.existeUser.perfil_usuario.nombre,
                        apellido: $scope.existeUser.perfil_usuario.apellido,
                        email: $scope.existeUser.email
                        };
                  }
              }

                console.log(data);
                $http.put('api/usuario/' +  $scope.existeUser.id, data)
                .success(function (data, status, headers) {
                   console.log('Usuario '+$scope.existeUser.name+' modificado correctamente.');
                       $http.get('/api/usuarios').success(

                          function(usuarios) {
                                    $scope.usuarios = usuarios.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

        };


      //Eliminar Usuario
      $scope.btn_eliminar = function(id){
        $scope.idusuario= id;
        console.log($scope.idusuario);

         $http.delete('api/usuario/destroy/' +  $scope.idusuario)
            .success(function (data, status, headers) {
               console.log('Usuario '+$scope.idusuario+' borrado correctamente.');
                   $http.get('/api/usuarios').success(

                      function(usuarios) {
                                $scope.usuarios = usuarios.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el usuario.');
            });
      };

      //Regresar usuario
       $scope.btn_restaurar = function(id){
        $scope.idusuario= id;
        console.log($scope.idusuario);

         $http.put('api/usuario/restaurar/' +  $scope.idusuario)
            .success(function (data, status, headers) {
               console.log('Usuario '+$scope.idusuario+' restaurado correctamente.');
                   $http.get('/api/usuarios').success(

                      function(usuarios) {
                                $scope.usuarios = usuarios.datos;
                    }).error(function(error) {
                         $scope.error = error;
                    });
                    //$timeout(function () { $scope.alertaEliminado = true; }, 1000);
                   // $timeout(function () { $scope.alertaEliminado = false; }, 5000);
                   $scope.ver_eli = false;
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el usuario.');
            });
      };


});


//************************************Proveedores**********************************************//
wApp.controller('ProveedoresCtrl',function($scope, $http,ApiProveedorNuevo, $timeout, $log,$uibModal){

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

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.proveedor={};
     };


     //Todos los proveedores
      $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Nuevo Proveedor

      $scope.proveedor={};
      $scope.guardarProveedor = function(){
         // console.log($scope.usuario);

        ApiProveedorNuevo.save($scope.proveedor, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
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

       //Eliminar Proveedor
      $scope.btn_eliminar = function(id){
        $scope.idproveedor= id;
        console.log($scope.idproveedor);

         $http.delete('api/proveedor/destroy/' +  $scope.idproveedor)
            .success(function (data, status, headers) {
               console.log('Proveedor '+$scope.idproveedor+' borrado correctamente.');
                   $http.get('/api/proveedores').success(

                        function(proveedores) {
                        $scope.proveedores = proveedores.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el proveedor.');
            });
      };

       //Editar Proveedor
        $scope.btn_editar = function(proveedor) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeProve= proveedor;
       };


      $scope.editarProveedor = function(){
                var data = {
                  empresa: $scope.existeProve.empresa,
                  encargado: $scope.existeProve.encargado,
                  nit: $scope.existeProve.nit,
                  direccion: $scope.existeProve.direccion,
                  telefono: $scope.existeProve.telefono,
                  telefono_encargado: $scope.existeProve.telefono_encargado,
                  email_encargado: $scope.existeProve.email_encargado
                };
                // console.log(data);
                $http.put('api/proveedor/' +  $scope.existeProve.id, data)
                .success(function (data, status, headers) {
                   console.log('Proveedor '+$scope.existeProve.empresa+' modificado correctamente.');
                       $http.get('/api/proveedores').success(
                          function(proveedores) {
                                    $scope.proveedores = proveedores.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

        };


});

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


   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.producto={};
     };

    $scope.btn_linea = function() {
        $scope.linea_obj = !$scope.linea_obj;
       $scope.linea={};
     };

       //Lineas de productos
       $http.get('/api/lineaproductos').success(

              function(lineas) {
                        $scope.lineas = lineas.datos;
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
                                 console.log( producto.stock);
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
                  preciop: $scope.existeProducto.preciop
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



//************************************Compras**********************************************//
wApp.controller('ComprasCtrl',function($scope, $http,ApiCompraNuevo, $timeout, $log,$uibModal){

   $scope.status = {
    isopen: false
  };


  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
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

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false; //Nuevo proveedor
   $scope.editar_obj = false; // Editar proveedor
   $scope.mas_obj= false;
   $scope.ver_eli = false; // Ver proveedores eliminados
   $scope.alertaNuevo = false; // Alerta de nuevo proveedor registrado
   $scope.alertaExiste = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.compra={};
     };


     //Todos los proveedores
      $http.get('/api/proveedores').success(

              function(proveedores) {
                        $scope.proveedores = proveedores.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

       //Todas las compras
      $http.get('/api/compras').success(

              function(compras) {
                        $scope.compras = compras.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      $scope.estimadas=[
         {'id': '10','nombre': '10 dias'},
         {'id': '15','nombre': '15 dias'},
         {'id': '30','nombre': '30 dias'},
         {'id': '60','nombre': '60 dias'}
      ];
      //Nueva Compra

      $scope.compra={};
      $scope.guardarCompra = function(){
           $scope.nuevo_obj = false;

           $scope.procompra={};

           var datacompra = {
              id_proveedor: $scope.compra.id_proveedor,
              fecha_entrega: $scope.compra.fecha_entrega
            };

           $http.post('/api/compra/create', datacompra)
            .success(function (data, status, headers) {
                  $scope.midata=data.id_user;
                   console.log($scope.midata);
                    $http.get('/api/compras').success(

                        function(compras) {
                                  $scope.compras = compras.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
                  $timeout(function () { $scope.alertaNuevo = true; }, 1000);
                   $timeout(function () { $scope.alertaNuevo = false; }, 5000);
               })
            .error(function (data, status, header, config) {
                console.log("Parece que el producto ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });




      };

      $scope.abrircompra= function(com,de){
          $scope.mas_obj = !$scope.mas_obj;

          $scope.de=de;
             $scope.exisCompra=com;
             $scope.miorden=com.id;


          $scope.ProTotal = 0;
            $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

          //Productos
          $http.get('/api/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

         $http.get('/api/procompras/'+$scope.miorden).success(

            function(procompras) {
                      $scope.procompras = procompras.datos;
          }).error(function(error) {
               $scope.error = error;
              });

          //Agregar producto
           $scope.procompra={};
            $scope.guardarProCompra = function(){

                    var dataprocompra={
                          id_orden:  $scope.miorden,
                          id_producto: $scope.procompra.id_producto,
                          cantidad: $scope.procompra.cantidad,
                    };
                     $http.post('/api/procompra/create', dataprocompra)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };

             //Editar Productos Compra
             $scope.btn_editarl = function(procompra) {
                $scope.existePro= procompra;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad,
                  id_producto: $scope.existePro.id_producto
                };
               // console.log(data);
                $http.put('api/procompra/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                               $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                               $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar la compra.');
                    });
              };

           //Eliminar Productos Compra
              $scope.btn_proeliminar = function(id){
                $scope.idprocompra= id;
                 $http.delete('api/procompra/destroy/' +  $scope.idprocompra)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.idprocompra+' borrado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                            $timeout(function () { $scope.alertaEliminadoPro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadoPro = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar la compra.');
                    });
              };

             //Eliminar Productos Compra restando el total en la Orden
              $scope.btn_proeliminar2 = function(id){
                $scope.idprocompra= id;
                 $http.delete('api/procompra/destroy2/' +  $scope.idprocompra)
                    .success(function (data, status, headers) {
                       console.log('Producto de Compra '+$scope.idprocompra+' borrado correctamente.');

                          $http.get('/api/procompras/'+$scope.miorden).success(

                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                            $timeout(function () { $scope.alertaEliminadoPro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadoPro = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar la compra.');
                    });
              };

              //Enviar Paso 1
              $scope.enviarCompra=function(){
                     $http.post('api/compra/p1/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' modificada correctamente en el paso 1.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.mas_obj = false;

                                 /*  $timeout(function () { $scope.alertaEditadop1 = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadop1 = false; }, 5000);*/
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });

              };

               //Enviar productos pendientes
              $scope.pendienteCompra=function(){
                     $http.post('api/compra/pen/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' modificada correctamente en el paso 1.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.mas_obj = false;

                                 /*  $timeout(function () { $scope.alertaEditadop1 = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadop1 = false; }, 5000);*/
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });

              };

              //Enviar Producto a bodega

                $scope.procompra={};
              $scope.agregarProBodega=function(procompra){
                $scope.procompra=procompra;
                  var envpro={
                      id_orden:$scope.procompra.id_orden,
                      id_producto:$scope.procompra.id_producto,
                      cantidad: $scope.procompra.cantidad,
                      id_procompra: $scope.procompra.id
                  };
                  console.log(envpro);
                   $http.post('/api/procompra/envioproducto', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                                 console.log('Producto enviado a bodega central.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };

                 $scope.propcompra={};
              $scope.agregarProBodegaPen=function(propcompra){
                $scope.propcompra=propcompra;
                  var envpro={
                      id_orden:$scope.propcompra.id_orden,
                      id_producto:$scope.propcompra.id_producto,
                      cantidad: $scope.propcompra.pendiente_producto.cantidad,
                      id_procompra: $scope.propcompra.id
                  };
                  console.log(envpro);
                  $http.post('/api/procompra/envioproductopen', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/procompras/'+$scope.miorden).success(
                                    function(procompras) {
                                              $scope.procompras = procompras.datos;
                                                 console.log('Producto enviado a bodega central.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.procompra={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };



              //Finalizar Compra
               $scope.finalizarCompra=function(){
                     $http.put('api/compra/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Compra No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('/api/compras').success(

                                      function(compras) {
                                                $scope.compras = compras.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.mas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });

              };


      };

       //Eliminar Compra
      $scope.btn_eliminar = function(id){
        $scope.idcompra= id;
         $http.delete('api/compra/destroy/' +  $scope.idcompra)
            .success(function (data, status, headers) {
               console.log('Compra No.'+$scope.idcompra+' borrado correctamente.');
                   $http.get('/api/compras').success(

                        function(compras) {
                        $scope.compras = compras.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la compra.');
            });
      };



       //Editar Compra
        $scope.btn_editar = function(compra) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeCompra= compra;
       };


      $scope.editarCompra = function(){
                var data = {
                  id_proveedor: $scope.existeCompra.id_proveedor,
                  fecha_entrega: $scope.existeCompra.fecha_entrega2
                };
                // console.log(data);
                $http.put('api/compra/' +  $scope.existeCompra.id, data)
                .success(function (data, status, headers) {
                   console.log('Compra #'+$scope.existeCompra.id+' modificado correctamente.');
                       $http.get('/api/compras').success(
                          function(compras) {
                                    $scope.compras = compras.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar la compra.');
                });

        };


});

//************************************Sucursales**********************************************//
wApp.controller('SucursalesCtrl',function($scope, $http,ApiSucursalNuevo, $timeout, $log,$uibModal){

   $scope.status = {
    isopen: false
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };

  $scope.appendToEl = angular.element(document.querySelector('#dropdown-long-content'));


   $scope.nuevo_obj = false;
   $scope.editar_obj = false;
   $scope.mas_obj= false;
     $scope.abmas_obj= false;
   $scope.opcion_obj= false;
   $scope.ver_eli = false;
   $scope.alertaNuevo = false;
   $scope.alertaExiste = false;
   $scope.alertaEliminado = false;
   $scope.alertaEliminadopro = false;
   $scope.alertaEditado = false;

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.sucursal={};
     };
  $scope.deselec=function(){
    $scope.busfiltro='';
  }

     //Todos las sucursales
      $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

         //Todos los usuarios
      $http.get('/api/sucursales/usuarios').success(

              function(usuarios) {
                        $scope.usuarios = usuarios.datos;
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

            $scope.elstock=function(id){
              $scope.idpro=id;
                   $http.get('/api/sucursales/stockproducto/'+$scope.idpro).success(

                    function(stock) {
                              $scope.stock = stock.datos;
                  }).error(function(error) {
                       $scope.error = error;
                  });
            };

      //Envios
        $http.get('/api/envios').success(

          function(envios) {
                    $scope.envios = envios.datos;
        }).error(function(error) {
             $scope.error = error;
        });

      //Nueva Sucursal

      $scope.sucursal={};
      $scope.guardarSucursal = function(){
         // console.log($scope.usuario);

        ApiSucursalNuevo.save($scope.sucursal, function(){
          console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/sucursales').success(

              function(sucursales) {
                        $scope.sucursales = sucursales.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
          },
          function(error){
            console.log("Parece que la sucursal ya existe");
            $timeout(function () { $scope.alertaExiste = true; }, 100);
            $timeout(function () { $scope.alertaExiste = false; }, 5000);
          });

      };

       //Eliminar Sucursal
      $scope.btn_eliminar = function(id){
        $scope.idsucursal= id;
        console.log($scope.idsucursal);

         $http.delete('api/sucursal/destroy/' +  $scope.idsucursal)
            .success(function (data, status, headers) {
               console.log('Sucursal '+$scope.idsucursal+' borrado correctamente.');
                   $http.get('/api/sucursales').success(

                        function(sucursales) {
                        $scope.sucursales = sucursales.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar la sucursal.');
            });
      };

       //Editar Sucursal
        $scope.btn_editar = function(sucursal) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeSucu= sucursal;
       };


      $scope.editarSucursal = function(){
                var data = {
                  nombre: $scope.existeSucu.nombre,
                  ubicacion: $scope.existeSucu.ubicacion,
                  serie: $scope.existeSucu.serie,
                  id_user: $scope.existeSucu.id_user
                };
                 console.log(data);
                $http.put('api/sucursal/' +  $scope.existeSucu.id, data)
                .success(function (data, status, headers) {
                   console.log('Sucursal '+$scope.existeSucu.nombre+' modificada correctamente.');
                       $http.get('/api/sucursales').success(
                          function(sucursales) {
                                    $scope.sucursales = sucursales.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

        };

    //Abrir Sucursal
    $scope.abrirsucursal= function(sucursal){
          $scope.mas_obj = !$scope.mas_obj;

           $scope.exisSucursal=sucursal;
           $scope.miid=sucursal.id;

             $scope.btn_cerrarc=function(){
             $scope.mas_obj = false;
           };

           $scope.prosucursal={};

             $http.get('/api/prosucursales/'+$scope.miid).success(
                function(prosucursales) {
                          $scope.prosucursales = prosucursales.datos;
              }).error(function(error) {
                   $scope.error = error;
              });
   };

    //Nuevo Envio
    $scope.btn_envio= function(){
          $scope.opcion_obj = !$scope.opcion_obj;


             $scope.btn_cerraro=function(){
             $scope.opcion_obj = false;
           };


   };


      //Nuevo Envio
      $scope.envio={};
      $scope.guardarEnvio = function(){
           $scope.opcion_obj = false;

           $scope.proenvio={};

           var dataenvio = {
              id_sucursal: $scope.envio.id_sucursal
            };

           $http.post('/api/envio/create', dataenvio)
            .success(function (data, status, headers) {
                console.log("Orden de envio creada correctamente");
                    $http.get('/api/envios').success(

                        function(envios) {
                                  $scope.envios = envios.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
                  $timeout(function () { $scope.alertaNuevo = true; }, 1000);
                   $timeout(function () { $scope.alertaNuevo = false; }, 5000);
               })
            .error(function (data, status, header, config) {
                console.log("Parece que el envio ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });
      };


    //Area de envios
    $scope.abrirorden= function(envio){
          $scope.abmas_obj = !$scope.abmas_obj;


             $scope.btn_cerrarab=function(){
                 $scope.abmas_obj = false;
            };

           $scope.exisEnvio=envio;
           $scope.miorden=envio.id;


            //Productos
              $http.get('/api/proenvios/'+$scope.miorden).success(
                    function(proenvios) {
                              $scope.proenvios = proenvios.datos;
                             // console.log($scope.proenvios);
                  }).error(function(error) {
                       $scope.error = error;
                  });

           //Agregar producto
           $scope.proenvio={};
           $scope.guardarProEnvio = function(){

                    var dataproenvio={
                          id_orden:  $scope.miorden,
                          id_producto: $scope.proenvio.id_producto,
                          cantidad: $scope.proenvio.cantidad,
                    };
                     $http.post('/api/proenvio/create', dataproenvio)
                        .success(function (data, status, headers) {
                               $http.get('/api/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                              //console.log($scope.proenvios);
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });
             };

             //Editar Productos Envio
             $scope.btn_editarl = function(proenvio) {
                $scope.existePro= proenvio;
             };
              $scope.btn_proeditar = function(id){
                 var dataproenvio = {
                        cantidad: $scope.existePro.cantidad,
                        id_producto: $scope.existePro.id_producto
                    };

                $http.put('api/proenvio/' +  $scope.existePro.id,dataproenvio)
                    .success(function (data, status, headers) {
                       console.log('Producto de Envio '+$scope.existePro.id+' editado correctamente.');

                          $http.get('/api/proenvios/'+$scope.miorden).success(

                                  function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                   $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                                   $timeout(function () { $scope.alertaEditadol = false; }, 5000);

                                   //Envios
                                  $http.get('/api/envios').success(

                                    function(envios) {
                                              $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                          })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar el envio.');
                      });

              };

               //Eliminar Producto de envios
              $scope.btn_proeliminar = function(id){
                    $scope.idpro= id;
                    //console.log($scope.idpro);

                     $http.delete('api/proenvio/destroy/' +  $scope.idpro)
                      .success(function (data, status, headers) {
                           console.log('Producto de envio #'+$scope.idpro+' borrado correctamente.');
                               $http.get('/api/proenvios/'+$scope.miorden).success(

                                 function(proenvios) {
                                         $scope.proenvios = proenvios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                      })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar la sucursal.');
                      });
              };

              //Enviar orden a sucursal
              $scope.enviarEnvio= function(){
                     $http.post('api/envio/p1/' +  $scope.miorden)
                      .success(function (data, status, headers) {
                           console.log('Orden enviada a Sucursal #'+$scope.miorden);
                               $http.get('api/envios/').success(

                                 function(envios) {
                                         $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                  $scope.abmas_obj = false;
                      })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar la sucursal.');
                      });
              };

               //Finalizar Envio
               $scope.completarEnvio=function(){
                     $http.put('/api/envio/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Envio No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('api/envios/').success(

                                 function(envios) {
                                         $scope.envios = envios.datos;
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                   $scope.abmas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });
               }; 


   };//Termina abrirorden

});



//************************************Clientes**********************************************//
wApp.controller('ClientesCtrl',function($scope, $http, $timeout, $log,$uibModal){

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

   $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
       $scope.cliente={};
     };

   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Empresa'},
        ];

     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Nuevo Cliente

      $scope.cliente={};
      $scope.guardarCliente = function(){
         // console.log($scope.usuario);

          var datacliente = {
              empresa: $scope.cliente.empresa,
              nombre: $scope.cliente.nombre,
              nit: $scope.cliente.nit,
              direccion: $scope.cliente.direccion,
              telefono: $scope.cliente.telefono,
              celular: $scope.cliente.celular,
              email: $scope.cliente.email,
              tipo_cliente: $scope.cliente.tipo_cliente
            };

        $http.post('/api/cliente/create', datacliente)
          .success(function (data, status, headers) {
           console.log("Guardado correctamente");
           $scope.nuevo_obj = false;
           $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });
            $timeout(function () { $scope.alertaNuevo = true; }, 1000);
            $timeout(function () { $scope.alertaNuevo = false; }, 5000);
           })
            .error(function (data, status, header, config) {
                console.log("Parece que el cliente ya existe");
                $timeout(function () { $scope.alertaExiste = true; }, 100);
                $timeout(function () { $scope.alertaExiste = false; }, 5000);
            });

        };

       //Eliminar Cliente
      $scope.btn_eliminar = function(id){
        $scope.idcliente= id;
        console.log($scope.idcliente);

         $http.delete('api/cliente/destroy/' +  $scope.idcliente)
            .success(function (data, status, headers) {
               console.log('Cliente '+$scope.idcliente+' borrado correctamente.');
                   $http.get('/api/clientes').success(

                        function(clientes) {
                        $scope.clientes = clientes.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el proveedor.');
            });
      };

       //Editar Cliente
        $scope.btn_editar = function(cliente) {
          $scope.editar_obj = !$scope.editar_obj;
          $scope.existeCliente= cliente;
       };


      $scope.editarCliente = function(){
                var data = {
                  empresa: $scope.existeCliente.empresa,
                  nombre: $scope.existeCliente.nombre,
                  nit: $scope.existeCliente.nit,
                  direccion: $scope.existeCliente.direccion,
                  telefono: $scope.existeCliente.telefono,
                  celular: $scope.existeCliente.celular,
                  email: $scope.existeCliente.email,
                  tipo_cliente: $scope.existeCliente.tipo_cliente
                };
                // console.log(data);
                $http.put('api/cliente/' +  $scope.existeCliente.id, data)
                .success(function (data, status, headers) {
                   console.log('Cliente '+$scope.existeCliente.nombre+' modificado correctamente.');
                       $http.get('/api/clientes').success(
                          function(clientes) {
                                    $scope.clientes = clientes.datos;
                        }).error(function(error) {
                             $scope.error = error;
                        });
                       $scope.editar_obj = false;
                        $timeout(function () { $scope.alertaEditado = true; }, 1000);
                        $timeout(function () { $scope.alertaEditado = false; }, 5000);
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

        };


});

//************************************Venta**********************************************//
wApp.controller('VentasCtrl',function($scope, $http, $timeout, $log,$uibModal){

   //Todos las ventas
      $http.get('/api/ventas').success(

              function(ventas) {
                        $scope.ventas = ventas.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

       //Eliminar Proveedor
      $scope.btn_eliminar = function(id){
        $scope.idventa= id;
        console.log($scope.idventa);

         $http.delete('api/venta/destroy/' +  $scope.idventa)
            .success(function (data, status, headers) {
               console.log('Venta '+$scope.idventa+' borrada correctamente.');
                   $http.get('/api/ventas').success(

                        function(ventas) {
                        $scope.ventas = ventas.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el proveedor.');
            });
      };       

});
//************************************Venta N**********************************************//
wApp.controller('VentaNCtrl',function($scope, $http, $timeout, $log,$uibModal, $location,$window){
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
   $scope.alertaExistePro = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.acti_venta=true;
   $scope.termi_venta=false;
   $scope.acti_rol=false;
   $scope.acti_cliente=false;
   $scope.acti_areapro=false;


     $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
           $scope.acti_cliente=false;
       };

      $scope.act_cliente = function() {
          $scope.acti_cliente =true;
       };



   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Empresa'},
        ];

   $scope.tpagos=[
        {id:'1',pago:'Efectivo'},
        {id:'2',pago:'POS/Tarjeta'},
  ];

  $scope.tfacs=[
        {id:'1',factura:'Impresa'},
        {id:'2',factura:'Electrónica'},
  ];

     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });


      //Nuevo Cliente

      $scope.cliente={};
      $scope.guardarClienteCrear = function(){

               var dataventa={
                        empresa: $scope.cliente.empresa,
                        nombre: $scope.cliente.nombre,
                        nit: $scope.cliente.nit,
                        direccion: $scope.cliente.direccion,
                        telefono: $scope.cliente.telefono,
                        celular: $scope.cliente.celular,
                        email: $scope.cliente.email,
                        tipo_cliente: $scope.cliente.tipo_cliente
                    };
                    console.log(dataventa);
                    $http.post('/api/ventacliente/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };


       //Productos
          $http.get('/api/productos').success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      $scope.elstock=function(id){
            $scope.idpro=id;
                 $http.get('/api/ventas/stockproducto/'+$scope.idpro).success(

                  function(stock) {
                            $scope.stock = stock.datos;
                }).error(function(error) {
                     $scope.error = error;
                });
        };


        //Nueva Venta

      $scope.venta={};
      $scope.nuevaVenta = function(){

                    var dataventa={
                          id_cliente:  $scope.venta.cliente.id
                    };
                    console.log(dataventa);
                    $http.post('/api/ventacentral/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };
      $scope.agregarProductos=function(idventa){
        $scope.idventa=idventa;
        console.log($scope.idventa);

               //Mi Venta
                $http.get('/api/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
              $scope.proventa={};
              $scope.guardarProVenta=function(){
                      var datapro={
                           id_ventas:  $scope.idventa,
                           id_producto: $scope.proventa.id_producto,
                           cantidad: $scope.proventa.cantidad,
                      };
                      console.log(datapro);

                       $http.post('/api/ventaproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar el producto");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });


              };

              //Editar Producto Venta
             $scope.btn_editarl = function(mipro) {
                $scope.existePro= mipro;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad
                };
                console.log(data);
                $http.put('api/proventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                               $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                               $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };


               //Eliminar Producto Venta
              $scope.btn_proeliminar = function(id){
                $scope.idproventa= id;
                console.log($scope.idproventa);

                 $http.delete('api/proventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };
      };
      $scope.factura={};
      $scope.btn_facturar=function(){
            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_tfac: $scope.factura.tipo_factura,
                id_ventas: $scope.idventa,
            };
            console.log(datafact);

               $http.post('/api/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                               $scope.acti_venta=false;
                               $scope.termi_venta=true;
                               //  $window.location.href = '/ventas';
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al enviar la factura");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });
      };


      $scope.iraventas=function(){
            $window.location.href = '/ventas';
      }


});



//************************************Mi Sucursal**********************************************//
wApp.controller('MiSucursalCtrl',function($scope, $http, $timeout, $log,$uibModal){

    $scope.abmas_obj = false;
   //MiUsuario
      $http.get('api/mi/miusuario').success(

              function(miusuario) {
                        $scope.miusuario = miusuario.datos;
                       
                        $scope.actsucu($scope.miusuario.sucursal_usuario.id);
            }).error(function(error) {
                 $scope.error = error;
            });

     $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu;

            $http.get('api/mi/misenvios/'+$scope.misucu).success(

              function(misenvios) {
                        $scope.misenvios = misenvios.datos;
                       //console.log($scope.misenvios);
            }).error(function(error) {
                 $scope.error = error;
            });

        //Abrir Envios
        $scope.abrirorden= function(envio){

               $scope.abmas_obj = !$scope.abmas_obj;


                 $scope.btn_cerrarab=function(){
                     $scope.abmas_obj = false;
                };

                 $scope.exisEnvio=envio;
                    //console.log($scope.exisEnvio);
                 $scope.miorden=envio.id;

              //Productos
              $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                    function(proenvios) {
                              $scope.proenvios = proenvios.datos;
                              //console.log($scope.proenvios);
                  }).error(function(error) {
                       $scope.error = error;
                  });

              //Enviar Producto a bodega

              $scope.proenvio={};
              $scope.agregarProBodega=function(proenvio){
                $scope.proenvio=proenvio;
                  var envpro={
                      id_sucursal: $scope.misucu,
                      id_orden:$scope.proenvio.id_orden,
                      id_producto:$scope.proenvio.id_producto,
                      cantidad: $scope.proenvio.cantidad,
                      id_proenvio: $scope.proenvio.id
                  };
                  console.log(envpro);
                   $http.post('/api/mi/proenvio/envioproducto', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };//Fin agregarprobodega

               $scope.agregarProBodegaPen=function(proenvio){
                $scope.proenvio=proenvio;
                  var envpro={
                      id_sucursal: $scope.misucu,
                      id_orden:$scope.proenvio.id_orden,
                      id_producto:$scope.proenvio.id_producto,
                      cantidad: $scope.proenvio.cantidad,
                      id_proenvio: $scope.proenvio.id
                  };
                  //console.log(envpro);
                   $http.post('/api/mi/proenvio/envioproductopen', envpro)
                        .success(function (data, status, headers) {
                               $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                                    $scope.proenvio={};
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que el producto de compra  ya existe");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

              };//Fin agregarprobodegaPen

              //Finalizar Envio
               $scope.completarEnvio=function(){
                     $http.put('/api/mi/envio/p2/' + $scope.miorden)
                        .success(function (data, status, headers) {
                           console.log('Envio No.'+$scope.miorden+' finalizada correctamente.');
                               $http.get('/api/mi/misenvios/'+$scope.misucu).success(

                                      function(misenvios) {
                                                $scope.misenvios = misenvios.datos;

                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                                   $scope.abmas_obj = false;
                        })
                        .error(function (data, status, header, config) {
                            console.log('Parece que existe un error al modificar la compra.');
                        });
               }; 

                 //Eliminar Productos Envio restando el total en la Orden
                $scope.btn_proeliminar2 = function(id){
                  $scope.idproenvio= id;
                   $http.delete('api/mi/proenvio/destroy/' +  $scope.idproenvio)
                      .success(function (data, status, headers) {
                         console.log('Producto de Envio '+$scope.idproenvio+' borrado correctamente.');

                              $http.get('/api/mi/proenvios/'+$scope.miorden).success(
                                    function(proenvios) {
                                              $scope.proenvios = proenvios.datos;
                                                 console.log('Producto enviado a bodega de sucursal.');
                                  }).error(function(error) {
                                       $scope.error = error;
                                  });
                              $timeout(function () { $scope.alertaEliminadoPro = true; }, 1000);
                              $timeout(function () { $scope.alertaEliminadoPro = false; }, 5000);
                      })
                      .error(function (data, status, header, config) {
                          console.log('Parece que existe un error al borrar la compra.');
                      });
                }; 

          };   


       };      


});


//************************************Venta N**********************************************//
wApp.controller('MiVentaNCtrl',function($scope, $http, $timeout, $log,$uibModal, $location){
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
   $scope.alertaExistePro = false; // Alerta si el proveedor ya esta en existencia
   $scope.alertaEliminado = false; // Alerta de proveedor eliminado
   $scope.alertaEditado = false; // Alerta de proveedor editado
   $scope.acti_venta=true;
   $scope.termi_venta=false;
   $scope.acti_rol=false;
    $scope.acti_cliente=false;
    $scope.acti_areapro=false;

     $scope.act_rol = function() {
          $scope.acti_rol = !$scope.acti_rol;
           $scope.acti_cliente=false;
       };

      $scope.act_cliente = function() {
          $scope.acti_cliente =true;
       };





   $scope.tipos=[
        {id:'1',cliente:'Individual'},
        {id:'2',cliente:'Empresa'},
        ];

   $scope.tpagos=[
        {id:'1',pago:'Efectivo'},
        {id:'2',pago:'POS/Tarjeta'},
  ];

  $scope.tfacs=[
        {id:'1',factura:'Impresa'},
        {id:'2',factura:'Electrónica'},
  ];

     //Todos los clientes
      $http.get('/api/clientes').success(

              function(clientes) {
                        $scope.clientes = clientes.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

     //MiUsuario
      $http.get('api/mi/miusuario').success(

              function(miusuario) {
                        $scope.miusuario = miusuario.datos;
                       
                        $scope.actsucu($scope.miusuario.sucursal_usuario.id);
            }).error(function(error) {
                 $scope.error = error;
            }); 

  $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu;       


      //Nuevo Cliente

        $scope.cliente={};
        $scope.guardarClienteCrear = function(){

               var dataventa={
                        empresa: $scope.cliente.empresa,
                        nombre: $scope.cliente.nombre,
                        nit: $scope.cliente.nit,
                        direccion: $scope.cliente.direccion,
                        telefono: $scope.cliente.telefono,
                        celular: $scope.cliente.celular,
                        email: $scope.cliente.email,
                        tipo_cliente: $scope.cliente.tipo_cliente
                    };
                    console.log(dataventa);
                    $http.post('/api/mi/ventacliente/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

          };


       //Productos
          $http.get('/api/mi/productos/'+ $scope.misucu).success(

              function(productos) {
                        $scope.productos = productos.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

      $scope.elstock=function(id){
            $scope.idpro=id;
                 $http.get('/api/mi/ventas/stockproducto/'+$scope.misucu+'/'+$scope.idpro).success(

                  function(stock) {
                            $scope.stock = stock.datos;
                }).error(function(error) {
                     $scope.error = error;
                });
        };


        //Nueva Venta

      $scope.venta={};
      $scope.nuevaVenta = function(){

                    var dataventa={
                          id_cliente:  $scope.venta.cliente.id,
                          id_sucursal:  $scope.misucu
                    };
                    console.log(dataventa);
                    $http.post('/api/mi/venta/create', dataventa)
                        .success(function (data, status, headers) {
                             $scope.id_venta=data.id_venta;
                             $scope.agregarProductos($scope.id_venta);
                             $scope.acti_areapro =true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar la venta");
                            $timeout(function () { $scope.alertaExiste = true; }, 100);
                            $timeout(function () { $scope.alertaExiste = false; }, 5000);
                        });

      };
      $scope.agregarProductos=function(idventa){
        $scope.idventa=idventa;
        console.log($scope.idventa);

               //Mi Venta
                $http.get('/api/mi/miventa/'+$scope.idventa).success(

                        function(miventa) {
                                  $scope.miventa = miventa.datos;
                      }).error(function(error) {
                           $scope.error = error;
                      });
              $scope.proventa={};
              $scope.guardarProVenta=function(){
                      var datapro={
                           id_ventas:  $scope.idventa,
                           id_producto: $scope.proventa.id_producto,
                           cantidad: $scope.proventa.cantidad,
                      };
                      console.log(datapro);

                       $http.post('/api/mi/ventaproducto/create', datapro)
                        .success(function (data, status, headers) {
                              console.log("Producto agregado correctamente");

                                $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                        function(misproductos) {
                                                  $scope.misproductos = misproductos.datos;
                                      }).error(function(error) {
                                           $scope.error = error;
                                      });
                                  $scope.proventa={};

                                  //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });

                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al guardar el producto");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });


              };

              //Editar Producto Venta
             $scope.btn_editarl = function(mipro) {
                $scope.existePro= mipro;
             };
              $scope.btn_proeditar = function(id){
                 var data = {
                  cantidad: $scope.existePro.cantidad
                };
                console.log(data);
                $http.put('api/mi/proventa/' +  $scope.existePro.id,data)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.existePro.nombre_producto.codigo+' editado correctamente.');

                            $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                               $timeout(function () { $scope.alertaEditadol = true; }, 1000);
                               $timeout(function () { $scope.alertaEditadol = false; }, 5000);
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };


               //Eliminar Producto Venta
              $scope.btn_proeliminar = function(id){
                $scope.idproventa= id;
                console.log($scope.idproventa);

                 $http.delete('api/mi/proventa/destroy/' +  $scope.idproventa)
                    .success(function (data, status, headers) {
                       console.log('Producto '+$scope.idproventa+' borrado correctamente.');
                           $http.get('/api/mi/miproducto/'+$scope.idventa).success(

                                function(misproductos) {
                                $scope.misproductos = misproductos.datos;
                                    }).error(function(error) {
                                         $scope.error = error;
                                    });
                            $timeout(function () { $scope.alertaEliminadopro = true; }, 1000);
                            $timeout(function () { $scope.alertaEliminadopro = false; }, 5000);

                              //Mi Venta
                                  $http.get('/api/mi/miventa/'+$scope.idventa).success(

                                          function(miventa) {
                                                    $scope.miventa = miventa.datos;
                                        }).error(function(error) {
                                             $scope.error = error;
                                        });
                    })
                    .error(function (data, status, header, config) {
                        console.log('Parece que existe un error al borrar el producto.');
                    });
              };
      };
      $scope.factura={};
      $scope.btn_facturar=function(){
            var datafact={
                id_tpago: $scope.factura.tipo_pago,
                referencia: $scope.factura.referencia,
                id_tfac: $scope.factura.tipo_factura,
                id_ventas: $scope.idventa,
            };
            console.log(datafact);

               $http.post('/api/mi/factura/create', datafact)
                        .success(function (data, status, headers) {
                              console.log("Factura creada correctamente");
                                 $scope.acti_venta=false;
                                 $scope.termi_venta=true;
                           })
                        .error(function (data, status, header, config) {
                            console.log("Parece que hay error al enviar la factura");
                            $timeout(function () { $scope.alertaExistePro = true; }, 100);
                            $timeout(function () { $scope.alertaExistePro = false; }, 5000);
                        });
      };

  };
      
});

//************************************Mis productos**********************************************//
wApp.controller('MisProductosCtrl',function($scope, $http,ApiLineaNuevo,ApiProductoNuevo, $timeout, $log,$uibModal,$interval){

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
                       
                        $scope.actsucu($scope.miusuario.sucursal_usuario.id);
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

     };



});

//************************************Venta**********************************************//
wApp.controller('MisVentasCtrl',function($scope, $http, $timeout, $log,$uibModal){

      //MiUsuario
      $http.get('api/mi/miusuario').success(

              function(miusuario) {
                        $scope.miusuario = miusuario.datos;
                       
                        $scope.actsucu($scope.miusuario.sucursal_usuario.id);
            }).error(function(error) {
                 $scope.error = error;
            }); 

    $scope.actsucu=function(idsucu){

      //Id Sucursal
          $scope.misucu=idsucu;            

   //Todos las ventas
      $http.get('/api/mi/ventas/'+ $scope.misucu).success(

              function(ventas) {
                        $scope.ventas = ventas.datos;
            }).error(function(error) {
                 $scope.error = error;
            });

       //Eliminar venta 
      $scope.btn_eliminar = function(id){
        $scope.idventa= id;
        console.log($scope.idventa);

         $http.delete('api/mi/venta/destroy/' +  $scope.idventa)
            .success(function (data, status, headers) {
               console.log('Venta '+$scope.idventa+' borrada correctamente.');
                   $http.get('/api/mi/ventas/'+ $scope.misucu).success(

                        function(ventas) {
                        $scope.ventas = ventas.datos;
                            }).error(function(error) {
                                 $scope.error = error;
                            });
                    $timeout(function () { $scope.alertaEliminado = true; }, 1000);
                    $timeout(function () { $scope.alertaEliminado = false; }, 5000);
            })
            .error(function (data, status, header, config) {
                console.log('Parece que existe un error al borrar el proveedor.');
            });
      };   

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
