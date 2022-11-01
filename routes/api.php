<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/IndicadorFinanciero','App\Http\Controllers\IndicadorFinancieroController@index');
// Route::post('/IndicadorFinanciero','App\Http\Controllers\IndicadorFinancieroController@store');
// Route::put('/IndicadorFinanciero','App\Http\Controllers\IndicadorFinancieroController@update');
// Route::delete('/IndicadorFinanciero','App\Http\Controllers\IndicadorFinancieroController@destroy');
