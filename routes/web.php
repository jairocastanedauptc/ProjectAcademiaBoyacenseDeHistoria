<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});



Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware'=>['Secretario']],function(){
        Route::get('file/manualdeusuario','FileController@manualdeusuario');
        Route::get('file/manualdeprogramador','FileController@manualdeprogramador');

        Route::get('/ejemplar','EjemplarController@index');
        Route::post('/ejemplar/registrar','EjemplarController@store');
        Route::put('/ejemplar/activar','EjemplarController@activar');
        Route::put('/ejemplar/desactivar','EjemplarController@desactivar');
        Route::put('/ejemplar/actualizar','EjemplarController@update');
        Route::get('/ejemplar/selectEjemplar', 'EjemplarController@selectEjemplar');
        Route::get('/ejemplar/listarPdf','EjemplarController@listarPdf')->name('ejemplares_pdf');

        Route::get('/registro','RegistroController@index');
        Route::post('/registro/registrar','RegistroController@store');
        Route::put('/registro/activar','RegistroController@activar');
        Route::put('/registro/desactivar','RegistroController@desactivar');
        Route::put('/registro/actualizar','RegistroController@update');
        Route::get('/registro/listarPdf','RegistroController@listarPdf')->name('registros_pdf');
        
        Route::get('/categoria','CategoriaController@index');
        Route::post('/categoria/registrar','CategoriaController@store');
        Route::put('/categoria/actualizar','CategoriaController@update');
        Route::put('/categoria/activar','CategoriaController@activar');
        Route::put('/categoria/desactivar','CategoriaController@desactivar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

        Route::get('/coleccion','ColeccionController@index');
        Route::post('/coleccion/registrar','ColeccionController@store');
        Route::put('/coleccion/actualizar','ColeccionController@update');
        Route::put('/coleccion/activar','ColeccionController@activar');
        Route::put('/coleccion/desactivar','ColeccionController@desactivar');
        Route::get('/coleccion/selectColeccion', 'ColeccionController@selectColeccion');

    });
        
    Route::group(['middleware'=>['Administrador']],function(){
        Route::get('/categoria','CategoriaController@index');
        Route::post('/categoria/registrar','CategoriaController@store');
        Route::put('/categoria/actualizar','CategoriaController@update');
        Route::put('/categoria/activar','CategoriaController@activar');
        Route::put('/categoria/desactivar','CategoriaController@desactivar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

        Route::get('/coleccion','ColeccionController@index');
        Route::post('/coleccion/registrar','ColeccionController@store');
        Route::put('/coleccion/actualizar','ColeccionController@update');
        Route::put('/coleccion/activar','ColeccionController@activar');
        Route::put('/coleccion/desactivar','ColeccionController@desactivar');
        Route::get('/coleccion/selectColeccion', 'ColeccionController@selectColeccion');
    
        Route::get('/ejemplar','EjemplarController@index');
        Route::post('/ejemplar/registrar','EjemplarController@store');
        Route::put('/ejemplar/activar','EjemplarController@activar');
        Route::put('/ejemplar/desactivar','EjemplarController@desactivar');
        Route::put('/ejemplar/actualizar','EjemplarController@update');
        Route::get('/ejemplar/selectEjemplar', 'EjemplarController@selectEjemplar');
        Route::get('/ejemplar/listarPdf','EjemplarController@listarPdf')->name('ejemplares_pdf');
    
    
        Route::get('/rol','RolController@index');
        Route::get('/rol/selectRol','RolController@selectRol');
    
        Route::get('/user','UserController@index');
        Route::post('/user/registrar','UserController@store');
        Route::put('/user/activar','UserController@activar');
        Route::put('/user/desactivar','UserController@desactivar');
        Route::put('/user/actualizar','UserController@update');
        Route::get('/dashboard','DashboardController');
    
        Route::get('/user/selectPersona', 'UserController@selectPersona');
    
        Route::get('/registro','RegistroController@index');
        Route::post('/registro/registrar','RegistroController@store');
        Route::put('/registro/activar','RegistroController@activar');
        Route::put('/registro/desactivar','RegistroController@desactivar');
        Route::put('/registro/actualizar','RegistroController@update');
        Route::get('/registro/listarPdf','RegistroController@listarPdf')->name('registros_pdf');
    
        Route::get('file/manualdeusuario','FileController@manualdeusuario');
        Route::get('file/manualdeprogramador','FileController@manualdeprogramador');
        
    });
    //Route::get('/home', 'HomeController@index')->name('home');
});
