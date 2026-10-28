<a href="{{ route('customer.vendors.show', $vendor->id) }}" class="ec-card p-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="ec-avatar" aria-hidden="true">{{ $vendor->initials }}</div>

        <div class="min-w-0">
            <div class="fw-bold">{{ $vendor->name }}</div>

            @if ($vendor->vendor_code)
                <div class="small text-ec-muted">{{ $vendor->vendor_code }}</div>
            @endif
        </div>
    </div>

    @if ($vendor->address)
        <p class="small text-ec-muted mb-3">
            <i class="bi bi-geo-alt me-1"></i>{{ $vendor->address }}
        </p>
    @endif

    <span class="ec-link">Lihat Detail</span>
</a>
