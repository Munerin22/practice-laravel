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

//Route::get('/', function () {
	//return view('welcome');
//});

Route::get('/', 'ItemController@index')->name('index');
Route::get('/detail/{id?}', 'ItemController@detail')->name('detail');

Auth::routes();

//Userログイン
Route::group(['middleware' => 'auth'], function() {;
	Route::get('/home', 'HomeController@index')->name('home');
});

//Authログイン
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
	Route::get('/', function () {
		return redirect('/admin/home');
	});
	Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
});
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
});
