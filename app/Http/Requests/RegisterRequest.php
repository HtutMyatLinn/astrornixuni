<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
            'username' => ['required', 'string', 'max:30'],
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['max:30'],
            'email' => ['required', 'string', 'max:30', 'email', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', 'max:16', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[\W_]/', Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            // Username messages
            'username.required' => 'Username is required.',
            'username.max' => 'Username must not exceed 30 characters.',

            // First name messages
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 30 characters.',

            // Last name messages
            'last_name.max' => 'Last name must not exceed 30 characters.',

            // Email messages
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a string.',
            'email.max' => 'Email must not exceed 30 characters.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email is already taken.',

            // Password messages
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password must not exceed 16 characters.',
            'password.regex' => 'Password does not meet the default requirements.',
            'password.defaults' => 'Password does not meet the default requirements.',
        ];
    }
}
