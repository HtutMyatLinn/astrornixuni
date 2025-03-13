<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['max:30'],
            'username' => ['required', 'string', 'max:30'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages()
    {
        return [
            // Custom messages for first name
            'first_name.required' => 'First name must not be empty.',
            'first_name.max' => 'First name must not exceed 30 characters.',

            // Custom messages for last name
            'last_name.max' => 'Last name must not exceed 30 characters.',

            // Custom messages for username
            'username.required' => 'User name must not be empty.',
            'username.max' => 'User name must not exceed 30 characters.',
        ];
    }
}
