<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'category_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
