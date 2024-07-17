<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shop_name' => ['unique','string','max:50', Rule::unique(Shop::class)->ignore($this->user()->id)],
            'shop_description' => ['required','string','max:200'],
            'shop_address' => ['required','string'],
            'shop_phone' => ['required','string'],
            'opening_time' => ['required','string'],
            'closing_time' => ['required','string'],
            'shop_logo' => ['required','string'],
            'shop_email' => ['required','string'],
            'payment_method' => ['required','string'],
        ];
    }
}
