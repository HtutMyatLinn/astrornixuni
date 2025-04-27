<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAccountSettingRequest extends FormRequest
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
            'last_name' => ['nullable', 'string', 'max:30'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.max' => 'Username must not exceed 30 characters.',
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 30 characters.',
            'last_name.max' => 'Last name must not exceed 30 characters.',
            'profile_image.image' => 'The file must be an image.',
            'profile_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'profile_image.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
