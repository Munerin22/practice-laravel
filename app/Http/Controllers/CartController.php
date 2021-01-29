<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use App\Cart;

class CartController extends Controller
{
    //
	//商品の一覧
	public function index() {
		//ログインユーザーのIDを取得
		$user_id = Auth::guard('user')->user()->id;

		$carts = null;
		//ログインユーザーがCartテーブルにレコードを持っているか確認
		if (Cart::with('item')->where('user_id', $user_id)->exists()) {
			//ログインユーザーがカートに入れているアイテムを取得
			$carts = Cart::with('item')->where('user_id', $user_id)->get();
		}
		//dd($carts);

		return view('cart.index', compact('carts'));
	}
}
