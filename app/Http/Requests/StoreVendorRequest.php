<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_code'           => 'required|string|max:50|unique:vendors,vendor_code',
            'name'                  => 'required|string|max:150',
            'phone'                 => 'nullable|string|max:30',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string',
            'contact_person'        => 'nullable|string|max:100',
            'npwp'                  => 'nullable|string|max:30',
            'certification'         => 'nullable|string|max:255',
            'is_active'             => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'vendor_code.required'  => 'Kode vendor wajib diisi.',
            'vendor_code.unique'    => 'Kode vendor sudah digunakan.',
            'name.required'         => 'Nama vendor wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
        ];
    }
}
