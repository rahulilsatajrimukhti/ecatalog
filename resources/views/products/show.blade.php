@extends('layouts.app')

@section('title', 'Detail Produk')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('products.index') }}" class="btn btn-light btn-sm rounded-circle mr-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <h5 class="mb-0 font-weight-bold text-gray-800">
                    Detail Produk
                </h5>
            </div>

            @if (canAccess('products.index', 'can_edit'))
                <a href="{{ route('products.edit', $data->id) }}" class="btn btn-warning btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Produk
                </a>
            @endif
        </div>

        <div class="row mb-4">

            {{-- GAMBAR PRODUK --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <img src="{{ $data->image ? Storage::url($data->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                alt="{{ $data->name }}" class="img-fluid rounded shadow-sm border product-preview"
                                style="max-height:460px; object-fit:contain; cursor:pointer;" data-toggle="modal"
                                data-target="#productImageModal">
                        </div>

                        {{-- INFORMASI TAMBAHAN --}}
                        <div class="mt-auto">
                            <hr>

                            <div class="small text-uppercase text-muted mb-2">
                                Informasi Produk
                            </div>

                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted">Dibuat</span>
                                <strong>{{ $data->created_at ? $data->created_at->format('d M Y') : '-' }}</strong>
                            </div>

                            <div class="d-flex justify-content-between small mb-3">
                                <span class="text-muted">Update</span>
                                <strong>{{ $data->updated_at ? $data->updated_at->format('d M Y') : '-' }}</strong>
                            </div>

                            <button class="btn btn-outline-primary btn-sm btn-block rounded-pill" data-toggle="modal"
                                data-target="#productImageModal">
                                <i class="fas fa-search-plus mr-1"></i>
                                Lihat Gambar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h2 class="font-weight-bold text-gray-800 mb-1">
                                    {{ $data->name }}
                                </h2>

                                <div class="text-muted">
                                    Kode Produk: {{ $data->product_code ?? '-' }}
                                </div>
                            </div>

                            <span
                                class="badge badge-pill px-3 py-2 {{ $data->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $data->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Kategori</small>
                                <strong>{{ $data->category->name ?? '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Subkategori</small>
                                <strong>{{ $data->subCategory->name ?? '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Harga Beli</small>
                                <strong>Rp {{ number_format((float) $data->purchase_price, 0, ',', '.') }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Harga Jual</small>
                                <strong>Rp {{ number_format((float) $data->selling_price, 0, ',', '.') }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Stok Tersedia</small>

                                @if ($data->stock <= 0)
                                    <span class="badge badge-danger badge-pill px-3">Kosong</span>
                                @elseif ($data->stock <= $data->minimum_stock)
                                    <span class="badge badge-warning badge-pill px-3">
                                        {{ number_format($data->stock) }} {{ $data->unit }}
                                    </span>
                                @else
                                    <span class="badge badge-success badge-pill px-3">
                                        {{ number_format($data->stock) }} {{ $data->unit }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Stok Minimum</small>
                                <strong>{{ number_format($data->minimum_stock) }} {{ $data->unit }}</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Satuan</small>
                                <strong>{{ $data->unit ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-gray-700 mb-3">
                            Deskripsi Produk
                        </h6>

                        <div class="text-muted" style="line-height: 1.9; white-space: pre-line;">
                            {{ $data->description ?? 'Tidak ada deskripsi.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL GAMBAR PRODUK --}}
    <div class="modal fade" id="productImageModal" tabindex="-1" role="dialog" aria-labelledby="productImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-body p-2 text-center bg-dark">
                    <img src="{{ $data->image ? Storage::url($data->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                        alt="{{ $data->name }}" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

@endsection
