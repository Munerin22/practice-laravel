<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller {
	public function index() {
		$items = Item::all();
		return view('item.index', compact('items'));
	}

	public function detail($item_name = null) {
		//DBからURLパラメータの商品レコードを取得
		$item_detail = Item::Where('name', $item_name)->first();
		//$detailItemがあるかどうか確認
		if ($item_detail) {
			return view('item.detail', compact('item_detail'));
		} else {
			return redirect('/');
		}
	}
}
