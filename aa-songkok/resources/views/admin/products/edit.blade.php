@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" style="color:var(--gold)">Produk</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card form-card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Produk: {{ $product->name }}</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-600">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Ukuran Tersedia</label>
                            <input type="text" name="size" class="form-control" value="{{ old('size', $product->size) }}" placeholder="56,57,58,59,60">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Gambar Produk</label>
                            @if($product->image && file_exists(public_path('storage/'.$product->image)))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" style="height:100px;border-radius:8px;object-fit:cover;" id="preview">
                                </div>
                            @else
                                <img id="preview" style="height:100px;border-radius:8px;object-fit:cover;display:none;">
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-600" for="is_active">Produk Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label fw-600" for="is_featured">Produk Unggulan</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-gold px-4"><i class="bi bi-save me-2"></i>Perbarui Produk</button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('preview');
            prev.src = e.target.result;
            prev.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
