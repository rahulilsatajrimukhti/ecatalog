@extends('layouts.app')

@section('title', 'Detail Vendor')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('vendors.index') }}" class="btn btn-light btn-sm rounded-circle mr-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <h5 class="mb-0 font-weight-bold text-gray-800">
                    Detail Vendor
                </h5>
            </div>

            @if (canAccess('vendors.index', 'can_edit'))
                <a href="{{ route('vendors.edit', $data->id) }}" class="btn btn-warning btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Vendor
                </a>
            @endif
        </div>

        <div class="row mb-4">

            {{-- INFORMASI KONTAK --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">

                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-building fa-4x text-secondary"></i>
                            </div>

                            <h5 class="font-weight-bold text-gray-800 mb-1">
                                {{ $data->name }}
                            </h5>

                            <div class="text-muted small">
                                Kode Vendor: {{ $data->vendor_code ?? '-' }}
                            </div>

                            <div class="mt-3">
                                <span
                                    class="badge badge-pill px-3 py-2
                                    {{ $data->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $data->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <hr>

                        {{-- INFORMASI TAMBAHAN --}}
                        <div class="small text-uppercase text-muted mb-3">
                            Informasi Vendor
                        </div>

                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Contact Person</span>
                            <strong class="text-right">
                                {{ $data->contact_person ?: '-' }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Telepon</span>
                            <strong class="text-right">
                                {{ $data->phone ?: '-' }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between small mb-3">
                            <span class="text-muted">Email</span>
                            <strong class="text-right text-break">
                                {{ $data->email ?: '-' }}
                            </strong>
                        </div>

                        <div class="mt-auto">
                            <hr>

                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted">Dibuat</span>
                                <strong>
                                    {{ $data->created_at ? $data->created_at->format('d M Y') : '-' }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Diperbarui</span>
                                <strong>
                                    {{ $data->updated_at ? $data->updated_at->format('d M Y') : '-' }}
                                </strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- DETAIL VENDOR --}}
            <div class="col-lg-8">

                {{-- INFORMASI UMUM --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <h6 class="font-weight-bold text-gray-800 mb-3">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Informasi Umum
                        </h6>

                        <hr>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Kode Vendor</small>
                                <strong>{{ $data->vendor_code ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Nama Vendor</small>
                                <strong>{{ $data->name ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Contact Person</small>
                                <strong>{{ $data->contact_person ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Nomor Telepon</small>
                                <strong>{{ $data->phone ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Email</small>
                                <strong class="text-break">{{ $data->email ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">NPWP</small>
                                <strong>{{ $data->npwp ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Sertifikasi</small>
                                <strong>{{ $data->certification ?: '-' }}</strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Status</small>
                                <span
                                    class="badge badge-pill px-3
                                    {{ $data->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $data->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <h6 class="font-weight-bold text-gray-800 mb-3">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            Alamat Vendor
                        </h6>

                        <hr>

                        <div class="text-muted" style="line-height: 1.9; white-space: pre-line;">
                            {{ $data->address ?: 'Alamat belum diisi.' }}</div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
