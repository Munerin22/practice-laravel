<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use App\Cart;

class CartController extends Controller
{
    //
	//カートの一覧
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

	//選択した商品をカートから削除
	public function delete(Request $request) {
		//urlから選択した商品のユーザーIDを取得
		$cart_user = Cart::where('id', $request->id)->first(['user_id']);
		if (!$cart_user) {
			return redirect()->route('cart.index');
		}

		$user_id = Auth::guard('user')->user()->id;
		//ログインユーザーが他のユーザーのカート内削除の防止
		if ($user_id === $cart_user->user_id) {
			Cart::where('id', $request->id)->delete();
		}
		return redirect()->route('cart.index');
	}
}
