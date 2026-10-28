@extends('layouts.admin')
@section('title', 'Banner')
@section('page-title', 'Manajemen Banner')
@section('breadcrumb')
    <li class="breadcrumb-item active">Banner</li>
@endsection

@section('content')
<div class="d-flex justify-content-between mb-4">
    <div></div>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-2"></i>Tambah Banner
    </a>
</div>

<div class="row g-4">
    @forelse($banners as $banner)
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div style="height:180px;background:linear-gradient(135deg,#2d2d2d,#1a1a1a);position:relative;">
                @if($banner->image && file_exists(public_path('storage/'.$banner->image)))
                    <img src="{{ asset('storage/'.$banner->image) }}" class="w-100 h-100" style="object-fit:cover;opacity:.6;">
                @endif
                <div style="position:absolute;bottom:10px;left:10px;">
                    <h6 style="color:#fff;margin:0;">{{ $banner->title }}</h6>
                </div>
                <div style="position:absolute;top:10px;right:10px;">
                    <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">{{ Str::limit($banner->description, 80) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Urutan: {{ $banner->order }}</small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-images" style="font-size:4rem;color:#ddd;"></i>
        <h5 class="mt-3 text-muted">Belum ada banner</h5>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-gold mt-2">Tambah Banner</a>
    </div>
    @endforelse
</div>
@endsection
