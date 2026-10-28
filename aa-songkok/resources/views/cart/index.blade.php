@extends('layouts.app')
@section('title', 'Keranjang Belanja - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Keranjang Belanja</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <h3 class="mb-4"><i class="bi bi-cart3 me-2" style="color:#C9A84C;"></i>Keranjang Belanja</h3>

    @if(empty($cart))
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size:5rem;color:#ddd;"></i>
            <h4 class="mt-3 text-muted">Keranjang Anda masih kosong</h4>
            <p class="text-muted">Yuk, mulai belanja peci & songkok pilihan kami!</p>
            <a href="{{ route('products.index') }}" class="btn btn-gold mt-2 px-5">
                <i class="bi bi-bag2 me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead style="background:#1a1a1a;">
                                <tr>
                                    <th class="ps-3" style="color:#C9A84C;font-weight:600;border:none;">Produk</th>
                                    <th style="color:#C9A84C;font-weight:600;border:none;">Harga</th>
                                    <th style="color:#C9A84C;font-weight:600;border:none;">Jumlah</th>
                                    <th style="color:#C9A84C;font-weight:600;border:none;">Subtotal</th>
                                    <th style="color:#C9A84C;font-weight:600;border:none;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                <tr style="border-bottom:1px solid #f0f0f0;">
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width:60px;height:60px;background:linear-gradient(135deg,#2d2d2d,#1a1a1a);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                @if(isset($item['image']) && $item['image'] && file_exists(public_path('storage/'.$item['image'])))
                                                    <img src="{{ asset('storage/'.$item['image']) }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                                @else
                                                    <i class="bi bi-patch-check" style="color:#C9A84C;font-size:1.5rem;"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-600" style="font-size:.9rem;">{{ $item['name'] }}</div>
                                                <small class="text-muted">Stok: {{ $item['stock'] ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color:#C9A84C;font-weight:600;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf @method('PATCH')
                                            <div class="input-group input-group-sm" style="width:110px;">
                                                <input type="number" name="quantity" class="form-control text-center" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?? 99 }}" onchange="this.form.submit()">
                                            </div>
                                        </form>
                                    </td>
                                    <td class="fw-600">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Kosongkan semua keranjang?')">
                        <i class="bi bi-trash me-1"></i>Kosongkan Keranjang
                    </button>
                </form>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm ms-2">
                    <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
                </a>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:80px;">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0 !important;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal ({{ count($cart) }} item)</span>
                        <span class="fw-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="fw-600">Rp 15.000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-700">Total</span>
                        <span class="fw-700" style="color:#C9A84C;font-size:1.2rem;">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                    </div>
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-gold w-100 btn-lg">
                            <i class="bi bi-credit-card me-2"></i>Lanjut Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-gold w-100 btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Checkout
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
