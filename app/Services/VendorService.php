<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Models\Vendor;

class VendorService
{
    /**
     * Daftar vendor per halaman.
     * Filter: ['search' => teks, 'status' => '1' (aktif) | '0' (nonaktif)]
     */
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $search = trim($filters['search'] ?? '');
        $status = $filters['status'] ?? null;

        return Vendor::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('vendor_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('contact_person', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['0', '1', 0, 1], true), function ($q) use ($status) {
                $q->where('is_active', (bool) $status);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();   // pencarian & filter tetap terbawa saat pindah halaman
    }

    public function find($id): Vendor
    {
        return Vendor::findOrFail($id);
    }

    public function store(VendorDTO $dto): Vendor
    {
        return Vendor::create($dto->toArray());
    }

    public function update($id, VendorDTO $dto): Vendor
    {
        $vendor = $this->find($id);
        $vendor->update($dto->toArray());

        return $vendor->fresh();
    }

    public function delete($id): bool
    {
        $vendor = $this->find($id);

        return $vendor->delete();
    }
}
