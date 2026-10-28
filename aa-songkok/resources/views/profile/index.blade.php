@extends('layouts.app')
@section('title', 'Profil Saya - AA Songkok')

@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Profil Saya</li>
        </ol>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <div class="mb-3">
                    @if($user->avatar && file_exists(public_path('storage/'.$user->avatar)))
                        <img src="{{ asset('storage/'.$user->avatar) }}" class="rounded-circle" width="90" height="90" style="object-fit:cover;border:3px solid #C9A84C;">
                    @else
                        <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:flex;align-items:center;justify-content:center;margin:auto;border:3px solid #1a1a1a;font-size:2.5rem;color:#1a1a1a;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                </div>
                <h6 class="mb-0">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->email }}</small>
                <span class="badge mt-2 d-inline-block" style="background:{{ $user->isAdmin()?'#C9A84C':'#1a1a1a' }};color:{{ $user->isAdmin()?'#1a1a1a':'#C9A84C' }};">
                    {{ $user->isAdmin() ? 'Admin' : 'Member' }}
                </span>
                <hr>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-bag-check me-1"></i>Pesanan Saya
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-9">
            <!-- Edit Profil -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-person-gear me-2"></i>Edit Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-600">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600">Foto Profil</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                                <small class="text-muted">Maks. 2MB (JPG/PNG)</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600">Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-gold px-5">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header" style="background:#1a1a1a;border-radius:12px 12px 0 0;">
                    <h6 class="mb-0" style="color:#C9A84C;"><i class="bi bi-shield-lock me-2"></i>Ganti Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-600">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-600">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-600">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-gold px-5">
                                    <i class="bi bi-lock me-2"></i>Ganti Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
