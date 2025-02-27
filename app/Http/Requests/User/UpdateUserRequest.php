<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required | integer',
            'name' => 'required | string | max:255',
            'ip' => 'required | string | ipv4',
            'comment' => 'required | string | max:255',
            'password' => 'required | string',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('userId')]);
    }
}
