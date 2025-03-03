<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
            'faculty' => 'required|string|max:255|unique:faculties,faculty',
            'contact_number' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'faculty.required' => 'Faculty is required.',
            'faculty.string' => 'Faculty must be a string.',
            'faculty.max' => 'Faculty must not exceed 255 characters.',
            'faculty.unique' => 'Faculty already exists.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.string' => 'Contact number must be a string.',
            'contact_number.max' => 'Contact number must not exceed 20 characters.',
        ];
    }
}
