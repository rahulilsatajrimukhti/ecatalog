<?php

namespace App\DTO;

class ProductDTO
{
    public int $category_id;
    public int $sub_category_id;
    public string $product_code;
    public string $name;
    public ?string $description;
    public float $purchase_price;
    public float $selling_price;
    public int $stock;
    public int $minimum_stock;
    public string $unit;
    public ?string $image;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->category_id = (int) $data['category_id'];
        $this->sub_category_id = (int) $data['sub_category_id'];
        $this->product_code = $data['product_code'];
        $this->name = $data['name'];
        $this->description = $data['description'] ?? null;
        $this->purchase_price = (float) ($data['purchase_price'] ?? 0);
        $this->selling_price = (float) ($data['selling_price'] ?? 0);
        $this->stock = (int) ($data['stock'] ?? 0);
        $this->minimum_stock = (int) ($data['minimum_stock'] ?? 0);
        $this->unit = $data['unit'] ?? 'pcs';
        $this->image = $data['image'] ?? null;
        $this->is_active = (bool) ($data['is_active'] ?? true);
    }

    public function toArray(): array
    {
        return [
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'product_code' => $this->product_code,
            'name' => $this->name,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'stock' => $this->stock,
            'minimum_stock' => $this->minimum_stock,
            'unit' => $this->unit,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ];
    }
}
