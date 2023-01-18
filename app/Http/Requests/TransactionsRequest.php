<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer',
            'money' => 'required|integer',
            'date_transaction' => 'required|date',
            'comment' => 'nullable|string',
            'credit' => 'required|boolean'
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
