@extends('layouts.admin')
@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Pesanan</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nomor pesanan / nama pelanggan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-gold"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-3 fw-600">{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="fw-600" style="color:var(--gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'refunded' ? 'bg-info' : 'bg-warning text-dark') }}">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : ($order->payment_status == 'refunded' ? 'Refund' : 'Belum Bayar') }}
                            </span>
                        </td>
                        <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
