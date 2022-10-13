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

Route::group(['prefix' => 'users'], function() {
    Route::get('edit/{id}', 'UserController@getEdit');
    Route::post('edit/{id}', 'UserController@postEdit');
    Route::get('home', 'UserController@home')->name('users.home');
});

Auth::routes([
    // 'register' => false // ユーザ登録機能をオフに切替
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
     // ここにログイン後のみのルーティングを記述
 });
 
 URL::forceScheme('https');