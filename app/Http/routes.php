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

Route::group(['middleware' => ['auth','role:admin']], function()
{
	   //Usuarios
	   Route::get('/usuarios', 'UsuariosController@index');
	   //Proveedores
	   Route::get('/proveedores', 'ProveedoresController@index');
	   //Productos
	   Route::get('/productos', 'ProductosController@index');

	    //Compras
	   Route::get('/compras', 'OrdenCompraController@index');

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

			Route::get('/api/productos', 'ProductosController@indexproductos');
			Route::post('/api/producto/create', 'ProductosController@store');
			Route::put('/api/producto/{id}', 'ProductosController@update');
			Route::get('/producto/imagen/{id}', 'ProductosController@createimagen');
			Route::post('/producto/imagen/create',['as' => 'producto.imagen.create', 'uses' =>  'ProductosController@storeimagen']);
			Route::delete('api/producto/destroy/{id}','ProductosController@destroy');

			  //Compras
            Route::get('/api/compras', 'OrdenCompraController@indexcompras');
            Route::get('/api/procompras/{id}', 'OrdenCompraController@indexprocompras');
			Route::post('/api/compra/create', 'OrdenCompraController@store');
			Route::post('/api/procompra/create', 'OrdenCompraController@storeprocompra');
			Route::delete('/api/compra/destroy/{id}','OrdenCompraController@destroy');
			Route::delete('/api/procompra/destroy/{id}','OrdenCompraController@destroypro');
			Route::put('/api/compra/{id}', 'OrdenCompraController@update');
		});
});