<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'role' => 'required|string|max:30|unique:roles,role',
            'functionalities' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'Role is required.',
            'role.string' => 'Role must be a string.',
            'role.max' => 'Role must not exceed 30 characters.',
            'role.unique' => 'Role already exists.',
            'functionalities.string' => 'Functionalities must be a string.',
            'functionalities.max' => 'Functionalities must not exceed 255 characters.',
        ];
    }
}
