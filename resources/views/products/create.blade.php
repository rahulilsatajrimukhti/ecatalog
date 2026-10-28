@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('products.index') }}" class="btn btn-light btn-sm rounded-circle mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>

            <h5 class="mb-0 font-weight-bold text-gray-800">
                Tambah Produk
            </h5>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- LEFT --}}
                        <div class="col-md-8">

                            {{-- KODE PRODUK --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Kode Produk</label>
                                <input type="text" name="product_code" value="{{ old('product_code') }}"
                                    class="form-control form-control-sm rounded-pill px-3 @error('product_code') is-invalid @enderror"
                                    placeholder="Masukkan kode produk">

                                @error('product_code')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- NAMA PRODUK --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-sm rounded-pill px-3 @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama produk">

                                @error('name')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- KATEGORI --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Kategori</label>
                                        <select name="category_id" id="category_id"
                                            class="form-control form-control-sm rounded-pill px-3 @error('category_id') is-invalid @enderror">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SUBKATEGORI --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Subkategori</label>
                                        <select name="sub_category_id" id="sub_category_id"
                                            class="form-control form-control-sm rounded-pill px-3 @error('sub_category_id') is-invalid @enderror">
                                            <option value="">-- Pilih Subkategori --</option>
                                            @foreach ($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}"
                                                    data-category="{{ $subCategory->category_id }}"
                                                    {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('sub_category_id')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- HARGA --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Harga Beli (Rp)</label>
                                        <input type="number" name="purchase_price" min="0" step="0.01"
                                            value="{{ old('purchase_price', 0) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('purchase_price') is-invalid @enderror">

                                        @error('purchase_price')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Harga Jual (Rp)</label>
                                        <input type="number" name="selling_price" min="0" step="0.01"
                                            value="{{ old('selling_price', 0) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('selling_price') is-invalid @enderror">

                                        @error('selling_price')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- STOK --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Stok Awal</label>
                                        <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('stock') is-invalid @enderror">

                                        @error('stock')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Stok Minimum</label>
                                        <input type="number" name="minimum_stock" min="0"
                                            value="{{ old('minimum_stock', 0) }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('minimum_stock') is-invalid @enderror">

                                        @error('minimum_stock')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted">Satuan</label>
                                        <input type="text" name="unit" value="{{ old('unit', 'pcs') }}"
                                            class="form-control form-control-sm rounded-pill px-3 @error('unit') is-invalid @enderror"
                                            placeholder="Contoh: pcs, kg, box">

                                        @error('unit')
                                            <div class="text-danger small mt-1 ml-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="form-group mb-3">
                                <label class="small text-muted">Deskripsi</label>
                                <textarea name="description" rows="6" placeholder="Masukkan deskripsi produk..."
                                    class="form-control form-control-sm rounded @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="text-danger small mt-1 ml-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <div class="col-md-4">

                            {{-- GAMBAR PRODUK --}}
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <label class="small text-muted d-block">Gambar Produk</label>

                                    <div id="imageContainer"
                                        class="border rounded bg-light d-flex align-items-center justify-content-center shadow-sm mb-3"
                                        style="height:250px; overflow:hidden;">

                                        <div id="emptyImage" class="text-center">
                                            <i class="fas fa-box fa-3x text-secondary mb-2"></i>
                                            <div class="small text-muted">Preview Gambar Produk</div>
                                        </div>

                                        <img id="imagePreview" class="img-fluid rounded d-none"
                                            style="max-height:250px; object-fit:contain;">
                                    </div>

                                    <input type="file" name="image" id="imageInput" accept="image/*"
                                        class="form-control-file @error('image') is-invalid @enderror">

                                    @error('image')
                                        <div class="text-danger small mt-2">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <small class="text-muted d-block mt-2">
                                        Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                                    </small>
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div class="card border shadow-sm mt-3">
                                <div class="card-body">
                                    <label class="small text-muted d-block mb-2">Status</label>

                                    <input type="hidden" name="is_active" value="0">

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" value="1"
                                            class="custom-control-input" id="statusSwitch"
                                            {{ old('is_active', 1) ? 'checked' : '' }}>

                                        <label class="custom-control-label small" for="statusSwitch">
                                            Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="pt-3 mt-4 d-flex">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mr-2 shadow-sm">
                            <i class="fas fa-save mr-1"></i>
                            Simpan
                        </button>

                        <a href="{{ route('products.index') }}" class="btn btn-light btn-sm rounded-pill px-4">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const emptyImage = document.getElementById('emptyImage');

            if (imageInput) {
                imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (!file) {
                        imagePreview.src = '';
                        imagePreview.classList.add('d-none');
                        emptyImage.classList.remove('d-none');
                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        imageInput.value = '';
                        alert('Silakan pilih file gambar.');
                        return;
                    }

                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.classList.remove('d-none');
                    emptyImage.classList.add('d-none');
                });
            }

            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');

            function filterSubCategories() {
                const selectedCategory = categorySelect.value;
                const currentSubCategory = subCategorySelect.value;

                Array.from(subCategorySelect.options).forEach(function(option, index) {
                    if (index === 0) {
                        option.hidden = false;
                        return;
                    }

                    const belongsToCategory = option.dataset.category === selectedCategory;
                    option.hidden = selectedCategory !== '' && !belongsToCategory;

                    if (option.value === currentSubCategory && option.hidden) {
                        subCategorySelect.value = '';
                    }
                });
            }

            if (categorySelect && subCategorySelect) {
                categorySelect.addEventListener('change', filterSubCategories);
                filterSubCategories();
            }
        });
    </script>
@endpush
