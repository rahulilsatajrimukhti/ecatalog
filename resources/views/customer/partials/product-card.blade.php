@php
    // Status stok dari accessor stock_status di model Product (available | low | out)
    $badge =
        [
            'available' => ['Tersedia', 'ec-badge-ok'],
            'low' => ['Stok menipis', 'ec-badge-warn'],
            'out' => ['Stok habis', 'ec-badge-out'],
        ][$product->stock_status] ?? null;
@endphp

<a href="{{ route('customer.products.show', $product->id) }}" class="ec-card">
    <div class="ec-media">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="ec-product-image"
                loading="lazy">
        @else
            <div class="ec-product-placeholder" aria-hidden="true">
                <i class="bi bi-image"></i>
            </div>
        @endif

        @if ($badge)
            <span class="ec-badge {{ $badge[1] }}">{{ $badge[0] }}</span>
        @endif
    </div>

    <div class="p-3">
        <div class="fw-semibold mb-1">{{ $product->name }}</div>

        <div class="small text-ec-muted mb-2">
            {{ optional($product->category)->name ?? 'Tanpa kategori' }}
            &middot; {{ $product->product_code }}
        </div>

        @if ($product->selling_price !== null)
            <div class="ec-price">
                Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                @if ($product->unit)
                    <span class="small fw-normal text-ec-muted">/ {{ $product->unit }}</span>
                @endif
            </div>
        @else
            <div class="small text-ec-muted">Harga belum tersedia</div>
        @endif
    </div>
</a>
