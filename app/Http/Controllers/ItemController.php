<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests\ItemAddRequest;

class ItemController extends Controller {
	//商品の一覧
	public function index() {
		$items = Item::all();
		//管理者ログインの場合、管理者用のページにリダイレクト
		if (Auth::guard('admin')->user()){
			return view('item.admin.index', compact('items'));
		}
		return view('item.index', compact('items'));
	}

	//商品の詳細
	public function detail($item_id = null) {
		//DBからURLパラメータの商品レコードを取得
		$item_detail = Item::where('id', $item_id)->first();
		//$detailItemがあるかどうか確認
		if ($item_detail) {
			//管理者ログインの場合、管理者用のページにリダイレクト
			if (Auth::guard('admin')->user()){
				return view('item.admin.detail', compact('item_detail'));
			} else {
				return view('item.detail', compact('item_detail'));
			}
		} else {
			return redirect('/');
		}
	}

	//商品追加
	public function add(ItemAddRequest $request) {
		//商品の追加
		$item_add = new Item;
		$item = $request->all();
		unset($item['_token']);
		$item_add->fill($item)->save();

		//商品追加後
		$items = Item::all();
		return view('item.admin.index', compact('items'));
	}

	//商品の編集
	public function edit() {
		$item_url = url()->previous();
		return view('item.admin.edit', compact('items'));
	}
}
