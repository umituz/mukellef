<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'renewal_at' => 'required|date',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'renewal_at.required' => __('The :attribute field is required.'),
            'renewal_at.date' => __('The :attribute must be a valid date.'),
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'renewal_at' => __('Renewal Date'),
        ];
    }
}
