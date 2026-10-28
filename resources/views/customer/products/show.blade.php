@extends('layouts.customer')

@section('title', $product->name)

@section('content')
    @php
        $badge =
            [
                'available' => ['Tersedia', 'ec-badge-ok'],
                'low' => ['Stok menipis', 'ec-badge-warn'],
                'out' => ['Stok habis', 'ec-badge-out'],
            ][$product->stock_status] ?? null;
    @endphp

    <section class="pt-4 pt-lg-5">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}" class="ec-link">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.products.index') }}" class="ec-link">Produk</a>
                    </li>
                    @if ($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.products.index', ['category' => $product->category_id]) }}"
                                class="ec-link">{{ $product->category->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                {{-- Gambar --}}
                <div class="col-md-5">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="ec-detail-image">
                    @else
                        <div class="ec-detail-image d-flex flex-column align-items-center justify-content-center"
                            style="min-height: 320px;">
                            <i class="bi bi-image text-ec-muted" style="font-size: 4rem;"></i>
                            <p class="text-ec-muted mt-2 mb-0">Gambar belum tersedia</p>
                        </div>
                    @endif
                </div>

                {{-- Informasi --}}
                <div class="col-md-7">
                    @if ($badge)
                        <span class="ec-badge ec-badge-inline {{ $badge[1] }} mb-2">{{ $badge[0] }}</span>
                    @endif

                    <h1 class="h2 fw-bold mb-1">{{ $product->name }}</h1>

                    <p class="text-ec-muted mb-3">{{ optional($product->category)->name ?? 'Tanpa kategori' }}</p>

                    @if ($product->selling_price !== null)
                        <div class="fs-3 fw-bold text-ec-blue mb-3">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                            @if ($product->unit)
                                <span class="fs-6 fw-normal text-ec-muted">/ {{ $product->unit }}</span>
                            @endif
                        </div>
                    @else
                        <div class="text-ec-muted mb-3">Harga belum tersedia</div>
                    @endif

                    @if ($product->description)
                        <p class="text-ec-muted" style="white-space: pre-line;">{{ $product->description }}</p>
                    @endif

                    <dl class="row mb-4">
                        <dt class="col-5 col-sm-4 fw-normal text-ec-muted">Kategori</dt>
                        <dd class="col-7 col-sm-8 fw-semibold">{{ optional($product->category)->name ?? '-' }}</dd>

                        <dt class="col-5 col-sm-4 fw-normal text-ec-muted">Subkategori</dt>
                        <dd class="col-7 col-sm-8 fw-semibold">{{ optional($product->subCategory)->name ?? '-' }}</dd>

                        <dt class="col-5 col-sm-4 fw-normal text-ec-muted">Kode Produk</dt>
                        <dd class="col-7 col-sm-8 fw-semibold">{{ $product->product_code }}</dd>

                        <dt class="col-5 col-sm-4 fw-normal text-ec-muted">Stok</dt>
                        <dd class="col-7 col-sm-8 fw-semibold">
                            {{ number_format($product->stock ?? 0, 0, ',', '.') }} {{ $product->unit ?? 'unit' }}
                        </dd>
                    </dl>

                    <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Produk
                    </a>
                </div>
            </div>

            {{-- Produk lainnya --}}
            @if ($related->isNotEmpty())
                <h2 class="h5 fw-bold mt-5 mb-3">Produk Lainnya</h2>

                <div class="row g-3">
                    @foreach ($related as $item)
                        <div class="col-6 col-md-4">
                            @include('customer.partials.product-card', ['product' => $item])
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
@endsection
