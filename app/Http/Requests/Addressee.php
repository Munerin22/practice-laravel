<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Addressee extends FormRequest
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
			'post_number' => ['required', 'integer', 'numeric', 'max:7', 'min:7'],
			'prefecture' => ['required'],
			'city' => ['required', 'string'],
			'below_address' => ['required', 'max:500'],
			'phone' => ['required', 'max:11', 'numeric', 'integer']
        ];
    }
}
