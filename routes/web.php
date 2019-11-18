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
    
	return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/notas', 'TiposController');

Route::resource('/distritos', 'DistritoController');

Route::resource('/juzgados', 'JuzgadosController');

Route::get('distritosPDF', 'distritopdfController@exportPdf')->name('distritos.pdf');

Route::get('distritosEXCEL', 'distritopdfController@exportExcel')->name('distritos.excel');