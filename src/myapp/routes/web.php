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
Auth::routes();

Route::group(['middleware' => 'auth:ldap,users'], function () {
    Route::get('/', function () {
        return redirect()->to('dashboard');
    });
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('list','UserController@list')->name('list');
        Route::post('store','UserController@store')->name('store');
        Route::patch('{idUser}/update','UserController@update')->name('update');
        Route::delete('{idUser}/delete','UserController@destroy')->name('delete');
    });

});
