<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddresseeRequest extends FormRequest
{
	/**
	* Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize()
	{
		return true;
	}

	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules()
	{
		return [
			//
			'name' => ['required', 'max:50'],
			'post_number' => ['required', 'numeric', 'string'],
			'prefecture' => ['required'],
			'city' => ['required', 'string'],
			'below_address' => ['required', 'max:500'],
			'phone' => ['required', 'numeric', 'string']
		];
	}

	public function messages()
	{
		return [
			'name' => '名前を入力してください',
			'post_number' => '半角数字を入力してください',
			'prefecture' => '都道府県名を入力してください',
			'city' => '市町村名を入力してください',
			'below_address' => '市町村以降の住所を入力してください',
			'phone' => '半角数字で入力してください'
		];
	}
}
