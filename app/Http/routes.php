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
		Route::post('/cliente/porcentaje', 'ClientesController@storepor');
		Route::put('/cliente/{id}', 'ClientesController@update');
		Route::put('/cliente/porcentaje/{id}', 'ClientesController@updatepor');
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
	   Route::get('/proveedores', 'ProveedoresController@index');
	   	   //Gastos
	   Route::get('/gastos', 'GastosController@index');


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
			Route::get('/ventas', 'VentasCentralController@indexventas');
			Route::post('/ventacentral/create', 'VentasCentralController@store');
			Route::post('/ventacliente/create', 'VentasCentralController@storeclie');
			Route::post('/ventaproducto/create', 'VentasCentralController@storepro');
			Route::post('/factura/create', 'VentasCentralController@storefac');
			Route::post('/ventades/create', 'VentasCentralController@storedes');
			Route::get('/miventa/{id}', 'VentasCentralController@indexmiventa');
			Route::get('/miproducto/{id}', 'VentasCentralController@indexmiproducto');
			Route::get('/midescuento/{id}', 'VentasCentralController@indexmidescuento');
			Route::get('/ventas/stockproducto/{id}', 'VentasCentralController@stockproducto');
			Route::delete('/proventa/destroy/{id}','VentasCentralController@destroypro');
			Route::delete('/descuento/destroy/{id}','VentasCentralController@destroydes');
			Route::put('/proventa/{id}', 'VentasCentralController@updatepro');
			Route::delete('/venta/destroy/{id}','VentasCentralController@destroy');
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