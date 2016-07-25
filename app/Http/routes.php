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
       Route::group(['middleware' => ['cors']], function()
		{      
			Route::get('/api/usuarios', 'UsuariosController@indexusuarios');
			Route::get('/api/usuarioseli', 'UsuariosController@usuarioseli');
			Route::get('/api/roles', 'UsuariosController@indexroles');
			Route::post('/api/usuario/create', 'UsuariosController@store');
			Route::get('/api/usuario/{id}', 'UsuariosController@show');
			Route::put('/api/usuario/{id}', 'UsuariosController@update');
			Route::delete('api/usuario/destroy/{id}','UsuariosController@destroy');
            Route::put('api/usuario/restaurar/{id}','UsuariosController@restaurar');
		});
});