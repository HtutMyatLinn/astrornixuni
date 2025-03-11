<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment_text' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'comment_text.required' => 'Please enter your comment before submitting.',
            'comment_text.string' => 'Your comment must be a valid text.',
        ];
    }
}
