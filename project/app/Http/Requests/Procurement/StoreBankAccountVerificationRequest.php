<?php

namespace App\Http\Requests\Procurement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBankAccountVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('procurement') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(['Individual', 'Company'])],
            'first_name' => ['nullable', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'identity_number' => ['required', 'string', 'max:50'],
            'identity_type' => ['required', 'string', 'max:50'],
            'bank_account_number' => ['required', 'string', 'max:20'],
            'bank_branch_code' => ['required', 'string', 'size:6'],
            'bank_account_type' => ['required', 'string', 'max:50'],
        ];
    }
}
