<?php

namespace App\Http\Requests\Verification;

use Illuminate\Foundation\Http\FormRequest;

class StoreSouthAfricanIdVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('candidate')
            || $this->user()?->hasRole('client')
            || $this->user()?->hasRole('recruitment')
            || $this->user()?->hasRole('procurement');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_number' => ['required', 'string', 'size:13', 'regex:/^[0-9]{13}$/'],
        ];
    }
}
