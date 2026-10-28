@extends('layouts.app')
@section('title', $product->name . ' - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category'=>$product->category->slug]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Gambar -->
        <div class="col-md-5">
            <div class="rounded-3 overflow-hidden" style="border:2px solid #e0e0e0;">
                @if($product->image && file_exists(public_path('storage/'.$product->image)))
                    <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid w-100" style="max-height:420px;object-fit:cover;" alt="{{ $product->name }}">
                @else
                    <div style="height:420px;background:linear-gradient(135deg,#2d2d2d,#1a1a1a);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-patch-check" style="font-size:8rem;color:#C9A84C;opacity:.4;"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detail -->
        <div class="col-md-7">
            <span class="badge mb-3" style="background:rgba(201,168,76,.15);color:#C9A84C;">{{ $product->category->name }}</span>
            <h1 style="font-size:1.9rem;" class="mb-2">{{ $product->name }}</h1>

            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="font-size:2rem;font-weight:700;color:#C9A84C;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="mb-3">
                @if($product->stock > 10)
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Stok Tersedia ({{ $product->stock }})</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Stok Terbatas ({{ $product->stock }})</span>
                @else
                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Stok Habis</span>
                @endif
            </div>

            @if($product->size)
            <div class="mb-3">
                <span class="fw-600">Ukuran Tersedia: </span>
                <span class="text-muted">{{ $product->size }}</span>
            </div>
            @endif

            <hr>
            <div class="mb-4">
                <h6 class="fw-600 mb-2">Deskripsi Produk</h6>
                <p class="text-muted" style="line-height:1.8;">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>

            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="d-flex align-items-center gap-3 mb-3">
                    <label class="fw-600">Jumlah:</label>
                    <div class="input-group" style="width:140px;">
                        <button type="button" class="btn btn-outline-secondary" id="minus">-</button>
                        <input type="number" name="quantity" id="qty" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                        <button type="button" class="btn btn-outline-secondary" id="plus">+</button>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gold btn-lg px-5">
                        <i class="bi bi-cart-plus me-2"></i>Tambah Keranjang
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-gold btn-lg">
                        <i class="bi bi-bag-check me-2"></i>Beli Sekarang
                    </a>
                </div>
            </form>
            @else
            <div class="alert alert-danger">
                <i class="bi bi-x-circle me-2"></i>Maaf, produk ini sedang tidak tersedia.
            </div>
            @endif

            <!-- Info Pengiriman -->
            <div class="row g-2 mt-2">
                @foreach([['bi-truck','Gratis Ongkir','Min. Rp 200.000'],['bi-arrow-return-left','Retur 7 Hari','Garansi kualitas'],['bi-shield-check','Produk Asli','100% Original']] as $info)
                <div class="col-4">
                    <div class="p-2 rounded-2 text-center" style="background:#f8f8f8;border:1px solid #e0e0e0;">
                        <i class="bi {{ $info[0] }} mb-1 d-block" style="color:#C9A84C;"></i>
                        <div style="font-size:.75rem;font-weight:600;">{{ $info[1] }}</div>
                        <div style="font-size:.7rem;color:#888;">{{ $info[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    @if($related->count())
    <div class="mt-5">
        <h4 class="section-title mb-4">Produk Terkait</h4>
        <div class="row g-4">
            @foreach($related as $p)
            <div class="col-6 col-md-3">
                @include('partials.product-card', ['product' => $p])
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
const qty = document.getElementById('qty');
const max = {{ $product->stock }};
document.getElementById('minus').onclick = () => { if(qty.value > 1) qty.value--; };
document.getElementById('plus').onclick = () => { if(qty.value < max) qty.value++; };
</script>
@endpush
