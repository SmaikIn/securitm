<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'page' => 'integer',
            'search' => 'string',
            'sort' => 'bool',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
