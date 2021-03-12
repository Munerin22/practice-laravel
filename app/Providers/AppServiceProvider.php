<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		\Illuminate\Support\Facades\Schema::defaultStringLength(191);

		// 管理画面用のクッキー名称を変更
		$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		//uriにadminが含まれる場合にtrue
		if (strpos($uri, '/admin/') == true || $uri === '/admin/login') {
			//configファイルsession.phpのcookie => configファイルconst.phpのsession_cookie_adminにする
			config(['session.cookie' => config('const.session_cookie_admin')]);
		}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
