<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'rating' => ['required','string', 'max:5'],
            'reviewer_email' => ['required','email', 'max:255'],
            'reviewer_name'=>['required','min:3'],
            'review_message'=>['required','string'],   
        ];
    }
}
