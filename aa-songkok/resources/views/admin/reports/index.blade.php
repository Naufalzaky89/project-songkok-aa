@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<!-- Filter Tanggal -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-600 small">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-600 small">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-gold"><i class="bi bi-search me-1"></i>Tampilkan</button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 text-center p-4">
            <i class="bi bi-bag-check-fill mb-2" style="font-size:2rem;color:#C9A84C;"></i>
            <h3 class="fw-700 mb-1" style="color:#C9A84C;">{{ $summary->total_orders ?? 0 }}</h3>
            <p class="text-muted mb-0">Total Pesanan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 text-center p-4">
            <i class="bi bi-currency-dollar mb-2" style="font-size:2rem;color:#198754;"></i>
            <h3 class="fw-700 mb-1" style="color:#198754;">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</h3>
            <p class="text-muted mb-0">Total Pendapatan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 text-center p-4">
            <i class="bi bi-calculator mb-2" style="font-size:2rem;color:#0d6efd;"></i>
            <h3 class="fw-700 mb-1" style="color:#0d6efd;">Rp {{ number_format($summary->avg_order ?? 0, 0, ',', '.') }}</h3>
            <p class="text-muted mb-0">Rata-rata Pesanan</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header" style="background:#fff;border-bottom:2px solid #f0f0f0;">
                <h6 class="mb-0 fw-600"><i class="bi bi-bar-chart me-2" style="color:var(--gold)"></i>Penjualan Harian</h6>
            </div>
            <div class="card-body">
                <canvas id="reportChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <!-- Top Products -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header" style="background:#fff;border-bottom:2px solid #f0f0f0;">
                <h6 class="mb-0 fw-600"><i class="bi bi-trophy me-2" style="color:var(--gold)"></i>Produk Terlaris</h6>
            </div>
            <div class="card-body p-0">
                @forelse($topProducts as $i => $p)
                <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span style="width:25px;height:25px;border-radius:50%;background:var(--gold);color:#1a1a1a;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">{{ $i+1 }}</span>
                    <div class="flex-grow-1">
                        <div class="fw-600" style="font-size:.83rem;">{{ Str::limit($p->product_name, 22) }}</div>
                        <small class="text-muted">{{ $p->total_sold }} terjual · Rp {{ number_format($p->total_revenue, 0, ',', '.') }}</small>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">Belum ada data</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header" style="background:#fff;border-bottom:2px solid #f0f0f0;">
        <h6 class="mb-0 fw-600"><i class="bi bi-table me-2" style="color:var(--gold)"></i>Daftar Transaksi</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr><th class="ps-3">No. Pesanan</th><th>Pelanggan</th><th>Item</th><th>Total</th><th>Metode</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-3 fw-600">{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->orderDetails->count() }} item</td>
                        <td class="fw-600" style="color:var(--gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada transaksi pada periode ini</td></tr>
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

@push('scripts')
<script>
const labels = {!! json_encode($dailySales->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray()) !!};
const data = {!! json_encode($dailySales->pluck('total')->toArray()) !!};
new Chart(document.getElementById('reportChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan',
            data: data,
            backgroundColor: 'rgba(201,168,76,.6)',
            borderColor: '#C9A84C',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' } } }
    }
});
</script>
@endpush
