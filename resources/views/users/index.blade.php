@extends('layouts.app')
@section('title', 'User')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 font-weight-bold text-gray-800">
                User
            </h5>

            @if (canAccess('users.index', 'can_create'))
                <a href="{{ route('users.create') }}" class="btn-add-user">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">User</span>
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
                            <th class="text-left">Email</th>
                            <th class="text-left">No. HP</th>
                            <th class="text-left">Role Akses</th>
                            <th width="100">Status</th>
                            @if (canAccess('users.index', 'can_create'))
                                <th width="100">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $key => $row)
                            <tr>
                                <td class="text-center small">{{ $key + 1 }}</td>
                                <td class="small font-weight-600">{{ $row->name }}</td>
                                <td class="small">{{ $row->email }}</td>
                                <td class="small">{{ $row->phone ?? '-' }}</td>
                                <td class="small">{{ $row->userLevel->name ?? '-' }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-pill {{ $row->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if (canAccess('users.index', 'can_edit'))
                                        <a href="{{ route('users.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm rounded-circle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if (canAccess('users.index', 'can_delete'))
                                        <form action="{{ route('users.destroy', $row->id) }}" method="POST"
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
                                <td colspan="8" class="text-center small text-muted py-3">
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
