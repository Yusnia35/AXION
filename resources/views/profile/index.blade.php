@extends('layouts.adminlte')

@section('title', 'AXION - Profil Pengguna')
@section('topbar_page', 'Profil Pengguna')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">

  <!-- Feedback Alerts -->
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;">
    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
    <div class="fw-medium">{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan:</div>
    <ul class="mb-0 ps-3 fs-7">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Header Section -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Profil Saya
      </h1>
      
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-2 fs-7 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5 bg-white">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
      </a>
    </div>
  </div>

  <div class="row g-4">
    <!-- Kolom Kiri: Kartu Identitas & Foto -->
    <div class="col-12 col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100" style="background: #ffffff; border: 1px solid #ffedd5 !important;">
        <div class="position-relative d-inline-block mx-auto mb-3">
          <!-- Preview Avatar Foto -->
          <div id="pageAvatarContainer" class="rounded-circle shadow-sm overflow-hidden d-flex align-items-center justify-content-center mx-auto" style="width: 128px; height: 128px; border: 4px solid #fed7aa; background: {{ ($currentUser->role ?? '') === 'admin' ? '#9e4431' : 'linear-gradient(135deg, #f97316, #ea580c)' }};">
            @if ($currentUser->foto_url)
              <img id="pageAvatarImg" src="{{ $currentUser->foto_url }}" alt="{{ $currentUser->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <span id="pageAvatarInitials" class="text-white fw-bold" style="font-size: 2.8rem; letter-spacing: 1px;">
                {{ $currentUser->initials }}
              </span>
              <img id="pageAvatarImg" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
            @endif
          </div>
        </div>

        <h4 class="fw-bold text-dark mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
          {{ $currentUser->nama }}
        </h4>
        <p class="text-secondary fs-7 mb-2">{{ $currentUser->email }}</p>

        <div class="d-flex justify-content-center gap-2 mb-3">
          <span class="badge rounded-pill px-3 py-1.5 fw-semibold {{ ($currentUser->role ?? '') === 'admin' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}" style="font-size: 0.82rem;">
            <i class="bi {{ ($currentUser->role ?? '') === 'admin' ? 'bi-shield-check' : 'bi-person-badge' }} me-1"></i>
            {{ ucwords(str_replace('_', ' ', $currentUser->role ?? 'Operator')) }}
          </span>
        </div>

        <hr class="my-3" style="border-color: #ffedd5;">

        <div class="text-start fs-8 text-secondary">
          <div class="d-flex justify-content-between py-1">
            <span>Peternakan:</span>
            <strong class="text-dark">{{ $currentUser->workspace->nama ?? 'Arunika Farm' }}</strong>
          </div>
          <div class="d-flex justify-content-between py-1">
            <span>Terdaftar Sejak:</span>
            <strong class="text-dark">{{ $currentUser->created_at ? $currentUser->created_at->format('d M Y') : '-' }}</strong>
          </div>
          <div class="d-flex justify-content-between py-1">
            <span>Status Akun:</span>
            <span class="badge bg-success-subtle text-success">Aktif</span>
          </div>
        </div>

        @if ($currentUser->foto)
          <div class="mt-4 pt-2">
            <form action="{{ route('profile.foto.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto profil ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fs-8 w-100 d-inline-flex align-items-center justify-content-center gap-1.5">
                <i class="bi bi-trash3"></i> Hapus Foto Profil
              </button>
            </form>
          </div>
        @endif
      </div>
    </div>

    <!-- Kolom Kanan: Form Edit Profil & Ganti Foto -->
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="background: #ffffff; border: 1px solid #ffedd5 !important;">
        <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
          <i class="bi bi-sliders text-warning"></i> Pengaturan Informasi &amp; Foto Profil
        </h5>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Upload Foto Profil -->
          <div class="mb-4 p-3 rounded-4" style="background: #fffaf5; border: 1.5px dashed #fed7aa;">
            <label class="form-label fs-7 fw-bold text-dark d-block mb-1">
              <i class="bi bi-camera-fill me-1 text-warning"></i> Unggah / Ganti Foto Profil
            </label>
            <p class="text-secondary fs-8 mb-2">
              Pilih foto format JPG, PNG, atau WEBP. Ukuran maksimal 2 MB. Foto otomatis ditampilkan di lingkaran avatar atas.
            </p>
            <div class="d-flex align-items-center gap-3">
              <input type="file" name="foto" id="pageFotoInput" class="form-control rounded-3 fs-7" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewProfilePhoto(this, 'pageAvatarImg', 'pageAvatarInitials')">
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-bold text-dark mb-1">Nama Lengkap Peternak <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #fed7aa;">
                  <i class="bi bi-person text-secondary"></i>
                </span>
                <input type="text" name="nama" class="form-control rounded-end-3 border-start-0 py-2 fs-7" value="{{ old('nama', $currentUser->nama) }}" required style="border-color: #fed7aa;">
              </div>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-bold text-dark mb-1">Alamat Email <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #fed7aa;">
                  <i class="bi bi-envelope text-secondary"></i>
                </span>
                <input type="email" name="email" class="form-control rounded-end-3 border-start-0 py-2 fs-7" value="{{ old('email', $currentUser->email) }}" required style="border-color: #fed7aa;">
              </div>
            </div>
          </div>

          <hr class="my-4" style="border-color: #ffedd5;">

          <h6 class="fw-bold text-dark mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            <i class="bi bi-shield-lock text-secondary me-1"></i> Ubah Password (Opsional)
          </h6>
          <p class="text-secondary fs-8 mb-3">
            Biarkan kedua kolom password di bawah ini kosong jika Anda tidak ingin mengganti password Anda saat ini.
          </p>

          <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-semibold text-secondary mb-1">Password Baru</label>
              <input type="password" name="password" class="form-control rounded-3 py-2 fs-7" placeholder="Minimal 6 karakter" autocomplete="new-password" style="border-color: #fed7aa;">
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-semibold text-secondary mb-1">Konfirmasi Password Baru</label>
              <input type="password" name="password_confirmation" class="form-control rounded-3 py-2 fs-7" placeholder="Ketik ulang password baru" autocomplete="new-password" style="border-color: #fed7aa;">
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 pt-2">
            <button type="submit" class="btn rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border: none;">
              <i class="bi bi-check2-circle fs-6"></i>
              <span>Simpan Perubahan</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
function previewProfilePhoto(input, imgId, initialsId) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById(imgId);
      const initials = document.getElementById(initialsId);
      if (img) {
        img.src = e.target.result;
        img.style.display = 'block';
      }
      if (initials) {
        initials.style.display = 'none';
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
@endsection

