<div class="product-card h-100">
    <div class="position-relative">
        @if($product->image && file_exists(public_path('storage/'.$product->image)))
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:220px;object-fit:cover;">
        @else
            <div style="height:220px;background:linear-gradient(135deg,#2d2d2d,#1a1a1a);display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-patch-check" style="font-size:4rem;color:#C9A84C;opacity:.5;"></i>
            </div>
        @endif
        @if($product->is_featured)
            <span class="position-absolute top-0 start-0 m-2 badge" style="background:#C9A84C;color:#1a1a1a;">
                <i class="bi bi-star-fill me-1"></i>Unggulan
            </span>
        @endif
        @if($product->stock == 0)
            <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Habis</span>
        @elseif($product->stock <= 5)
            <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">Stok Terbatas</span>
        @endif
    </div>
    <div class="card-body d-flex flex-column p-3">
        <span class="badge mb-2 d-inline-block" style="background:rgba(201,168,76,.15);color:#C9A84C;font-size:.72rem;">
            {{ $product->category->name }}
        </span>
        <h6 class="card-title mb-1 fw-600" style="font-size:.92rem;line-height:1.4;">
            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none stretched-link">
                {{ $product->name }}
            </a>
        </h6>
        @if($product->size)
            <small class="text-muted mb-2"><i class="bi bi-rulers me-1"></i>Ukuran: {{ $product->size }}</small>
        @endif
        <div class="mt-auto pt-2">
            <div class="product-price mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-gold btn-sm w-100 {{ $product->stock == 0 ? 'disabled' : '' }}">
                    <i class="bi bi-cart-plus me-1"></i>
                    {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
                </button>
            </form>
        </div>
    </div>
</div>
