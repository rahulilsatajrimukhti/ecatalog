@extends('layouts.customer')

@section('title', 'Semua Produk')

@section('content')
    @php
        // Pertahankan kata kunci pencarian saat pindah kategori
        $keep = request()->except('category', 'page');
    @endphp

    <section class="pt-4 pt-lg-5">
        <div class="container">
            <h1 class="h3 fw-bold mb-3">Semua Produk</h1>

            @if (request()->filled('search'))
                <p class="text-ec-muted mb-3">
                    Hasil pencarian untuk <strong>&ldquo;{{ request('search') }}&rdquo;</strong>
                    &middot;
                    <a href="{{ route('customer.products.index', request()->except('search', 'page')) }}"
                        class="ec-link">Hapus pencarian</a>
                </p>
            @endif

            {{-- Filter kategori --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('customer.products.index', $keep) }}"
                    class="ec-pill {{ request()->filled('category') ? '' : 'active' }}">Semua</a>

                @foreach ($categories as $category)
                    <a href="{{ route('customer.products.index', $keep + ['category' => $category->id]) }}"
                        class="ec-pill {{ (string) request('category') === (string) $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <p class="small text-ec-muted mb-3">
                Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
            </p>

            <div class="row g-3">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('customer.partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ec-empty text-center py-5">
                            <i class="bi bi-search fs-1 text-ec-muted"></i>
                            <h5 class="mt-3">Produk tidak ditemukan</h5>
                            <p class="text-ec-muted mb-3">Coba gunakan kata kunci atau kategori yang berbeda.</p>
                            <a href="{{ route('customer.products.index') }}" class="btn btn-ec px-4">
                                Tampilkan Semua Produk
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links('customer.partials.pagination') }}
            </div>
        </div>
    </section>
@endsection
