<?php

namespace App\Http\Controllers;

use App\DTO\SubCategoriesDTO;
use App\Services\SubCategoriesService;
use App\Http\Requests\StoreSubCategoriesRequest;
use App\Http\Requests\UpdateSubCategoriesRequest;

class SubCategoriesController extends Controller
{
    public function __construct(private SubCategoriesService $service) {}

    public function index()
    {
        $data = $this->service->getAll();
        return view('sub-categories.index', compact('data'));
    }

    public function create()
    {
        $category = $this->service->getCategory();
        return view('sub-categories.create', compact('category'));
    }

    public function store(StoreSubCategoriesRequest $request)
    {
        $dto = new SubCategoriesDTO($request->validated());
        $this->service->store($dto);

        return redirect()->route('sub-categories.index')->with('success', 'Sub Kategori Berhasil Ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data   = $this->service->find($id);
        $category = $this->service->getCategory();
        return view('sub-categories.edit', compact('data', 'category'));
    }

    public function update(UpdateSubCategoriesRequest $request, $id)
    {
        $dto = new SubCategoriesDTO($request->validated());
        $this->service->update($id, $dto);

        return redirect()->route('sub-categories.index')->with('success', 'Sub Kategori Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Sub Kategori Berhasil Dihapus!');
    }
}
