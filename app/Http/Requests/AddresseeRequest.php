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
			'post_number' => ['required', 'numeric', 'string', 'regex:/^[0-9]{7}/'],
			'prefecture' => ['required'],
			'city' => ['required', 'string'],
			'below_address' => ['required', 'max:500'],
			'phone' => ['required', 'numeric', 'string', 'regex:/^[0-9]{10,11}/']
        ];
    }
}
