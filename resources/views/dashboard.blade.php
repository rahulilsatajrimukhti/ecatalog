@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <style>
        .ec-dash {
            --navy: #12294d;
            --muted: #6c7a92;
            --line: #e4e9f2;
            --blue: #2563eb;
            --blue-soft: #eaf1ff;
            --teal-soft: #d8f5ec;
            --teal: #0f9d77;
            --amber-soft: #fdf0c8;
            --amber: #d68a00;
            --red-soft: #fde3e3;
            --red: #d32f2f;
        }

        .ec-dash .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
        }

        .ec-dash .page-sub {
            color: var(--muted);
            margin: .25rem 0 1.5rem;
        }

        /* Kartu */
        .ec-dash .box {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            height: 100%;
        }

        .ec-dash .box-pad {
            padding: 1.5rem;
        }

        .ec-dash .box-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
        }

        .ec-dash .box-sub {
            font-size: .85rem;
            color: var(--muted);
            margin: .25rem 0 1.25rem;
        }

        /* Statistik */
        .ec-dash .stat {
            padding: 1.25rem 1.35rem;
        }

        .ec-dash .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            margin-bottom: .9rem;
        }

        .ec-dash .stat-label {
            color: var(--muted);
            font-size: .9rem;
        }

        .ec-dash .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.15;
            font-variant-numeric: tabular-nums;
        }

        .ec-dash .ic-blue {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .ec-dash .ic-teal {
            background: var(--teal-soft);
            color: var(--teal);
        }

        .ec-dash .ic-amber {
            background: var(--amber-soft);
            color: var(--amber);
        }

        .ec-dash .ic-red {
            background: var(--red-soft);
            color: var(--red);
        }

        /* Grafik */
        .ec-dash .chart-wrap {
            position: relative;
            height: 240px;
        }

        /* Produk terbaru */
        .ec-dash .latest-item {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .7rem 0;
            border-bottom: 1px solid var(--line);
        }

        .ec-dash .latest-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .ec-dash .latest-item:first-child {
            padding-top: 0;
        }

        .ec-dash .thumb {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 8px;
            background: var(--blue-soft);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ec-dash .thumb {
            overflow: hidden;
        }

        .ec-dash .thumb-btn {
            display: block;
            width: 100%;
            height: 100%;
            padding: 0;
            border: 0;
            background: none;
            cursor: zoom-in;
        }

        .ec-dash .thumb-btn:focus-visible {
            outline: 2px solid var(--blue);
            outline-offset: 2px;
        }

        .ec-dash .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ec-dash .item-name {
            font-weight: 700;
            color: var(--navy);
            line-height: 1.25;
        }

        .ec-dash .item-meta {
            font-size: .78rem;
            color: var(--muted);
        }

        .ec-dash .item-price {
            margin-left: auto;
            font-weight: 700;
            font-size: .85rem;
            color: var(--navy);
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        /* Tabel */
        .ec-dash .table-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .ec-dash .link-all {
            font-size: .85rem;
            font-weight: 600;
            color: var(--blue);
            white-space: nowrap;
        }

        .ec-dash table {
            margin: 0;
        }

        .ec-dash thead th {
            background: #f4f7fb;
            border: 0;
            font-size: .82rem;
            font-weight: 700;
            color: var(--navy);
            padding: .85rem 1rem;
            white-space: nowrap;
        }

        .ec-dash tbody td {
            padding: .95rem 1rem;
            vertical-align: middle;
            border-color: var(--line);
            color: var(--navy);
        }

        .ec-dash .pill {
            display: inline-block;
            font-size: .75rem;
            font-weight: 700;
            padding: .2rem .75rem;
            border-radius: 999px;
        }

        .ec-dash .pill-low {
            background: var(--amber-soft);
            color: #9a6200;
        }

        .ec-dash .pill-out {
            background: var(--red-soft);
            color: var(--red);
        }

        .ec-dash .stock-out {
            color: var(--red);
            font-weight: 700;
        }

        .ec-dash .stock-min {
            font-size: .78rem;
            color: var(--muted);
            margin-left: .35rem;
        }

        .ec-dash .table-foot {
            margin-top: .9rem;
            font-size: .82rem;
            color: var(--muted);
        }

        .ec-dash .empty {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--muted);
        }

        .ec-dash .empty strong {
            display: block;
            color: var(--navy);
            margin-bottom: .2rem;
        }
    </style>

    <div class="container-fluid ec-dash">

        {{-- Header --}}
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Ringkasan aktivitas dan data e-catalog</p>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Statistik --}}
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="box stat">
                    <div class="stat-icon ic-blue"><i class="fas fa-box"></i></div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-value">{{ number_format($totalProducts) }}</div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="box stat">
                    <div class="stat-icon ic-teal"><i class="fas fa-truck"></i></div>
                    <div class="stat-label">Total Vendor</div>
                    <div class="stat-value">{{ number_format($totalVendors) }}</div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="box stat">
                    <div class="stat-icon ic-amber"><i class="fas fa-exclamation"></i></div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-value">{{ number_format($lowStockProducts) }}</div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="box stat">
                    <div class="stat-icon ic-red"><i class="fas fa-box-open"></i></div>
                    <div class="stat-label">Stok Kosong</div>
                    <div class="stat-value">{{ number_format($outOfStockProducts) }}</div>
                </div>
            </div>
        </div>

        {{-- Grafik + Produk terbaru --}}
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="box box-pad">
                    <h2 class="box-title">Aktivitas Produk</h2>
                    <p class="box-sub">Produk baru yang ditambahkan selama 6 bulan terakhir</p>

                    <div class="chart-wrap">
                        <canvas id="productActivityChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="box box-pad">
                    <h2 class="box-title">Produk Terbaru</h2>
                    <p class="box-sub">Produk yang baru ditambahkan</p>

                    @forelse ($latestProducts as $product)
                        <div class="latest-item">
                            <div class="thumb">
                                @if (!empty($product->image))
                                    <button type="button" class="thumb-btn" data-preview="{{ $product->image_url }}"
                                        data-title="{{ $product->name }}" title="Lihat gambar">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                    </button>
                                @else
                                    <i class="fas fa-image"></i>
                                @endif
                            </div>
                            <div>
                                <div class="item-name">{{ $product->name }}</div>
                                <div class="item-meta">{{ $product->category->name ?? '-' }}</div>
                            </div>
                            <div class="item-price">
                                Rp {{ number_format($product->purchase_price ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="empty">
                            <strong>Belum ada produk</strong>
                            Produk yang Anda tambahkan akan muncul di sini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Stok perlu diperhatikan --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="box box-pad">
                    <div class="table-head">
                        <h2 class="box-title">Stok Perlu Diperhatikan</h2>
                        <a href="{{ route('products.index') }}" class="link-all">Lihat semua produk</a>
                    </div>

                    @if ($attentionList->isEmpty())
                        <div class="empty">
                            <strong>Semua stok aman</strong>
                            Tidak ada produk yang kosong atau di bawah batas stok minimum.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attentionList as $product)
                                        @php $isEmpty = $product->stock <= 0; @endphp
                                        <tr>
                                            <td class="font-weight-bold">{{ $product->name }}</td>
                                            <td>{{ $product->category->name ?? '-' }}</td>
                                            <td>
                                                <span class="{{ $isEmpty ? 'stock-out' : '' }}">
                                                    {{ number_format(max(0, $product->stock)) }} {{ $product->unit }}
                                                </span>
                                                <span class="stock-min">min.
                                                    {{ number_format($product->minimum_stock) }}</span>
                                            </td>
                                            <td>
                                                @if ($isEmpty)
                                                    <span class="pill pill-out">Kosong</span>
                                                @else
                                                    <span class="pill pill-low">Menipis</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($attentionTotal > $attentionList->count())
                            <div class="table-foot">
                                Menampilkan {{ $attentionList->count() }} dari {{ number_format($attentionTotal) }}
                                produk.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Pratinjau gambar produk --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="imagePreviewImg" src="" alt="" style="max-width: 100%; max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('[data-preview]');
            if (!btn) return;

            var src = btn.getAttribute('data-preview');
            var title = btn.getAttribute('data-title') || '';

            if (window.jQuery && jQuery.fn.modal) {
                document.getElementById('imagePreviewImg').src = src;
                document.getElementById('imagePreviewImg').alt = title;
                document.getElementById('imagePreviewTitle').textContent = title;
                jQuery('#imagePreviewModal').modal('show');
            } else {
                window.open(src, '_blank');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            var el = document.getElementById('productActivityChart');
            if (!el || typeof Chart === 'undefined') return;

            new Chart(el, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Produk baru',
                        data: @json($chartData),
                        borderColor: '#2563eb',
                        backgroundColor: '#2563eb',
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 6,
                        tension: 0.25
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c7a92'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#6c7a92'
                            },
                            grid: {
                                color: '#e4e9f2'
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        })();
    </script>

@endsection
