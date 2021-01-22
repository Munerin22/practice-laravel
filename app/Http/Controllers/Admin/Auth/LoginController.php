<?php

namespace App\Http\Controllers\Admin\Auth;//パスの修正
use App\Http\Controllers\Admin\Auth;//モデルをApp\Userから変更
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/admin/home';//ログイン後のリダイレクト先

	//ログイン画面
	public function showLoginForm() {
		return view('admin.login'); //管理者ログインページのテンプレート
	}

	protected function guard() {
		return \Auth::guard('admin'); //管理者認証のguardを指定
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest:admin')->except('logout');
	}

	//ログアウト処理
	public function logout(Request $request)
	{
		$this->guard('admin')->logout();
		// $request->session()->invalidate();全部のSessionを消してしまう
		return redirect('/');
	}
}
