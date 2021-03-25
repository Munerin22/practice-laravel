<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AddresseeRequest;
use App\Addressee;
use App\Prefecture;

class AddressController extends Controller
{
	//送り先情報の取得
	function sendInfomation() {
		$user_id = Auth::guard('user')->user()->id;

		$addressees = null;
		//ログインユーザーがAddressテーブルにレコードを持っているか確認
		if (Addressee::where('user_id', $user_id)) {
			//ログインユーザーのお届け先住所を取得
			$addressees = Addressee::where('user_id', $user_id)->get();
		}
		return [$addressees, $user_id];
	}

	//送り先一覧の表示
	public function index() {
		list($addressees, $user_id) = $this->sendInfomation();
		return view('address.index', compact('addressees', 'user_id'));
	}

	//送り先追加フォーム
	public function addform() {

		//送り先追加後の画面
		$view = 'address.index';

		//直前のURL情報を取得
		$url = url()->previous();
		if (strpos($url, 'cart/send') !== false) {
			$view = 'cart.send';
		}

		//都道府県名の取得
		$prefectures = Prefecture::all();
		return view('address.add', compact('prefectures', 'view'));
	}

	//送り先の追加
	public function add(AddresseeRequest $request) {

		$addressee_add = new Addressee;
		$address = $request->all();
		$view = $address['url'];
		unset($address['url']);
		unset($address['_token']);
		if (!Prefecture::where('name', $address['prefecture'])) {
			return redirect()->route('index');
		}
		$addressee_add->fill($address)->save();

		//送り先追加後
		if ($view == 'cart.send') {
			return redirect()->route('cart.send')->with('flash_message', '送り先を追加しました');
		}
		return redirect()->route('address.index')->with('flash_message', '送り先を追加しました');
	}

	//送り先の編集
	public function editform($address_id = null) {

		$address = Addressee::where('id', $address_id)->first();
		if (!$address || $address['user_id'] !== Auth::guard('user')->user()->id) {
			return redirect()->route('index');
		}

		//都道府県名の取得
		$prefectures = Prefecture::all();

		return view('address.edit', compact('address', 'prefectures'));
	}

	//送り先の更新
	public function edit(AddresseeRequest $request) {
		$address_update = Addressee::find($request->id);

		if (!$address_update || $address_update['user_id'] !== Auth::guard('user')->user()->id) {
			return redirect()->route('index');
		}

		$address = $request->all();
		unset($address['_token']);
		$address_update->fill($address)->save();

		//送り先編集後
		return redirect()->route('address.index')->with('flash_message', '送り先を編集しました');
	}

	//送り先の削除
	public function delete($address_id = null) {
		$address = Addressee::find($address_id);
		if (!$address || $address['user_id'] !== Auth::guard('user')->user()->id) {
			return redirect()->route('index');
		}

		Addressee::where('id', $address_id)->delete();

		//送り先削除後
		return redirect()->route('address.index')->with('flash_message', '送り先を削除しました');
	}


	//カートから送り先選択画面へ
	public function cartsend() {
		list($addressees, $user_id) = $this->sendInfomation();
		return view('cart.send', compact('addressees', 'user_id'));
	}
}
