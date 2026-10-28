@extends('layouts.app')
@section('title', 'Riwayat Pesanan - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Riwayat Pesanan</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <h3 class="mb-4"><i class="bi bi-bag-check me-2" style="color:#C9A84C;"></i>Riwayat Pesanan</h3>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-bag-x" style="font-size:5rem;color:#ddd;"></i>
            <h5 class="mt-3 text-muted">Belum ada pesanan</h5>
            <a href="{{ route('products.index') }}" class="btn btn-gold mt-3">Mulai Belanja</a>
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background:#f8f8f8;">
                        <div>
                            <span class="fw-600">{{ $order->order_number }}</span>
                            <small class="text-muted ms-3">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'refunded' ? 'Refund' : 'Belum Bayar') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small mb-1">{{ $order->orderDetails->count() }} item • {{ $order->payment_method }}</div>
                                <div class="fw-700" style="color:#C9A84C;font-size:1.1rem;">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                @if($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin membatalkan pesanan ini?')">
                                        <i class="bi bi-x-circle me-1"></i>Batalkan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
