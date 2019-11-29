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
    return view('welcome');
});

Route::group(['prefix' => 'app'], function () {
    Route::post('upload', 'WebAppController@upload');
    Route::post('deploy', 'WebAppDeploymentLocationController@deploy');
    Route::post('withdraw', 'WebAppDeploymentLocationController@withdraw');
});

Route::group(['prefix' => 'payment'], function () {
    Route::post('submit', 'PaymentController@submit');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\AdminPaymentController@index');
});

Route::get('/test', function () {

});
