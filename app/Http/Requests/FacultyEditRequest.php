<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyEditRequest extends FormRequest
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
    public function rules()
    {
        return [
            'edit_faculty' => [
                'required',
                'string',
                'max:255',
                Rule::unique('faculties', 'faculty')->ignore($this->faculty_id, 'faculty_id')
            ],
            'edit_contact_number' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'edit_faculty.required' => 'The faculty name is required.',
            'edit_faculty.unique' => 'The faculty name has already been taken.',
            'edit_contact_number.required' => 'The contact number is required.',
        ];
    }
}
