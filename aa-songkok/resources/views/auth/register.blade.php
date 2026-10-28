<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AA Songkok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --gold: #C9A84C; --dark: #1a1a1a; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0; }
        .auth-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,.4); max-width: 900px; width: 100%; }
        .auth-left { background: linear-gradient(135deg, #1a1a1a, #2d2d2d); padding: 50px 40px; border-right: 2px solid var(--gold); }
        .auth-brand { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--gold); }
        .auth-right { padding: 50px 40px; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.15); }
        .btn-gold { background: var(--gold); color: var(--dark); border: none; font-weight: 600; padding: .75rem 2rem; border-radius: 8px; }
        .btn-gold:hover { background: #e0ba5a; color: var(--dark); }
    </style>
</head>
<body>
<div class="container p-3">
    <div class="auth-card mx-auto">
        <div class="row g-0">
            <!-- Left -->
            <div class="col-md-4 auth-left d-none d-md-flex flex-column justify-content-between">
                <div>
                    <div class="auth-brand mb-2">AA <span style="color:#fff;">Songkok</span></div>
                    <p style="color:#aaa;font-size:.9rem;">Buat akun baru dan mulai belanja!</p>
                </div>
                <div style="font-size:5rem;color:rgba(201,168,76,.2);"><i class="bi bi-person-plus-fill"></i></div>
                <div>
                    @foreach(['Akses ke semua koleksi','Lacak pesanan Anda','Profil & riwayat belanja'] as $f)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill" style="color:var(--gold);"></i>
                        <span style="color:#ccc;font-size:.83rem;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Right -->
            <div class="col-md-8 auth-right">
                <h4 class="mb-1">Buat Akun Baru</h4>
                <p class="text-muted mb-4">Bergabunglah dengan ribuan pelanggan AA Songkok</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person" style="color:var(--gold);"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap Anda" value="{{ old('name') }}" required autofocus>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope" style="color:var(--gold);"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock" style="color:var(--gold);"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 karakter" required>
                                <button type="button" class="input-group-text" onclick="togglePass('password','eye1')"><i id="eye1" class="bi bi-eye" style="color:var(--gold);"></i></button>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill" style="color:var(--gold);"></i></span>
                                <input type="password" name="password_confirmation" id="password2" class="form-control" placeholder="Ulangi password" required>
                                <button type="button" class="input-group-text" onclick="togglePass('password2','eye2')"><i id="eye2" class="bi bi-eye" style="color:var(--gold);"></i></button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label text-muted small" for="terms">
                                    Saya setuju dengan <a href="#" style="color:var(--gold);">Syarat & Ketentuan</a> dan <a href="#" style="color:var(--gold);">Kebijakan Privasi</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-gold w-100 py-2">
                                <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                            </button>
                        </div>
                        <div class="col-12 text-center">
                            <span class="text-muted small">Sudah punya akun? </span>
                            <a href="{{ route('login') }}" style="color:var(--gold);font-weight:600;">Masuk di sini</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass(id, iconId) {
    const p = document.getElementById(id);
    const i = document.getElementById(iconId);
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
