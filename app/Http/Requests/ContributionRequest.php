<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributionRequest extends FormRequest
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
            'contribution_title' => 'required|string|max:70',
            'intake_id' => 'required|exists:intakes,intake_id',
            'contribution_category_id' => 'required|exists:contribution_categories,contribution_category_id',
            'contribution_description' => 'required|string',
            'terms_and_conditions' => 'required|accepted'
        ];
    }

    public function messages(): array
    {
        return [
            'contribution_title.required' => 'The contribution title is required.',
            'contribution_title.string' => 'The contribution title must be a string.',
            'contribution_title.max' => 'The contribution title must not exceed 70 characters.',

            'intake_id.required' => 'The intake ID is required.',
            'intake_id.exists' => 'The selected intake ID is invalid.',

            'contribution_category_id.required' => 'The contribution category is required.',
            'contribution_category_id.exists' => 'The selected contribution category is invalid.',

            'contribution_description.required' => 'The contribution description is required.',
            'contribution_description.string' => 'The contribution description must be a string.',

            'terms_and_conditions.required' => 'You must agree to the terms and conditions.',
            'terms_and_conditions.accepted' => 'You must agree to the terms and conditions.',
        ];
    }
}
