@extends('layouts.customer')

@section('title', 'Vendor')

@section('content')
    <section class="pt-4 pt-lg-5">
        <div class="container">

            <div class="mb-3">
                <h1 class="h3 fw-bold mb-1">Vendor</h1>
                <p class="text-ec-muted mb-0">Daftar vendor yang menyediakan produk di katalog.</p>
            </div>

            @if (request()->filled('search'))
                <p class="text-ec-muted mb-3">
                    Hasil pencarian untuk <strong>&ldquo;{{ request('search') }}&rdquo;</strong>
                    &middot;
                    <a href="{{ route('customer.vendors.index') }}" class="ec-link">Hapus pencarian</a>
                </p>
            @endif

            <div class="row g-3">
                @forelse ($vendors as $vendor)
                    <div class="col-12 col-md-6 col-lg-4">
                        @include('customer.partials.vendor-card', ['vendor' => $vendor])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ec-empty text-center py-5">
                            <i class="bi bi-building fs-1 text-ec-muted"></i>
                            <h5 class="mt-3">Vendor tidak ditemukan</h5>
                            <p class="text-ec-muted mb-3">Coba gunakan kata kunci pencarian yang berbeda.</p>
                            <a href="{{ route('customer.vendors.index') }}" class="btn btn-ec px-4">
                                Tampilkan Semua Vendor
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $vendors->links('customer.partials.pagination') }}
            </div>

        </div>
    </section>
@endsection
