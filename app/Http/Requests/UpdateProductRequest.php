<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',

            'product_code'      => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'product_code')->ignore($productId),
            ],

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
