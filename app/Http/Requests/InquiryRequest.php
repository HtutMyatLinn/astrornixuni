<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Set to true to allow all users to submit the form
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'priority_level' => 'required',
            'inquiry' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'priority_level.required' => 'The priority level is required.',
            'inquiry.required' => 'The inquiry message is required.',
            'inquiry.string' => 'The inquiry must be a string.',
        ];
    }
}
