<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'balance_credit_card_full' => 'nullable|integer',
            'expend_category_main' => 'nullable|json',
            'income_category_main' => 'nullable|json',
            'expend_category_active' => 'nullable|json',
            'income_category_active' => 'nullable|json',
            'dark_mode' => 'nullable|boolean'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'data'      => $validator->errors()
        ]));
    }
}
