<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemEditRequest extends FormRequest
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
			'name' => ['required', 'max:100', 'unique:items,name,' . $this->id . ',id'],
			'explain' => ['required', 'max:10000'],
			'stock' => ['required', 'max:1000000', 'numeric'],
        ];
    }
}
