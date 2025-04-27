<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributionCategoryRequest extends FormRequest
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
            'contribution_category' => 'required|string|max:255|unique:contribution_categories,contribution_category',
        ];
    }

    public function messages()
    {
        return [
            'contribution_category.required' => 'Contribution Category is required.',
            'contribution_category.string' => 'Contribution Category must be a string.',
            'contribution_category.max' => 'Contribution Category must not exceed 255 characters.',
            'contribution_category.unique' => 'Contribution Category already exists.',
        ];
    }
}
