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

    private function disk(): string
    {
        return config('filesystems.product_disk', 'public');
    }

    /**
     * Daftar produk per halaman, dengan filter kategori dan pencarian.
     * Filter: ['category' => id, 'search' => teks]
     */
    public function paginate(array $filters = [], int $perPage = 10)
    {
        return Product::with([
            'category',
            'subCategory',
        ])
            ->when(! empty($filters['category']), function ($q) use ($filters) {
                $q->where('category_id', (int) $filters['category']);
            })
            ->when(! empty($filters['search']), function ($q) use ($filters) {
                $search = trim($filters['search']);

                $q->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')   // sama dengan urutan getAll()
            ->paginate($perPage)
            ->withQueryString();       // filter tetap terbawa saat pindah halaman
    }

    public function store(
        ProductDTO $dto,
        Request $request
    ) {
        $data = $dto->toArray();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', $this->disk());
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
                Storage::disk($this->disk())->exists($product->image)
            ) {
                Storage::disk($this->disk())->delete($product->image);
            }

            $data['image'] = $request->file('image')
                ->store('products', $this->disk());
        }

        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if (
            $product->image &&
            Storage::disk($this->disk())->exists($product->image)
        ) {
            Storage::disk($this->disk())->delete($product->image);
        }

        $product->delete();
    }
}
