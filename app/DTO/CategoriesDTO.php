<?php

namespace App\DTO;

class CategoriesDTO
{
    public string $name;
    public ?string $description;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->name        = $data['name'];
        $this->description = $data['description'] ?? null;
        $this->is_active   = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'name'         => $this->name,
            'description'  => $this->description,
            'is_active'    => $this->is_active,
        ];
    }
}
