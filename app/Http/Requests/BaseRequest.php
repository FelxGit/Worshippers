<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
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
