<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',
            'product_code'      => 'required|string|max:50|unique:products,product_code',
            'name'              => 'required|string|max:150',
            'description'       => 'nullable|string',
            'purchase_price'    => 'required|numeric|min:0',
            'selling_price'     => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'minimum_stock'     => 'required|integer|min:0',
            'unit'              => 'required|string|max:30',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'         => 'required|boolean',
        ];
    }
}
