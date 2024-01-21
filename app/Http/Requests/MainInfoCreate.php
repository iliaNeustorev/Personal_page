<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\Rule;

class MainInfoCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quotes' => ['nullable', 'string'],
            'education' => ['required', 'string'],
            'teaching_experience' => ['required', 'string', 'max:255'],
            'teaching_category' => ['required', 'string', 'max:255'],
            'personal_slogan' => ['nullable', 'string'],
            'credo' => ['nullable', 'string'],
            'personal_email_teacher' => ['nullable', 'email', 'max:64'],
            'kindergarten_in_place_work' => ['nullable', 'string'],
            'address_kindergarten' => ['nullable', 'string', 'max:255'],
            'phone_kindergarten' => ['nullable', 'string', 'max:64'],
            'working_principles' => ['array'],
            'personal_qualities' => ['array'],
        ];
    }

    /**
     * Undocumented function
     *
     * @return Unique
     */
    protected function uniqueRule(): Unique
    {
        return Rule::unique('main_info_teachers');
    }
}
