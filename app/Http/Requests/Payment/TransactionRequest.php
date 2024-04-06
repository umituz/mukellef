<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'subscription_id' => 'required|exists:subscriptions,id',
            'price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'subscription_id.required' => __('Subscription ID is required.'),
            'subscription_id.exists' => __('Subscription not found.'),
            'price.required' => __('Price is required.'),
            'price.numeric' => __('Price must be a number.'),
            'price.min' => __('Price must be greater than or equal to 0.'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'subscription_id' => __('Subscription ID'),
            'price' => __('Price'),
        ];
    }
}
