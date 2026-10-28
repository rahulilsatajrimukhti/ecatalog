@extends('layouts.app')

@section('title', 'Vendor')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 font-weight-bold text-gray-800">
                Vendor
            </h5>

            @if (canAccess('vendors.index', 'can_create'))
                <a href="{{ route('vendors.create') }}" class="btn-add-user">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Vendor</span>
                </a>
            @endif
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 px-3 small shadow-sm">
                <i class="fas fa-check-circle mr-1"></i>
                {{ session('success') }}

                <button type="button" class="close p-1" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- FILTER --}}
        <form action="{{ route('vendors.index') }}" method="GET"
            class="filter-bar d-flex flex-wrap align-items-center mb-3">

            <select name="status" class="custom-select filter-control filter-select mr-2 mb-2" aria-label="Filter status"
                onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <div class="filter-search mr-2 mb-2">
                <i class="fas fa-search" aria-hidden="true"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control filter-control"
                    placeholder="Cari kode, nama, atau contact person..." aria-label="Cari vendor" autocomplete="off">
            </div>

            <button type="submit" class="btn btn-primary filter-btn mr-2 mb-2">Cari</button>

            @if (request()->filled('search') || request()->filled('status'))
                <a href="{{ route('vendors.index') }}" class="btn btn-link text-muted filter-reset mb-2">
                    <i class="fas fa-undo-alt mr-1"></i>Reset
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-center">
                                <th width="50">#</th>
                                <th class="text-left">Kode Vendor</th>
                                <th class="text-left">Nama Vendor</th>
                                <th class="text-left">Contact Person</th>
                                <th class="text-left">Telepon</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Sertifikasi</th>
                                <th width="90">Status</th>

                                @if (canAccess('vendors.index', 'can_edit') || canAccess('vendors.index', 'can_delete'))
                                    <th width="150">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $key => $row)
                                <tr>
                                    {{-- NOMOR --}}
                                    <td class="text-center small align-middle">
                                        {{ $data->firstItem() + $key }}
                                    </td>

                                    {{-- KODE VENDOR --}}
                                    <td class="small align-middle">
                                        {{ $row->vendor_code }}
                                    </td>

                                    {{-- NAMA VENDOR --}}
                                    <td class="small align-middle font-weight-bold text-gray-700">
                                        {{ $row->name }}
                                    </td>

                                    {{-- CONTACT PERSON --}}
                                    <td class="small align-middle">
                                        {{ $row->contact_person ?? '-' }}
                                    </td>

                                    {{-- TELEPON --}}
                                    <td class="small align-middle">
                                        {{ $row->phone ?? '-' }}
                                    </td>

                                    {{-- EMAIL --}}
                                    <td class="small align-middle">
                                        {{ $row->email ?? '-' }}
                                    </td>

                                    {{-- SERTIFIKASI --}}
                                    <td class="small align-middle">
                                        {{ $row->certification ?? '-' }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center align-middle">
                                        <span
                                            class="badge badge-pill {{ $row->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center align-middle">
                                        <a href="{{ route('vendors.show', $row->id) }}"
                                            class="btn btn-info btn-sm rounded-circle" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if (canAccess('vendors.index', 'can_edit'))
                                            <a href="{{ route('vendors.edit', $row->id) }}"
                                                class="btn btn-warning btn-sm rounded-circle" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        @if (canAccess('vendors.index', 'can_delete'))
                                            <form action="{{ route('vendors.destroy', $row->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus vendor ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center small text-muted py-4">
                                        @if (request()->filled('search') || request()->filled('status'))
                                            Tidak ada vendor yang cocok dengan filter
                                        @else
                                            Belum ada data vendor
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- PAGINATION --}}
            @if ($data->total() > 0)
                <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center">
                    <small class="text-muted my-2">
                        Menampilkan {{ $data->firstItem() }}&ndash;{{ $data->lastItem() }}
                        dari {{ $data->total() }} vendor
                    </small>

                    <div class="my-2">
                        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <style>
        /* Hilangkan margin bawah bawaan Bootstrap 4 agar rata dengan teks di sebelahnya */
        .card-footer .pagination {
            margin-bottom: 0;
        }

        /* Filter */
        .filter-control {
            height: 38px;
            border: 1px solid #d1d3e2;
            border-radius: .6rem;
            background-color: #fff;
            font-size: .875rem;
            box-shadow: none;
        }

        .filter-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 .15rem rgba(78, 115, 223, .2);
        }

        .filter-select {
            width: 210px;
            max-width: 100%;
        }

        .filter-search {
            position: relative;
            flex: 1 1 260px;
            max-width: 380px;
        }

        .filter-search i {
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);
            color: #b7b9cc;
            pointer-events: none;
        }

        .filter-search .filter-control {
            width: 100%;
            padding-left: 36px;
        }

        .filter-btn {
            height: 38px;
            padding: 0 1.4rem;
            border-radius: .6rem;
        }

        .filter-reset {
            height: 38px;
            line-height: 24px;
            text-decoration: none;
        }

        @media (max-width: 575.98px) {

            .filter-select,
            .filter-search {
                width: 100%;
                max-width: none;
                flex-basis: 100%;
                margin-right: 0 !important;
            }
        }
    </style>
@endsection
