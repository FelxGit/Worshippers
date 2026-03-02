<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends BaseRequest
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
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|string|max:255',
            'password' => 'required|confirmed|max:255',
            'firstname' => 'required|max:255',
            'middlename' => 'max:255',
            'lastname' => 'required|max:255',
            'name' => 'required|string|max:255',
            'nick_name' => 'string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'in:0,1', // 0 - male, 1 female
            'zip_code' => 'required|string|max:8',
            'address' => 'string|min:4|max:255',
            'tel' => 'string|size:11',
            'termsAndPrivacy' => 'accepted'
        ];
    }
}
