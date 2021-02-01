<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
		dd($user);
		//ログインユーザーのIDを取得
		$user_id = Auth::guard('user')->user()->id;
		//ログインしていればTwitterのユーザー情報を追加・更新
		if ($user_id) {
			$user_update = User::find($user_id);
			$twitter_info = [
				'twitter_id' => $user->id,
				'access_token' => $user->token,
				'access_token_secret' => $user->tokenSecret,
				'avatar' => $user->avatar,
				'profile' => $user->user['description'],
			];
			$user_update->fill($twitter_info)->save();
		}

		return redirect()->route('index')->with('flash_message', 'Twitterログイン成功しました');
	}

	// ユーザー情報の取得
	public function getProviderUserInfo() {
		return Socialite::driver('twitter')->user();
	}
}
