<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SnsController extends Controller
{
	// Socialiteのドライバーにリダイレクトさせる
	public function getAuth() {
		return Socialite::driver('twitter')->redirect();
	}

	//  Twitterから戻ってくる際のエンドポイント作成
	public function authCallback() {
		//  ユーザー情報の取得
		$user_info = $this->getProviderUserInfo('twitter');
		dd($user_info); //デバック用
		return view('sns.callback');
	}

	// ユーザー情報の取得
	public function getProviderUserInfo() {
		return Socialite::driver('twitter')->user();
	}
}
