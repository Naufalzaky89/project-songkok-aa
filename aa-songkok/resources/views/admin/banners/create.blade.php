@extends('layouts.admin')
@section('title', 'Tambah Banner')
@section('page-title', 'Tambah Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}" style="color:var(--gold)">Banner</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card form-card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Banner Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600">Judul Banner <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required onchange="previewImg(this)">
                        <small class="text-muted">JPG/PNG, maks 3MB. Resolusi direkomendasikan: 1920x600px</small>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="prevImg" src="" style="height:150px;border-radius:8px;object-fit:cover;">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Link (Opsional)</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Urutan Tampil</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label fw-600" for="is_active">Banner Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4"><i class="bi bi-save me-2"></i>Simpan</button>
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
            document.getElementById('prevImg').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
