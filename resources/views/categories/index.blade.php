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
                <table class="table table-sm mb-0">
                    <thead class="bg-light">
                        <tr class="small text-muted text-center">
                            <th width="50">#</th>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Deskripsi</th>
                            <th width="50">Status</th>
                            @if (canAccess('categories.index', 'can_create'))
                                <th width="150">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $key => $row)
                            <tr>
                                <td class="text-center small">{{ $key + 1 }}</td>

                                <td class="small">{{ $row->name }}</td>

                                <td class="small">
                                    {{ Str::limit($row->description, 100, '...') }}
                                    @if (strlen($row->description) > 100)
                                        <a href="#" class="text-primary" data-toggle="modal"
                                            data-target="#descModal{{ $row->id }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="descModal{{ $row->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Deskripsi Lengkap</h5>
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

                                <td class="text-center">
                                    <span
                                        class="badge badge-pill {{ $row->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="text-center">

                                    @if (canAccess('categories.index', 'can_edit'))
                                        <a href="{{ route('categories.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm rounded-circle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if (canAccess('categories.index', 'can_delete'))
                                        <form action="{{ route('categories.destroy', $row->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm rounded-circle">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center small text-muted py-3">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
