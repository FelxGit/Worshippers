<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Rules\FileRuleTrait;

class FileRequest extends BaseRequest
{
    use FileRuleTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->fileType == \Globals::FILETYPE_IMAGE) {
            if ($this->image) {
                $rules[$this->validateField] = $this->imageRule('required');
            }
        }

        return $rules;
    }
}
