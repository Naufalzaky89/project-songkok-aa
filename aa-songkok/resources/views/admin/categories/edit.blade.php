@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" style="color:var(--gold)">Kategori</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card form-card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Kategori: {{ $category->name }}</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Gambar</label>
                        @if($category->image && file_exists(public_path('storage/'.$category->image)))
                            <div class="mb-2"><img src="{{ asset('storage/'.$category->image) }}" height="80" class="rounded"></div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="is_active">Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4"><i class="bi bi-save me-2"></i>Perbarui</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
