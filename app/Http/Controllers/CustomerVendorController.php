<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class CustomerVendorController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $query = Vendor::where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('vendor_code', 'like', "%{$search}%");
            });
        }

        $vendors = $query->latest()
            ->paginate(12)
            ->withQueryString();

        return view('customer.vendors.index', compact('vendors'));
    }

    public function show(Vendor $vendor)
    {
        abort_unless($vendor->is_active, 404);

        return view('customer.vendors.show', compact('vendor'));
    }
}
