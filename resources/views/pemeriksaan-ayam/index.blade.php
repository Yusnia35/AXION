@extends('layouts.adminlte')

@section('title', 'AXION - Pemeriksaan Kesehatan Ayam')
@section('topbar_page', 'Pemeriksaan Ayam')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">

  <!-- Success & Error Notifications -->
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
    <div class="fw-medium">{{ session('success') }}</div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Mohon periksa kesalahan input berikut:</div>
    <ul class="mb-0 ps-3 fs-7">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!--begin::Card Tambah Pemeriksaan Baru (Collapsible/Inline)-->
  <div class="card border-0 shadow-sm rounded-4 bg-body mb-4 p-4 p-md-5" id="cardTambahPemeriksaan" style="{{ ($showCreateCard ?? false) ? '' : 'display: none;' }}">
    <div class="d-flex justify-content-between align-items-start mb-2">
      <div class="kandang-kicker text-uppercase fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.12em; color: #728174;">
        PENCATATAN KLINIS BARU
      </div>
      <button type="button" class="btn-close text-secondary" id="btnCloseCreateCard" aria-label="Close" title="Tutup formulir"></button>
    </div>

    <h2 class="kandang-hero-title mb-3" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
      Catat Pemeriksaan Kesehatan Ayam
    </h2>
    <p class="text-secondary fs-7 mb-4">
      Observasi 6 parameter klinis ayam secara cermat. Data ini akan diproses oleh mesin inferensi sistem pakar untuk mendeteksi dini risiko penyakit.
    </p>

    <form action="{{ route('pemeriksaan-ayam.store') }}" method="POST" id="formPemeriksaanAyam">
      @csrf

      <!-- Baris 1: Kelompok Ayam & Waktu Pemeriksaan -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-md-7">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            <i class="bi bi-grid-3x3-gap me-1 text-primary"></i> Kelompok Ayam & Kandang <span class="text-danger">*</span>
          </label>
          <select name="kelompok_id" id="selectKelompok" class="form-select rounded-3 py-2.5 px-3 border shadow-sm" required style="border-color: #d8e2d8 !important; background-color: #fafbfa;">
            <option value="" disabled selected>-- Pilih Kelompok Ayam Terdaftar --</option>
            @foreach ($kelompokAyams as $flock)
              <option value="{{ $flock->id }}" {{ old('kelompok_id') == $flock->id ? 'selected' : '' }}>
                {{ $flock->kandang?->nama ?? 'Kandang' }} &mdash; {{ $flock->kode }} ({{ number_format($flock->jumlah_ayam) }} ekor &middot; {{ $flock->profil }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-5">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            <i class="bi bi-clock me-1 text-primary"></i> Waktu Pemeriksaan
          </label>
          <input type="datetime-local" name="dicatat_pada" class="form-control rounded-3 py-2.5 px-3 border shadow-sm" value="{{ old('dicatat_pada', now()->format('Y-m-d\TH:i')) }}" style="border-color: #d8e2d8 !important; background-color: #fafbfa;">
        </div>
      </div>

      <!-- Section Title: 6 Parameter Klinis -->
      <div class="p-3 mb-3 rounded-3 bg-light border-0 d-flex align-items-center gap-2">
        <i class="bi bi-heart-pulse-fill text-danger fs-5"></i>
        <span class="fw-bold fs-7 text-uppercase text-secondary tracking-wide">6 Parameter Observasi Gejala Klinis Ayam</span>
      </div>

      <!-- Grid 6 Parameter Gejala Klinis -->
      <div class="row g-3 g-md-4 mb-4">
        <!-- 1. Nafsu Makan -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            🍽️ 1. Nafsu Makan <span class="text-danger">*</span>
          </label>
          <select name="nafsu_makan" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="normal" {{ old('nafsu_makan') === 'normal' ? 'selected' : '' }}>Normal (Pakan Habis Sesuai Jadwal)</option>
            <option value="menurun" {{ old('nafsu_makan') === 'menurun' ? 'selected' : '' }}>Menurun (Pakan Tersisa &gt; 15%)</option>
            <option value="tidak_mau_makan" {{ old('nafsu_makan') === 'tidak_mau_makan' ? 'selected' : '' }}>Tidak Mau Makan (Anoreksia)</option>
          </select>
          <small class="text-secondary fs-8">Parameter kunci metabolisme ayam.</small>
        </div>

        <!-- 2. Aktivitas / Keaktifan -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            🏃 2. Aktivitas Gerak <span class="text-danger">*</span>
          </label>
          <select name="aktivitas" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="aktif" {{ old('aktivitas') === 'aktif' ? 'selected' : '' }}>Aktif &amp; Lincah (Pergerakan Wajar)</option>
            <option value="lesu" {{ old('aktivitas') === 'lesu' ? 'selected' : '' }}>Lesu (Banyak Diam di Sudut)</option>
            <option value="sangat_lesu" {{ old('aktivitas') === 'sangat_lesu' ? 'selected' : '' }}>Sangat Lesu (Lemah &amp; Terkulai)</option>
          </select>
          <small class="text-secondary fs-8">Kelesuan menandakan stres atau demam.</small>
        </div>

        <!-- 3. Kondisi Mata -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            👁️ 3. Kondisi Mata <span class="text-danger">*</span>
          </label>
          <select name="kondisi_mata" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="normal" {{ old('kondisi_mata') === 'normal' ? 'selected' : '' }}>Normal (Mata Bersih &amp; Jernih)</option>
            <option value="berair" {{ old('kondisi_mata') === 'berair' ? 'selected' : '' }}>Berair (Lakrimasi / Iritasi)</option>
            <option value="bengkak" {{ old('kondisi_mata') === 'bengkak' ? 'selected' : '' }}>Bengkak (Indikasi Coryza / Infeksi)</option>
          </select>
          <small class="text-secondary fs-8">Iritasi sering disebabkan gas amonia.</small>
        </div>

        <!-- 4. Kondisi Bulu -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            🪶 4. Kondisi Bulu <span class="text-danger">*</span>
          </label>
          <select name="kondisi_bulu" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="normal" {{ old('kondisi_bulu') === 'normal' ? 'selected' : '' }}>Normal (Bulu Bersih &amp; Rapi)</option>
            <option value="kusut" {{ old('kondisi_bulu') === 'kusut' ? 'selected' : '' }}>Kusut / Kusam (Bulu Berdiri)</option>
            <option value="rontok" {{ old('kondisi_bulu') === 'rontok' ? 'selected' : '' }}>Rontok Berlebih</option>
          </select>
          <small class="text-secondary fs-8">Bulu kusut mencerminkan gangguan suhu.</small>
        </div>

        <!-- 5. Batuk & Bersin (Pernapasan) -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            🗣️ 5. Batuk &amp; Bersin (Rule R06) <span class="text-danger">*</span>
          </label>
          <select name="batuk_bersin" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="tidak_ada" {{ old('batuk_bersin') === 'tidak_ada' ? 'selected' : '' }}>Tidak Ada (Napas Bersih)</option>
            <option value="ringan" {{ old('batuk_bersin') === 'ringan' ? 'selected' : '' }}>Ringan (Sesekali Bersin)</option>
            <option value="sering" {{ old('batuk_bersin') === 'sering' ? 'selected' : '' }}>Sering (Bunyi Ngorok / CRD)</option>
          </select>
          <small class="text-secondary fs-8">Memicu aturan inferensi pakar R06.</small>
        </div>

        <!-- 6. Kondisi Kotoran (Feses) -->
        <div class="col-12 col-md-4">
          <label class="form-label fs-7 text-secondary fw-semibold mb-1">
            💩 6. Kondisi Kotoran (Rule R07) <span class="text-danger">*</span>
          </label>
          <select name="kondisi_kotoran" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
            <option value="normal" {{ old('kondisi_kotoran') === 'normal' ? 'selected' : '' }}>Normal (Padat Berkepala Putih)</option>
            <option value="encer" {{ old('kondisi_kotoran') === 'encer' ? 'selected' : '' }}>Encer (Diare / Mencret)</option>
            <option value="kehijauan" {{ old('kondisi_kotoran') === 'kehijauan' ? 'selected' : '' }}>Kehijauan (Kelelahan / Stres)</option>
            <option value="berdarah" {{ old('kondisi_kotoran') === 'berdarah' ? 'selected' : '' }}>Berdarah (Kritis / Koksidiosis)</option>
          </select>
          <small class="text-secondary fs-8">Feses berdarah memicu status kritis R07.</small>
        </div>
      </div>

      <!-- Baris 3: Catatan Pengamatan Tambahan -->
      <div class="mb-4">
        <label class="form-label fs-7 text-secondary fw-semibold mb-1">
          <i class="bi bi-pencil-square me-1"></i> Catatan Klinis Tambahan / Keterangan Lapangan
        </label>
        <textarea name="catatan" rows="2" class="form-control rounded-3 py-2 px-3 border shadow-sm" placeholder="Contoh: Terlihat 5 ekor ayam berkumpul di bawah blower tirai utara, feses sedikit basah karena kebocoran nipple air." style="border-color: #d8e2d8 !important; background-color: #fafbfa;">{{ old('catatan') }}</textarea>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-tambah-kandang d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2" style="border-radius: 10px; font-weight: 600;">
          <i class="bi bi-check-circle"></i>
          <span>Simpan Catatan Pemeriksaan</span>
        </button>
        <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" id="btnCancelCreate">
          Batal
        </button>
      </div>
    </form>
  </div>
  <!--end::Card Tambah Pemeriksaan Baru-->

  <!--begin::Hero / Header Section-->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2" id="heroHeaderSection" style="{{ ($showCreateCard ?? false) ? 'display: none;' : '' }}">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1">
        Pemeriksaan Ayam
      </h1>
     
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <button type="button" class="btn btn-tambah-kandang shadow-sm d-inline-flex align-items-center gap-2" id="btnToggleCreateCard" style="border-radius: 10px; padding: 10px 22px;">
        <i class="bi bi-plus-lg"></i>
        <span>Catat Pemeriksaan Baru</span>
      </button>
    </div>
  </div>
  <!--end::Hero Section-->

  <!--begin::KPI Stats Cards (4 Cards)-->
  <div class="row g-3 g-xl-4 mb-4">
    <!-- Card 1: Total Pemeriksaan -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 stat-summary-card bg-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="stat-summary-label fw-medium text-secondary fs-7">Total Log Pemeriksaan</span>
          <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; width: 38px; height: 38px;">
            <i class="bi bi-clipboard2-pulse fs-5"></i>
          </div>
        </div>
        <div class="d-flex align-items-baseline gap-1 my-1">
          <span class="stat-summary-number fw-bold" style="font-size: 2.2rem; color: #1e293b;">{{ $totalPemeriksaan }}</span>
          <span class="text-secondary fs-7 ms-1">catatan</span>
        </div>
        <div class="text-secondary fs-8 mt-1">
          Historis observasi harian klinis
        </div>
      </div>
    </div>

    <!-- Card 2: Kawanan Normal / Sehat -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 stat-summary-card bg-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="stat-summary-label fw-medium text-secondary fs-7">Kondisi Sehat &amp; Normal</span>
          <div class="rounded-3 p-2 d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 38px; height: 38px;">
            <i class="bi bi-check-circle-fill fs-5"></i>
          </div>
        </div>
        <div class="d-flex align-items-baseline gap-1 my-1">
          <span class="stat-summary-number fw-bold text-success" style="font-size: 2.2rem;">{{ $totalNormal }}</span>
          <span class="text-secondary fs-7 ms-1">pemeriksaan</span>
        </div>
        <div class="text-success fs-8 mt-1">
          <i class="bi bi-shield-check me-1"></i> Bebas dari indikasi penyakit
        </div>
      </div>
    </div>

    <!-- Card 3: Perlu Pantau -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 stat-summary-card bg-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="stat-summary-label fw-medium text-secondary fs-7">Perlu Pemantauan</span>
          <div class="rounded-3 p-2 d-flex align-items-center justify-content-center bg-warning-subtle text-warning-emphasis" style="width: 38px; height: 38px;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
          </div>
        </div>
        <div class="d-flex align-items-baseline gap-1 my-1">
          <span class="stat-summary-number fw-bold text-warning-emphasis" style="font-size: 2.2rem;">{{ $totalPerluPantau }}</span>
          <span class="text-secondary fs-7 ms-1">peringatan</span>
        </div>
        <div class="text-secondary fs-8 mt-1">
          Gejala ringan nafsu makan / feses
        </div>
      </div>
    </div>

    <!-- Card 4: Gejala Kritis & Populasi Terpantau -->
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 stat-summary-card bg-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="stat-summary-label fw-medium text-secondary fs-7">Gejala Kritis / Koksidiosis</span>
          <div class="rounded-3 p-2 d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 38px; height: 38px;">
            <i class="bi bi-shield-exclamation fs-5"></i>
          </div>
        </div>
        <div class="d-flex align-items-baseline gap-1 my-1">
          <span class="stat-summary-number fw-bold {{ $totalKritis > 0 ? 'text-danger' : 'text-body' }}" style="font-size: 2.2rem;">{{ $totalKritis }}</span>
          <span class="text-secondary fs-7 ms-1">kasus</span>
        </div>
        <div class="text-secondary fs-8 mt-1">
          Dari total {{ number_format($totalAyamTerpantau) }} ekor ayam aktif
        </div>
      </div>
    </div>
  </div>
  <!--end::KPI Stats Cards-->

  <!--begin::Filter & Search Bar-->
  <div class="card border-0 shadow-sm rounded-4 bg-body mb-4 p-3">
    <form action="{{ route('pemeriksaan-ayam.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-4">
        <div class="input-group">
          <span class="input-group-text bg-transparent border-end-0 text-secondary">
            <i class="bi bi-funnel"></i>
          </span>
          <select name="kelompok_id" class="form-select border-start-0 fs-7" onchange="this.form.submit()">
            <option value="">Semua Kelompok Ayam</option>
            @foreach ($kelompokAyams as $flock)
              <option value="{{ $flock->id }}" {{ request('kelompok_id') == $flock->id ? 'selected' : '' }}>
                {{ $flock->kandang?->nama }} &mdash; {{ $flock->kode }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <select name="status" class="form-select fs-7" onchange="this.form.submit()">
          <option value="">Semua Status Klinis</option>
          <option value="normal" {{ request('status') === 'normal' ? 'selected' : '' }}>✅ Normal &amp; Sehat</option>
          <option value="perlu_pantau" {{ request('status') === 'perlu_pantau' ? 'selected' : '' }}>⚠️ Perlu Pantau</option>
          <option value="kritis" {{ request('status') === 'kritis' ? 'selected' : '' }}>🚨 Bahaya / Kritis</option>
        </select>
      </div>

      <div class="col-12 col-md-auto ms-md-auto d-flex gap-2">
        @if (request()->hasAny(['kelompok_id', 'status']))
          <a href="{{ route('pemeriksaan-ayam.index') }}" class="btn btn-outline-secondary fs-7 rounded-3">
            <i class="bi bi-x-circle me-1"></i> Reset Filter
          </a>
        @endif
        <a href="{{ route('rules.index') }}" class="btn btn-light fs-7 rounded-3 border text-secondary">
          <i class="bi bi-journal-code me-1"></i> Cek Aturan Pakar (R06 &middot; R07)
        </a>
      </div>
    </form>
  </div>
  <!--end::Filter Bar-->

  <!--begin::Tabel Pemeriksaan Klinis-->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h5 class="fw-bold mb-1" style="color: #16241b;">Daftar Pemeriksaan Klinis Harian</h5>
       
      </div>
      <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fs-8">
        {{ $pemeriksaans->count() }} Data Ditampilkan
      </span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle table-hover mb-0">
        <thead class="table-light fs-8 text-uppercase" style="letter-spacing: 0.05em;">
          <tr>
            <th class="ps-3">Waktu Periksa</th>
            <th>Kandang &amp; Kelompok</th>
            <th>Status Klinis</th>
            <th>Ringkasan 6 Parameter</th>
            <th>Indikasi Sistem Pakar</th>
            <th>Pemeriksa</th>
            <th class="text-end pe-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($pemeriksaans as $item)
          <tr>
            <!-- Waktu Periksa -->
            <td class="ps-3 font-monospace text-secondary text-nowrap">
              <div>{{ $item->dicatat_pada ? $item->dicatat_pada->translatedFormat('d M Y') : '-' }}</div>
              <small class="text-muted">{{ $item->dicatat_pada ? $item->dicatat_pada->format('H:i') . ' WIB' : '' }}</small>
            </td>

            <!-- Kandang & Kelompok -->
            <td>
              <div class="fw-bold text-body">
                {{ $item->kelompokAyam?->kandang?->nama ?? 'Kandang' }}
              </div>
              <div class="fs-8 text-secondary">
                {{ $item->kelompokAyam?->kode ?? 'Kelompok' }}
                @if ($item->kelompokAyam?->jumlah_ayam)
                  &middot; <span class="text-muted">{{ number_format($item->kelompokAyam->jumlah_ayam) }} ekor</span>
                @endif
              </div>
            </td>

            <!-- Status Klinis -->
            <td>
              @if ($item->status_klinis === 'kritis')
                <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded-pill fw-semibold border border-danger-subtle">
                  <i class="bi bi-exclamation-octagon-fill me-1"></i> {{ $item->status_klinis_label }}
                </span>
              @elseif ($item->status_klinis === 'perlu_pantau')
                <span class="badge bg-warning-subtle text-warning-emphasis px-2.5 py-1.5 rounded-pill fw-semibold border border-warning-subtle">
                  <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $item->status_klinis_label }}
                </span>
              @else
                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-pill fw-semibold border border-success-subtle">
                  <i class="bi bi-check-circle-fill me-1"></i> {{ $item->status_klinis_label }}
                </span>
              @endif
            </td>

            <!-- 6 Parameter Chips -->
            <td>
              <div class="d-flex flex-wrap gap-1" style="max-width: 320px;">
                <!-- Makan -->
                <span class="badge {{ $item->nafsu_makan === 'normal' ? 'bg-light text-secondary' : 'bg-danger-subtle text-danger' }} border" title="Nafsu Makan">
                  Makan: {{ $item->nafsu_makan_formatted }}
                </span>
                <!-- Aktivitas -->
                <span class="badge {{ $item->aktivitas === 'aktif' ? 'bg-light text-secondary' : 'bg-warning-subtle text-warning-emphasis' }} border" title="Aktivitas Gerak">
                  Gerak: {{ $item->aktivitas_formatted }}
                </span>
                <!-- Batuk -->
                <span class="badge {{ $item->batuk_bersin === 'tidak_ada' ? 'bg-light text-secondary' : ($item->batuk_bersin === 'sering' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning-emphasis') }} border" title="Batuk & Bersin">
                  Pernapasan: {{ $item->batuk_bersin_formatted }}
                </span>
                <!-- Kotoran -->
                <span class="badge {{ $item->kondisi_kotoran === 'normal' ? 'bg-light text-secondary' : 'bg-danger-subtle text-danger' }} border" title="Kondisi Feses">
                  Kotoran: {{ $item->kondisi_kotoran_formatted }}
                </span>
              </div>
            </td>

            <!-- Indikasi Pakar -->
            <td>
              <div class="fs-8 {{ $item->status_klinis !== 'normal' ? 'text-danger fw-semibold' : 'text-secondary' }}" style="max-width: 220px;">
                {!! $item->indikasi_diagnosa !!}
              </div>
              @if ($item->catatan)
                <div class="text-muted fs-8 text-truncate mt-1" style="max-width: 220px;" title="{{ $item->catatan }}">
                  <i class="bi bi-chat-left-text me-1"></i> {{ $item->catatan }}
                </div>
              @endif
            </td>

            <!-- Petugas -->
            <td class="text-secondary fs-8">
              <i class="bi bi-person-circle me-1"></i> {{ $item->user?->nama ?? 'Petugas Lapangan' }}
            </td>

            <!-- Aksi -->
            <td class="text-end pe-3 text-nowrap">
              <!-- Detail Modal Button -->
              <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Lihat Rekam Medis Lengkap">
                <i class="bi bi-eye"></i>
              </button>

              <!-- Edit Link -->
              <a href="{{ route('pemeriksaan-ayam.edit', $item) }}" class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1 ms-1" title="Edit Data">
                <i class="bi bi-pencil"></i>
              </a>

              <!-- Delete Form -->
              <form action="{{ route('pemeriksaan-ayam.destroy', $item) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemeriksaan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="Hapus Data">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>

          <!-- Modal Detail Pemeriksaan -->
          <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom py-3 px-4" style="background-color: #fafbfa;">
                  <div>
                    <div class="kandang-kicker text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.12em; color: #728174;">
                      REKAM OBSERVASI KLINIS &middot; AXION VET
                    </div>
                    <h5 class="modal-title fw-bold text-body" id="modalDetailLabel{{ $item->id }}">
                      {{ $item->kelompokAyam?->kandang?->nama ?? 'Kandang' }} &mdash; {{ $item->kelompokAyam?->kode }}
                    </h5>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                  <!-- Header status banner -->
                  <div class="p-3 rounded-4 mb-4 d-flex justify-content-between align-items-center {{ $item->status_klinis === 'kritis' ? 'bg-danger-subtle text-danger' : ($item->status_klinis === 'perlu_pantau' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-success-subtle text-success') }}">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi {{ $item->status_klinis === 'kritis' ? 'bi-shield-exclamation' : ($item->status_klinis === 'perlu_pantau' ? 'bi-exclamation-triangle-fill' : 'bi-shield-check') }} fs-3"></i>
                      <div>
                        <div class="fw-bold fs-6">Status Observasi: {{ $item->status_klinis_label }}</div>
                        <div class="fs-8 opacity-75">{!! $item->indikasi_diagnosa !!}</div>
                      </div>
                    </div>
                    <div class="text-end font-monospace fs-7">
                      {{ $item->dicatat_pada ? $item->dicatat_pada->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                    </div>
                  </div>

                  <!-- 6 Parameter Details in Grid Cards -->
                  <h6 class="fw-bold mb-3 text-secondary text-uppercase fs-8" style="letter-spacing: 0.05em;">Hasil Pengamatan 6 Parameter Klinis</h6>
                  <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">🍽️ Nafsu Makan</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->nafsu_makan_formatted }}</div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">🏃 Aktivitas Gerak</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->aktivitas_formatted }}</div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">👁️ Kondisi Mata</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->kondisi_mata_formatted }}</div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">🪶 Kondisi Bulu</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->kondisi_bulu_formatted }}</div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">🗣️ Batuk &amp; Bersin</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->batuk_bersin_formatted }}</div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                      <div class="card border rounded-3 p-3 bg-light h-100">
                        <div class="fs-8 text-secondary">💩 Kondisi Kotoran (Feses)</div>
                        <div class="fw-bold fs-7 mt-1 text-body">{{ $item->kondisi_kotoran_formatted }}</div>
                      </div>
                    </div>
                  </div>

                  <!-- Catatan Pengamatan -->
                  @if ($item->catatan)
                  <div class="mb-3">
                    <h6 class="fw-bold mb-1 text-secondary text-uppercase fs-8">Catatan Tambahan Petugas:</h6>
                    <div class="p-3 rounded-3 bg-light border fs-7 text-secondary">
                      {{ $item->catatan }}
                    </div>
                  </div>
                  @endif

                  <!-- Info Pencatat -->
                  <div class="d-flex justify-content-between align-items-center pt-2 border-top text-secondary fs-8">
                    <div>Dicatat oleh: <strong>{{ $item->user?->nama ?? 'Petugas Farm' }}</strong> ({{ $item->user?->email ?? '-' }})</div>
                    <div>ID Record: #{{ $item->id }}</div>
                  </div>
                </div>

                <div class="modal-footer border-top py-2.5 px-4 bg-light">
                  <a href="{{ route('pemeriksaan-ayam.edit', $item) }}" class="btn btn-outline-secondary rounded-3 fs-7">
                    <i class="bi bi-pencil me-1"></i> Edit Catatan
                  </a>
                  <button type="button" class="btn btn-secondary rounded-3 fs-7" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Detail -->

          @empty
          <tr>
            <td colspan="7" class="text-center py-5 text-secondary">
              <i class="bi bi-clipboard-x fs-1 d-block mb-2 text-muted"></i>
              <div class="fw-semibold">Belum ada catatan pemeriksaan ayam yang sesuai kriteria.</div>
              <p class="fs-8 text-muted mb-3">Klik tombol di bawah untuk mencatat hasil pengamatan kesehatan ayam harian.</p>
              <button type="button" class="btn btn-sm btn-tambah-kandang" onclick="document.getElementById('btnToggleCreateCard').click()">
                <i class="bi bi-plus-lg me-1"></i> Catat Pemeriksaan Pertama
              </button>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <!--end::Tabel Pemeriksaan Klinis-->

</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnToggleCreateCard');
    const btnClose = document.getElementById('btnCloseCreateCard');
    const btnCancel = document.getElementById('btnCancelCreate');
    const cardTambah = document.getElementById('cardTambahPemeriksaan');
    const heroHeader = document.getElementById('heroHeaderSection');
    const selectKelompok = document.getElementById('selectKelompok');

    function openForm() {
      if (heroHeader) heroHeader.style.display = 'none';
      if (cardTambah) {
        cardTambah.style.display = 'block';
        cardTambah.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (selectKelompok) selectKelompok.focus();
      }
    }

    function closeForm() {
      if (cardTambah) cardTambah.style.display = 'none';
      if (heroHeader) heroHeader.style.display = '';
    }

    if (btnToggle) btnToggle.addEventListener('click', openForm);
    if (btnClose) btnClose.addEventListener('click', closeForm);
    if (btnCancel) btnCancel.addEventListener('click', closeForm);
  });
</script>
@endpush
@endsection
