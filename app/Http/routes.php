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
	     //Productos
	   Route::get('/productos', 'ProductosController@index');

	Route::group(['middleware' => 'cors','prefix' => 'api'], function()
	{ 

		 //Clientes
        Route::get('/clientes', 'ClientesController@indexclientes');
		Route::post('/cliente/create', 'ClientesController@store');
		Route::put('/cliente/{id}', 'ClientesController@update');
		Route::delete('/cliente/destroy/{id}','ClientesController@destroy');

		//Productos

		Route::get('/productos', 'ProductosController@indexproductos');

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

	   //Proveedores
	   Route::get('/gastos', 'GastosController@index');


       Route::group(['middleware' => ['cors']], function()
		{     
			//Usuarios 
			Route::get('/api/usuarios', 'UsuariosController@indexusuarios');
			Route::get('/api/usuarioseli', 'UsuariosController@usuarioseli');
			Route::get('/api/roles', 'UsuariosController@indexroles');
			Route::post('/api/usuario/create', 'UsuariosController@store');
			Route::get('/api/usuario/{id}', 'UsuariosController@show');
			Route::put('/api/usuario/{id}', 'UsuariosController@update');
			Route::delete('api/usuario/destroy/{id}','UsuariosController@destroy');
            Route::put('api/usuario/restaurar/{id}','UsuariosController@restaurar');

            //Proveedores
            Route::get('/api/proveedores', 'ProveedoresController@indexproveedores');
			Route::post('/api/proveedor/create', 'ProveedoresController@store');
			Route::delete('/api/proveedor/destroy/{id}','ProveedoresController@destroy');
			Route::put('/api/proveedor/{id}', 'ProveedoresController@update');

			//Productos
			Route::get('/api/lineaproductos', 'ProductosController@indexlineas');
			Route::post('/api/lineaproducto/create', 'ProductosController@storelinea');
			Route::put('/api/lineaproducto/{id}', 'ProductosController@updatelinea');
			Route::delete('api/lineaproducto/destroy/{id}','ProductosController@destroylinea');

			
			Route::post('/api/producto/create', 'ProductosController@store');
			Route::put('/api/producto/{id}', 'ProductosController@update');
			Route::get('/producto/imagen/{id}', 'ProductosController@createimagen');
			Route::post('/producto/imagen/create',['as' => 'producto.imagen.create', 'uses' =>  'ProductosController@storeimagen']);
			Route::delete('api/producto/destroy/{id}','ProductosController@destroy');
			Route::get('/api/stockproducto/{id}', 'ProductosController@stockproducto');

			  //Compras
            Route::get('/api/compras', 'OrdenCompraController@indexcompras');
            Route::get('/api/procompras/{id}', 'OrdenCompraController@indexprocompras');
			Route::post('/api/compra/create', 'OrdenCompraController@store');
			Route::post('/api/procompra/create', 'OrdenCompraController@storeprocompra');
			Route::post('/api/procompra/envioproducto', 'OrdenCompraController@enviarproductos');
			Route::post('/api/procompra/envioproductopen', 'OrdenCompraController@enviarproductopen');
			Route::delete('/api/compra/destroy/{id}','OrdenCompraController@destroy');
			Route::delete('/api/procompra/destroy/{id}','OrdenCompraController@destroypro');
			Route::delete('/api/procompra/destroy2/{id}','OrdenCompraController@destroypro2');
			Route::put('/api/compra/{id}', 'OrdenCompraController@update');
			Route::put('/api/procompra/{id}', 'OrdenCompraController@updatepro');
			Route::post('/api/compra/p1/{id}', 'OrdenCompraController@updatep1');
			Route::post('/api/compra/pen/{id}', 'OrdenCompraController@updatepen');
			Route::put('/api/compra/p2/{id}', 'OrdenCompraController@updatep2');

			 //Sucursales
            Route::get('/api/sucursales', 'SucursalController@indexsucursales');
            Route::get('/api/envios', 'SucursalController@indexenvios');
            Route::get('/api/prosucursales/{id}', 'SucursalController@indexprosucursales');
            Route::get('/api/sucursales/usuarios', 'SucursalController@indexusers');
            Route::get('/api/sucursales/stockproducto/{id}', 'SucursalController@stockproducto');
			Route::post('/api/sucursal/create', 'SucursalController@store');
			Route::delete('/api/sucursal/destroy/{id}','SucursalController@destroy');
			Route::put('/api/sucursal/{id}', 'SucursalController@update');

			Route::post('/api/envio/create', 'SucursalController@storeenvio');
			Route::post('/api/proenvio/create', 'SucursalController@storeproenvio');
			Route::get('/api/proenvios/{id}', 'SucursalController@indexproenvios');
			Route::put('/api/proenvio/{id}', 'SucursalController@updateproenvio');
			Route::delete('/api/proenvio/destroy/{id}','SucursalController@destroypro');
			Route::post('/api/envio/p1/{id}', 'SucursalController@updatep1');
			Route::put('/api/envio/p2/{id}', 'SucursalController@updatep2');


			//Ventas Central
			Route::get('/api/ventas', 'VentasCentralController@indexventas');
			Route::post('/api/ventacentral/create', 'VentasCentralController@store');
			Route::post('/api/ventacliente/create', 'VentasCentralController@storeclie');
			Route::post('/api/ventaproducto/create', 'VentasCentralController@storepro');
			Route::post('/api/factura/create', 'VentasCentralController@storefac');
			Route::get('/api/miventa/{id}', 'VentasCentralController@indexmiventa');
			Route::get('/api/miproducto/{id}', 'VentasCentralController@indexmiproducto');
			Route::get('/api/ventas/stockproducto/{id}', 'VentasCentralController@stockproducto');
			Route::delete('/api/proventa/destroy/{id}','VentasCentralController@destroypro');
			Route::put('/api/proventa/{id}', 'VentasCentralController@updatepro');
			Route::delete('/api/venta/destroy/{id}','VentasCentralController@destroy');
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


	 Route::group(['middleware' => 'cors','prefix' => 'api/mi'], function()
	{   

		 Route::get('/miusuario', 'MiSucursalController@misucursal');
		 Route::get('/misenvios/{id}', 'MiSucursalController@indexenvios');
		 Route::get('/proenvios/{id}', 'MiSucursalController@indexproenvios');
		 Route::post('/proenvio/envioproducto', 'MiSucursalController@enviarproductos');
		 Route::post('/proenvio/envioproductopen', 'MiSucursalController@enviarproductopen');
		 Route::put('/envio/p2/{id}', 'MiSucursalController@updatep2');
		 Route::delete('/proenvio/destroy/{id}','MiSucursalController@destroypro');


		//Ventas
		Route::get('/ventas/{id}', 'VentasController@indexventas');
		Route::post('/venta/create', 'VentasController@store');
		Route::post('/ventacliente/create', 'VentasController@storeclie');
		Route::post('/ventaproducto/create', 'VentasController@storepro');
		Route::post('/factura/create', 'VentasController@storefac');
		Route::get('/miventa/{id}', 'VentasController@indexmiventa');
		Route::get('/miproducto/{id}', 'VentasController@indexmiproducto');
		Route::get('/ventas/stockproducto/{sucursal}/{id}', 'VentasController@stockproducto');
		Route::delete('/proventa/destroy/{id}','VentasController@destroypro');
		Route::put('/proventa/{id}', 'VentasController@updatepro');
		Route::delete('/venta/destroy/{id}','VentasController@destroy');

		//Productos
		Route::get('/productos/{id}', 'MiProductoController@indexproductos');

	});	

		
});