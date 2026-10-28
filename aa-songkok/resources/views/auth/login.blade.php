<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AA Songkok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --gold: #C9A84C; --dark: #1a1a1a; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,.4); max-width: 900px; width: 100%; }
        .auth-left { background: linear-gradient(135deg, #1a1a1a, #2d2d2d); padding: 50px 40px; border-right: 2px solid var(--gold); }
        .auth-brand { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--gold); }
        .auth-brand span { color: #fff; }
        .auth-right { padding: 50px 40px; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.15); }
        .btn-gold { background: var(--gold); color: var(--dark); border: none; font-weight: 600; padding: .75rem 2rem; border-radius: 8px; transition: all .3s; }
        .btn-gold:hover { background: #e0ba5a; color: var(--dark); transform: translateY(-1px); }
        .divider { display: flex; align-items: center; gap: 10px; color: #aaa; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e0e0e0; }
    </style>
</head>
<body>
<div class="container p-3">
    <div class="auth-card mx-auto">
        <div class="row g-0">
            <!-- Left -->
            <div class="col-md-5 auth-left d-none d-md-flex flex-column justify-content-between">
                <div>
                    <div class="auth-brand mb-2">AA <span>Songkok</span></div>
                    <p style="color:#aaa;font-size:.9rem;">Peci & Songkok Premium Terpercaya</p>
                </div>
                <div>
                    <div style="font-size:6rem;color:rgba(201,168,76,.2);"><i class="bi bi-patch-check-fill"></i></div>
                </div>
                <div>
                    @foreach(['Koleksi Peci Premium','Pengrajin Berpengalaman','Pengiriman ke Seluruh Indonesia'] as $f)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill" style="color:var(--gold);"></i>
                        <span style="color:#ccc;font-size:.85rem;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Right -->
            <div class="col-md-7 auth-right">
                <a href="{{ route('home') }}" class="d-flex d-md-none mb-4 text-decoration-none" style="color:var(--gold);font-family:'Playfair Display',serif;font-size:1.5rem;">
                    AA <span class="text-dark ms-1">Songkok</span>
                </a>
                <h4 class="mb-1">Selamat Datang Kembali!</h4>
                <p class="text-muted mb-4">Masuk ke akun AA Songkok Anda</p>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-600">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope" style="color:var(--gold);"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label fw-600">Password</label>
                            <a href="{{ route('password.request') }}" style="color:var(--gold);font-size:.83rem;">Lupa Password?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock" style="color:var(--gold);"></i></span>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                            <button type="button" class="input-group-text" onclick="togglePass()"><i class="bi bi-eye" id="eyeIcon" style="color:var(--gold);"></i></button>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>
                <div class="divider">atau</div>
                <div class="text-center">
                    <span class="text-muted small">Belum punya akun? </span>
                    <a href="{{ route('register') }}" style="color:var(--gold);font-weight:600;">Daftar Sekarang</a>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <p class="text-muted small mb-2">Akun Demo:</p>
                    <small class="text-muted d-block">Admin: admin@aasongkok.com / password</small>
                    <small class="text-muted d-block">User: user@aasongkok.com / password</small>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass() {
    const p = document.getElementById('password');
    const i = document.getElementById('eyeIcon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
