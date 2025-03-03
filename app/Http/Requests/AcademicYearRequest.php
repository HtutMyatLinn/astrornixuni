<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicYearRequest extends FormRequest
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
            'academic_year' => 'required|string|max:20|unique:academic_years,academic_year',
        ];
    }

    public function messages()
    {
        return [
            'academic_year.required' => 'Academic year is required.',
            'academic_year.string' => 'Academic year must be a string.',
            'academic_year.max' => 'Academic year must not exceed 20 characters.',
            'academic_year.unique' => 'Academic year already exists.',
        ];
    }
}
