<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;

class HomeController extends Controller
{
    public function index()
    {
        // 4 produk terbaru (1 baris) sesuai desain beranda
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        // 3 vendor (1 baris) sesuai desain beranda
        $vendors = Vendor::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('customer.home', compact('products', 'vendors'));
    }
}
