@extends('layouts.admin')
@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" style="color:var(--gold)">Pengguna</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 text-center p-4">
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:flex;align-items:center;justify-content:center;margin:auto;font-size:2rem;color:#1a1a1a;font-weight:700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }} px-3 py-2">{{ ucfirst($user->role) }}</span>
            <hr>
            <div class="text-start">
                <p class="small mb-2"><i class="bi bi-telephone me-2" style="color:var(--gold);"></i>{{ $user->phone ?? 'Belum diisi' }}</p>
                <p class="small mb-2"><i class="bi bi-geo-alt me-2" style="color:var(--gold);"></i>{{ $user->address ?? 'Belum diisi' }}</p>
                <p class="small mb-0"><i class="bi bi-calendar me-2" style="color:var(--gold);"></i>Bergabung {{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header" style="background:var(--dark);border-radius:12px 12px 0 0;">
                <h6 class="mb-0" style="color:var(--gold);"><i class="bi bi-bag me-2"></i>Riwayat Pesanan</h6>
            </div>
            <div class="card-body p-0">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr><th class="ps-3">No. Pesanan</th><th>Total</th><th>Status</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td class="ps-3 fw-600">{{ $order->order_number }}</td>
                            <td style="color:var(--gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
