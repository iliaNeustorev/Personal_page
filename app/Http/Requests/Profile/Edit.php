<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Edit extends FormRequest
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
            'first_name' => ['string', 'min:3', 'max:255'],
            'last_name' => ['string', 'min:3', 'max:255'],
            'middle_name' => ['string', 'min:3', 'max:255'],
            'email' => ['string', 'email', 'min:3', 'max:255', Rule::unique('users')->ignore(request()->user()->id)],
            'phone' => ['nullable', 'numeric', 'digits_between:5,50'],
        ];
    }
}
