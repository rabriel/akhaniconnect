<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCandidateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('candidate') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()?->id;
        $provinces = config('south_africa.provinces', []);
        $noticePeriods = config('south_africa.notice_periods', []);
        $jobIndustries = config('south_africa.job_industries', []);
        $employmentTypes = config('south_africa.employment_types', []);
        $educationLevels = config('south_africa.education_levels', []);

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone,' . $userId, 'regex:/^(\+27|0)[0-9]{9}$/'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', Rule::in($provinces)],
            'job_title' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'employment_status' => ['nullable', 'string', 'max:100'],
            'notice_period' => ['nullable', 'string', Rule::in($noticePeriods)],
            'willing_to_relocate' => ['nullable', 'boolean'],
            'job_industry' => ['nullable', 'string', Rule::in($jobIndustries)],
            'preferred_employment_type' => ['nullable', 'string', Rule::in($employmentTypes)],
            'salary_expectation' => ['nullable', 'string', 'max:100'],
            'education_level' => ['nullable', 'string', Rule::in($educationLevels)],
            'education' => ['nullable', 'string', 'max:3000'],
            'certifications' => ['nullable', 'string', 'max:3000'],
            'experience' => ['nullable', 'string', 'max:4000'],
            'skills' => ['nullable', 'string', 'max:3000'],
            'bio' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
