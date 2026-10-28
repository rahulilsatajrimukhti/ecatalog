@extends('layouts.customer')

@section('title', $vendor->name)

@section('content')
    @php
        // Hubungi Vendor: email bila ada, jika tidak telepon
        $contactUrl = $vendor->email
            ? 'mailto:' . $vendor->email
            : ($vendor->phone
                ? 'tel:' . preg_replace('/[^0-9+]/', '', $vendor->phone)
                : null);
    @endphp

    <section class="pt-4 pt-lg-5">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}" class="ec-link">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.vendors.index') }}" class="ec-link">Vendor</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $vendor->name }}</li>
                </ol>
            </nav>

            <div class="ec-card p-4 p-lg-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="ec-avatar ec-avatar-lg" aria-hidden="true">{{ $vendor->initials }}</div>

                    <div class="min-w-0">
                        <h1 class="h3 fw-bold mb-1">{{ $vendor->name }}</h1>

                        @if ($vendor->address)
                            <p class="text-ec-muted mb-0" style="white-space: pre-line;">{{ $vendor->address }}</p>
                        @endif
                    </div>
                </div>

                <dl class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-4">
                        <dt class="small fw-normal text-ec-muted">Telepon</dt>
                        <dd class="fw-semibold mb-0">{{ $vendor->phone ?: '-' }}</dd>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <dt class="small fw-normal text-ec-muted">Email</dt>
                        <dd class="fw-semibold mb-0 text-break">{{ $vendor->email ?: '-' }}</dd>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <dt class="small fw-normal text-ec-muted">Kode Vendor</dt>
                        <dd class="fw-semibold mb-0">{{ $vendor->vendor_code ?: '-' }}</dd>
                    </div>

                    @if ($vendor->contact_person)
                        <div class="col-sm-6 col-lg-4">
                            <dt class="small fw-normal text-ec-muted">Contact Person</dt>
                            <dd class="fw-semibold mb-0">{{ $vendor->contact_person }}</dd>
                        </div>
                    @endif

                    @if ($vendor->certification)
                        <div class="col-sm-6 col-lg-8">
                            <dt class="small fw-normal text-ec-muted">Sertifikasi</dt>
                            <dd class="fw-semibold mb-0" style="white-space: pre-line;">{{ $vendor->certification }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="d-flex flex-wrap gap-2">
                    @if ($contactUrl)
                        <a href="{{ $contactUrl }}" class="btn btn-ec px-4 py-2">Hubungi Vendor</a>
                    @endif

                    <a href="{{ route('customer.vendors.index') }}" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Vendor
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection
