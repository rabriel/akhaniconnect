<?php

namespace App\Http\Requests\Verification;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverLicenceVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('candidate')
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
            'front_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'back_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ];
    }
}
