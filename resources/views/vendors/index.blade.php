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
                                        Belum ada data vendor
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($data->hasPages())
                    <div class="d-flex justify-content-end p-3">
                        {{ $data->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
