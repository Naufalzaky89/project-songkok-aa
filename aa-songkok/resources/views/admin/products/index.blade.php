@extends('layouts.admin')
@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Unggulan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-3">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:45px;height:45px;border-radius:8px;background:linear-gradient(135deg,#2d2d2d,#1a1a1a);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @if($product->image && file_exists(public_path('storage/'.$product->image)))
                                        <img src="{{ asset('storage/'.$product->image) }}" style="width:45px;height:45px;object-fit:cover;border-radius:8px;">
                                    @else
                                        <i class="bi bi-patch-check" style="color:#C9A84C;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-600" style="font-size:.87rem;">{{ Str::limit($product->name, 25) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-secondary">{{ $product->category->name ?? '-' }}</span></td>
                        <td class="fw-600" style="color:var(--gold);">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            @if($product->is_featured)
                                <i class="bi bi-star-fill" style="color:#C9A84C;"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada produk</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white">{{ $products->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
