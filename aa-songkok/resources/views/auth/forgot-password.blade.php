<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - AA Songkok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --gold: #C9A84C; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg,#1a1a1a,#2d2d2d); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .card { border-radius:16px; box-shadow:0 20px 50px rgba(0,0,0,.4); max-width:440px; width:100%; }
        .form-control:focus { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.15); }
        .btn-gold { background:var(--gold); color:#1a1a1a; font-weight:600; border:none; }
    </style>
</head>
<body>
<div class="container p-3">
    <div class="card mx-auto">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <div style="width:70px;height:70px;background:linear-gradient(135deg,#C9A84C,#E8C96A);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:auto;font-size:1.8rem;color:#1a1a1a;"><i class="bi bi-shield-lock"></i></div>
                <h5 class="mt-3">Lupa Password?</h5>
                <p class="text-muted small">Masukkan email Anda untuk reset password</p>
            </div>
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-600">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-gold w-100 py-2 mb-3">
                    <i class="bi bi-send me-2"></i>Kirim Link Reset
                </button>
            </form>
            <div class="text-center">
                <a href="{{ route('login') }}" style="color:var(--gold);" class="small"><i class="bi bi-arrow-left me-1"></i>Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
