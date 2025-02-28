<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributionCategoryEditRequest extends FormRequest
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
            'edit_contribution_category' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'edit_contribution_category.required' => 'Contribution category is required.',
            'edit_contribution_category.string' => 'Contribution category must be a string.',
            'edit_contribution_category.max' => 'Contribution category must not exceed 255 characters.',
        ];
    }
}
