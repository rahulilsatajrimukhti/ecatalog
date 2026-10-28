<?php

namespace App\DTO;

class SubCategoriesDTO
{
    public string $name;
    public string $description;
    public int $category_id;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->name           = $data['name'];
        $this->description    = $data['description'];
        $this->category_id    = $data['category_id'];
        $this->is_active      = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'name'          => $this->name,
            'description'   => $this->description,
            'category_id'   => $this->category_id,
            'is_active'     => $this->is_active
        ];
    }
}
