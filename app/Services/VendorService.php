<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Models\Vendor;

class VendorService
{

    public function getAll()
    {
        $query = Vendor::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('vendor_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
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
