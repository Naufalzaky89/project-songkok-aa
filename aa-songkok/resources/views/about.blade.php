@extends('layouts.app')
@section('title', 'Tentang Kami - AA Songkok')
@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Tentang Kami</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Hero About -->
<section style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);padding:80px 0;">
    <div class="container text-center">
        <p style="color:#C9A84C;"><i class="bi bi-star-fill me-2"></i>Tentang Kami</p>
        <h1 style="color:#fff;font-size:3rem;">AA <span style="color:#C9A84C;">Songkok</span></h1>
        <p class="text-white-50 mt-3" style="max-width:600px;margin:auto;">Toko peci dan songkok premium terpercaya dengan pengalaman lebih dari 20 tahun melayani kebutuhan masyarakat Indonesia.</p>
    </div>
</section>

<!-- Tentang -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <div style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);border-radius:16px;height:380px;display:flex;align-items:center;justify-content:center;border:2px solid #C9A84C;">
                    <i class="bi bi-shop" style="font-size:8rem;color:#C9A84C;opacity:.6;"></i>
                </div>
            </div>
            <div class="col-md-6">
                <p style="color:#C9A84C;font-weight:600;"><i class="bi bi-star-fill me-2"></i>Sejarah Kami</p>
                <h2 class="mb-4">Berdiri Sejak 2003</h2>
                <p class="text-muted mb-3">AA Songkok adalah toko peci dan songkok premium yang telah berdiri sejak tahun 2003. Berawal dari usaha kecil di Jakarta, kami kini telah melayani ribuan pelanggan di seluruh Indonesia.</p>
                <p class="text-muted mb-4">Dengan pengalaman lebih dari 20 tahun, kami berkomitmen menghadirkan produk peci dan songkok berkualitas tinggi dengan harga yang terjangkau. Setiap produk dibuat dengan teliti oleh para pengrajin berpengalaman menggunakan bahan-bahan pilihan.</p>
                <div class="row g-3">
                    @foreach([['2000+','Pelanggan Puas'],['50+','Varian Produk'],['20+','Tahun Pengalaman'],['99%','Kepuasan Pelanggan']] as $stat)
                    <div class="col-6">
                        <div class="p-3 rounded-3 text-center" style="background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.3);">
                            <div style="font-size:1.8rem;font-weight:700;color:#C9A84C;">{{ $stat[0] }}</div>
                            <small class="text-muted">{{ $stat[1] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi -->
<section class="py-5" style="background:#f0f2f5;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Visi & Misi</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 rounded-3 h-100" style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);border:1px solid #C9A84C;">
                    <div class="mb-3"><i class="bi bi-eye" style="font-size:2.5rem;color:#C9A84C;"></i></div>
                    <h4 style="color:#C9A84C;">Visi</h4>
                    <p class="text-white-50 mb-0">Menjadi toko peci dan songkok pilihan utama masyarakat Indonesia dengan menghadirkan produk berkualitas premium yang memadukan tradisi dan modernitas.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded-3 h-100" style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);border:1px solid #C9A84C;">
                    <div class="mb-3"><i class="bi bi-bullseye" style="font-size:2.5rem;color:#C9A84C;"></i></div>
                    <h4 style="color:#C9A84C;">Misi</h4>
                    <ul class="text-white-50 mb-0 ps-3">
                        <li class="mb-2">Menghadirkan produk peci dan songkok berkualitas tinggi</li>
                        <li class="mb-2">Menjaga tradisi pengrajin lokal Indonesia</li>
                        <li class="mb-2">Memberikan pelayanan terbaik kepada pelanggan</li>
                        <li>Terus berinovasi dalam desain dan kualitas produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tim -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Tim Kami</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['Ahmad Aziz','Founder & CEO','Pendiri AA Songkok yang berpengalaman lebih dari 25 tahun di industri peci dan songkok'],
                ['Aminah Sari','Head of Design','Kepala desainer yang menciptakan koleksi-koleksi unggulan AA Songkok'],
                ['Abdullah Malik','Head of Production','Mengawasi proses produksi untuk memastikan kualitas setiap produk'],
            ] as $member)
            <div class="col-md-4">
                <div class="text-center p-4 rounded-3" style="border:1px solid #e0e0e0;background:#fff;">
                    <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);margin:0 auto 15px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#1a1a1a;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h5 class="mb-1">{{ $member[0] }}</h5>
                    <p style="color:#C9A84C;font-size:.85rem;margin-bottom:8px;">{{ $member[1] }}</p>
                    <p class="text-muted" style="font-size:.83rem;">{{ $member[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Kontak -->
<section class="py-5" style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="color:#C9A84C;">Hubungi Kami</h2>
        </div>
        <div class="row g-4 text-center">
            @foreach([
                ['bi-geo-alt-fill','Alamat','Jl. Songkok No. 1, Jakarta Pusat 10110'],
                ['bi-telephone-fill','Telepon','+62 812-3456-7890'],
                ['bi-envelope-fill','Email','info@aasongkok.com'],
                ['bi-clock-fill','Jam Operasional','Senin - Sabtu: 08.00 - 20.00'],
            ] as $c)
            <div class="col-md-3">
                <div style="font-size:2rem;color:#C9A84C;margin-bottom:12px;"><i class="bi {{ $c[0] }}"></i></div>
                <h6 style="color:#fff;">{{ $c[1] }}</h6>
                <p style="color:#aaa;font-size:.85rem;">{{ $c[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
