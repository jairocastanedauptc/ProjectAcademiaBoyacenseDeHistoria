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

Route::get('/autor','AutorController@index');
Route::post('/autor/registrar','AutorController@store');
Route::put('/autor/actualizar','AutorController@update');
Route::put('/autor/activar','AutorController@activar');
Route::put('/autor/desactivar','AutorController@desactivar');

Route::get('/coleccion','ColeccionController@index');
Route::post('/coleccion/registrar','ColeccionController@store');
Route::put('/coleccion/actualizar','ColeccionController@update');
Route::put('/coleccion/activar','ColeccionController@activar');
Route::put('/coleccion/desactivar','ColeccionController@desactivar');
