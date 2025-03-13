<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntakeEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'edit_intake' => 'required|string|max:50',
            'status' => 'required|in:active,finished,upcoming',
            'edit_academic_year_select' => 'required|exists:academic_years,academic_year_id',
            'edit_closure_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'edit_intake.required' => 'The intake is required.',
            'edit_intake.string' => 'The intake must be a string.',
            'edit_intake.max' => 'The intake may not be greater than 50 characters.',
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',
            'edit_academic_year_select.required' => 'The academic year is required.',
            'edit_academic_year_select.exists' => 'The selected academic year is invalid.',
            'edit_closure_date.required' => 'The closure date is required.',
            'edit_closure_date.date' => 'The closure date must be a valid date.',
        ];
    }
}
