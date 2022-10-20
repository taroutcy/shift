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

Route::group(['prefix' => 'user'], function() {
    Route::get('edit/{id}', 'UserController@getEdit')->name('user.edit.get');
    Route::post('edit/{id}', 'UserController@postEdit')->name('user.edit.post');
    Route::get('home', 'UserController@home')->name('user.home');
});
Route::group(['prefix' => 'schedule'], function() {
    Route::get('calendar/{year?}/{month?}', 'ScheduleController@getShift')->name('schedule.calendar');
    Route::post('calendar/{year?}/{month?}', 'ScheduleController@postShift')->name('schedule.calendar.post');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {
     // ここにログイン後のみのルーティングを記述
 });
 
 URL::forceScheme('https');