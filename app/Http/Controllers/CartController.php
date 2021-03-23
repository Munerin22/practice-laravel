<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use App\Cart;
use App\Addressee;
use DB;

class CartController extends Controller
{
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
		return view('cart.index', compact('carts'));
	}

	//選択した商品をカートから削除
	public function delete(Request $request) {
		//選択した商品（ユーザーID）を取得
		$cart_user = Cart::where('id', $request->id)->first();
		//存在しない商品（ユーザー）であればリダイレクト
		if (!$cart_user) {
			return redirect()->route('cart.index')->with('flash_message', '選択した商品はカートに存在してないです');
		}

		$user_id = Auth::guard('user')->user()->id;
		//ログインユーザーによる他のユーザーのカート内削除の防止
		if ($user_id === $cart_user->user_id) {
			//DBの複数処理_トランザクション
			DB::transaction(function () use ($request, $cart_user) {
				//カートの中身を在庫に足す
				$item = Item::with('cart')->where('id', $cart_user->item_id)->first();
				$item->increment('stock', $cart_user->count);
			});
			//カートの商品を削除
			Cart::where('id', $request->id)->delete();
		}
		return redirect()->route('cart.index');
	}

	//カートに追加
	public function add(Request $request) {
		//選択した商品の在庫が存在するか確認
		$item_check = Item::where('id', $request->id)->where('stock', '>', 0)->first();
		if (!$item_check) {
			return redirect()->route('cart.index')->with('flash_message', '選択した商品の在庫はないです');
		}

		//DBの複数処理_トランザクション
		DB::transaction(function () use ($item_check) {
			$user_id = Auth::guard('user')->user()->id;
			//ユーザーがカートに既に追加しているか確認
			//既にある場合はインクリメントで更新
			if (Cart::with('item')->where('user_id', $user_id)->where('item_id', $item_check->id)->exists()) {
				$cart = Cart::with('item')->where('user_id', $user_id)->where('item_id', $item_check->id)->first();
				$cart->increment('count');
				$cart->increment('cost', $item_check->price);
			} else {
				//新しくカートに追加
				$cart_add = new Cart;
				$cart = [
					'item_id' => $item_check->id,
					'count' => 1,
					'cost' => $item_check->price,
					'user_id' => $user_id
				];
				$cart_add->fill($cart)->save();
			}
			//商品追加後、在庫数をデクリメント
			$item_check->decrement('stock');
		});
		return redirect()->route('cart.index');
	}

	//カートから送り先選択画面へ
	public function send() {

		//ログインユーザーのIDを取得
		$user_id = Auth::guard('user')->user()->id;

		$addressees = null;
		//ログインユーザーがAddressテーブルにレコードを持っているか確認
		if (Addressee::where('user_id', $user_id)) {
			//ログインユーザーのお届け先住所を取得
			$addressees = Addressee::where('user_id', $user_id)->get();
		}
		return view('cart.send', compact('addressees', 'user_id'));

	}
}
