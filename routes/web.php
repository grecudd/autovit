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

Route::resource('/cars', 'App\Http\Controllers\CarsController')->middleware('auth', ['except' => ['index', 'show']]);

/* Route::get('/', function () {
    return redirect()->route('cars.index');
}); */

Route::get('/', 'App\Http\Controllers\CarsController@index');

Route::get('/cars/{car}/show', 'App\Http\Controllers\CarsController@show')->name('cars.show');

Route::middleware('auth')->group(function () {
    /* Route::resource('/cars', 'App\Http\Controllers\CarsController', ['except' => ['index', 'show']]); */

    Route::put('/cars/{car}/update', 'App\Http\Controllers\CarsController@update')->name('update');
    Route::get('dashboard', 'App\Http\Controllers\CarsController@dashboard')->name('cars.dashboard');
    Route::delete('/cars/{car}/delete', 'App\Http\Controllers\CarsController@destroy');
    Route::get('/logOut', 'App\Http\Controllers\CarsController@logOut')->name('logOut');
    Route::get('/cars/{car}/buy', 'App\Http\Controllers\CarsController@buy')->name('cars.buy');
    Route::get('/cars/{car}/validate-buy', 'App\Http\Controllers\CarsController@validateBuy')->name('cars.validateBuy');
    Route::put('/cars/{car}/list', 'App\Http\Controllers\CarsController@list')->name('cars.list');
});
