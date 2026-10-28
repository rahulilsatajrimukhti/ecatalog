<?php

namespace App\Services;

use App\DTO\CategoriesDTO;
use App\Models\Categories;

class CategoriesService
{
    public function getAll()
    {
        return Categories::latest()->get();
    }

    public function store(CategoriesDTO $dto)
    {
        return Categories::create($dto->toArray());
    }

    public function find($id)
    {
        return Categories::findOrFail($id);
    }

    public function update($id, CategoriesDTO $dto)
    {
        $data = Categories::findOrFail($id);
        $data->update($dto->toArray());
        return $data;
    }

    public function delete($id)
    {
        Categories::findOrFail($id)->delete();
    }
}
