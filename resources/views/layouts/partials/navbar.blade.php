<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body border-bottom">
  <!--begin::Container-->
  <div class="container-fluid px-3 px-lg-4">
    <!--begin::Start Navbar Links-->
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-link text-body p-0 d-flex align-items-center" data-lte-toggle="sidebar" type="button" aria-label="Toggle sidebar">
        <i class="bi bi-list fs-4"></i>
      </button>
    </div>
    <!--end::Start Navbar Links-->

    <!--begin::End Navbar Links-->
    <div class="ms-auto d-flex align-items-center gap-2 gap-md-3">
      <!-- Search Icon Button -->
      <button type="button" class="btn btn-link text-secondary p-1.5 nav-action-btn" aria-label="Pencarian" title="Cari data..." data-bs-toggle="modal" data-bs-target="#searchModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </button>

      <!-- Notification Bell with orange unread dot -->
      <div class="dropdown">
        <button class="btn btn-link text-secondary p-1.5 position-relative nav-action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          <span class="position-absolute rounded-circle" style="top: 4px; right: 4px; width: 7px; height: 7px; background-color: #ea580c;"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" style="width: 290px;">
          <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-7">Notifikasi Terkini</span>
            <span class="badge bg-warning-subtle text-warning fs-8">2 Baru</span>
          </li>
          <li>
            <a class="dropdown-item py-2 px-3 d-flex gap-2 align-items-start" href="#">
              <span class="d-inline-block rounded-circle bg-warning mt-1.5" style="width: 8px; height: 8px;"></span>
              <div>
                <div class="fs-7 fw-semibold text-body">Kandang A Perlu Pantau</div>
                <small class="text-secondary d-block">Suhu sedikit meningkat (32.5°C)</small>
                <small class="text-body-tertiary fs-8">10 menit lalu</small>
              </div>
            </a>
          </li>
          <li>
            <a class="dropdown-item py-2 px-3 d-flex gap-2 align-items-start" href="#">
              <span class="d-inline-block rounded-circle bg-success mt-1.5" style="width: 8px; height: 8px;"></span>
              <div>
                <div class="fs-7 fw-semibold text-body">Kandang B Optimal</div>
                <small class="text-secondary d-block">Mikroklimat stabil, skor kesehatan 92</small>
                <small class="text-body-tertiary fs-8">1 jam lalu</small>
              </div>
            </a>
          </li>
        </ul>
      </div>

      <!-- Color Mode Toggle Dropdown -->
      <div class="dropdown">
        <button class="btn btn-link text-secondary p-1.5 nav-action-btn" type="button" id="bd-theme" data-bs-toggle="dropdown" aria-expanded="false" title="Ganti Tema">
          <i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
          <i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
          <i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="bd-theme" style="--bs-dropdown-min-width: 8.5rem">
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
              <i class="bi bi-sun-fill me-2 text-warning"></i> Terang
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
              <i class="bi bi-moon-fill me-2 text-primary"></i> Gelap
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">
              <i class="bi bi-circle-half me-2 text-secondary"></i> Otomatis
            </button>
          </li>
        </ul>
      </div>

      <!-- User Avatar / Foto Profil Circle -->
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Profil {{ $currentUser->nama ?? 'Pengguna' }}">
          @if ($currentUser?->foto_url)
            <img src="{{ $currentUser->foto_url }}" alt="{{ $currentUser->nama }}" class="user-avatar-circle shadow-sm"
              style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #fdba74; transition: transform 0.15s ease;">
          @else
            <div class="user-avatar-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
              style="width: 36px; height: 36px; border-radius: 50%; background: {{ ($currentUser->role ?? '') === 'admin' ? '#9e4431' : 'linear-gradient(135deg, #f97316, #ea580c)' }}; font-size: 0.85rem; letter-spacing: 0.5px; transition: transform 0.15s ease;">
              {{ $currentUser?->initials ?? 'YA' }}
            </div>
          @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" style="min-width: 250px;">
          <li class="px-3 py-2 border-bottom">
            <div class="d-flex align-items-center gap-2 mb-1">
              @if ($currentUser?->foto_url)
                <img src="{{ $currentUser->foto_url }}" alt="{{ $currentUser->nama }}" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #fdba74;">
              @else
                <div class="d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                  style="width: 42px; height: 42px; border-radius: 50%; background: {{ ($currentUser->role ?? '') === 'admin' ? '#9e4431' : 'linear-gradient(135deg, #f97316, #ea580c)' }}; font-size: 0.95rem;">
                  {{ $currentUser?->initials ?? 'YA' }}
                </div>
              @endif
              <div class="overflow-hidden">
                <div class="fw-bold text-body text-truncate" style="font-size: 0.9rem;" title="{{ $currentUser->nama ?? 'Pengguna' }}">
                  {{ $currentUser->nama ?? 'Pengguna' }}
                </div>
                <small class="text-secondary d-block text-truncate" style="font-size: 0.78rem;" title="{{ $currentUser->email ?? '' }}">
                  {{ $currentUser->email ?? '' }}
                </small>
              </div>
            </div>
            <span class="badge {{ ($currentUser->role ?? '') === 'admin' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning-emphasis' }} fs-8 mt-1">
              {{ ucwords(str_replace('_', ' ', $currentUser->role ?? 'Operator')) }}
            </span>
          </li>

          <!-- Profil & Edit Foto Dropdown Items -->
          <li>
            <button type="button" class="dropdown-item py-2 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
              <i class="bi bi-person-bounding-box text-warning fs-6"></i>
              <span>Profil &amp; Edit Foto</span>
            </button>
          </li>
          <li>
            <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
              <i class="bi bi-person-circle text-secondary fs-6"></i>
              <span>Halaman Profil Lengkap</span>
            </a>
          </li>

          @if (($currentUser->role ?? '') === 'admin')
          <li class="border-top my-1"></li>
          <li>
            <a class="dropdown-item py-2" href="{{ route('users.index') }}">
              <i class="bi bi-people me-2 text-secondary"></i> Data User (Admin)
            </a>
          </li>
          @endif
          <li class="border-top my-1"></li>
          <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
              @csrf
              <button type="submit" class="dropdown-item py-2 text-danger w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
<!--end::Header-->

<!-- Modal Cepat: Edit Profil & Foto -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-bottom py-3" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);">
        <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="editProfileModalLabel" style="font-family: 'Plus Jakarta Sans', sans-serif;">
          <i class="bi bi-person-gear text-warning fs-5"></i> Edit Profil &amp; Foto Pengguna
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-body p-4">
          <!-- Avatar Preview & Upload -->
          <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
              <div id="modalAvatarPreviewBox" class="rounded-circle shadow-sm overflow-hidden d-flex align-items-center justify-content-center mx-auto"
                style="width: 96px; height: 96px; border: 3px solid #fdba74; background: {{ ($currentUser->role ?? '') === 'admin' ? '#9e4431' : 'linear-gradient(135deg, #f97316, #ea580c)' }};">
                @if ($currentUser?->foto_url)
                  <img id="modalAvatarPreviewImg" src="{{ $currentUser->foto_url }}" alt="{{ $currentUser->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <span id="modalAvatarPreviewInitials" class="text-white fw-bold" style="font-size: 2.2rem;">
                    {{ $currentUser?->initials ?? 'YA' }}
                  </span>
                  <img id="modalAvatarPreviewImg" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                @endif
              </div>

              <!-- Tombol Camera Trigger Upload -->
              <label for="navbarFotoInput" class="position-absolute bottom-0 end-0 bg-warning text-white rounded-circle p-2 shadow d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px; cursor: pointer; border: 2px solid #ffffff;" title="Pilih Foto Baru">
                <i class="bi bi-camera-fill fs-8"></i>
              </label>
            </div>

            <div class="mt-2">
              <input type="file" name="foto" id="navbarFotoInput" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewNavbarAvatar(this)">
              <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fs-8 mt-1" onclick="document.getElementById('navbarFotoInput').click()">
                <i class="bi bi-upload me-1"></i> Pilih Foto Baru
              </button>
            </div>
            <small class="text-secondary d-block mt-1 fs-9">Format: JPG, PNG, WEBP (Maksimal 2 MB)</small>
          </div>

          <div class="mb-3">
            <label class="form-label fs-7 fw-bold text-dark mb-1">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control rounded-3 py-2 fs-7" value="{{ $currentUser->nama ?? '' }}" required style="border-color: #fed7aa;">
          </div>

          <div class="mb-3">
            <label class="form-label fs-7 fw-bold text-dark mb-1">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control rounded-3 py-2 fs-7" value="{{ $currentUser->email ?? '' }}" required style="border-color: #fed7aa;">
          </div>

          <hr class="my-3" style="border-color: #ffedd5;">

          <div class="mb-3">
            <label class="form-label fs-7 fw-bold text-dark mb-1">Password Baru (Opsional)</label>
            <input type="password" name="password" class="form-control rounded-3 py-2 fs-7" placeholder="Biarkan kosong jika tidak diganti" autocomplete="new-password" style="border-color: #fed7aa;">
          </div>

          <div class="mb-2">
            <label class="form-label fs-7 fw-bold text-dark mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control rounded-3 py-2 fs-7" placeholder="Ketik ulang password baru" autocomplete="new-password" style="border-color: #fed7aa;">
          </div>
        </div>

        <div class="modal-footer border-top py-2.5 px-4 d-flex justify-content-between bg-light">
          <div>
            @if ($currentUser?->foto)
              <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fs-8" onclick="if(confirm('Hapus foto profil saat ini?')) { document.getElementById('navbarDeleteFotoForm').submit(); }">
                <i class="bi bi-trash3"></i> Hapus Foto
              </button>
            @endif
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 py-1.5 fs-7" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-sm rounded-pill px-4 py-1.5 fs-7 fw-bold text-white shadow-sm" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border: none;">
              Simpan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($currentUser?->foto)
  <form id="navbarDeleteFotoForm" action="{{ route('profile.foto.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
  </form>
@endif

<script>
function previewNavbarAvatar(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('modalAvatarPreviewImg');
      const initials = document.getElementById('modalAvatarPreviewInitials');
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

<!-- Search Modal Quick Filter -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-body p-3">
        <div class="input-group">
          <span class="input-group-text bg-transparent border-0 pe-2">
            <i class="bi bi-search text-secondary"></i>
          </span>
          <input type="text" class="form-control border-0 shadow-none" id="quickSearchInput" placeholder="Cari kandang, sensor, atau kelompok ayam..." autofocus>
          <button type="button" class="btn-close my-auto ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
    </div>
  </div>
</div>
