<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Addressee;

class AddressController extends Controller
{
    //
	public function index() {
		//ログインユーザーのIDを取得
		$user_id = Auth::guard('user')->user()->id;

		$addressees = null;
		//ログインユーザーがAddressテーブルにレコードを持っているか確認
		if (Addressee::where('user_id', $user_id)) {
			//ログインユーザーのお届け先住所を取得
			$addressees = Addressee::where('user_id', $user_id)->get();
		}
		return view('address.index', compact('addressees'));

	}
}
