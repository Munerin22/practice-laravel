<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;

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
	public function add() {
		$items = item::all();
		//管理者ログインの場合、管理者用のページにリダイレクト
		if (auth::guard('admin')->user()){
			return view('item.admin.index', compact('items'));
		}
		return view('item.index', compact('items'));
	}

	//商品の編集
	public function edit() {
		$items = item::all();
		//管理者ログインの場合、管理者用のページにリダイレクト
		if (auth::guard('admin')->user()){
			return view('item.admin.index', compact('items'));
		}
		return view('item.index', compact('items'));
	}
}
