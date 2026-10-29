@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 font-weight-bold text-gray-800">
                Kategori
            </h5>

            @if (canAccess('categories.index', 'can_create'))
                <a href="{{ route('categories.create') }}" class="btn-add-catb">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Kategori</span>
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
                                <th width="90">Status</th>

                                @if (canAccess('categories.index', 'can_edit') || canAccess('categories.index', 'can_delete'))
                                    <th width="150">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $key => $row)
                                <tr>
                                    {{-- Nomor urut berlanjut antar halaman --}}
                                    <td class="text-center small align-middle">
                                        {{ $data->firstItem() + $key }}
                                    </td>

                                    <td class="small align-middle">
                                        {{ $row->name }}
                                    </td>

                                    <td class="small align-middle">
                                        {{ Str::limit($row->description, 100, '...') }}

                                        @if (strlen($row->description ?? '') > 100)
                                            <a href="#" class="text-primary" data-toggle="modal"
                                                data-target="#descModal{{ $row->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Modal deskripsi lengkap --}}
                                            <div class="modal fade" id="descModal{{ $row->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Deskripsi Lengkap
                                                            </h5>

                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            {{ $row->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-center align-middle">
                                        <span
                                            class="badge badge-pill {{ $row->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    @if (canAccess('categories.index', 'can_edit') || canAccess('categories.index', 'can_delete'))
                                        <td class="text-center align-middle">

                                            @if (canAccess('categories.index', 'can_edit'))
                                                <a href="{{ route('categories.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm rounded-circle" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if (canAccess('categories.index', 'can_delete'))
                                                <form action="{{ route('categories.destroy', $row->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ canAccess('categories.index', 'can_edit') || canAccess('categories.index', 'can_delete') ? 5 : 4 }}"
                                        class="text-center small text-muted py-4">
                                        Belum ada data kategori
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
                        dari {{ $data->total() }} kategori
                    </small>

                    <div class="my-2">
                        {{ $data->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <style>
        .card-footer .pagination {
            margin-bottom: 0;
        }
    </style>
@endsection
