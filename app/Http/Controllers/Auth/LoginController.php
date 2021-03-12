<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;
use App\User;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	//ログアウト処理
	public function logout(Request $request)
	{
		$this->guard()->logout();
		return redirect('/index');
	}

	// Socialiteのドライバーにリダイレクトさせる
	public function getAuth() {
		return Socialite::driver('twitter')->redirect();
	}

	//  Twitterから戻ってくる際のエンドポイント作成
	public function authCallback() {
	//  ユーザー情報の取得
		try {
			$user = $this->getProviderUserInfo('twitter');
		} catch(\Exception $e) {
			return redirect('/sns/twitter/login');
		}

		//Twitterから取得した情報を保存するために整理
		//画像名
		$img_name = substr($user->avatar, strrpos($user->avatar, '/') +1);
		 //サーバーにアップロード
		Storage::put('public/image/' . $img_name, $user->avatar);
		 $twitter_info = [
			'twitter_id' => $user->id,
			'access_token' => $user->token,
			'access_token_secret' => $user->tokenSecret,
			'avatar' => $img_name,
			'profile' => $user->user['description'],
		];

		//Twitterのメールアドレス登録の有無を確認
		if (!$user->email) {
			$email = $user->nickname . '@user.com';
		} else {
			$email = $user->email;
		}
		//Twitter認証によるアカウント登録はパスを固定
		$password = '12345678';

		//1度Twitter認証していればTwitterのユーザー情報を更新。初回認証であれば新しく追加
		if (User::where('email', $email)->first()) {
			$user_data = User::where('email', $email)->first();
			$user_data->fill($twitter_info)->save();
		} else {
			$user_data = new User;
			$twitter_info = array_merge($twitter_info, array(
				'name' => $user->nickname,
				'email' => $email,
				'password' => Hash::make($password),
			));
			$user_data->fill($twitter_info)->save();
		}

		//TwitterでLaravelにログイン
		Auth::attempt(['email' => $email, 'password' => $password]);
		return redirect()->route('index')->with('flash_message', 'Twitterログイン成功しました');
	}

	// ユーザー情報の取得
	public function getProviderUserInfo() {
		return Socialite::driver('twitter')->user();
	}
}
