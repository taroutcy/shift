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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes([
    // 'register' => false // ユーザ登録機能をオフに切替
]);


Route::group(['middleware' => 'auth'], function() {
     // ここにログイン後のみのルーティングを記述
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');
    
    Route::group(['prefix' => 'user'], function() {
        Route::get('register', 'UserController@getRegister')->name('user.register.get');
        Route::get('edit/{id}', 'UserController@getEdit')->name('user.edit.get');
        Route::post('edit/{id}', 'UserController@postEdit')->name('user.edit.post');
        Route::get('home', 'UserController@home')->name('user.home');
        Route::post('register', 'UserController@postRegister')->name('user.register.post');
    });
    
    Route::group(['prefix' => 'shift'], function() {
        Route::get('calendar/{year?}/{month?}', 'ScheduleController@getShift')->name('shift.calendar.edit');
        Route::post('calendar/{date?}', 'ScheduleController@postShift')->name('shift.calendar.post');
        Route::get('check/{year?}/{month?}','ScheduleController@checkShift')->name('shift.check');
        Route::get('confirm/{year?}/{month?}','ScheduleController@getConfirmShift')->name('shift.confirm.get');
        Route::post('confirm/{year?}/{month?}','ScheduleController@allConfirmShift')->name('shift.confirm.all');
        Route::post('confirm/{id?}/{year?}/{month?}/{date?}','ScheduleController@changeConfirmShift')->name('shift.confirm.change');
    });
 });
 
 URL::forceScheme('https');
