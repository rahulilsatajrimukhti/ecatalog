@extends('layouts.app')
@section('title', 'Edit Vendor')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('vendors.index') }}" class="btn btn-light btn-sm rounded-circle mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>

            <h5 class="mb-0 font-weight-bold text-gray-800">
                Edit Vendor
            </h5>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <form action="{{ route('vendors.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- LEFT --}}
                        <div class="col-md-8">

                            {{-- KODE VENDOR --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Kode Vendor</label>
                                <input type="text" name="vendor_code"
                                    value="{{ old('vendor_code', $data->vendor_code) }}"
                                    class="form-control form-control-sm rounded-pill px-3 @error('vendor_code') is-invalid @enderror"
                                    placeholder="Masukkan kode vendor">

                                @error('vendor_code')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- NAMA VENDOR --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Nama Vendor</label>
                                <input type="text" name="name" value="{{ old('name', $data->name) }}"
                                    class="form-control form-control-sm rounded-pill px-3 @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama vendor">

                                @error('name')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- CONTACT PERSON DAN TELEPON --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Nama Contact Person</label>
                                        <input type="text" name="contact_person"
                                            value="{{ old('contact_person', $data->contact_person) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('contact_person') is-invalid @enderror"
                                            placeholder="Nama penanggung jawab">

                                        @error('contact_person')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Nomor Telepon</label>
                                        <input type="text" name="phone" value="{{ old('phone', $data->phone) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('phone') is-invalid @enderror"
                                            placeholder="Masukkan nomor telepon">

                                        @error('phone')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- EMAIL DAN NPWP --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Email</label>
                                        <input type="email" name="email" value="{{ old('email', $data->email) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('email') is-invalid @enderror"
                                            placeholder="contoh@email.com">

                                        @error('email')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">NPWP</label>
                                        <input type="text" name="npwp" value="{{ old('npwp', $data->npwp) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('npwp') is-invalid @enderror"
                                            placeholder="Masukkan NPWP">

                                        @error('npwp')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SERTIFIKASI --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Sertifikasi</label>
                                <input type="text" name="certification"
                                    value="{{ old('certification', $data->certification) }}"
                                    class="form-control form-control-sm rounded-pill px-3 @error('certification') is-invalid @enderror"
                                    placeholder="Contoh: ISO, HACCP, atau sertifikasi lainnya">

                                @error('certification')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- ALAMAT --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Alamat</label>
                                <textarea name="address" rows="4" placeholder="Masukkan alamat lengkap vendor"
                                    class="form-control form-control-sm rounded @error('address') is-invalid @enderror">{{ old('address', $data->address) }}</textarea>

                                @error('address')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="col-md-4">

                            {{-- INFORMASI VENDOR --}}
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <label class="small text-muted d-block mb-2">
                                        <i class="fas fa-truck mr-1"></i>
                                        Informasi Vendor
                                    </label>

                                    <p class="small text-muted mb-0">
                                        Periksa kembali informasi vendor sebelum
                                        menyimpan perubahan. Kode vendor harus
                                        unik dan tidak boleh sama dengan kode
                                        vendor lainnya.
                                    </p>
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div class="card border shadow-sm mt-3">
                                <div class="card-body">
                                    <label class="small text-muted d-block mb-2">
                                        Status
                                    </label>

                                    <input type="hidden" name="is_active" value="0">

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" value="1"
                                            class="custom-control-input" id="statusSwitch"
                                            {{ old('is_active', $data->is_active) ? 'checked' : '' }}>

                                        <label class="custom-control-label small" for="statusSwitch">
                                            Aktif
                                        </label>
                                    </div>

                                    @error('is_active')
                                        <div class="text-danger small mt-2">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="pt-3 mt-4 d-flex">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mr-2 shadow-sm">
                            <i class="fas fa-save mr-1"></i>
                            Update
                        </button>

                        <a href="{{ route('vendors.index') }}" class="btn btn-light btn-sm rounded-pill px-4">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
