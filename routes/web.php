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

Route::get('/', function () {
    return view('contenido/contenido');
});

//cada que se ingrese a la direccion categoria se hace
//peticion al metodo del controlador
Route::get('/categoria','CategoriaController@index');
Route::post('/categoria/registrar','CategoriaController@store');
Route::put('/categoria/actualizar','CategoriaController@update');
Route::put('/categoria/activar','CategoriaController@activar');
Route::put('/categoria/desactivar','CategoriaController@desactivar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

//Route::get('/autor','AutorController@index');
//Route::post('/autor/registrar','AutorController@store');
//Route::put('/autor/actualizar','AutorController@update');
//Route::put('/autor/activar','AutorController@activar');
//Route::put('/autor/desactivar','AutorController@desactivar');

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
