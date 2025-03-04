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

    public function messages()
    {
        return [
            // First name messages
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 30 characters.',

            // Last name messages
            'last_name.max' => 'Last name must not exceed 30 characters.',

            // Username messages
            'username.required' => 'Username is required.',
            'username.max' => 'Username must not exceed 30 characters.',
        ];
    }
}
