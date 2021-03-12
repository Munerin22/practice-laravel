<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests\ItemAddRequest;
use App\Http\Requests\ItemEditRequest;

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

		//存在しない商品IDがurlに含まれていた場合のリダイレクト先
		$route = 'index';
		if (Auth::guard('admin')->user()){
			$route = 'admin.index';
		}

		//$detailItemがあるかどうか確認
		if ($item_detail) {
			//管理者ログインの場合、管理者用のページにリダイレクト
			if (Auth::guard('admin')->user()){
				return view('item.admin.detail', compact('item_detail'));
			} else {
				return view('item.detail', compact('item_detail'));
			}
		} else {
			return redirect()->route($route);
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
		return redirect()->route('admin.index');
	}

	//商品の編集
	public function edit($item_id = null) {
		$item_edit = Item::where('id', $item_id)->first();
		if ($item_edit) {
			session()->put('edit_id', $item_id);
			return view('item.admin.edit', compact('item_edit'));
		} else {
			return redirect()->route('admin.index');
		}
	}

	//商品の更新
	public function update(ItemEditRequest $request) {
		//商品情報の更新
		$request->id = session()->get('edit_id');
		$item_update = Item::find($request->id);

		//IDが存在しない場合
		if (!$item_update) {
			return redirect()->route('admin.index');
		}

		$item = $request->all();
		unset($item['_token']);
		$item_update->fill($item)->save();

		//商品追加後_編集ページアクセス時に取得したセッションを破棄
		session()->pull('edit_id');
		return redirect()->route('admin.index');
	}
}
