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

//User側商品ページ
Route::get('/', 'ItemController@index')->name('index');
Route::get('/detail/{id?}', 'ItemController@detail')->name('detail');

Auth::routes();

//Userログイン後にアクセス可
Route::group(['middleware' => 'auth'], function() {;
	Route::get('/home', 'HomeController@index')->name('home');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});

//adminログイン
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
	Route::get('/', function () {
		return redirect('/admin/home');
	});
	Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
});
//adminログイン後にアクセス可
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');

	//Admin側商品ページ
	Route::get('/index', 'ItemController@index')->name('admin.index');
	Route::get('/detail/{id?}', 'ItemController@detail')->name('admin.detail');
	Route::get('/add', 'ItemController@add')->name('admin.add');
	Route::get('/edit/{id?}', 'ItemController@edit')->name('admin.edit');
});

//twitterログイン
Route::get('/sns/twitter/login', 'SnsController@getAuth')->name('sns.login');
Route::get('/sns/twitter/callback', 'SnsController@authCallback')->name('sns.callback');

