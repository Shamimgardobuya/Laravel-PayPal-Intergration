<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_number' => 'required|phone:KE',
            'amount' => 'required|integer|min:1',
            'item'=> 'required|string|max:25'

        ];
    }

    public function messages()
    {
        return [
            'phone_number.required' => 'Phone number is required',
            'amount.required' => 'Amount is required',
            'item.required' => 'Item is required',
        ];
    }
}
