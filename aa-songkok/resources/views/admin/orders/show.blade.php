@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" style="color:var(--gold)">Pesanan</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <!-- Info Pesanan -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header" style="background:var(--dark);border-radius:12px 12px 0 0;">
                <h6 class="mb-0" style="color:var(--gold);">
                    <i class="bi bi-receipt me-2"></i>{{ $order->order_number }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-3 text-center">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ $order->status }} px-3 py-2 mt-1">{{ $order->status_label }}</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <small class="text-muted d-block">Pembayaran</small>
                        <span class="badge mt-1 {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                            {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                    <div class="col-md-3 text-center">
                        <small class="text-muted d-block">Metode</small>
                        <span class="fw-600 d-block mt-1">{{ $order->payment_method }}</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <small class="text-muted d-block">Tanggal</small>
                        <span class="fw-600 d-block mt-1">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Detail Produk -->
                <table class="table">
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
                        <tr><td colspan="3" class="text-end fw-600">Ongkos Kirim</td><td>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td></tr>
                        <tr><td colspan="3" class="text-end fw-700">Total</td><td class="fw-700" style="color:var(--gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header" style="background:var(--dark);border-radius:12px 12px 0 0;">
                <h6 class="mb-0" style="color:var(--gold);"><i class="bi bi-pencil-square me-2"></i>Update Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-600">Status Pesanan</label>
                            <select name="status" class="form-select">
                                @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'] as $val => $label)
                                    <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-600">Status Pembayaran</label>
                            <select name="payment_status" class="form-select">
                                @foreach(['unpaid'=>'Belum Bayar','paid'=>'Lunas','refunded'=>'Refund'] as $val => $label)
                                    <option value="{{ $val }}" {{ $order->payment_status == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-gold w-100"><i class="bi bi-save me-1"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Info Pelanggan -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header" style="background:var(--dark);border-radius:12px 12px 0 0;">
                <h6 class="mb-0" style="color:var(--gold);"><i class="bi bi-person me-2"></i>Pelanggan</h6>
            </div>
            <div class="card-body">
                <p class="mb-1 fw-600">{{ $order->user->name ?? 'N/A' }}</p>
                <p class="text-muted small mb-1">{{ $order->user->email ?? '' }}</p>
                <p class="text-muted small">{{ $order->user->phone ?? '' }}</p>
            </div>
        </div>
        <!-- Alamat -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header" style="background:var(--dark);border-radius:12px 12px 0 0;">
                <h6 class="mb-0" style="color:var(--gold);"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman</h6>
            </div>
            <div class="card-body">
                <p class="mb-1 fw-600">{{ $order->shipping_phone }}</p>
                <p class="text-muted small">{{ $order->shipping_address }},<br>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                @if($order->notes)
                <div class="alert alert-warning py-2 mt-2 small"><i class="bi bi-sticky me-1"></i>{{ $order->notes }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
