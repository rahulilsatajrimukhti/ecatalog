@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')

    {{-- HERO --}}
    <section class="pt-4 pt-lg-5">
        <div class="container">
            <div class="ec-hero">
                <div class="ec-hero-eyebrow mb-2">KATALOG PRODUK</div>

                <h1 class="fw-bold mb-3" style="font-size: clamp(1.75rem, 4vw, 2.25rem); line-height: 1.2; max-width: 560px;">
                    Temukan produk dan vendor terpercaya
                </h1>

                <p class="mb-4">
                    Jelajahi produk dari berbagai kategori beserta harga dan ketersediaan stok terbaru.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('customer.products.index') }}" class="btn btn-ec px-4 py-2">Jelajahi Produk</a>
                    <a href="{{ route('customer.vendors.index') }}" class="btn btn-ec-outline px-4 py-2">Lihat Vendor</a>
                </div>
            </div>
        </div>
    </section>


    {{-- PRODUK TERBARU --}}
    <section class="pt-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <h2 class="h5 fw-bold mb-0">Produk Terbaru</h2>
                <a href="{{ route('customer.products.index') }}" class="ec-link">Lihat semua produk</a>
            </div>

            <div class="row g-3">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('customer.partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ec-empty text-center py-5">
                            <i class="bi bi-box-seam fs-1 text-ec-muted"></i>
                            <h5 class="mt-3">Belum ada produk</h5>
                            <p class="text-ec-muted mb-0">Produk aktif akan tampil di sini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- VENDOR --}}
    <section class="pt-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <h2 class="h5 fw-bold mb-0">Vendor Kami</h2>
                <a href="{{ route('customer.vendors.index') }}" class="ec-link">Lihat semua vendor</a>
            </div>

            <div class="row g-3">
                @forelse ($vendors as $vendor)
                    <div class="col-md-6 col-lg-4">
                        @include('customer.partials.vendor-card', ['vendor' => $vendor])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ec-empty text-center py-4">
                            <i class="bi bi-building fs-1 text-ec-muted"></i>
                            <p class="text-ec-muted mt-2 mb-0">Belum ada vendor aktif.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
