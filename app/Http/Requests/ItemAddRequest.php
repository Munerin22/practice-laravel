<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemAddRequest extends FormRequest
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
			'name' => ['required', 'max:100', 'unique:items,name'],
			'explain' => ['required', 'max:10000'],
			'price' => ['required', 'max:100000000', 'numeric'],
			'stock' => ['required', 'max:1000000', 'numeric'],
        ];
    }
}
