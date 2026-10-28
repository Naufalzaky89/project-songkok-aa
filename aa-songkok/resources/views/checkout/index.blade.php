@extends('layouts.app')
@section('title', 'Checkout - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Keranjang</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <h3 class="mb-4"><i class="bi bi-credit-card me-2" style="color:#C9A84C;"></i>Checkout</h3>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            <!-- Alamat Pengiriman -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                        <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-600">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan...">{{ old('shipping_address', $user->address) }}</textarea>
                                @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror" placeholder="Kota/Kabupaten" value="{{ old('shipping_city') }}">
                                @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_province" class="form-control @error('shipping_province') is-invalid @enderror" placeholder="Provinsi" value="{{ old('shipping_province') }}">
                                @error('shipping_province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_postal_code" class="form-control @error('shipping_postal_code') is-invalid @enderror" placeholder="12345" value="{{ old('shipping_postal_code') }}">
                                @error('shipping_postal_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" placeholder="08xxxxxxxxxx" value="{{ old('shipping_phone', $user->phone) }}">
                                @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                        <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-wallet2 me-2"></i>Metode Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        @foreach(['Transfer Bank' => ['bi-bank2','Transfer Bank BCA/Mandiri/BNI/BRI'], 'COD' => ['bi-cash-coin','Bayar di Tempat (COD)'], 'QRIS' => ['bi-qr-code','QRIS (Scan QR)']] as $val => $info)
                        <div class="form-check mb-3 p-3 rounded-2" style="border:1px solid #e0e0e0;">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_{{ $val }}" value="{{ $val }}" {{ old('payment_method') == $val || $val == 'Transfer Bank' ? 'checked' : '' }}>
                            <label class="form-check-label d-flex align-items-center gap-2 fw-500" for="pay_{{ $val }}">
                                <i class="bi {{ $info[0] }}" style="color:#C9A84C;font-size:1.3rem;"></i>
                                {{ $info[1] }}
                            </label>
                        </div>
                        @endforeach
                        @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Catatan -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <label class="form-label fw-600">Catatan Pesanan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan untuk pesanan Anda...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:80px;">
                    <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                        <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan</h6>
                    </div>
                    <div class="card-body">
                        @foreach($cart as $id => $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <div class="fw-600" style="font-size:.85rem;">{{ $item['name'] }}</div>
                                <small class="text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                            </div>
                            <span class="fw-600" style="font-size:.85rem;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-between mt-3 mb-1">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span class="fw-600">Rp 15.000</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-700">Total Pembayaran</span>
                            <span class="fw-700" style="color:#C9A84C;font-size:1.2rem;">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-gold w-100 btn-lg" id="submitBtn">
                            <i class="bi bi-bag-check me-2"></i>Buat Pesanan
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
});
</script>
@endpush
