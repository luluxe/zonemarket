<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',

            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => [
                'required',
                'min:8',
                'regex:/^.*(?=.*[a-z])(?=.*[0-9]).*$/', // Check we have one character and one number
                'confirmed',
            ],
        ];
    }
}
