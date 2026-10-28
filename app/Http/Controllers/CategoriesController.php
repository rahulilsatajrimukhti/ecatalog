<?php

namespace App\Http\Controllers;

use App\Services\CategoriesService;
use App\DTO\CategoriesDTO;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;

class CategoriesController extends Controller
{
    public function __construct(private CategoriesService $service) {}

    public function index()
    {
        $data = $this->service->getAll();
        return view('categories.index', compact('data'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoriesRequest $request)
    {
        $dto = new CategoriesDTO($request->validated());
        $this->service->store($dto);

        return redirect()->route('categories.index')->with('success', 'Kategori  Berhasil Ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->service->find($id);
        return view('categories.edit', compact('data'));
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        $dto = new CategoriesDTO($request->validated());
        $this->service->update($id, $dto);

        return redirect()->route('categories.index')->with('success', 'Kategori  Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Kategori     Berhasil Dihapus!');
    }
}
