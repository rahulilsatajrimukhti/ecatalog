<?php

namespace App\Http\Controllers;

use App\DTO\ProductDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index(Request $request)
    {
        $request->validate([
            'search'   => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer'],
        ]);

        $data = $this->service->paginate(
            $request->only(['search', 'category'])
        );

        $categories = Categories::orderBy('name', 'asc')->get();

        return view('products.index', compact('data', 'categories'));
    }

    public function create()
    {
        $categories = Categories::orderBy('name', 'asc')->get();

        $subCategories = SubCategories::with('categories')
            ->orderBy('name', 'asc')
            ->get();

        return view('products.create', compact(
            'categories',
            'subCategories'
        ));
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->store(
            new ProductDTO($request->validated()),
            $request
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        $data = $this->service->find($id);

        return view('products.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->service->find($id);

        $categories = Categories::orderBy('name', 'asc')->get();

        $subCategories = SubCategories::with('categories')
            ->orderBy('name', 'asc')
            ->get();

        return view('products.edit', compact(
            'data',
            'categories',
            'subCategories'
        ));
    }

    public function update(
        UpdateProductRequest $request,
        $id
    ) {
        $this->service->update(
            $id,
            new ProductDTO($request->validated()),
            $request
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk Berhasil Dihapus!');
    }
}
