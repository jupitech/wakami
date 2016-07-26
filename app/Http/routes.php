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
		});
});