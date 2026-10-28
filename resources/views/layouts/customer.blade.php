<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ trim($__env->yieldContent('title')) ? $__env->yieldContent('title') . ' | E-Catalog' : 'E-Catalog' }}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --ec-navy: #12284a;
            --ec-blue: #2563eb;
            --ec-blue-dark: #1d4fc4;
            --ec-bg: #f5f8fc;
            --ec-line: #e3eaf5;
            --ec-muted: #5b6b84;
            --ec-placeholder: #e8effb;
        }

        body {
            background: var(--ec-bg);
            color: var(--ec-navy);
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Arial, sans-serif;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 3px solid rgba(37, 99, 235, .45);
            outline-offset: 2px;
        }

        .min-w-0 {
            min-width: 0;
        }

        /* ---------- Header ---------- */
        .ec-header {
            background: #fff;
            border-bottom: 1px solid var(--ec-line);
        }

        .ec-brand {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: var(--ec-navy);
            font-size: 1.375rem;
            font-weight: 700;
            text-decoration: none;
        }

        .ec-brand i {
            color: var(--ec-blue);
            font-size: 1.25rem;
        }

        .ec-search {
            display: flex;
            align-items: center;
            gap: .625rem;
            height: 44px;
            padding: 0 14px;
            background: #f1f5fb;
            border: 1px solid var(--ec-line);
            border-radius: 10px;
        }

        .ec-search i {
            color: var(--ec-muted);
        }

        .ec-search input {
            flex: 1;
            min-width: 0;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: .875rem;
            color: var(--ec-navy);
        }

        .ec-search input::placeholder {
            color: var(--ec-muted);
        }

        .ec-nav-link {
            position: relative;
            display: inline-block;
            padding: .5rem 0;
            color: var(--ec-navy);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
        }

        .ec-nav-link:hover {
            color: var(--ec-blue);
        }

        .ec-nav-link.active {
            color: var(--ec-blue);
            font-weight: 600;
        }

        @media (min-width: 992px) {
            .ec-nav-link.active::after {
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                bottom: -17px;
                height: 3px;
                border-radius: 2px;
                background: var(--ec-blue);
            }
        }

        /* ---------- Tombol & teks ---------- */
        .btn-ec {
            background: var(--ec-blue);
            border: 1px solid var(--ec-blue);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-ec:hover {
            background: var(--ec-blue-dark);
            border-color: var(--ec-blue-dark);
            color: #fff;
        }

        .btn-ec-outline {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-ec-outline:hover {
            background: #fff;
            color: var(--ec-navy);
        }

        .text-ec-blue {
            color: var(--ec-blue);
        }

        .text-ec-muted {
            color: var(--ec-muted);
        }

        .ec-link {
            color: var(--ec-blue);
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
        }

        .ec-link:hover {
            text-decoration: underline;
        }

        /* ---------- Hero ---------- */
        .ec-hero {
            background: var(--ec-navy);
            color: #fff;
            border-radius: 18px;
            padding: 48px;
        }

        .ec-hero-eyebrow {
            color: #9fc0ff;
            font-size: .8125rem;
            font-weight: 600;
            letter-spacing: .04em;
        }

        .ec-hero p {
            color: #c9d6ee;
            max-width: 520px;
        }

        @media (max-width: 575.98px) {
            .ec-hero {
                padding: 28px 22px;
            }
        }

        /* ---------- Kartu ---------- */
        .ec-card {
            display: block;
            height: 100%;
            background: #fff;
            border: 1px solid var(--ec-line);
            border-radius: 14px;
            overflow: hidden;
            color: var(--ec-navy);
            text-decoration: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .ec-card:hover {
            color: var(--ec-navy);
            border-color: #c5d4ee;
            box-shadow: 0 8px 24px rgba(18, 40, 74, .08);
        }

        .ec-media {
            position: relative;
        }

        .ec-product-image {
            display: block;
            width: 100%;
            height: 180px;
            object-fit: contain;
            background: var(--ec-placeholder);
            padding: 12px;
        }

        .ec-product-placeholder {
            height: 180px;
            background: var(--ec-placeholder);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a5d7c;
            font-size: 2.5rem;
        }

        .ec-detail-image {
            display: block;
            width: 100%;
            max-height: 420px;
            object-fit: contain;
            background: var(--ec-placeholder);
            padding: 24px;
            border-radius: 14px;
        }

        .ec-price {
            color: var(--ec-blue);
            font-size: 1rem;
            font-weight: 700;
        }

        /* Badge status stok */
        .ec-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: .2rem .6rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .ec-badge-inline {
            position: static;
            display: inline-block;
        }

        .ec-badge-ok {
            background: #dcfce7;
            color: #166534;
        }

        .ec-badge-warn {
            background: #fef3c7;
            color: #92400e;
        }

        .ec-badge-out {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Filter kategori */
        .ec-pill {
            display: inline-block;
            padding: .4rem 1rem;
            border: 1px solid var(--ec-line);
            border-radius: 999px;
            background: #fff;
            color: var(--ec-navy);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
        }

        .ec-pill:hover {
            border-color: var(--ec-blue);
            color: var(--ec-blue);
        }

        .ec-pill.active {
            background: var(--ec-blue);
            border-color: var(--ec-blue);
            color: #fff;
        }

        /* Pagination mengikuti warna tema */
        .pagination {
            --bs-pagination-color: var(--ec-blue);
            --bs-pagination-hover-color: var(--ec-blue-dark);
            --bs-pagination-active-bg: var(--ec-blue);
            --bs-pagination-active-border-color: var(--ec-blue);
            --bs-pagination-border-color: var(--ec-line);
            --bs-pagination-focus-box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .25);
        }

        .ec-avatar {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
            border-radius: 50%;
            background: var(--ec-placeholder);
            color: var(--ec-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.0625rem;
            font-weight: 700;
        }

        .ec-avatar-lg {
            width: 72px;
            height: 72px;
            font-size: 1.5rem;
        }

        .ec-empty {
            background: #fff;
            border: 1px dashed #b9c8e2;
            border-radius: 14px;
        }

        /* ---------- Footer ---------- */
        .ec-footer {
            background: var(--ec-navy);
            color: #c9d6ee;
            margin-top: 56px;
        }

        .ec-footer a {
            color: #c9d6ee;
            text-decoration: none;
        }

        .ec-footer a:hover {
            color: #fff;
            text-decoration: underline;
        }

        @media (prefers-reduced-motion: reduce) {
            .ec-card {
                transition: none;
            }
        }

        .ec-search-select {
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--ec-blue);
            font-size: .8125rem;
            font-weight: 600;
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $onVendors = request()->routeIs('customer.vendors.*');
        $productsUrl = route('customer.products.index');
        $vendorsUrl = route('customer.vendors.index');
    @endphp

    <header class="ec-header sticky-top">
        <nav class="navbar navbar-expand-lg p-0">
            <div class="container py-3">
                <a class="ec-brand" href="{{ route('customer.home') }}">
                    <i class="bi bi-diamond-fill"></i>E-Catalog
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNavbar"
                    aria-controls="customerNavbar" aria-expanded="false" aria-label="Buka navigasi">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="customerNavbar">
                    <form id="searchForm" class="ec-search flex-grow-1 mx-lg-4 my-3 my-lg-0" role="search"
                        action="{{ $onVendors ? $vendorsUrl : $productsUrl }}" method="GET">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <input id="searchInput" type="search" name="search" value="{{ request('search') }}"
                            placeholder="{{ $onVendors ? 'Cari nama atau kode vendor...' : 'Cari produk atau kategori...' }}"
                            aria-label="Cari">

                        {{-- Tanpa atribut name, jadi tidak ikut terkirim sebagai query --}}
                        <select id="searchTarget" class="ec-search-select" aria-label="Cari di">
                            <option value="{{ $productsUrl }}" data-placeholder="Cari produk atau kategori..."
                                {{ $onVendors ? '' : 'selected' }}>Produk</option>
                            <option value="{{ $vendorsUrl }}" data-placeholder="Cari nama atau kode vendor..."
                                {{ $onVendors ? 'selected' : '' }}>Vendor</option>
                        </select>
                    </form>

                    <ul class="navbar-nav align-items-lg-center gap-lg-4">
                        <li class="nav-item">
                            <a class="ec-nav-link {{ request()->routeIs('customer.home') ? 'active' : '' }}"
                                href="{{ route('customer.home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="ec-nav-link {{ request()->routeIs('customer.products.*') ? 'active' : '' }}"
                                href="{{ route('customer.products.index') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="ec-nav-link {{ request()->routeIs('customer.vendors.*') ? 'active' : '' }}"
                                href="{{ route('customer.vendors.index') }}">Vendor</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="ec-footer">
        <div class="container py-4">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-2">
                <div>
                    <span class="fw-bold fs-6 text-white">E-Catalog</span>

                    {{-- Isi alamat/kontak di config/catalog.php: ['address' => '...'] --}}
                    @if (config('catalog.address'))
                        <div class="small mt-1">{{ config('catalog.address') }}</div>
                    @endif
                </div>

                <small>
                    &copy; {{ date('Y') }} E-Catalog
                    &nbsp;|&nbsp;
                    <a href="{{ route('login') }}">Login Admin</a>
                </small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchInput');
        const target = document.getElementById('searchTarget');

        target.addEventListener('change', () => {
            form.action = target.value;
            input.placeholder = target.selectedOptions[0].dataset.placeholder;
            input.focus();
        });
    </script>

    @stack('scripts')
</body>

</html>
