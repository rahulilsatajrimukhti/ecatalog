<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Vendor;

class DashboardService
{
    public function getDashboardData(): array
    {
        [$chartLabels, $chartData] = $this->productActivity(6);

        $lowStockProducts   = Product::lowStock()->count();
        $outOfStockProducts = Product::outOfStock()->count();

        return [
            'totalProducts'      => Product::count(),
            'totalVendors'       => Vendor::count(),
            'lowStockProducts'   => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'attentionTotal'     => $lowStockProducts + $outOfStockProducts,

            'chartLabels' => $chartLabels,
            'chartData'   => $chartData,

            'latestProducts' => Product::with('category')
                ->latest()
                ->take(4)
                ->get(),

            // Stok kosong dan menipis dalam satu daftar, yang kosong tampil lebih dulu.
            'attentionList' => Product::with('category')
                ->needsAttention()
                ->orderBy('stock')
                ->take(8)
                ->get(),
        ];
    }

    /**
     * Jumlah produk baru per bulan untuk N bulan terakhir (termasuk bulan ini).
     *
     * @return array{0: array<int, string>, 1: array<int, int>}
     */
    protected function productActivity(int $months): array
    {
        $start = now()->startOfMonth()->subMonths($months - 1);

        $counts = Product::where('created_at', '>=', $start)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $labels = [];
        $data   = [];

        for ($i = 0; $i < $months; $i++) {
            $month    = $start->copy()->addMonths($i);
            $labels[] = $month->translatedFormat('M');
            $data[]   = (int) ($counts[$month->format('Y-m')] ?? 0);
        }

        return [$labels, $data];
    }
}
