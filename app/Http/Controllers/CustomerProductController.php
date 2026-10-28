<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search'   => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer'],
        ]);

        $query = Product::with(['category', 'subCategory'])
            ->where('is_active', true);

        // Pencarian: nama/kode produk, kategori, subkategori
        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('subCategory', fn($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter kategori (pill: Semua / Minuman / Bahan Baku)
        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        $products = $query->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Categories::orderBy('name')->get();

        return view('customer.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'subCategory']);

        // "Produk Lainnya" (3 kartu): utamakan kategori yang sama
        $related = Product::with('category')
            ->where('is_active', true)
            ->whereKeyNot($product->getKey())
            ->orderByRaw('category_id = ? desc', [$product->category_id])
            ->latest()
            ->take(3)
            ->get();

        return view('customer.products.show', compact('product', 'related'));
    }
}
