<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantOnboardingRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_name' => 'required|string|max:255|unique:tenants,name',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
