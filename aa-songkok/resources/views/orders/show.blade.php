@extends('layouts.app')
@section('title', 'Detail Pesanan - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3><i class="bi bi-receipt me-2" style="color:#C9A84C;"></i>Detail Pesanan</h3>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <!-- Status -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <div class="text-muted small mb-1">Nomor Pesanan</div>
                            <div class="fw-700">{{ $order->order_number }}</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="text-muted small mb-1">Status Pesanan</div>
                            <span class="badge badge-{{ $order->status }} px-3 py-2">{{ $order->status_label }}</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="text-muted small mb-1">Status Pembayaran</div>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'refunded' ? 'Refund' : 'Belum Bayar') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-box-seam me-2"></i>Produk Dipesan</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead style="background:#f8f8f8;">
                            <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                            <tr>
                                <td>{{ $detail->product_name }}</td>
                                <td>Rp {{ number_format($detail->product_price, 0, ',', '.') }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td class="fw-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background:#f8f8f8;">
                            <tr>
                                <td colspan="3" class="text-end fw-600">Subtotal</td>
                                <td class="fw-600">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-600">Ongkos Kirim</td>
                                <td class="fw-600">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-700">Total</td>
                                <td class="fw-700" style="color:#C9A84C;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($order->notes)
            <div class="alert alert-gold">
                <i class="bi bi-sticky me-2"></i><strong>Catatan:</strong> {{ $order->notes }}
            </div>
            @endif

            @if($order->status == 'pending')
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin membatalkan pesanan ini?')">
                    <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                </button>
            </form>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Alamat -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                    <p class="mb-1 text-muted small">{{ $order->shipping_phone }}</p>
                    <p class="text-muted small">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                </div>
            </div>
            <!-- Pembayaran -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-wallet2 me-2"></i>Info Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode</span>
                        <span class="fw-600">{{ $order->payment_method }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tanggal Pesan</span>
                        <span class="fw-600">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    @if($order->payment_status == 'unpaid')
                    <div class="alert-gold p-3 rounded-2 mt-3 text-center" style="font-size:.85rem;">
                        <i class="bi bi-info-circle me-2"></i>
                        Harap transfer ke:<br>
                        <strong>BCA 1234567890 a/n AA Songkok</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
