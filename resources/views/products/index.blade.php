@extends('layouts.app')
@section('title', 'Produk')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 font-weight-bold text-gray-800">
                Produk
            </h5>

            @if (canAccess('products.index', 'can_create'))
                <a href="{{ route('products.create') }}" class="btn-add-user">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Produk</span>
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
                            <th width="70">Gambar</th>
                            <th class="text-left">Kode Produk</th>
                            <th class="text-left">Nama Produk</th>
                            <th class="text-left">Kategori</th>
                            <th class="text-left">Subkategori</th>
                            <th class="text-right">Harga Jual</th>
                            <th width="90">Stok</th>
                            <th width="90">Status</th>

                            @if (canAccess('products.index', 'can_edit') || canAccess('products.index', 'can_delete'))
                                <th width="150">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $key => $row)
                            <tr>
                                <td class="text-center small align-middle">
                                    {{ $key + 1 }}
                                </td>

                                {{-- GAMBAR PRODUK --}}
                                <td class="text-center align-middle">
                                    @if ($row->image)
                                        <img src="{{ Storage::url($row->image) }}" width="45" height="60"
                                            class="rounded shadow-sm border" style="object-fit: cover; cursor: pointer;"
                                            data-toggle="modal" data-target="#imageModal{{ $row->id }}"
                                            alt="{{ $row->name }}">

                                        {{-- MODAL GAMBAR --}}
                                        <div class="modal fade" id="imageModal{{ $row->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-body p-2 text-center bg-dark">
                                                        <img src="{{ Storage::url($row->image) }}"
                                                            class="img-fluid rounded shadow" alt="{{ $row->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto border"
                                            style="width: 45px; height: 60px;">
                                            <i class="fas fa-box text-secondary"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- KODE PRODUK --}}
                                <td class="small align-middle">
                                    {{ $row->product_code }}
                                </td>

                                {{-- NAMA PRODUK --}}
                                <td class="small align-middle font-weight-bold text-gray-700">
                                    {{ $row->name }}

                                    @if ($row->unit)
                                        <div class="text-muted small">
                                            Satuan: {{ $row->unit }}
                                        </div>
                                    @endif
                                </td>

                                {{-- KATEGORI --}}
                                <td class="small align-middle">
                                    {{ $row->category->name ?? '-' }}
                                </td>

                                {{-- SUBKATEGORI --}}
                                <td class="small align-middle">
                                    {{ $row->subCategory->name ?? '-' }}
                                </td>

                                {{-- HARGA JUAL --}}
                                <td class="small text-right align-middle">
                                    Rp {{ number_format($row->selling_price, 0, ',', '.') }}
                                </td>

                                {{-- STOK --}}
                                <td class="text-center align-middle">
                                    @if ($row->stock <= 0)
                                        <span class="badge badge-danger badge-pill px-3">
                                            Kosong
                                        </span>
                                    @elseif ($row->stock <= $row->minimum_stock)
                                        <span class="badge badge-warning badge-pill px-3">
                                            {{ $row->stock }}
                                        </span>
                                    @else
                                        <span class="badge badge-success badge-pill px-3">
                                            {{ $row->stock }}
                                        </span>
                                    @endif
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
                                    <a href="{{ route('products.show', $row->id) }}"
                                        class="btn btn-info btn-sm rounded-circle" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if (canAccess('products.index', 'can_edit'))
                                        <a href="{{ route('products.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm rounded-circle" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if (canAccess('products.index', 'can_delete'))
                                        <form action="{{ route('products.destroy', $row->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
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
                                <td colspan="10" class="text-center small text-muted py-4">
                                    Belum ada data produk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
