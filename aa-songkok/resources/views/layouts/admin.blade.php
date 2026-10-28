<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - AA Songkok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root { --gold: #C9A84C; --dark: #1a1a1a; --dark-2: #252525; --sidebar-w: 260px; }
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; }
        /* Sidebar */
        .admin-sidebar { width: var(--sidebar-w); min-height: 100vh; background: var(--dark); position: fixed; top: 0; left: 0; z-index: 1000; transition: all .3s; border-right: 2px solid var(--gold); display: flex; flex-direction: column; }
        .sidebar-brand { padding: 20px; border-bottom: 1px solid #333; }
        .sidebar-brand h4 { color: var(--gold); font-weight: 700; margin: 0; font-size: 1.3rem; }
        .sidebar-brand small { color: #777; font-size: .75rem; }
        .sidebar-menu { flex: 1; padding: 15px 0; overflow-y: auto; }
        .sidebar-menu .menu-label { color: #555; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 5px; }
        .sidebar-menu .nav-link { color: #aaa; padding: 10px 20px; display: flex; align-items: center; gap: 10px; border-radius: 0; transition: all .2s; font-size: .9rem; }
        .sidebar-menu .nav-link i { font-size: 1.1rem; width: 20px; }
        .sidebar-menu .nav-link:hover, .sidebar-menu .nav-link.active { color: var(--gold); background: rgba(201,168,76,.1); border-left: 3px solid var(--gold); padding-left: 17px; }
        /* Topbar */
        .admin-topbar { margin-left: var(--sidebar-w); background: white; padding: 12px 25px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
        /* Content */
        .admin-content { margin-left: var(--sidebar-w); padding: 25px; min-height: calc(100vh - 65px); }
        /* Cards */
        .stat-card { border: none; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px; }
        .stat-card .stat-icon { width: 55px; height: 55px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .stat-card .stat-value { font-size: 1.6rem; font-weight: 700; margin: 0; }
        .stat-card .stat-label { color: #888; font-size: .82rem; margin: 0; }
        /* Table */
        .admin-table thead th { background: var(--dark); color: var(--gold); border: none; font-size: .85rem; font-weight: 600; }
        .admin-table tbody tr:hover { background: rgba(201,168,76,.05); }
        /* Badge status */
        .badge-pending { background: #ffc107; color: #000; }
        .badge-processing { background: #0dcaf0; color: #000; }
        .badge-shipped { background: #0d6efd; color: #fff; }
        .badge-delivered { background: #198754; color: #fff; }
        .badge-cancelled { background: #dc3545; color: #fff; }
        /* Form card */
        .form-card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,.06); }
        .form-card .card-header { background: var(--dark); color: var(--gold); border-radius: 12px 12px 0 0 !important; }
        .btn-gold { background: var(--gold); color: var(--dark); border: none; font-weight: 600; }
        .btn-gold:hover { background: #e0ba5a; color: var(--dark); }
        @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .admin-topbar, .admin-content { margin-left: 0; } }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-shop me-2"></i>AA Songkok</h4>
        <small>Panel Administrator</small>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="menu-label">Produk</div>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produk
        </a>

        <div class="menu-label">Toko</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Pesanan
        </a>
        <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Banner
        </a>

        <div class="menu-label">Manajemen</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Pengguna
        </a>
        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Laporan
        </a>

        <div class="menu-label">Akun</div>
        <a href="{{ route('home') }}" class="nav-link" target="_blank">
            <i class="bi bi-globe"></i> Lihat Website
        </a>
        <a href="#" class="nav-link text-danger" onclick="document.getElementById('logout-form').submit()">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>
</aside>

<!-- Topbar -->
<div class="admin-topbar">
    <div>
        <h6 class="mb-0 fw-600">@yield('page-title', 'Dashboard')</h6>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:var(--gold)">Admin</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge" style="background:var(--gold);color:var(--dark);">
            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
        </span>
    </div>
</div>

<!-- Content -->
<main class="admin-content">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 4000, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif

    // Confirm delete
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin hapus?', text: 'Data tidak dapat dikembalikan!',
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#C9A84C', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then(result => { if (result.isConfirmed) form.submit(); });
        });
    });
</script>
@stack('scripts')
</body>
</html>
