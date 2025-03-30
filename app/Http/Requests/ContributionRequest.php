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
            'contribution_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'contribution_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'contribution_file_path' => 'mimes:doc,docx',
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

            'contribution_cover.image' => 'The cover must be an image file.',
            'contribution_cover.mimes' => 'Only JPEG, PNG and JPG formats are allowed for the cover.',

            'contribution_images.*.image' => 'Only image files are allowed.',
            'contribution_images.*.mimes' => 'Only JPEG, PNG and JPG formats are allowed.',

            'contribution_file_path.mimes' => 'Only Word files (.doc, .docx) are allowed.',

            'terms_and_conditions.required' => 'You must agree to the terms and conditions.',
            'terms_and_conditions.accepted' => 'You must agree to the terms and conditions.',
        ];
    }
}
