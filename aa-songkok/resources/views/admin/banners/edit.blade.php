@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}" style="color:var(--gold)">Banner</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card form-card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Banner</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-600">Judul Banner</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $banner->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Gambar</label>
                        @if($banner->image && file_exists(public_path('storage/'.$banner->image)))
                            <div class="mb-2"><img src="{{ asset('storage/'.$banner->image) }}" style="height:120px;border-radius:8px;object-fit:cover;" id="prevImg"></div>
                        @else
                            <img id="prevImg" style="height:120px;border-radius:8px;object-fit:cover;display:none;">
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                        <small class="text-muted">Kosongkan jika tidak mengubah gambar</small>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Link</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link', $banner->link) }}" placeholder="https://...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Urutan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order) }}" min="0">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="is_active">Banner Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4"><i class="bi bi-save me-2"></i>Perbarui</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('prevImg');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
