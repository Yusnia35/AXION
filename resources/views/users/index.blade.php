@extends('layouts.adminlte')

@section('title', 'Data User - AXION Monitoring & Sistem Pakar')
@section('topbar_page', 'Data User')
@section('hide_header', 'true')

@section('content')
<!--begin::Page Header-->
<div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
  <div class="col-12 col-md-8">
    <div class="kandang-kicker text-uppercase fw-semibold mb-1">
      ADMINISTRATOR &middot; MANAJEMEN AKSES
    </div>
    <h1 class="kandang-hero-title mb-1">
      Data Pengguna Sistem
    </h1>
    <p class="kandang-hero-subtitle text-secondary mb-0">
      Kelola akun pengguna, hak akses administrator, farm manager, dan operator kandang AXION.
    </p>
  </div>
  <div class="col-12 col-md-4 text-md-end">
    <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2 rounded-pill px-3.5 py-2 fw-semibold shadow-sm"
      style="background-color: #1c3d28; border-color: #1c3d28;"
      data-bs-toggle="modal" data-bs-target="#addUserModal">
      <i class="bi bi-person-plus-fill"></i>
      <span>Tambah User</span>
    </button>
  </div>
</div>
<!--end::Page Header-->

<!-- Flash Alerts -->
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill fs-5"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <div>{{ session('error') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Row 1: KPI Stats -->
<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-body">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-medium text-secondary">Total Pengguna</span>
          <span class="text-secondary opacity-75">
            <i class="bi bi-people fs-5"></i>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-body lh-1">{{ $totalUsers }}</span>
          <span class="fs-7 ms-2 text-secondary">akun terdaftar</span>
        </div>
        <div class="fs-8 text-secondary mt-2">
          Seluruh hak akses aktif
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-body">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-medium text-secondary">Administrator</span>
          <span class="text-danger opacity-75">
            <i class="bi bi-shield-lock fs-5"></i>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-body lh-1" style="color: #9e4431;">{{ $totalAdmin }}</span>
          <span class="fs-7 ms-2 text-secondary">admin</span>
        </div>
        <div class="fs-8 text-secondary mt-2">
          Akses penuh ke semua menu
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-body">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-medium text-secondary">Operator & Peternak</span>
          <span class="text-success opacity-75">
            <i class="bi bi-person-badge fs-5"></i>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-body lh-1">{{ $totalUserBiasa }}</span>
          <span class="fs-7 ms-2 text-secondary">operator</span>
        </div>
        <div class="fs-8 text-secondary mt-2">
          Peternak / Farm Manager
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-body">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-medium text-secondary">Status Aktif</span>
          <span class="text-success opacity-75">
            <i class="bi bi-check-circle fs-5"></i>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-success lh-1">{{ $totalAktif }}</span>
          <span class="fs-7 ms-2 text-secondary">dapat login</span>
        </div>
        <div class="fs-8 text-success mt-2">
          <span class="d-inline-block rounded-circle bg-success me-1" style="width: 7px; height: 7px;"></span>
          Sistem beroperasi normal
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
  <div class="card-header bg-body border-bottom py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-person-lines-fill fs-5 text-primary"></i>
      <h5 class="fw-bold mb-0 text-body">Daftar Akun Pengguna</h5>
    </div>
    
    <!-- Filter search & role -->
    <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center gap-2">
      <div class="input-group input-group-sm" style="max-width: 260px;">
        <span class="input-group-text bg-body-tertiary border-end-0">
          <i class="bi bi-search text-secondary"></i>
        </span>
        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama / email..." value="{{ request('search') }}">
      </div>

      <select name="role" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
        <option value="">Semua Peran</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="farm_manager" {{ request('role') === 'farm_manager' ? 'selected' : '' }}>Farm Manager</option>
        <option value="operator" {{ request('role') === 'operator' ? 'selected' : '' }}>Operator</option>
        <option value="pakar" {{ request('role') === 'pakar' ? 'selected' : '' }}>Pakar</option>
      </select>

      @if(request('search') || request('role'))
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
          <i class="bi bi-x-circle"></i>
        </a>
      @endif
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light fs-8 text-uppercase text-secondary">
        <tr>
          <th class="ps-4">Pengguna</th>
          <th>Peran (Role)</th>
          <th>Kandang / Peternakan</th>
          <th>Status</th>
          <th>Terdaftar</th>
          <th class="text-end pe-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td class="ps-4">
              <div class="d-flex align-items-center gap-3">
                @if ($user->foto_url)
                  <img src="{{ $user->foto_url }}" alt="{{ $user->nama }}" class="user-avatar-circle shadow-sm"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fdba74;">
                @else
                  <div class="user-avatar-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                    style="width: 40px; height: 40px; border-radius: 50%; background-color: {{ $user->role === 'admin' ? '#9e4431' : '#ea580c' }}; font-size: 0.9rem;">
                    {{ $user->initials }}
                  </div>
                @endif
                <div>
                  <div class="fw-bold text-body">
                    {{ $user->nama }}
                    @if (auth()->id() === $user->id)
                      <span class="badge bg-secondary-subtle text-secondary fs-9 ms-1">Anda</span>
                    @endif
                  </div>
                  <div class="text-secondary fs-8">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td>
              @if ($user->role === 'admin')
                <span class="badge rounded-pill fw-semibold px-2.5 py-1"
                  style="background-color: #fbeee8; color: #9e4431; border: 1px solid #f6dcd0; font-size: 0.78rem;">
                  <i class="bi bi-shield-fill-check me-1"></i> Administrator
                </span>
              @elseif ($user->role === 'farm_manager')
                <span class="badge rounded-pill fw-semibold px-2.5 py-1"
                  style="background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; font-size: 0.78rem;">
                  <i class="bi bi-briefcase me-1"></i> Farm Manager
                </span>
              @elseif ($user->role === 'pakar')
                <span class="badge rounded-pill fw-semibold px-2.5 py-1"
                  style="background-color: #f3e8fd; color: #6b21a8; border: 1px solid #e9d5ff; font-size: 0.78rem;">
                  <i class="bi bi-mortarboard me-1"></i> Pakar Ayam
                </span>
              @else
                <span class="badge rounded-pill fw-semibold px-2.5 py-1"
                  style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; font-size: 0.78rem;">
                  <i class="bi bi-person me-1"></i> Operator Kandang
                </span>
              @endif
            </td>
            <td>
              <span class="text-body fw-medium fs-7">{{ $user->workspace->nama ?? 'Arunika Farm' }}</span>
            </td>
            <td>
              @if ($user->is_active)
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-8 rounded-pill">
                  <i class="bi bi-check-circle me-1"></i> Aktif
                </span>
              @else
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-8 rounded-pill">
                  <i class="bi bi-x-circle me-1"></i> Nonaktif
                </span>
              @endif
            </td>
            <td class="fs-8 text-secondary">
              {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
            </td>
            <td class="text-end pe-4">
              @if (auth()->id() !== $user->id)
                <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill px-3"
                    title="{{ $user->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                    <i class="bi {{ $user->is_active ? 'bi-lock' : 'bi-unlock' }} me-1"></i>
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                  </button>
                </form>
              @else
                <span class="text-muted fs-8 fst-italic">Akun aktif saat ini</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-secondary">
              <i class="bi bi-people fs-1 d-block mb-2 text-muted"></i>
              Tidak ada data pengguna yang sesuai dengan pencarian.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="modal-header border-bottom py-3 px-4">
          <h5 class="modal-title fw-bold text-body" id="addUserModalLabel">
            <i class="bi bi-person-plus text-primary me-2"></i> Tambah Pengguna Baru
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="nama" class="form-label fs-7 fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama" class="form-control rounded-3" placeholder="Contoh: Ahmad Fadli" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fs-7 fw-semibold">Email Pengguna <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control rounded-3" placeholder="Contoh: ahmad@arunika.test" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fs-7 fw-semibold">Kata Sandi <span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class="form-control rounded-3" placeholder="Minimal 6 karakter" required>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label fs-7 fw-semibold">Peran (Role) <span class="text-danger">*</span></label>
            <select name="role" id="role" class="form-select rounded-3" required>
              <option value="operator">Operator Kandang (User Biasa)</option>
              <option value="farm_manager">Farm Manager (Pengelola Farm)</option>
              <option value="pakar">Pakar Kesehatan Ayam</option>
              <option value="admin">Administrator (Akses Penuh + Menu User)</option>
            </select>
            <small class="text-muted fs-8 mt-1 d-block">
              Peran "Administrator" akan memiliki menu "Data User" di sidebar.
            </small>
          </div>
        </div>
        <div class="modal-footer border-top py-3 px-4">
          <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold" style="background-color: #1c3d28; border-color: #1c3d28;">
            Simpan Pengguna
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
