<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer'
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
