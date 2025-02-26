<?php

namespace app\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'ip' => ['required'],
            'comment' => ['required'],
            'password' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
