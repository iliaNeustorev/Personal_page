<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
{
    /**
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current' => 'required|current_password',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'current' => 'текущий пароль',
            'password' => 'новый пароль',
        ];
    }
}
