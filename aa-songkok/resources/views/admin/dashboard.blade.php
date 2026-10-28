@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Stat Cards -->
<div class="row g-4 mb-4">
    @foreach([
        ['Rp ' . number_format($totalRevenue, 0, ',', '.'), 'Total Pendapatan', 'bi-currency-dollar', '#198754', '#d1f2e1'],
        [$totalOrders, 'Total Pesanan', 'bi-bag-check', '#0d6efd', '#d1e3ff'],
        [$totalProducts, 'Total Produk', 'bi-box-seam', '#C9A84C', '#fff3cd'],
        [$totalUsers, 'Total Pengguna', 'bi-people', '#dc3545', '#ffe0e0'],
        [$pendingOrders, 'Pesanan Pending', 'bi-clock-history', '#6f42c1', '#ede0ff'],
    ] as $stat)
    <div class="col-6 col-md-4 col-xl">
        <div class="card stat-card shadow-sm" style="background:{{ $stat[4] }};">
            <div class="stat-icon" style="background:{{ $stat[3] }}20;">
                <i class="bi {{ $stat[2] }}" style="color:{{ $stat[3] }};"></i>
            </div>
            <div>
                <p class="stat-value" style="font-size:1.3rem;color:{{ $stat[3] }};">{{ $stat[0] }}</p>
                <p class="stat-label">{{ $stat[1] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    <!-- Chart Penjualan -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff;border-bottom:2px solid #f0f0f0;">
                <h6 class="mb-0 fw-600"><i class="bi bi-graph-up me-2" style="color:var(--gold)"></i>Grafik Penjualan 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <!-- Top Produk -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header" style="background:#fff;border-bottom:2px solid #f0f0f0;">
                <h6 class="mb-0 fw-600"><i class="bi bi-trophy me-2" style="color:var(--gold)"></i>Produk Terlaris</h6>
            </div>
            <div class="card-body p-0">
                @forelse($topProducts as $i => $p)
                <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:flex;align-items:center;justify-content:center;font-weight:700;color:#1a1a1a;font-size:.8rem;flex-shrink:0;">{{ $i+1 }}</div>
                    <div class="flex-grow-1">
                        <div class="fw-600" style="font-size:.85rem;">{{ Str::limit($p->product_name, 22) }}</div>
                        <small class="text-muted">{{ $p->total_sold }} terjual</small>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Pesanan Terbaru -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:#fff;border-bottom:2px solid #f0f0f0;">
        <h6 class="mb-0 fw-600"><i class="bi bi-bag me-2" style="color:var(--gold)"></i>Pesanan Terbaru</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-gold">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="ps-3 fw-600">{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="fw-600" style="color:var(--gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                        <td>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum' }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($chartData) !!},
            borderColor: '#C9A84C',
            backgroundColor: 'rgba(201,168,76,.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#C9A84C',
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' } }
        }
    }
});
</script>
@endpush
