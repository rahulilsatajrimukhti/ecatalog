<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_code',
        'name',
        'phone',
        'email',
        'address',
        'contact_person',
        'npwp',
        'certification',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected function initials(): Attribute
    {
        return Attribute::get(fn() => Str::of($this->name)
            ->replaceMatches('/^(PT|CV)\.?\s+/i', '')
            ->explode(' ')
            ->filter()
            ->map(fn($w) => Str::upper(Str::substr($w, 0, 1)))
            ->take(2)
            ->implode(''));
    }
}
