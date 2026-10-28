@extends('layouts.app')
@section('title', 'AA Songkok - Peci & Songkok Premium')

@push('styles')
<style>
.hero-slider .carousel-item { height: 520px; }
.hero-slider .carousel-item img { width:100%; height:520px; object-fit:cover; filter:brightness(.45); }
.hero-slider .carousel-caption { bottom:50%; transform:translateY(50%); text-align:left; }
.hero-title { font-size:3rem; font-weight:700; color:#fff; text-shadow:2px 2px 8px rgba(0,0,0,.5); }
.hero-sub { font-size:1.1rem; color:#E8C96A; }
.hero-slider .carousel-indicators [data-bs-target] { background-color:#C9A84C; }
.category-card { border:none; border-radius:14px; overflow:hidden; cursor:pointer; transition:all .3s; background:#fff; box-shadow:0 4px 15px rgba(0,0,0,.08); }
.category-card:hover { transform:translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,.15); }
.why-icon { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#C9A84C,#E8C96A); display:flex; align-items:center; justify-content:center; font-size:1.8rem; color:#1a1a1a; margin:0 auto 15px; }
.testimonial-card { border:none; border-radius:14px; background:#fff; padding:25px; box-shadow:0 4px 15px rgba(0,0,0,.06); }
.stars { color:#C9A84C; }
.section-bg { background:linear-gradient(135deg,#1a1a1a 0%,#2d2d2d 100%); }
</style>
@endpush

@section('content')

{{-- Hero Slider --}}
@if($banners->count())
<div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
        @foreach($banners as $i => $banner)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" {{ $i==0 ? 'class=active aria-current=true' : '' }}></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($banners as $i => $banner)
        <div class="carousel-item {{ $i==0 ? 'active' : '' }}">
            @if($banner->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($banner->image))
                <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
            @else
                <div style="height:520px;background:linear-gradient(135deg,#1a1a1a 0%,#2d2d2d 100%);"></div>
            @endif
            <div class="carousel-caption container">
                <p class="hero-sub mb-2"><i class="bi bi-star-fill me-1"></i>Koleksi Premium</p>
                <h1 class="hero-title mb-3">{{ $banner->title }}</h1>
                @if($banner->description)
                    <p class="text-white-50 mb-4 d-none d-md-block" style="max-width:500px;">{{ $banner->description }}</p>
                @endif
                <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg px-5 me-3">
                    <i class="bi bi-bag2 me-2"></i>Belanja Sekarang
                </a>
                <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">Tentang Kami</a>
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
@else
<div style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);height:520px;" class="d-flex align-items-center">
    <div class="container text-center">
        <p style="color:#C9A84C;font-size:1.1rem;"><i class="bi bi-star-fill me-1"></i>Selamat Datang di</p>
        <h1 style="font-size:3.5rem;color:#fff;font-family:'Playfair Display',serif;">AA Songkok</h1>
        <p class="text-white-50 mb-4">Peci &amp; Songkok Premium Berkualitas Tinggi</p>
        <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg px-5">
            <i class="bi bi-bag2 me-2"></i>Belanja Sekarang
        </a>
    </div>
</div>
@endif

{{-- Stats Bar --}}
<div style="background:#C9A84C;padding:18px 0;">
    <div class="container">
        <div class="row text-center g-3">
            @foreach([
                ['bi-truck','Gratis Ongkir','Min. pembelian Rp200rb'],
                ['bi-shield-check','Garansi Produk','Kualitas terjamin'],
                ['bi-arrow-return-left','Mudah Return','7 hari pengembalian'],
                ['bi-headset','Layanan 24/7','Siap membantu Anda'],
            ] as $s)
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="bi {{ $s[0] }} fs-4 text-dark"></i>
                    <div class="text-start">
                        <div class="fw-bold text-dark small">{{ $s[1] }}</div>
                        <div class="text-dark" style="font-size:.75rem;">{{ $s[2] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Kategori --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block mb-3">Kategori Produk</h2>
            <p class="text-muted mt-3">Temukan peci dan songkok pilihan sesuai kebutuhan Anda</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                    <div class="category-card text-center p-3">
                        <div style="width:70px;height:70px;background:linear-gradient(135deg,#1a1a1a,#3d3d3d);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                            <i class="bi bi-patch-check" style="font-size:2rem;color:#C9A84C;"></i>
                        </div>
                        <h6 class="mb-1 fw-bold" style="font-size:.88rem;color:#1a1a1a;">{{ $category->name }}</h6>
                        <small class="text-muted">{{ $category->products_count }} Produk</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Produk Unggulan --}}
@if($featuredProducts->count())
<section class="py-5" style="background:#f0f2f5;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="section-title mb-2">Produk Unggulan</h2>
                <p class="text-muted mt-3">Pilihan terbaik dari koleksi premium kami</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-gold d-none d-md-inline-flex">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('partials.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Banner Promo --}}
<section class="section-bg py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-7">
                <p style="color:#C9A84C;font-size:1rem;"><i class="bi bi-star-fill me-2"></i>Penawaran Spesial</p>
                <h2 style="color:#fff;font-size:2.2rem;">Songkok Custom<br><span style="color:#C9A84C;">Sesuai Keinginan Anda</span></h2>
                <p class="text-white-50 mt-3 mb-4">Buat songkok dengan desain, ukuran, dan bordir sesuai pesanan. Cocok untuk souvenir pernikahan, organisasi, dan instansi.</p>
                <a href="{{ route('products.index', ['category' => 'songkok-custom']) }}" class="btn btn-gold btn-lg px-5">
                    Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-md-5 text-center">
                <i class="bi bi-patch-check-fill" style="font-size:10rem;color:rgba(201,168,76,.2);"></i>
            </div>
        </div>
    </div>
</section>

{{-- Produk Terbaru --}}
@if($newProducts->count())
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="section-title mb-2">Produk Terbaru</h2>
                <p class="text-muted mt-3">Koleksi terbaru yang baru saja kami hadirkan</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="btn btn-outline-gold d-none d-md-inline-flex">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($newProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('partials.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Keunggulan --}}
<section class="py-5" style="background:#f0f2f5;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Mengapa AA Songkok?</h2>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['bi-award','Kualitas Terjamin','Setiap produk dibuat dari bahan pilihan dengan standar kualitas tinggi'],
                ['bi-people','Pengrajin Berpengalaman','Tim pengrajin berpengalaman lebih dari 20 tahun di bidang pembuatan peci'],
                ['bi-palette','Desain Elegan','Desain klasik yang dipadukan sentuhan modern untuk tampilan berkelas'],
                ['bi-truck','Pengiriman Cepat','Kami memastikan pesanan Anda tiba tepat waktu ke seluruh Indonesia'],
                ['bi-gear','Custom Order','Layanan pemesanan khusus sesuai keinginan dengan desain dan ukuran custom'],
                ['bi-chat-heart','Layanan Ramah','Tim customer service kami siap membantu 7 hari seminggu'],
            ] as $item)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="why-icon"><i class="bi {{ $item[0] }}"></i></div>
                <h6 class="fw-bold mb-2">{{ $item[1] }}</h6>
                <p class="text-muted" style="font-size:.83rem;">{{ $item[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimoni --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Apa Kata Pelanggan</h2>
        </div>
        <div class="row g-4">
            @php
            $testimonials = [
                ['nama'=>'Ahmad Fauzi','kota'=>'Jakarta','teks'=>'Peci hitam polos-nya sangat nyaman dipakai. Bahan beludru-nya lembut dan jahitannya sangat rapi. Sudah pesan 3x dan selalu puas!','bintang'=>5],
                ['nama'=>'Budi Santoso','kota'=>'Surabaya','teks'=>'Songkok bordir emas-nya benar-benar keren! Cocok banget dipakai di acara pernikahan. Pengirimannya juga cepat.','bintang'=>5],
                ['nama'=>'Rizky Pratama','kota'=>'Bandung','teks'=>'Pelayanannya ramah dan produknya berkualitas. Peci NU-nya persis seperti yang saya cari. Harga juga sangat terjangkau.','bintang'=>5],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="col-md-4">
                <div class="testimonial-card h-100">
                    <div class="stars mb-3">
                        @for($s=0; $s < $t['bintang']; $s++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-4" style="font-style:italic;">"{{ $t['teks'] }}"</p>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:45px;height:45px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-dark"></i>
                        </div>
                        <div>
                            <div class="fw-bold">{{ $t['nama'] }}</div>
                            <small class="text-muted">{{ $t['kota'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
