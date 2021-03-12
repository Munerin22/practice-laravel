<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Socialite;
use App\User;

class SnsController extends Controller
{
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
		Storage::put('public/' . $img_name, $user->avatar);
		$twitter_info = [
			'twitter_id' => $user->id,
			'access_token' => $user->token,
			'access_token_secret' => $user->tokenSecret,
			'avatar' => $img_name,
			'profile' => $user->user['description'],
		];

		//ログインしていればTwitterのユーザー情報を更新。未ログインであれば新しく追加
		if (Auth::guard('user')->user()) {
			//ログインユーザーのIDを取得
			$user_id = Auth::guard('user')->user()->id;
			$user_update = User::find($user_id);
			$user_update->fill($twitter_info)->save();
		} else {
			$user_add = new User;
			$user_add->fill($twitter_info)->save();
		}

		return redirect()->route('index')->with('flash_message', 'Twitterログイン成功しました');
	}

	// ユーザー情報の取得
	public function getProviderUserInfo() {
		return Socialite::driver('twitter')->user();
	}
}
