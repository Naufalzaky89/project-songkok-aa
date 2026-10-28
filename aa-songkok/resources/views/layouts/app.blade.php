<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AA Songkok - Peci & Songkok Premium')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C96A; --dark:#1a1a1a; --dark-2:#2d2d2d; }
        body { font-family:'Poppins',sans-serif; background:#f8f8f8; color:#333; }
        h1,h2,h3,h4,h5 { font-family:'Playfair Display',serif; }
        .navbar-main { background:var(--dark)!important; border-bottom:2px solid var(--gold); }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:700; color:var(--gold)!important; letter-spacing:1px; }
        .navbar-brand span { color:#fff; }
        .navbar-main .nav-link { color:#ccc!important; transition:color .3s; font-weight:500; }
        .navbar-main .nav-link:hover,.navbar-main .nav-link.active { color:var(--gold)!important; }
        .navbar-toggler { border-color:var(--gold); }
        .btn-gold { background:var(--gold); color:var(--dark); border:none; font-weight:600; transition:all .3s; }
        .btn-gold:hover { background:var(--gold-light); color:var(--dark); transform:translateY(-1px); }
        .btn-outline-gold { border:2px solid var(--gold); color:var(--gold); background:transparent; font-weight:600; transition:all .3s; }
        .btn-outline-gold:hover { background:var(--gold); color:var(--dark); }
        .product-card { border:none; border-radius:12px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,.08); transition:all .3s; background:white; }
        .product-card:hover { transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,.15); }
        .product-price { color:var(--gold); font-weight:700; font-size:1.1rem; }
        .section-title { position:relative; display:inline-block; color:var(--dark); }
        .section-title::after { content:''; position:absolute; bottom:-8px; left:0; width:60px; height:3px; background:var(--gold); border-radius:2px; }
        footer { background:var(--dark); color:#ccc; }
        footer h5 { color:var(--gold); font-family:'Playfair Display',serif; }
        footer a { color:#aaa; text-decoration:none; transition:color .3s; }
        footer a:hover { color:var(--gold); }
        .social-icon { font-size:1.4rem; }
        .breadcrumb-area { background:linear-gradient(135deg,var(--dark),var(--dark-2)); padding:20px 0; border-bottom:1px solid var(--gold); }
        .breadcrumb-item a { color:var(--gold); }
        .breadcrumb-item.active { color:#aaa; }
        .breadcrumb-item+.breadcrumb-item::before { color:#666; }
        .filter-card { border:1px solid #e0e0e0; border-radius:12px; }
        .filter-card .card-header { background:var(--dark); color:var(--gold); border-radius:12px 12px 0 0!important; }
        .alert-gold { background:rgba(201,168,76,.1); border:1px solid var(--gold); color:var(--dark); }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-main sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">AA <span>Songkok</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="bi bi-list" style="color:var(--gold);font-size:1.5rem;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                </li>
            </ul>
            <form class="d-flex me-3" action="{{ route('products.index') }}" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                        value="{{ request('search') }}"
                        style="background:#2d2d2d;border-color:#555;color:#fff;min-width:160px;">
                    <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-gold btn-sm me-2 position-relative">
                <i class="bi bi-cart3"></i>
                @php $cartCount = count(session()->get('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                        style="background:var(--gold);color:var(--dark);font-size:.65rem;">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                <div class="dropdown">
                    <button class="btn btn-sm btn-gold dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>{{ \Illuminate\Support\Str::limit(auth()->user()->name, 12) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="background:#2d2d2d;border-color:var(--gold);">
                        <li><a class="dropdown-item text-light" href="{{ route('profile.index') }}">
                            <i class="bi bi-person me-2" style="color:var(--gold)"></i>Profil Saya</a></li>
                        <li><a class="dropdown-item text-light" href="{{ route('orders.index') }}">
                            <i class="bi bi-bag me-2" style="color:var(--gold)"></i>Pesanan Saya</a></li>
                        @if(auth()->user()->isAdmin())
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li><a class="dropdown-item text-light" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2" style="color:var(--gold)"></i>Dashboard Admin</a></li>
                        @endif
                        <li><hr class="dropdown-divider border-secondary"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-gold me-2">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-gold">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<main>@yield('content')</main>

<footer class="pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="mb-3" style="font-size:1.8rem;">AA Songkok</h5>
                <p style="color:#999;line-height:1.8;">Toko peci dan songkok premium terpercaya. Menyediakan berbagai koleksi peci dan songkok berkualitas tinggi untuk berbagai kebutuhan.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="social-icon"><i class="bi bi-instagram" style="color:var(--gold)"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-facebook" style="color:var(--gold)"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-whatsapp" style="color:var(--gold)"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-tiktok" style="color:var(--gold)"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5 class="mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Katalog</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Tentang Kami</a></li>
                    <li class="mb-2"><a href="{{ route('cart.index') }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Keranjang</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5 class="mb-3">Kategori</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('products.index', ['category'=>'peci-hitam']) }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Peci Hitam</a></li>
                    <li class="mb-2"><a href="{{ route('products.index', ['category'=>'peci-nu']) }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Peci NU</a></li>
                    <li class="mb-2"><a href="{{ route('products.index', ['category'=>'songkok-premium']) }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Songkok Premium</a></li>
                    <li class="mb-2"><a href="{{ route('products.index', ['category'=>'songkok-bordir']) }}"><i class="bi bi-chevron-right me-1" style="color:var(--gold)"></i>Songkok Bordir</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5 class="mb-3">Kontak</h5>
                <ul class="list-unstyled" style="color:#999;">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2" style="color:var(--gold)"></i>Jl. Songkok No. 1, Jakarta Pusat 10110</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2" style="color:var(--gold)"></i>+62 812-3456-7890</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2" style="color:var(--gold)"></i>info@aasongkok.com</li>
                    <li class="mb-2"><i class="bi bi-clock me-2" style="color:var(--gold)"></i>Senin - Sabtu: 08.00 - 20.00</li>
                </ul>
            </div>
        </div>
        <hr style="border-color:#333;margin-top:2rem;">
        <div class="text-center" style="color:#666;">
            <p class="mb-0">&copy; {{ date('Y') }} <span style="color:var(--gold)">AA Songkok</span>. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),timer:4000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('warning'))
    Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
</script>
@stack('scripts')
</body>
</html>
