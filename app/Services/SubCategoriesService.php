<?php

namespace App\Services;

use App\DTO\SubCategoriesDTO;
use App\Models\Categories;
use App\Models\SubCategories;

class SubCategoriesService
{
    public function getAll()
    {
        return SubCategories::with('categories')
            ->latest()
            ->paginate(10);
    }

    public function getCategory()
    {
        return Categories::orderBy('name', 'asc')->get();
    }

    public function store(SubCategoriesDTO $dto)
    {
        return SubCategories::create($dto->toArray());
    }

    public function find($id)
    {
        return SubCategories::with('categories')
            ->findOrFail($id);
    }

    public function update($id, SubCategoriesDTO $dto)
    {
        $data = SubCategories::findOrFail($id);

        $data->update($dto->toArray());

        return $data->load('categories');
    }

    public function delete($id)
    {
        SubCategories::findOrFail($id)->delete();
    }
}
