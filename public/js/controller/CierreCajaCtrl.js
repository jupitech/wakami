//************************************Cierre de Caja**********************************************//
wApp.controller('CierreCajaCtrl',function($scope, $http, $timeout, $log,$uibModal,$location,$window){

    $scope.api='';
    
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
    $scope.existeCierre = false;
    $scope.mandarsaldo = true;
    $scope.mandardepo = false;
    $scope.estadoMandar = 1;
    $scope.imprimir = false;

    $scope.btn_nuevo = function() {
        $scope.nuevo_obj = !$scope.nuevo_obj;
        $scope.cierres_hoy ={};
        $scope.cierres = {};
        $scope.proveedor={};
    };

  

        $scope.btn_saldo = function(){            
            $scope.mandarsaldo = true;
            $scope.mandardepo = false;
            $scope.estadoMandar = 1;
            console.log("Mandar a saldo",$scope.mandarsaldo);
        };
        $scope.btn_depositar = function(){
            $scope.mandarsaldo = false;
            $scope.mandardepo = true;
            $scope.estadoMandar = 2;
            console.log("Mandar a deposito",$scope.mandardepo);
        };

    //MiUsuario
    $http.get($scope.api+'/api/mi/miusuario').success(

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

          $http.get($scope.api+'/api/mi/estadocierre/'+$scope.misucu).success(
        function(cierre) {
            $scope.cierre = cierre.datos;

            console.log($scope.cierre);
            if ($scope.cierre) {
                $scope.existeCierre = true;
            };
        }).error(function(error) {
        $scope.error = error;
    });

        //Trayendo Datos de la sucursal
        $http.get($scope.api+'/api/mi/sucursalcierre/'+$scope.misucu).success(

            function(datasucursal) {
                $scope.datasucursal = datasucursal.datos;
                console.log($scope.datasucursal);                

                $http.get($scope.api+'/api/mi/ventasdia/'+$scope.misucu).success(
                        function(ventasdia) {
                            $scope.ventasdia = ventasdia.datos;
                            console.log($scope.ventasdia);                
                        }).error(function(error) {            
                            $scope.error = error;
                    });
            }).error(function(error) {            
                $scope.error = error;
        });



        $scope.cierre_p1=true;

        //Buscando saldo actual
        $http.get($scope.api+'/api/mi/bsaldo/'+$scope.misucu).success(

            function(bsaldo) {
                $scope.bsaldo = bsaldo.datos;
                console.log(bsaldo);
                console.log('Saldo actual: ',$scope.bsaldo.efectivo);
            }).error(function(error) {

            $scope.bsaldo = 0;
            $scope.error = error;
        });

        //TOTAL VENTAS EFECTIVO
        $http.get($scope.api+'/api/mi/totventaefec/'+$scope.misucu).success(
            function(totalefectivo) {
                if (totalefectivo.datos.length == '' ){
                    $scope.efec_habilitado = true;
                    $scope.efectivo = 0;
                    $scope.efectivo_cierre = 0;
                }else{
                    $scope.efec_habilitado = false;
                    $scope.efectivo = totalefectivo.datos[0].total;
                }
                // $scope.ventadiapago = ventadiapago.datos;
            }).error(function(error) {
            $scope.error = error;
        });

        $http.get($scope.api+'/api/mi/totventatarj/'+$scope.misucu).success(
            function(totaltarjeta) {
                if (totaltarjeta.datos.length == '' ){
                    $scope.tarj_habilitado = true;
                    $scope.tarjeta = 0;
                    $scope.tarjeta_cierre = 0;
                }else{
                    $scope.tarj_habilitado = false;
                    $scope.tarjeta = totaltarjeta.datos[0].total;
                    $scope.tarjeta_cierre = 0;
                    //total : totaltarjeta.datos[0].total
                }
            }).error(function(error) {
            $scope.error = error;
        });

        $scope.cierres={};
        $http.get($scope.api+'/api/mi/totventachec/'+$scope.misucu).success(
            function(totalcheque) {
                if (totalcheque.datos.length == ''){
                    $scope.cheque_habilitado = true;
                    $scope.cheque = 0;
                    $scope.cierres.cheque = 0;
                }else{
                    $scope.cheque_habilitado = false;
                    $scope.cheque = totalcheque.datos[0].total;

                    //total : totaltarjeta.datos[0].total
                }
            }).error(function(error) {
            $scope.error = error;
        });

        $http.get($scope.api+'/api/mi/totventadep/'+$scope.misucu).success(
            function(totaldeposito) {
                if (totaldeposito.datos.length == '' ){
                    $scope.deposito_habilitado = true;
                    $scope.deposito = 0;
                    $scope.deposito_cierre = 0;
                }else{
                    $scope.deposito_habilitado = false;
                    $scope.deposito_cierre = totaldeposito.datos[0].total;

                }
            }).error(function(error) {
            $scope.error = error;
        });

        //Todos los cierres
        $http.get($scope.api+'/api/mi/cierres/'+$scope.misucu).success(
            function(cierres) {
                $scope.cierres = cierres.datos;

            }).error(function(error) {
            $scope.error = error;
        });

        $http.get($scope.api+'/api/mi/cierreshoy/'+$scope.misucu).success(
            function(cierres_hoy) {
                console.log('ultimo cierre hoy: ');
                console.log(cierres_hoy.datos);
                $scope.cierres_hoy = cierres_hoy.datos;
            }).error(function(error) {
            $scope.error = error;
        });

        //Nuevo Cierre
        $scope.guardarCierrep1 = function () {
            $scope.justi={};
            if ($scope.cierres.justificacion == undefined) {
                $scope.justi = '';
            }else{
                $scope.justi = $scope.cierres.justificacion;
            };

            var data = {
                id_sucursal: $scope.misucu,
                total_efectivo: $scope.cierres.efectivo,
                total_efectivo_sis: $scope.efectivo,
                total_tarjeta: $scope.cierres.tarjeta, //No nos interesa
                total_tarjeta_sis: $scope.tarjeta,
                total_cheque: $scope.cierres.cheque,
                total_cheque_sis: $scope.efectivo,
                total_deposito: $scope.cierres.deposito,
                total_deposito_sis: $scope.deposito, //Hasta acá, no nos interesa
                justificacion: $scope.justi,
                saldo_efectivo: $scope.bsaldo.efectivo,
                dolares: $scope.cierres.dolares,            //Esto tampoco nos interesa
                tipo_cambio: $scope.cierres.tipo_cambio,    //Esto menos, pero lo dejamos por si acaso
                gasto_efectivo: $scope.gasto_efectivo,
                gasto_tarjeta: $scope.gasto_tarjeta,
                estado: $scope.estadoMandar,
            };
            $http.post($scope.api+'/api/mi/cierre/create/'+$scope.misucu, data)
                .success(function (data, status, headers) {
                    // $scope.cierre_p1 = false;
                    // $scope.cierre_p2 = true;

                    $scope.imprimir = true;
                    $scope.nuevo_obj = false;
                $http.get($scope.api+'/api/mi/cierres/'+$scope.misucu)
                        .success(function(cierres) {
                                $scope.cierres = cierres.datos;

                            }).error(function(error) {
                            $scope.error = error;
                        });

                $http.get($scope.api+'/api/mi/cierreshoy/'+$scope.misucu)
                        .success(function(cierres_hoy) {
                                console.log('ultimo cierre hoy: ');
                                console.log(cierres_hoy.datos);
                                $scope.cierres_hoy = cierres_hoy.datos;
                            }).error(function(error) {
                            $scope.error = error;
                        });
                })
                .error(function (data, status, header, config) {
                    console.log('Parece que existe un error al modificar el usuario.');
                });

                $http.get($scope.api+'/api/mi/estadocierre').success(
                        function(cierre) {
                            $scope.cierre = cierre.datos;
                            if ($scope.cierre) {
                                $scope.existeCierre = true;
                            };
                        }).error(function(error) {
                        $scope.error = error;
                    });

        };
        //Nuevo Proveedor

        $scope.proveedor={};
        $scope.guardarProveedor = function(){
            // console.log($scope.usuario);

            /*ApiCierresNuevo.save($scope.proveedor, function(){
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
             });*/

        };

        //Eliminar Proveedor
        $scope.btn_eliminar = function(id){
            $scope.idproveedor= id;
            console.log($scope.idproveedor);

            $http.delete($scope.api+'/api/proveedor/destroy/' +  $scope.idproveedor)
                .success(function (data, status, headers) {
                    console.log('Proveedor '+$scope.idproveedor+' borrado correctamente.');
                    $http.get($scope.api+'/api/proveedores').success(

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
            $http.put($scope.api+'/api/proveedor/' +  $scope.existeProve.id, data)
                .success(function (data, status, headers) {
                    console.log('Proveedor '+$scope.existeProve.empresa+' modificado correctamente.');
                    $http.get($scope.api+'/api/proveedores').success(
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


    };

    $scope.agr_montoef = function(){
        $scope.monto_ef = true;
        $scope.gasto_ef = false;
        $scope.monto_tar = false;
        $scope.gasto_tar = false;
    };

    $scope.agr_gastoef = function(){
        $scope.gasto_ef = true;
        $scope.monto_ef = false;
        $scope.monto_tar = false;
        $scope.gasto_tar = false;
    };

    $scope.agr_montota = function(){
        $scope.monto_tar = true;
        $scope.monto_ef = false;
        $scope.gasto_ef = false;
        $scope.gasto_tar = false;
    };

    $scope.agr_gastota = function(){
        $scope.gasto_tar = true;
        $scope.monto_ef = false;
        $scope.gasto_ef = false;
        $scope.monto_tar = false;
    };

    // Modificar Monto Efectivo
    $scope.agrNumMF = function(numero){
        if ($scope.cierres.efectivo == undefined) {
          $scope.n = numero;
          $scope.cierres.efectivo = $scope.n;
        }else{
          $scope.cierres.efectivo = $scope.cierres.efectivo + numero.toString();                  
        }        
        console.log($scope.cierres.efectivo);
      };

    $scope.susNumMF = function(){
        $scope.cierres.efectivo = '';        
      };

      // Modificar Gasto Efectivo
    $scope.agrNumGF = function(numero){
        if ($scope.gasto_efectivo == undefined) {
          $scope.n = numero;
          $scope.gasto_efectivo = $scope.n;
        }else{
          $scope.gasto_efectivo = $scope.gasto_efectivo + numero.toString();          
        }        
        console.log($scope.gasto_efectivo);
      };

    $scope.susNumGF = function(){
        $scope.gasto_efectivo = '';        
      };

      // Modificar Monto Tarjeta
    $scope.agrNumMT = function(numero){
        if ($scope.cierres.tarjeta == undefined) {
          $scope.n = numero;
          $scope.cierres.tarjeta = $scope.n;
        }else{
          $scope.cierres.tarjeta = $scope.cierres.tarjeta + numero.toString();          
        }        
        console.log($scope.cierres.tarjeta);
      };

    $scope.susNumMT = function(){
        $scope.cierres.tarjeta = '';        
      };

      // Modificar Gasto Tarjeta
    $scope.agrNumGT = function(numero){
        if ($scope.gasto_tarjeta == undefined) {
          $scope.n = numero;
          $scope.gasto_tarjeta = $scope.n;
        }else{
          $scope.gasto_tarjeta = $scope.gasto_tarjeta + numero.toString();          
        }        
        console.log($scope.gasto_tarjeta);
      };

    $scope.susNumGT = function(){
        $scope.gasto_tarjeta = '';        
      };

      $scope.ircierres=function(){
            $window.location.href = $scope.api+'/cierrecaja';
        };
});
