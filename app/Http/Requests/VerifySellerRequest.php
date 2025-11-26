<?php

namespace App\Http\Requests;

use App\Models\Seller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifySellerRequest extends FormRequest
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
            'status' => ['required', Rule::in([Seller::STATUS_APPROVED, Seller::STATUS_REJECTED])],
            'verification_notes' => [
                Rule::requiredIf(fn () => $this->input('status') === Seller::STATUS_REJECTED),
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
