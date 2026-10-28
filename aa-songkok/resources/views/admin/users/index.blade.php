@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                    <option value="user" {{ request('role')=='user'?'selected':'' }}>User</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-gold"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Total Pesanan</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-3">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:35px;height:35px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:flex;align-items:center;justify-content:center;color:#1a1a1a;font-weight:700;font-size:.8rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-600">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->orders_count }} pesanan</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $user->role=='admin'?'btn-outline-warning':'btn-outline-success' }}" title="{{ $user->role=='admin'?'Jadikan User':'Jadikan Admin' }}">
                                        <i class="bi {{ $user->role=='admin'?'bi-arrow-down-circle':'bi-arrow-up-circle' }}"></i>
                                    </button>
                                </form>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada pengguna</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
