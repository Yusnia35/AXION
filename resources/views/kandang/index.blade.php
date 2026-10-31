@extends('layouts.adminlte')

@section('title', 'AXION - Daftar Kandang')
@section('topbar_page', 'Daftar Kandang')
@section('hide_header', 'true')
@section('content')
<div class="kandang-page-container pb-5">

  <!-- Success Notification -->
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
    <div class="fw-medium">{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan input:</div>
    <ul class="mb-0 ps-3 fs-7">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!--begin::Card Tambah Data Kandang (Matching User Screenshot)-->
  <div class="card border-0 shadow-sm rounded-4 bg-body mb-4 p-4 p-md-5" id="cardTambahKandang" style="{{ ($showCreateCard ?? request()->routeIs('kandang.create') ?? false) ? '' : 'display: none;' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="kandang-hero-title mb-0" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Tambah Data Kandang
      </h2>
      <button type="button" class="btn-close text-secondary" id="btnCloseCreateCard" aria-label="Close" title="Tutup formulir"></button>
    </div>

    <form action="{{ route('kandang.store') }}" method="POST" id="formInlineTambahKandang">
      @csrf
      <div class="row g-3 g-md-4 mb-3">
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-medium mb-1">Nama Kandang</label>
          <input type="text" name="nama" id="inputNamaKandang" class="form-control rounded-3 py-2.5 px-3 border" placeholder="Kandang C" value="{{ old('nama') }}" required maxlength="50" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-medium mb-1">Lokasi</label>
          <input type="text" name="lokasi" class="form-control rounded-3 py-2.5 px-3 border" placeholder="Blok Timur" value="{{ old('lokasi') }}" maxlength="100" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-medium mb-1">Kapasitas</label>
          <input type="number" name="kapasitas" class="form-control rounded-3 py-2.5 px-3 border" placeholder="500" value="{{ old('kapasitas') }}" min="1" required style="border-color: #16241b !important; background-color: #ffffff;">
        </div>
      </div>

      <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-medium mb-1">Jumlah Ayam</label>
          <input type="number" name="jumlah_ayam" class="form-control rounded-3 py-2.5 px-3 border" placeholder="450" value="{{ old('jumlah_ayam') }}" min="0" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-medium mb-1">Jenis Kandang</label>
          <select name="jenis_kandang" class="form-select rounded-3 py-2.5 px-3 border" required style="border-color: #e2e8e2 !important; background-color: #ffffff;">
            <option value="Broiler|open_house" {{ old('jenis_kandang') === 'Broiler|open_house' ? 'selected' : '' }}>Broiler &middot; Open house</option>
            <option value="Broiler|closed_house" {{ old('jenis_kandang') === 'Broiler|closed_house' ? 'selected' : '' }}>Broiler &middot; Closed house</option>
            <option value="Layer|open_house" {{ old('jenis_kandang') === 'Layer|open_house' ? 'selected' : '' }}>Layer &middot; Open house</option>
            <option value="Layer|closed_house" {{ old('jenis_kandang') === 'Layer|closed_house' ? 'selected' : '' }}>Layer &middot; Closed house</option>
            <option value="Kampung|open_house" {{ old('jenis_kandang') === 'Kampung|open_house' ? 'selected' : '' }}>Kampung &middot; Open house</option>
            <option value="Kampung|closed_house" {{ old('jenis_kandang') === 'Kampung|closed_house' ? 'selected' : '' }}>Kampung &middot; Closed house</option>
          </select>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-simpan-kandang d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2">
          <span>Simpan</span>
        </button>
        <button type="button" class="btn btn-batal-kandang rounded-3 px-4 py-2" id="btnCancelCreateCard">
          Batal
        </button>
      </div>
    </form>
  </div>
  <!--end::Card Tambah Data Kandang-->

  <!--begin::Hero / Header Section (Matching Image 1)-->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2" id="heroHeaderSection" style="{{ ($showCreateCard ?? request()->routeIs('kandang.create') ?? false) ? 'display: none;' : '' }}">
    <div class="col-12 col-md-8">
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Daftar Kandang
      </h1>
      
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <button type="button" class="btn btn-tambah-kandang shadow-sm d-inline-flex align-items-center gap-2" id="btnToggleCreateCard">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <span>Tambah Kandang</span>
      </button>
    </div>
  </div>
  <!--end::Hero Section-->

  <!--begin::Kandang Data Container (Hidden when adding new kandang)-->
  <div id="kandangDataContainer" style="{{ ($showCreateCard ?? request()->routeIs('kandang.create') ?? false) ? 'display: none;' : '' }}">

  <!--begin::KPI Stats Cards (Matching Image 1: 4 cards)-->
  <div class="row g-3 g-xl-4 mb-4">
    <!-- Card 1: Total kandang -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <span class="stat-summary-label">Total Kandang</span>
          <div class="d-flex align-items-baseline mt-2">
            <span class="stat-summary-number">{{ $totalKandang }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Total kapasitas -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <span class="stat-summary-label">Total Kapasitas</span>
          <div class="d-flex align-items-baseline mt-2">
            <span class="stat-summary-number">{{ number_format($totalKapasitas, 0, ',', '.') }}</span>
            <span class="stat-summary-unit ms-2">ekor</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Populasi aktif -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <span class="stat-summary-label">Populasi Aktif</span>
          <div class="d-flex align-items-baseline mt-2">
            <span class="stat-summary-number">{{ number_format($totalPopulasi, 0, ',', '.') }}</span>
            <span class="stat-summary-unit ms-2">ekor</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Rata-rata health score -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <span class="stat-summary-label">Rata-Rata Skor Kesehatan</span>
          <div class="d-flex align-items-baseline mt-2">
            <span class="stat-summary-number">{{ $avgHealthScore }}</span>
            <span class="stat-summary-unit ms-1">/100</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end::KPI Stats Cards-->

  <!--begin::Kandang Cards Grid (2 Columns on Desktop)-->
  @if ($kandangs->isEmpty())
  <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4 bg-body">
    <div class="my-4">
      <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3" style="background-color: #f6eee3;">
        <i class="bi bi-house-door text-warning fs-1"></i>
      </div>
      <h4 class="fw-bold text-body mb-2">Belum Ada Kandang Terdaftar</h4>
      <p class="text-secondary mb-4 mx-auto" style="max-width: 460px;">
        Mulai dengan menambahkan data kandang pertama Anda untuk memantau kapasitas, sensor lingkungan, dan kesehatan populasi ayam.
      </p>
      <button type="button" class="btn btn-tambah-kandang px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahKandang">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kandang Sekarang
      </button>
    </div>
  </div>
  @else
  <div class="row g-4 mb-4">
    @foreach ($kandangs as $kandang)
    <div class="col-12 col-lg-6">
      <div class="card h-100 border-0 kandang-item-card bg-body">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <!-- Card Header: Icon, Name, Type, and Dropdown Action -->
            <div class="d-flex align-items-start justify-content-between mb-3">
              <div class="d-flex align-items-center gap-3">
                <!-- House Icon in warm beige rounded box -->
                <div class="kandang-icon-box shadow-2xs">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                  </svg>
                </div>
                <div>
                  <h3 class="kandang-name mb-0 text-body">
                    {{ $kandang->nama }}
                  </h3>
                  <div class="kandang-meta text-secondary">
                    {{ $kandang->jenis_ayam }} &middot; {{ $kandang->tipe_kandang_formatted }}
                  </div>
                </div>
              </div>

              <!-- Three dots action dropdown -->
              <div class="dropdown">
                <button class="btn btn-link text-secondary p-1 dropdown-toggle-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Opsi">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="5" cy="12" r="2"/>
                    <circle cx="12" cy="12" r="2"/>
                    <circle cx="19" cy="12" r="2"/>
                  </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" style="min-width: 190px;">
                  <li>
                    <a class="dropdown-item py-2 fs-7" href="{{ route('kandang.show', $kandang) }}">
                      <i class="bi bi-eye me-2 text-secondary"></i> Detail Kandang
                    </a>
                  </li>
                  <li>
                    <button type="button" class="dropdown-item py-2 fs-7" data-bs-toggle="modal" data-bs-target="#modalEditKandang{{ $kandang->id }}">
                      <i class="bi bi-pencil me-2 text-secondary"></i> Edit Data
                    </button>
                  </li>
                  <li>
                    <button type="button" class="dropdown-item py-2 fs-7" data-bs-toggle="modal" data-bs-target="#modalTambahFlock{{ $kandang->id }}">
                      <i class="bi bi-plus-circle me-2 text-secondary"></i> Tambah Populasi Ayam
                    </button>
                  </li>
                  <li class="border-top my-1"></li>
                  <li>
                    <button type="button" class="dropdown-item py-2 fs-7 text-danger" data-bs-toggle="modal" data-bs-target="#modalHapusKandang{{ $kandang->id }}">
                      <i class="bi bi-trash3 me-2"></i> Hapus Kandang
                    </button>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Divider -->
            <div class="kandang-card-divider my-3"></div>

            <!-- Lokasi Row -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="fs-7 text-secondary">Lokasi</span>
              <span class="fs-7 fw-bold text-body">{{ $kandang->lokasi ?: 'Blok Terpusat' }}</span>
            </div>

            <!-- 3 Metrics row: Kapasitas, Jumlah Ayam, Terisi -->
            <div class="row g-2 text-start mb-4 pt-1">
              <div class="col-4">
                <div class="kandang-metric-label mb-1">Kapasitas</div>
                <div class="kandang-metric-val">{{ number_format($kandang->kapasitas, 0, ',', '.') }} ekor</div>
              </div>
              <div class="col-4">
                <div class="kandang-metric-label mb-1">Jumlah Ayam</div>
                <div class="kandang-metric-val">{{ number_format($kandang->total_ayam, 0, ',', '.') }} ekor</div>
              </div>
              <div class="col-4">
                <div class="kandang-metric-label mb-1">Terisi</div>
                <div class="kandang-metric-val">{{ $kandang->persentase_terisi }}%</div>
              </div>
            </div>
          </div>

          <!-- Bottom Footer Row: Status indicator & Health Score -->
          <div class="d-flex justify-content-between align-items-center pt-2">
            <!-- Left: Status Indicator (Orange dot for perlu pantau, Green dot for normal) -->
            <div class="d-flex align-items-center">
              @php
                $status = $kandang->status_kandang;
              @endphp

              @if ($status === 'perlu_pantau')
                <span class="status-indicator-dot me-2" style="background-color: #d97706;"></span>
                <span class="status-indicator-text">Perlu Pantau</span>
              @elseif ($status === 'bahaya')
                <span class="status-indicator-dot me-2" style="background-color: #dc2626;"></span>
                <span class="status-indicator-text text-danger">Bahaya</span>
              @else
                <span class="status-indicator-dot me-2" style="background-color: #16a34a;"></span>
                <span class="status-indicator-text">Normal</span>
              @endif
            </div>

            <!-- Right: Health score -->
            <div class="d-flex align-items-baseline gap-1">
              <span class="fs-7 text-secondary">Skor Kesehatan</span>
              <span class="kandang-health-score ms-1">{{ $kandang->health_score }}</span>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Edit Kandang -->
    <div class="modal fade" id="modalEditKandang{{ $kandang->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $kandang->id }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
          <form action="{{ route('kandang.update', $kandang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pb-0 pt-4 px-4">
              <h5 class="modal-title fw-bold" id="modalEditLabel{{ $kandang->id }}">Edit Data {{ $kandang->nama }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
              <div class="mb-3">
                <label class="form-label fs-7 fw-semibold text-secondary">Nama Kandang <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control rounded-3" value="{{ old('nama', $kandang->nama) }}" required maxlength="50">
              </div>

              <div class="row g-3 mb-3">
                <div class="col-6">
                  <label class="form-label fs-7 fw-semibold text-secondary">Jenis Ayam <span class="text-danger">*</span></label>
                  <select name="jenis_ayam" class="form-select rounded-3" required>
                    <option value="Broiler" {{ $kandang->jenis_ayam === 'Broiler' ? 'selected' : '' }}>Broiler</option>
                    <option value="Layer" {{ $kandang->jenis_ayam === 'Layer' ? 'selected' : '' }}>Layer (Petelur)</option>
                    <option value="Kampung" {{ $kandang->jenis_ayam === 'Kampung' ? 'selected' : '' }}>Ayam Kampung</option>
                    <option value="Pejantan" {{ $kandang->jenis_ayam === 'Pejantan' ? 'selected' : '' }}>Ayam Pejantan</option>
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label fs-7 fw-semibold text-secondary">Tipe Kandang <span class="text-danger">*</span></label>
                  <select name="tipe_kandang" class="form-select rounded-3" required>
                    <option value="open_house" {{ $kandang->tipe_kandang === 'open_house' ? 'selected' : '' }}>Open House</option>
                    <option value="closed_house" {{ $kandang->tipe_kandang === 'closed_house' ? 'selected' : '' }}>Closed House</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fs-7 fw-semibold text-secondary">Lokasi / Blok</label>
                <input type="text" name="lokasi" class="form-control rounded-3" value="{{ old('lokasi', $kandang->lokasi) }}" placeholder="Contoh: Blok Utara" maxlength="100">
              </div>

              <div class="mb-3">
                <label class="form-label fs-7 fw-semibold text-secondary">Kapasitas Maksimal (ekor) <span class="text-danger">*</span></label>
                <input type="number" name="kapasitas" class="form-control rounded-3" value="{{ old('kapasitas', $kandang->kapasitas) }}" min="1" required>
              </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
              <button type="button" class="btn btn-batal-kandang px-3 py-2 fs-7" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-simpan-kandang px-4 py-2 fs-7">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Hapus Kandang -->
    <div class="modal fade" id="modalHapusKandang{{ $kandang->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 text-center p-3">
          <div class="modal-body p-3">
            <div class="d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger mb-3">
              <i class="bi bi-trash3 fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">Hapus Kandang?</h5>
            <p class="text-secondary fs-7 mb-4">
              Apakah Anda yakin ingin menghapus <strong>{{ $kandang->nama }}</strong>? Seluruh riwayat analisis dan kelompok ayam terkait akan terhapus.
            </p>
            <form action="{{ route('kandang.destroy', $kandang) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-light rounded-3 px-3 fs-7 flex-fill" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger rounded-3 px-3 fs-7 flex-fill">Ya, Hapus</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Flock / Populasi Ayam -->
    <div class="modal fade" id="modalTambahFlock{{ $kandang->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
          <form action="{{ route('kandang.store') }}" method="POST">
            @csrf
            <!-- Quick update / flock handler -->
            <div class="modal-header border-0 pb-0 pt-4 px-4">
              <h5 class="modal-title fw-bold">Tambah Populasi {{ $kandang->nama }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
              <p class="text-secondary fs-7 mb-3">
                Kapasitas saat ini: <strong>{{ number_format($kandang->kapasitas) }} ekor</strong>, Terisi: <strong>{{ number_format($kandang->total_ayam) }} ekor</strong>.
              </p>
              <div class="mb-3">
                <label class="form-label fs-7 fw-semibold text-secondary">Jumlah Ayam Masuk (ekor)</label>
                <input type="number" class="form-control rounded-3" placeholder="Contoh: 100" min="1" max="{{ max(0, $kandang->kapasitas - $kandang->total_ayam) }}">
                <small class="text-body-secondary fs-8">Maksimal sisa kapasitas: {{ max(0, $kandang->kapasitas - $kandang->total_ayam) }} ekor</small>
              </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
              <button type="button" class="btn btn-light rounded-3 px-3 fs-7" data-bs-dismiss="modal">Tutup</button>
              <a href="{{ route('kandang.show', $kandang) }}" class="btn btn-tambah-kandang px-3 py-2 fs-7">Buka Detail Kandang</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
  <!--end::Kandang Cards Grid-->

  </div>
  <!--end::Kandang Data Container-->

</div>

<!--begin::Modal Tambah Kandang (Direct Dynamic Creation)-->
<div class="modal fade" id="modalTambahKandang" tabindex="-1" aria-labelledby="modalTambahKandangLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-xl rounded-4">
      <form action="{{ route('kandang.store') }}" method="POST" id="formTambahKandang">
        @csrf
        <div class="modal-header border-0 pb-0 pt-4 px-4">
          <div>
            <div class="fs-8 fw-bold text-uppercase text-success tracking-wide">Formulir Pendaftaran</div>
            <h4 class="modal-title fw-bold text-body" id="modalTambahKandangLabel">Tambah Kandang Baru</h4>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <p class="text-secondary fs-7 mb-4">
            Masukkan data spesifikasi kandang ke dalam database. Data ini akan otomatis terintegrasi dengan sensor DHT22 dan modul inferensi sistem pakar.
          </p>

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-7">
              <label class="form-label fs-7 fw-semibold text-secondary">Nama Kandang <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control rounded-3 py-2" placeholder="Contoh: Kandang C, Kandang Starter" value="{{ old('nama') }}" required maxlength="50">
              <div class="form-text fs-8">Nama unit kandang harus unik dalam farm.</div>
            </div>
            <div class="col-12 col-md-5">
              <label class="form-label fs-7 fw-semibold text-secondary">Jenis Ayam <span class="text-danger">*</span></label>
              <select name="jenis_ayam" class="form-select rounded-3 py-2" required>
                <option value="Broiler" {{ old('jenis_ayam') === 'Broiler' ? 'selected' : '' }}>Broiler (Pedaging)</option>
                <option value="Layer" {{ old('jenis_ayam') === 'Layer' ? 'selected' : '' }}>Layer (Petelur)</option>
                <option value="Kampung" {{ old('jenis_ayam') === 'Kampung' ? 'selected' : '' }}>Ayam Kampung</option>
                <option value="Pejantan" {{ old('jenis_ayam') === 'Pejantan' ? 'selected' : '' }}>Ayam Pejantan</option>
              </select>
            </div>
          </div>

          <!-- Tipe Kandang Selector -->
          <div class="mb-4">
            <label class="form-label fs-7 fw-semibold text-secondary d-block">Tipe Bangunan Kandang <span class="text-danger">*</span></label>
            <div class="row g-3">
              <div class="col-12 col-sm-6">
                <input type="radio" class="btn-check" name="tipe_kandang" id="tipe_open" value="open_house" autocomplete="off" {{ old('tipe_kandang', 'open_house') === 'open_house' ? 'checked' : '' }} required>
                <label class="btn btn-outline-custom-type w-100 p-3 text-start rounded-3 h-100" for="tipe_open">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-wind text-success fs-5"></i>
                    <strong class="fs-7 text-body">Open House</strong>
                  </div>
                  <small class="text-secondary d-block fs-8">Sirkulasi udara alami / terbuka, tirai samping manual atau semi-otomatis.</small>
                </label>
              </div>
              <div class="col-12 col-sm-6">
                <input type="radio" class="btn-check" name="tipe_kandang" id="tipe_closed" value="closed_house" autocomplete="off" {{ old('tipe_kandang') === 'closed_house' ? 'checked' : '' }} required>
                <label class="btn btn-outline-custom-type w-100 p-3 text-start rounded-3 h-100" for="tipe_closed">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-fan text-primary fs-5"></i>
                    <strong class="fs-7 text-body">Closed House</strong>
                  </div>
                  <small class="text-secondary d-block fs-8">Kandang tertutup modern dengan blower terowongan angin (tunnel ventilation).</small>
                </label>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-semibold text-secondary">Lokasi / Blok</label>
              <input type="text" name="lokasi" class="form-control rounded-3 py-2" placeholder="Contoh: Blok Timur, Sektor A" value="{{ old('lokasi') }}" maxlength="100">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fs-7 fw-semibold text-secondary">Kapasitas Maksimal (ekor) <span class="text-danger">*</span></label>
              <input type="number" name="kapasitas" class="form-control rounded-3 py-2" placeholder="Contoh: 500" value="{{ old('kapasitas', 500) }}" min="1" required>
            </div>
          </div>

          <!-- Populasi Awal Ayam (Opsional) -->
          <div class="p-3 rounded-3 mb-2" style="background-color: #f8faf8; border: 1px dashed #d6e2d8;">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <label class="form-label fs-7 fw-semibold text-body mb-0">
                <i class="bi bi-people-fill text-success me-1"></i> Populasi Awal Ayam (Opsional)
              </label>
              <span class="badge bg-light text-secondary border fs-8">Kelompok Ayam</span>
            </div>
            <div class="row g-2 align-items-center">
              <div class="col-12 col-sm-6">
                <input type="number" name="populasi_awal" class="form-control form-control-sm rounded-3" placeholder="Contoh: 450" value="{{ old('populasi_awal') }}" min="0">
              </div>
              <div class="col-12 col-sm-6">
                <small class="text-secondary fs-8">
                  Jika diisi, sistem otomatis membuat data kelompok ayam aktif pertama di kandang ini.
                </small>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between">
          <a href="{{ route('kandang.create') }}" class="text-decoration-none fs-7 text-secondary">
            <i class="bi bi-box-arrow-up-right me-1"></i> Buka halaman penuh
          </a>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-batal-kandang px-3 py-2 fs-7" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-simpan-kandang px-4 py-2 fs-7">
              <i class="bi bi-check-lg me-1"></i> Simpan Kandang
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--end::Modal Tambah Kandang-->

<!--begin::Floating Button "Ask AXION" (Matching Image 1)-->
<button type="button" class="btn btn-ask-axion shadow-lg d-inline-flex align-items-center gap-2" data-bs-toggle="offcanvas" data-bs-target="#askAxionOffcanvas" aria-controls="askAxionOffcanvas">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="10" rx="2"/>
    <circle cx="12" cy="5" r="2"/>
    <path d="M12 7v4"/>
    <line x1="8" y1="16" x2="8" y2="16"/>
    <line x1="16" y1="16" x2="16" y2="16"/>
  </svg>
  <span>Ask AXION</span>
</button>
<!--end::Floating Button-->

<!--begin::Ask AXION Offcanvas Drawer-->
<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="askAxionOffcanvas" aria-labelledby="askAxionLabel" style="width: 380px;">
  <div class="offcanvas-header border-bottom py-3" style="background-color: #fbf8f3;">
    <div class="d-flex align-items-center gap-2">
      <div class="p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #c88e40;">
        <i class="bi bi-robot fs-6"></i>
      </div>
      <div>
        <h6 class="offcanvas-title fw-bold text-body mb-0" id="askAxionLabel">AXION AI Assistant</h6>
        <small class="text-secondary fs-8">Pakar Pemeliharaan & Mikroklimat</small>
      </div>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-4 d-flex flex-column justify-content-between">
    <div>
      <div class="alert alert-warning border-0 rounded-3 p-3 fs-7 mb-3" style="background-color: #fdf5eb; color: #8f5c22;">
        <i class="bi bi-lightbulb-fill me-1"></i>
        Halo! Saya siap membantu menjawab status mikroklimat suhu, rekomendasi ventilasi, dan analisis kesehatan ayam Anda.
      </div>

      <div class="mb-3">
        <label class="fs-8 fw-bold text-uppercase text-secondary tracking-wide mb-2 d-block">Pertanyaan Cepat</label>
        <div class="d-flex flex-column gap-2">
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-body" onclick="setQuickPrompt('Bagaimana status kesehatan seluruh kandang saat ini?')">
            🐔 Bagaimana status kesehatan seluruh kandang saat ini?
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-body" onclick="setQuickPrompt('Kandang mana yang memerlukan ventilasi tambahan?')">
            🌡️ Kandang mana yang memerlukan ventilasi tambahan?
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-body" onclick="setQuickPrompt('Berapa sisa total kapasitas kandang yang masih kosong?')">
            📊 Berapa sisa total kapasitas kandang yang masih kosong?
          </button>
        </div>
      </div>

      <div id="aiChatOutput" class="p-3 rounded-3 bg-light fs-7 text-secondary border mb-3" style="min-height: 120px; font-size: 0.85rem;">
        Pilih pertanyaan di atas atau ketik pertanyaan seputar kandang.
      </div>
    </div>

    <div>
      <div class="input-group">
        <input type="text" id="aiInputPrompt" class="form-control rounded-start-3 fs-7" placeholder="Tanyakan seputar kandang...">
        <button class="btn btn-warning text-white rounded-end-3 px-3" type="button" style="background-color: #c88e40; border-color: #c88e40;" onclick="submitAiPrompt()">
          <i class="bi bi-send-fill"></i>
        </button>
      </div>
    </div>
  </div>
</div>
<!--end::Ask AXION Offcanvas-->

@push('styles')
<style>
  /* Base Typography & Editorial Design */
  .kandang-page-container {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }

  .kandang-kicker {
    font-size: 0.74rem;
    letter-spacing: 0.12em;
    color: #ea580c;
    font-weight: 800;
  }

  .kandang-hero-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.02em;
    line-height: 1.2;
  }

  .kandang-hero-subtitle {
    font-size: 1rem;
    color: #64748b;
  }

  /* Primary Action Button: + Tambah Kandang (Hijau / Green) */
  .btn-tambah-kandang {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    border-color: #059669 !important;
    color: #ffffff !important;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 0.92rem;
    transition: all 0.2s ease;
  }

  .btn-tambah-kandang:hover {
    background: linear-gradient(135deg, #059669, #047857) !important;
    border-color: #047857 !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35) !important;
  }

  /* Simpan Action Button (Biru / Blue) */
  .btn-simpan-kandang {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    border-color: #1d4ed8 !important;
    color: #ffffff !important;
    font-weight: 600;
    border-radius: 10px;
    padding: 9px 22px;
    font-size: 0.92rem;
    transition: all 0.2s ease;
  }

  .btn-simpan-kandang:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af) !important;
    border-color: #1e40af !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35) !important;
  }

  /* Batal Action Button (Abu-abu / Grey) */
  .btn-batal-kandang {
    background-color: #64748b !important;
    border-color: #64748b !important;
    color: #ffffff !important;
    font-weight: 600;
    border-radius: 10px;
    padding: 9px 20px;
    font-size: 0.92rem;
    transition: all 0.2s ease;
  }

  .btn-batal-kandang:hover {
    background-color: #475569 !important;
    border-color: #475569 !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(100, 116, 139, 0.25) !important;
  }

  /* Stat Summary Cards (4 Cards Row) */
  .stat-summary-card {
    border-radius: 16px !important;
    border: 1px solid #ffedd5 !important;
    box-shadow: 0 4px 14px rgba(234, 88, 12, 0.05) !important;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .stat-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(234, 88, 12, 0.09) !important;
  }

  .stat-summary-label {
    font-size: 0.84rem;
    color: #64748b;
    font-weight: 600;
  }

  .stat-summary-number {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
    letter-spacing: -0.03em;
  }

  .stat-summary-unit {
    font-size: 0.95rem;
    font-weight: 500;
    color: #64748b;
  }

  /* Kandang Item Card */
  .kandang-item-card {
    border-radius: 16px !important;
    border: 1px solid #ffedd5 !important;
    box-shadow: 0 4px 14px rgba(234, 88, 12, 0.05) !important;
    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
  }

  .kandang-item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(234, 88, 12, 0.1) !important;
    border-color: #fdba74 !important;
  }

  /* House Icon Box */
  .kandang-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background-color: #fff7ed;
    color: #ea580c;
    border: 1px solid #fed7aa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .kandang-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.25rem;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.01em;
    line-height: 1.2;
  }

  .kandang-meta {
    font-size: 0.82rem;
    color: #64748b;
    margin-top: 2px;
  }

  .dropdown-toggle-dots {
    border: none;
    background: transparent;
    border-radius: 8px;
    transition: background 0.15s ease;
  }

  .dropdown-toggle-dots:hover {
    background: #fff7ed;
  }

  .kandang-card-divider {
    border-bottom: 1px solid #ffedd5;
  }

  .kandang-metric-label {
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 500;
  }

  .kandang-metric-val {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b;
  }

  /* Status Indicator */
  .status-indicator-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
  }

  .status-indicator-text {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
  }

  .kandang-health-score {
    font-size: 1.15rem;
    font-weight: 800;
    color: #ea580c;
  }

  /* Floating Ask AXION Button */
  .btn-ask-axion {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 1040;
    background: linear-gradient(135deg, #f97316, #ea580c) !important;
    border-color: #ea580c !important;
    color: #ffffff !important;
    font-weight: 600;
    border-radius: 9999px;
    padding: 11px 22px;
    font-size: 0.92rem;
    box-shadow: 0 8px 24px rgba(234, 88, 12, 0.35) !important;
    transition: all 0.2s ease;
  }

  .btn-ask-axion:hover {
    background: linear-gradient(135deg, #ea580c, #c2410c) !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(234, 88, 12, 0.45) !important;
  }

  /* Custom Type Radio Button */
  .btn-outline-custom-type {
    border: 1.5px solid #fed7aa !important;
    background: transparent;
    transition: all 0.2s ease;
  }

  .btn-check:checked + .btn-outline-custom-type {
    border-color: #ea580c !important;
    background-color: #fff7ed !important;
    box-shadow: 0 0 0 1px #ea580c;
  }

  /* Dark Theme Adaptations */
  [data-bs-theme="dark"] .kandang-hero-title,
  [data-bs-theme="dark"] .stat-summary-number,
  [data-bs-theme="dark"] .kandang-name,
  [data-bs-theme="dark"] .kandang-metric-val,
  [data-bs-theme="dark"] .kandang-health-score {
    color: #f1f5f9 !important;
  }

  [data-bs-theme="dark"] .stat-summary-card,
  [data-bs-theme="dark"] .kandang-item-card {
    border-color: rgba(255, 255, 255, 0.08) !important;
  }

  [data-bs-theme="dark"] .kandang-icon-box {
    background-color: rgba(217, 119, 6, 0.15) !important;
    color: #f59e0b !important;
  }

  [data-bs-theme="dark"] .kandang-card-divider {
    border-bottom-color: rgba(255, 255, 255, 0.08) !important;
  }

  [data-bs-theme="dark"] .status-indicator-text {
    color: #cbd5e1 !important;
  }

  [data-bs-theme="dark"] .btn-check:checked + .btn-outline-custom-type {
    background-color: rgba(34, 197, 94, 0.12) !important;
    border-color: #22c55e !important;
  }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnToggleCreateCard');
    const btnClose = document.getElementById('btnCloseCreateCard');
    const btnCancel = document.getElementById('btnCancelCreateCard');
    const cardTambah = document.getElementById('cardTambahKandang');
    const heroHeader = document.getElementById('heroHeaderSection');
    const dataContainer = document.getElementById('kandangDataContainer');
    const inputNama = document.getElementById('inputNamaKandang');

    function openCreateForm() {
      if (heroHeader) heroHeader.style.display = 'none';
      if (dataContainer) dataContainer.style.display = 'none';
      if (cardTambah) {
        cardTambah.style.display = 'block';
        cardTambah.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (inputNama) inputNama.focus();
      }
    }

    function closeCreateForm() {
      if (cardTambah) cardTambah.style.display = 'none';
      if (heroHeader) heroHeader.style.display = '';
      if (dataContainer) dataContainer.style.display = '';
    }

    if (btnToggle) btnToggle.addEventListener('click', openCreateForm);
    if (btnClose) btnClose.addEventListener('click', closeCreateForm);
    if (btnCancel) btnCancel.addEventListener('click', closeCreateForm);
  });

  function setQuickPrompt(text) {
    document.getElementById('aiInputPrompt').value = text;
    submitAiPrompt();
  }

  function submitAiPrompt() {
    const input = document.getElementById('aiInputPrompt');
    const output = document.getElementById('aiChatOutput');
    const query = input.value.trim();
    if (!query) return;

    output.innerHTML = `<div class="d-flex align-items-center gap-2 text-primary"><div class="spinner-border spinner-border-sm" role="status"></div><span>AXION AI sedang menganalisis data kandang...</span></div>`;

    setTimeout(() => {
      let response = '';
      if (query.toLowerCase().includes('kesehatan') || query.toLowerCase().includes('status')) {
        response = `<strong>Status Kesehatan Kandang:</strong><br>&bull; <strong>Kandang A:</strong> Status <em>Perlu Pantau</em> (Skor Kesehatan: 78). Suhu lingkungan agak tinggi, disarankan pemeriksaan sirkulasi tirai.<br>&bull; <strong>Kandang B:</strong> Status <em>Normal</em> (Skor Kesehatan: 92). Mikroklimat closed house sangat optimal.`;
      } else if (query.toLowerCase().includes('ventilasi') || query.toLowerCase().includes('suhu')) {
        response = `<strong>Rekomendasi Ventilasi:</strong><br>&bull; <strong>Kandang A (Open House):</strong> Direkomendasikan membuka tirai sisi selatan 25% lebih lebar untuk mengurangi suhu hangat siang hari.<br>&bull; <strong>Kandang B (Closed House):</strong> Blower exhaust beroperasi stabil dengan static pressure normal.`;
      } else {
        response = `<strong>Ringkasan Sistem AXION:</strong><br>Total terdaftar ${document.querySelectorAll('.kandang-item-card').length} kandang dengan rata-rata skor kesehatan {{ $avgHealthScore }}/100. Semua sensor DHT22 terhubung dan sinkronisasi aktif.`;
      }
      output.innerHTML = response;
    }, 600);
  }
</script>
@endpush
@endsection
