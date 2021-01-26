<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		//管理者用も追加
		$redir = '/home';
		switch ($guard) {
			case "admin":
				$redir = '/admin/index';
				break;
			default:
				$redir = '/';
				break;
			}
		//ここまで

        if (Auth::guard($guard)->check()) {
            return redirect($redir); //'/home'->$redirに変更
        }

        return $next($request);
    }
}
