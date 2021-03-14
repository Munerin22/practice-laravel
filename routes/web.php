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

//ホーム画面
Route::get('/', 'PortController@menu')->name('welcome');

//User側商品ページ
Route::get('/index', 'ItemController@index')->name('index');
Route::get('/detail/{id?}', 'ItemController@detail')->name('detail');

Auth::routes();

//Userログイン後にアクセス可
Route::group(['middleware' => 'auth'], function() {;
	Route::get('/home', 'HomeController@index')->name('home');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
	//カートの操作
	Route::get('/cart', 'CartController@index')->name('cart.index');
	Route::get('/cart/delete', 'CartController@index');
	Route::post('/cart/delete', 'CartController@delete')->name('cart.delete');
	Route::get('/cart/add', 'CartController@index');
	Route::post('/cart/add', 'CartController@add')->name('cart.add');

	//お届け先住所の操作
	Route::get('/address', 'AddressController@index')->name('address.index');
	Route::get('/address/add', 'AddressController@add');
	Route::get('/address/add/form', function() {
		return view('address.add');
	})->name('address.add.form');
	Route::get('/address/add', 'AddressController@add')->name('address.add');
});

//adminログイン
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
	Route::get('/', function () {
		return redirect('/admin/index');
	});
	Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
});
//adminログイン後にアクセス可
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::get('/home', 'Admin\HomeController@index')->name('admin.home');

	//Admin側商品ページ
	Route::get('/index', 'ItemController@index')->name('admin.index');
	Route::get('/detail/{id?}', 'ItemController@detail')->name('admin.detail');
	//商品追加フォームと追加処理
	Route::get('/add', function() {
		return view('item.admin.add');
	})->name('admin.add');
	Route::get('/add/item', 'ItemController@index');//URL直叩き防止
	Route::post('/add/item', 'ItemController@add')->name('admin.add.item');
	//商品編集フォームと編集処理
	Route::get('/edit/{id?}', 'ItemController@edit')->name('admin.edit');
	Route::post('/edit/item', 'ItemController@update')->name('admin.update');
});

//twitterログイン
Route::get('/sns/twitter/login', 'Auth\LoginController@getAuth')->name('twitter.login');
Route::get('/sns/twitter/callback', 'Auth\LoginController@authCallback')->name('twitter.callback');

