<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutUserRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'firstname' => 'required|max:255',
            'middlename' => 'max:255',
            'lastname' => 'required|max:255',
            'nick_name' => 'string|max:255',
            'avatar' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'in:0,1', // 0 - male, 1 female
            'zip_code' => 'required|string|max:8',
            'address' => 'string|min:4|max:255',
            'tel' => 'string'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $nameParts = [$this->firstname];

        if ($this->middlename) {
            $nameParts[] = $this->middlename;
        }

        if ($this->lastname) {
            $nameParts[] = $this->lastname;
        }

        $this->merge([
            'name' => implode(' ', $nameParts)
        ]);
    }
}