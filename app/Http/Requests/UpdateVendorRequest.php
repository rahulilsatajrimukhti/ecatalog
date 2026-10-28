<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vendor     = $this->route('vendor');
        $vendorId   = $vendor instanceof \App\Models\Vendor
            ? $vendor->id
            : $vendor;

        return [
            'vendor_code'               => [
                'required',
                'string',
                'max:50',
                Rule::unique('vendors', 'vendor_code')->ignore($vendorId),
            ],

            'name'                      => 'required|string|max:150',
            'phone'                     => 'nullable|string|max:30',
            'email'                     => 'nullable|email|max:255',
            'address'                   => 'nullable|string',
            'contact_person'            => 'nullable|string|max:100',
            'npwp'                      => 'nullable|string|max:30',
            'certification'             => 'nullable|string|max:255',
            'is_active'                 => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'vendor_code.required'      => 'Kode vendor wajib diisi.',
            'vendor_code.unique'        => 'Kode vendor sudah digunakan.',
            'name.required'             => 'Nama vendor wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
        ];
    }
}
