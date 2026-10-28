<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAll()
    {
        return Product::with([
            'category',
            'subCategory',
        ])->orderBy('name', 'asc')->get();
    }

    public function store(
        ProductDTO $dto,
        Request $request
    ) {
        $data = $dto->toArray();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        return Product::create($data);
    }

    public function find($id)
    {
        return Product::with([
            'category',
            'subCategory',
        ])->findOrFail($id);
    }

    public function update(
        $id,
        ProductDTO $dto,
        Request $request
    ) {
        $product = Product::findOrFail($id);
        $data = $dto->toArray();

        if ($request->hasFile('image')) {
            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
    }
}
