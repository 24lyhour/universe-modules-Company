<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'industry' => ['nullable', 'string', 'max:100'],
            'founded_year' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'company_size' => ['nullable', 'string', 'in:1-10,11-50,51-200,201-500,501-1000,1000+'],
            'status' => ['sometimes', 'required', 'in:active,inactive'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'website.url' => 'The website must be a valid URL.',
            'email.email' => 'The email must be a valid email address.',
            'founded_year.min' => 'The founded year must be at least 1800.',
            'founded_year.max' => 'The founded year cannot be in the future.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}
