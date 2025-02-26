<?php

namespace app\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'integer|required',
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
