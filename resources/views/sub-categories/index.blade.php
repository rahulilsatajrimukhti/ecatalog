@extends('layouts.app')
@section('title', 'Sub Kategori')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 font-weight-bold text-gray-800">
                Sub Kategori
            </h5>

            @if (canAccess('sub-categories.index', 'can_create'))
                <a href="{{ route('sub-categories.create') }}" class="btn-add-subcat">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Sub Kategori</span>
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 px-3 small shadow-sm">
                <i class="fas fa-check-circle mr-1"></i>
                {{ session('success') }}

                <button type="button" class="close p-1" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-center">
                                <th width="50">#</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Deskripsi</th>
                                <th class="text-left">Kategori</th>
                                <th width="100">Status</th>

                                @if (canAccess('sub-categories.index', 'can_edit') || canAccess('sub-categories.index', 'can_delete'))
                                    <th width="100">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $key => $row)
                                <tr>
                                    <td class="text-center small">
                                        {{ $data->firstItem() + $key }}
                                    </td>

                                    <td class="small font-weight-600">
                                        {{ $row->name }}
                                    </td>

                                    <td class="small">
                                        {{ $row->description }}
                                    </td>

                                    <td class="small">
                                        {{ $row->categories->name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge badge-pill {{ $row->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    @if (canAccess('sub-categories.index', 'can_edit') || canAccess('sub-categories.index', 'can_delete'))
                                        <td class="text-center">
                                            @if (canAccess('sub-categories.index', 'can_edit'))
                                                <a href="{{ route('sub-categories.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if (canAccess('sub-categories.index', 'can_delete'))
                                                <form action="{{ route('sub-categories.destroy', $row->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Hapus sub kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ canAccess('sub-categories.index', 'can_edit') || canAccess('sub-categories.index', 'can_delete') ? 6 : 5 }}"
                                        class="text-center small text-muted py-3">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($data->total() > 0)
                <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center">
                    <small class="text-muted my-2">
                        Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }}
                        dari {{ $data->total() }} sub kategori
                    </small>

                    <div class="my-2">
                        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
