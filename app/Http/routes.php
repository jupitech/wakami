<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login');
});


Route::auth();

Route::get('/', 'HomeController@index');


Route::group(['middleware' => ['auth','role:admin|operativo|vendedor']], function()
{
	   //Clientes
	   Route::get('/clientes', 'ClientesController@index');
	    Route::get('/clientessu', 'ClientesController@indexsu');
	     //Productos
	   Route::get('/productos', 'ProductosController@index');

	     //Devoluciones
	   Route::get('/devoluciones', 'DevolucionesController@index');

	Route::group(['middleware' => 'cors','prefix' => 'api'], function()
	{ 

		 //Clientes
        Route::get('/clientes', 'ClientesController@indexclientes');
		Route::post('/cliente/create', 'ClientesController@store');
		Route::post('/cliente/porcentaje', 'ClientesController@storepor');
		Route::put('/cliente/{id}', 'ClientesController@update');
        //OBTENER CLIENTE POR NIT
        Route::post('/bclientes/', 'ClientesController@indexclientenit');

		Route::put('/cliente/porcentaje/{id}', 'ClientesController@updatepor');
		Route::delete('/cliente/destroy/{id}','ClientesController@destroy');

		//Productos

		Route::get('/productos', 'ProductosController@indexproductos');
		Route::get('/productosas', 'ProductosController@productosconstock');

	});	


});	

Route::group(['middleware' => ['auth','role:admin|operativo']], function()
{
	   //Usuarios
	   Route::get('/usuarios', 'UsuariosController@index');

	 
	   //Compras
	   Route::get('/compras', 'OrdenCompraController@index');
	   //Sucursales
	   Route::get('/sucursales', 'SucursalController@index');


	   //Ventas
	   Route::get('/ventas', 'VentasCentralController@index');
	   Route::get('/nuevaventa', 'VentasCentralController@indexnueva');
	   Route::get('/editarventa/{id}', 'VentasCentralController@indexeditar');

	   //Proveedores
	   Route::get('/proveedores', 'ProveedoresController@index');
	   	   //Gastos
	   Route::get('/gastos', 'GastosController@index');

	    //Consignacion
	   Route::get('/consignacion', 'ConsignacionController@index');

	    //Reportes ventas
	   Route::get('/reporteventas', 'ReporteVentasController@index');
	    Route::get('/libroventas', 'ReporteVentasController@indexlibro');

	    //Promociones
	   Route::get('/promociones', 'PromocionesController@index');


		Route::get('/producto/imagen/{id}', 'ProductosController@createimagen');
		Route::post('/producto/imagen/create',['as' => 'producto.imagen.create', 'uses' =>  'ProductosController@storeimagen']);

       Route::group(['middleware' => 'cors','prefix' => 'api'], function()
		{     
			//Usuarios 
			Route::get('/usuarios', 'UsuariosController@indexusuarios');
			Route::get('/usuarioseli', 'UsuariosController@usuarioseli');
			Route::get('/roles', 'UsuariosController@indexroles');
			Route::post('/usuario/create', 'UsuariosController@store');
			Route::get('/usuario/{id}', 'UsuariosController@show');
			Route::put('/usuario/{id}', 'UsuariosController@update');
			Route::delete('/usuario/destroy/{id}','UsuariosController@destroy');
            Route::put('/usuario/restaurar/{id}','UsuariosController@restaurar');

            //Proveedores
            Route::get('/proveedores', 'ProveedoresController@indexproveedores');
			Route::post('/proveedor/create', 'ProveedoresController@store');
			Route::delete('/proveedor/destroy/{id}','ProveedoresController@destroy');
			Route::put('/proveedor/{id}', 'ProveedoresController@update');

			//Productos
			Route::get('/lineaproductos', 'ProductosController@indexlineas');
			Route::post('/lineaproducto/create', 'ProductosController@storelinea');
			Route::put('/lineaproducto/{id}', 'ProductosController@updatelinea');
			Route::delete('/lineaproducto/destroy/{id}','ProductosController@destroylinea');
			Route::get('/excelproductos', 'ProductosController@excelproductos');

			
			Route::post('/producto/create', 'ProductosController@store');
			Route::put('/producto/{id}', 'ProductosController@update');
			Route::delete('/producto/destroy/{id}','ProductosController@destroy');
			Route::get('/stockproducto/{id}', 'ProductosController@stockproducto');

			  //Compras
            Route::get('/compras', 'OrdenCompraController@indexcompras');
            Route::get('/procompras/{id}', 'OrdenCompraController@indexprocompras');
			Route::post('/compra/create', 'OrdenCompraController@store');
			Route::post('/procompra/create', 'OrdenCompraController@storeprocompra');
			Route::post('/procompra/envioproducto', 'OrdenCompraController@enviarproductos');
			Route::post('/procompra/envioproductopen', 'OrdenCompraController@enviarproductopen');
			Route::delete('/compra/destroy/{id}','OrdenCompraController@destroy');
			Route::delete('/procompra/destroy/{id}','OrdenCompraController@destroypro');
			Route::delete('/procompra/destroy2/{id}','OrdenCompraController@destroypro2');
			Route::put('/compra/{id}', 'OrdenCompraController@update');
			Route::put('/procompra/{id}', 'OrdenCompraController@updatepro');
			Route::post('/compra/p1/{id}', 'OrdenCompraController@updatep1');
			Route::post('/compra/pen/{id}', 'OrdenCompraController@updatepen');
			Route::put('/compra/p2/{id}', 'OrdenCompraController@updatep2');

			 //Sucursales
            Route::get('/sucursales', 'SucursalController@indexsucursales');
            Route::get('/envios', 'SucursalController@indexenvios');
            Route::get('/prosucursales/{id}', 'SucursalController@indexprosucursales');
            Route::get('/sucursales/usuarios', 'SucursalController@indexusers');
            Route::get('/sucursales/stockproducto/{id}', 'SucursalController@stockproducto');
			Route::post('/sucursal/create', 'SucursalController@store');
			Route::delete('/sucursal/destroy/{id}','SucursalController@destroy');
			Route::put('/sucursal/{id}', 'SucursalController@update');

			Route::post('/envio/create', 'SucursalController@storeenvio');
			Route::post('/proenvio/create', 'SucursalController@storeproenvio');
			Route::get('/proenvios/{id}', 'SucursalController@indexproenvios');
			Route::put('/proenvio/{id}', 'SucursalController@updateproenvio');
			Route::delete('/proenvio/destroy/{id}','SucursalController@destroypro');
			Route::post('/envio/p1/{id}', 'SucursalController@updatep1');
			Route::put('/envio/p2/{id}', 'SucursalController@updatep2');


			//Ventas Central
			Route::get('/ventasdia', 'VentasCentralController@indexventasdia');
			Route::get('/ventasmes', 'VentasCentralController@indexventasmes');
			Route::get('/ventasanio', 'VentasCentralController@indexventasanio');
			Route::post('/ventacentral/create', 'VentasCentralController@store');
			Route::post('/ventacliente/create', 'VentasCentralController@storeclie');
			Route::post('/ventaproducto/create', 'VentasCentralController@storepro');
			Route::post('/factura/create', 'VentasCentralController@storefac');
			Route::post('/notacredito/{id}', 'VentasCentralController@notacredito');
			Route::post('/notadebito/{id}', 'VentasCentralController@notadebito');
			Route::post('/ventades/create', 'VentasCentralController@storedes');
			Route::post('/ventapromo/create', 'VentasCentralController@storepromo');
			Route::get('/miventa/{id}', 'VentasCentralController@indexmiventa');
			Route::get('/miproducto/{id}', 'VentasCentralController@indexmiproducto');
			Route::get('/midescuento/{id}', 'VentasCentralController@indexmidescuento');
			Route::get('/mipromocion/{id}', 'VentasCentralController@indexmipromoventa');
			Route::get('/mipromocion', 'VentasCentralController@indexmipromocion');
			Route::get('/productomin/{id}', 'VentasCentralController@indexmiproductomin');
			Route::get('/misucursal/{id}', 'VentasCentralController@indexmisucursal');
			Route::get('/ventas/stockproducto/{id}', 'VentasCentralController@stockproducto');
			Route::delete('/proventa/destroy/{id}','VentasCentralController@destroypro');
			Route::delete('/descuento/destroy/{id}','VentasCentralController@destroydes');
			Route::delete('/promocion/destroy/{id}','VentasCentralController@destroypromo');
			Route::put('/proventa/{id}', 'VentasCentralController@updatepro');
			Route::delete('/venta/destroy/{id}','VentasCentralController@destroy');

			Route::post('/ventadiasucursal', 'VentasCentralController@ventadiasucursal');
			Route::post('/ventamessucursal', 'VentasCentralController@ventamessucursal');
			Route::post('/ventaaniosucursal', 'VentasCentralController@ventaaniosucursal');
			Route::post('/ventadiapago', 'VentasCentralController@ventadiapago');
			Route::post('/ventamespago', 'VentasCentralController@ventamespago');
			Route::post('/ventaaniopago', 'VentasCentralController@ventaaniopago');
			Route::post('/ventadiafac', 'VentasCentralController@ventadiafac');
			Route::post('/ventamesfac', 'VentasCentralController@ventamesfac');
			Route::post('/ventaaniofac', 'VentasCentralController@ventaaniofac');

			Route::get('/pdfventa/{id}', 'VentasCentralController@pdfventa');


			//Consignaciones
            Route::get('/consignaciones', 'ConsignacionController@indexconsignacion');
            Route::get('/proconsignacion/{id}', 'ConsignacionController@indexproconsignacion');
             Route::get('/proconsignacionas/{id}', 'ConsignacionController@indexproconsignacionas');
            Route::get('/consignacion/stockproducto/{id}', 'ConsignacionController@stockproducto');
			Route::post('/consignacion/create', 'ConsignacionController@store');
			Route::delete('/consignacion/destroy/{id}','ConsignacionController@destroy');
			Route::post('/consignacion/nuevaventa/{idcliente}', 'ConsignacionController@nuevaventa');
			Route::post('/consignacionproducto/create', 'ConsignacionController@storepro');
			Route::post('/consignaciondes/create', 'ConsignacionController@storedes');
			Route::put('/consignacionproventa/{id}', 'ConsignacionController@updatepro');
			Route::delete('/consignacionproventa/destroy/{id}','ConsignacionController@destroyprofac');
			Route::delete('/consignaciondescuento/destroy/{id}','ConsignacionController@destroydes');

			Route::get('/consignacion/ventas/{id}', 'ConsignacionController@indexventas');
			Route::post('/consignacion/factura/create', 'ConsignacionController@storefac');
			Route::get('/consignacion/miventa/{id}', 'ConsignacionController@indexmiventa');
			Route::get('/consignacion/miproducto/{id}', 'ConsignacionController@indexmiproducto');
			Route::get('/consignacion/midescuento/{id}', 'ConsignacionController@indexmidescuento');
			Route::get('/consignacion/misucursal/{id}', 'ConsignacionController@indexmisucursal');

			Route::get('/consignacion/pdfventa/{id}', 'ConsignacionController@pdfventa');
			Route::get('/consignacion/pdfenvio/{id}', 'ConsignacionController@pdfenvio');

			Route::get('/enviosconsignaciones', 'ConsignacionController@indexenvios');
			Route::post('/envioconsignacion/create', 'ConsignacionController@storeenvio');
			Route::post('/proenvioconsignacion/create', 'ConsignacionController@storeproenvio');
			Route::get('/proenviosconsignacion/{id}', 'ConsignacionController@indexproenvios');
			Route::put('/proenvioconsignacion/{id}', 'ConsignacionController@updateproenvio');
			Route::delete('/proenvioconsignacion/destroy/{id}','ConsignacionController@destroypro');
			Route::post('/envioconsignacion/p1/{id}', 'ConsignacionController@updatep1');

			//Reportes
			Route::get('/reportes/ventasmes', 'ReporteVentasController@indexventas');	
			Route::get('/reportes/ventaspago', 'ReporteVentasController@ventaspago');
			Route::get('/reportes/ventasproducto', 'ReporteVentasController@ventasproducto');	
			Route::get('/reportes/ventaslinea', 'ReporteVentasController@ventaslinea');	
			Route::get('/reportes/ventasl', 'ReporteVentasController@indexlventas');	

			//Devoluciones
			Route::get('/devoluciones', 'DevolucionesController@indexdevoluciones');
			Route::post('/devolucion/create', 'DevolucionesController@store');
			Route::post('/prodevolucion/create', 'DevolucionesController@storeprodevolucion');
			Route::get('/prodevolucion/{id}', 'DevolucionesController@indexprodevoluciones');
			Route::put('/prodevolucion/{id}', 'DevolucionesController@updatepro');
			Route::put('/devolucion/p1/{id}', 'DevolucionesController@updatep1');
			Route::delete('/devolucion/destroy/{id}','DevolucionesController@destroy');
			Route::delete('/prodevolucion/destroy/{id}','DevolucionesController@destroypro');
			Route::get('/devoluciones/consignacion/{id}', 'DevolucionesController@indexproconsignacionas');


            //Promociones
            Route::get('/promociones', 'PromocionesController@indexpromociones');
			Route::post('/promocion/create', 'PromocionesController@store');
			Route::delete('/promocion/destroy/{id}','PromocionesController@destroy');
			Route::put('/promocion/{id}', 'PromocionesController@update');

		});
});

Route::group(['middleware' => ['auth','role:vendedor']], function(){

	//Mi Sucursal
	 Route::get('/misucursal', 'MiSucursalController@index');

	 	 	//Ventas
	   Route::get('/misventas', 'VentasController@index');
	   Route::get('/minuevaventa', 'VentasController@indexnueva');

	   //Productos
	    Route::get('/misproductos', 'MiProductoController@index');

	    //Traslados
	      Route::get('/traslados', 'TrasladosController@index');



	 Route::group(['middleware' => 'cors','prefix' => 'api/mi'], function()
	{   

		 Route::get('/miusuario', 'MiSucursalController@misucursal');
		 Route::get('/misenvios/{id}', 'MiSucursalController@indexenvios');
		 Route::get('/proenvios/{id}', 'MiSucursalController@indexproenvios');
		 Route::post('/proenvio/envioproducto', 'MiSucursalController@enviarproductos');
		 Route::post('/proenvio/envioproductopen', 'MiSucursalController@enviarproductopen');
		 Route::put('/envio/p2/{id}', 'MiSucursalController@updatep2');
		 Route::delete('/proenvio/destroy/{id}','MiSucursalController@destroypro');


		 Route::get('/excelproductos/{id}', 'MiProductoController@excelproductos');


		//Ventas
		Route::get('/ventasdia/{id}', 'VentasController@indexventasdia');
		Route::get('/ventasmes/{id}', 'VentasController@indexventasmes');
		Route::get('/ventasanio/{id}', 'VentasController@indexventasanio');
		Route::post('/venta/create', 'VentasController@store');
		Route::post('/ventacliente/create/{id}', 'VentasController@storeclie');
		Route::post('/ventaproducto/create', 'VentasController@storepro');
			Route::post('/ventapromo/create', 'VentasController@storepromo');
		Route::post('/factura/create', 'VentasController@storefac');
		Route::get('/miventa/{id}', 'VentasController@indexmiventa');
		Route::get('/miproducto/{id}', 'VentasController@indexmiproducto');
		Route::get('/misucursal/{id}', 'VentasController@indexmisucursal');
			Route::get('/mipromocion/{id}', 'VentasController@indexmipromoventa');
			Route::get('/mipromocion', 'VentasController@indexmipromocion');
			Route::get('/productomin/{id}', 'VentasController@indexmiproductomin');
		Route::get('/ventas/stockproducto/{sucursal}/{id}', 'VentasController@stockproducto');
		Route::delete('/proventa/destroy/{id}','VentasController@destroypro');
		Route::put('/proventa/{id}', 'VentasController@updatepro');
		Route::delete('/venta/destroy/{id}','VentasController@destroy');
			Route::delete('/promocion/destroy/{id}','VentasCentralController@destroypromo');

		Route::get('/ventadiasucursal/{id}', 'VentasController@ventadiasucursal');
		Route::get('/ventamessucursal/{id}', 'VentasController@ventamessucursal');
		Route::get('/ventaaniosucursal/{id}', 'VentasController@ventaaniosucursal');
		Route::get('/ventadiapago/{id}', 'VentasController@ventadiapago');
		Route::get('/ventamespago/{id}', 'VentasController@ventamespago');
		Route::get('/ventaaniopago/{id}', 'VentasController@ventaaniopago');
		Route::get('/ventadiafac/{id}', 'VentasController@ventadiafac');
		Route::get('/ventamesfac/{id}', 'VentasController@ventamesfac');
		Route::get('/ventaaniofac/{id}', 'VentasController@ventaaniofac');
		Route::get('/ventadiauser/{id}', 'VentasController@ventadiauser');
		Route::get('/ventamesuser/{id}', 'VentasController@ventamesuser');
		Route::get('/ventaaniouser/{id}', 'VentasController@ventaaniouser');

		Route::get('/pdfventa/{id}', 'VentasController@pdfventa');

		//Productos
		Route::get('/productos/{id}', 'MiProductoController@indexproductos');
		Route::get('/productosas/{id}', 'MiProductoController@indexproductosstock');

		//Traslados
	    Route::get('/traslados/sucursales/{id}', 'TrasladosController@indexsucursales');
	    Route::post('/traslados/create', 'TrasladosController@store');
	    Route::get('/trasladosen/{id}', 'TrasladosController@indextrasladosen');
	    Route::get('/trasladosre/{id}', 'TrasladosController@indextrasladosre');
	    Route::delete('/traslados/destroy/{id}','TrasladosController@destroy');
	    Route::put('/traslados/ok/{id}', 'TrasladosController@update');

	});	

		
});