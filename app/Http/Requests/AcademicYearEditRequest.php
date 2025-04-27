<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicYearEditRequest extends FormRequest
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
            'edit_academic_year' => [
                'required',
                'string',
                'max:20',
                Rule::unique('academic_years', 'academic_year')->ignore($this->route('academic_year'), 'academic_year_id')
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'edit_academic_year.required' => 'Academic year is required.',
            'edit_academic_year.string' => 'Academic year must be a string.',
            'edit_academic_year.max' => 'Academic year must not exceed 20 characters.',
            'edit_academic_year.unique' => 'Academic year already exists.',
        ];
    }
}
