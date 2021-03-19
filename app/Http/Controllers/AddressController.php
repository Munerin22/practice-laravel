<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AddresseeRequest;
use App\Addressee;
use App\Prefecture;

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
		return view('address.index', compact('addressees', 'user_id'));

	}

	//送り先追加フォーム
	public function addform() {
		$prefectures = Prefecture::all();
		return view('address.add', compact('prefectures'));
	}

	//送り先の追加
	public function add(AddresseeRequest $request) {
		$addressee_add = new Addressee;
		$address = $request->all();
		unset($address['_token']);
		//dd($address);
		if (!Prefecture::where('name', $address['prefecture'])) {
			return redirect()->route('index');
		}
		$addressee_add->fill($address)->save();

		//送り先追加後
		return redirect()->route('address.index')->with('flash_message', '送り先を追加しました');
	}
}
