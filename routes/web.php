<?php

use Illuminate\Support\Facades\Route;


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

$controller_path = 'App\Http\Controllers';

Route::get('/', "$controller_path\IndicadorFinancieroController@index")->name('dashboard');
Route::get('/webservice',"$controller_path\WebServiceSolutoriaController@getConnectionSolutoria")->name('webservice');

Route::post('/indicadorfinanciero','App\Http\Controllers\IndicadorFinancieroController@store');
Route::put('/indicadorfinanciero/{id}/update','App\Http\Controllers\IndicadorFinancieroController@update');
Route::delete('/indicadorfinanciero','App\Http\Controllers\IndicadorFinancieroController@destroy');
Route::get('/indicadorfinanciero/{id}/edit','App\Http\Controllers\IndicadorFinancieroController@edit');
Route::get('/indicadorfinanciero/getmeses','App\Http\Controllers\IndicadorFinancieroController@getMeses');
Route::get('/indicadorfinanciero/grafico','App\Http\Controllers\IndicadorFinancieroController@graph');

// Main Page Route
// Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');
Route::get('/layouts/without-menu', $controller_path . '\graficos\WithoutMenu@index')->name('layouts-without-menu');
