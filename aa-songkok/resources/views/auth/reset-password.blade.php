<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - AA Songkok</title>
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
            <h5 class="mb-4">Reset Password</h5>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="mb-3">
                    <label class="form-label fw-600">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-600">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-gold w-100 py-2">
                    <i class="bi bi-check-circle me-2"></i>Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
