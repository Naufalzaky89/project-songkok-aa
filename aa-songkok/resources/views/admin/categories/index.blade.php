@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="ps-3">{{ $loop->iteration }}</td>
                        <td class="fw-600">{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td>
                            <span class="badge" style="background:rgba(201,168,76,.15);color:#C9A84C;">{{ $cat->products_count }} produk</span>
                        </td>
                        <td>
                            <span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white">{{ $categories->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
