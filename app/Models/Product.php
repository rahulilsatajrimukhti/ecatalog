<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'product_code',
        'name',
        'description',
        'purchase_price',
        'selling_price',
        'stock',
        'minimum_stock',
        'unit',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock')
            ->where('stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeNeedsAttention($query)
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock');
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::get(fn() => match (true) {
            $this->stock <= 0                    => 'out',
            $this->stock <= $this->minimum_stock => 'low',
            default                              => 'available',
        });
    }
}
