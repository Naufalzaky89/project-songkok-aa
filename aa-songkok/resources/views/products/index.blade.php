@extends('layouts.app')
@section('title', 'Katalog Produk - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Katalog Produk</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- Filter Sidebar -->
        <div class="col-lg-3">
            <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                <div class="filter-card card mb-4">
                    <div class="card-header py-3">
                        <h6 class="mb-0 fw-600"><i class="bi bi-funnel me-2"></i>Filter Produk</h6>
                    </div>
                    <div class="card-body">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-600 small">Cari Produk</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama produk..." value="{{ request('search') }}">
                        </div>
                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="form-label fw-600 small">Kategori</label>
                            @foreach($categories as $cat)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="category" id="cat{{ $cat->id }}" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label small" for="cat{{ $cat->id }}">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                            @if(request('category'))
                            <a href="{{ route('products.index') }}" class="btn btn-link btn-sm p-0 text-danger mt-1"><i class="bi bi-x-circle me-1"></i>Hapus Filter</a>
                            @endif
                        </div>
                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="form-label fw-600 small">Range Harga</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>
                        <!-- Urutkan -->
                        <div class="mb-4">
                            <label class="form-label fw-600 small">Urutkan</label>
                            <select name="sort" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Terbaru</option>
                                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Harga: Tinggi ke Rendah</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Produk -->
        <div class="col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="mb-1">Katalog Produk</h5>
                    <small class="text-muted">Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</small>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search" style="font-size:4rem;color:#ddd;"></i>
                    <h5 class="mt-3 text-muted">Produk tidak ditemukan</h5>
                    <p class="text-muted">Coba ubah kata kunci atau filter pencarian</p>
                    <a href="{{ route('products.index') }}" class="btn btn-gold mt-2">Lihat Semua Produk</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-6 col-md-4">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
