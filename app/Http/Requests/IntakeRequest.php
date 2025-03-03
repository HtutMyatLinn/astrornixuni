<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntakeRequest extends FormRequest
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
            'intake' => 'required|string|max:50',
            'academic_year' => 'required|exists:academic_years,academic_year_id',
            'closure_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'intake.required' => 'The intake is required.',
            'intake.string' => 'The intake must be a string.',
            'intake.max' => 'The intake may not be greater than 50 characters.',
            'academic_year.required' => 'The academic year is required.',
            'academic_year.exists' => 'The selected academic year is invalid.',
            'closure_date.required' => 'The closure date is required.',
            'closure_date.date' => 'The closure date must be a valid date.',
        ];
    }
}
