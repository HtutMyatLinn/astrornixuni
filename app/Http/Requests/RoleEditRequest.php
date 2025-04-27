<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleEditRequest extends FormRequest
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
            'edit_role' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'role')->ignore($this->role_id, 'role_id') // Ignore current role
            ],
            'edit_functionalities' => 'nullable|string',
        ];
    }


    public function messages()
    {
        return [
            'edit_role.required' => 'Role is required.',
            'edit_role.string' => 'Role must be a string.',
            'edit_role.max' => 'Role must not exceed 255 characters.',
            'edit_role.unique' => 'The role has already been taken.',
            'edit_functionalities.string' => 'Functionalities must be a string.',
        ];
    }
}
