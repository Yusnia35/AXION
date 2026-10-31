@extends('layouts.adminlte')

@section('title', 'AXION - Edit Pemeriksaan Ayam #' . $pemeriksaanAyam->id)
@section('topbar_page', 'Edit Pemeriksaan')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">

      <!-- Breadcrumbs & Back link -->
      <div class="mb-3 pt-2">
        <a href="{{ route('pemeriksaan-ayam.index') }}" class="text-decoration-none text-secondary fs-7 fw-medium d-inline-flex align-items-center gap-1.5">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali ke Daftar Pemeriksaan</span>
        </a>
      </div>

      <!-- Card Form -->
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div class="kandang-kicker text-uppercase fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.12em; color: #728174;">
            PENCATATAN KLINIS &middot; PERBARUI DATA #{{ $pemeriksaanAyam->id }}
          </div>
          <a href="{{ route('pemeriksaan-ayam.index') }}" class="btn-close text-secondary" aria-label="Close" title="Kembali"></a>
        </div>

        <h1 class="kandang-hero-title mb-2" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
          Edit Pemeriksaan Kesehatan Ayam
        </h1>
        <p class="text-secondary fs-7 mb-4">
          Perbarui rincian observasi gejala klinis untuk {{ $pemeriksaanAyam->kelompokAyam?->kandang?->nama ?? 'Kandang' }} &mdash; {{ $pemeriksaanAyam->kelompokAyam?->kode }}.
        </p>

        @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">
          <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Mohon periksa kesalahan input berikut:</div>
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('pemeriksaan-ayam.update', $pemeriksaanAyam) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-md-7">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">
                Kelompok Ayam &amp; Kandang <span class="text-danger">*</span>
              </label>
              <select name="kelompok_id" class="form-select rounded-3 py-2.5 px-3 border" required style="border-color: #d8e2d8 !important;">
                @foreach ($kelompokAyams as $flock)
                  <option value="{{ $flock->id }}" {{ old('kelompok_id', $pemeriksaanAyam->kelompok_id) == $flock->id ? 'selected' : '' }}>
                    {{ $flock->kandang?->nama ?? 'Kandang' }} &mdash; {{ $flock->kode }} ({{ number_format($flock->jumlah_ayam) }} ekor &middot; {{ $flock->profil }})
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-5">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">
                Waktu Observasi / Pemeriksaan
              </label>
              <input type="datetime-local" name="dicatat_pada" class="form-control rounded-3 py-2.5 px-3 border" value="{{ old('dicatat_pada', $pemeriksaanAyam->dicatat_pada ? $pemeriksaanAyam->dicatat_pada->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" style="border-color: #d8e2d8 !important;">
            </div>
          </div>

          <div class="p-3 mb-3 rounded-3 bg-light border-0 d-flex align-items-center gap-2">
            <i class="bi bi-heart-pulse-fill text-danger fs-5"></i>
            <span class="fw-bold fs-7 text-uppercase text-secondary tracking-wide">6 Parameter Gejala Klinis Ayam</span>
          </div>

          <div class="row g-3 g-md-4 mb-4">
            <!-- 1. Nafsu Makan -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">🍽️ 1. Nafsu Makan <span class="text-danger">*</span></label>
              <select name="nafsu_makan" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="normal" {{ old('nafsu_makan', $pemeriksaanAyam->nafsu_makan) === 'normal' ? 'selected' : '' }}>Normal (Pakan Habis Teratur)</option>
                <option value="menurun" {{ old('nafsu_makan', $pemeriksaanAyam->nafsu_makan) === 'menurun' ? 'selected' : '' }}>Menurun (Pakan Bersisa)</option>
                <option value="tidak_mau_makan" {{ old('nafsu_makan', $pemeriksaanAyam->nafsu_makan) === 'tidak_mau_makan' ? 'selected' : '' }}>Tidak Mau Makan (Anoreksia)</option>
              </select>
            </div>

            <!-- 2. Aktivitas -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">🏃 2. Aktivitas Gerak <span class="text-danger">*</span></label>
              <select name="aktivitas" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="aktif" {{ old('aktivitas', $pemeriksaanAyam->aktivitas) === 'aktif' ? 'selected' : '' }}>Aktif &amp; Lincah</option>
                <option value="lesu" {{ old('aktivitas', $pemeriksaanAyam->aktivitas) === 'lesu' ? 'selected' : '' }}>Lesu (Banyak Berdiam Diri)</option>
                <option value="sangat_lesu" {{ old('aktivitas', $pemeriksaanAyam->aktivitas) === 'sangat_lesu' ? 'selected' : '' }}>Sangat Lesu / Terkulai</option>
              </select>
            </div>

            <!-- 3. Kondisi Mata -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">👁️ 3. Kondisi Mata <span class="text-danger">*</span></label>
              <select name="kondisi_mata" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="normal" {{ old('kondisi_mata', $pemeriksaanAyam->kondisi_mata) === 'normal' ? 'selected' : '' }}>Normal (Jernih &amp; Terbuka)</option>
                <option value="berair" {{ old('kondisi_mata', $pemeriksaanAyam->kondisi_mata) === 'berair' ? 'selected' : '' }}>Berair (Iritasi Lakrimasi)</option>
                <option value="bengkak" {{ old('kondisi_mata', $pemeriksaanAyam->kondisi_mata) === 'bengkak' ? 'selected' : '' }}>Bengkak (Indikasi Coryza)</option>
              </select>
            </div>

            <!-- 4. Kondisi Bulu -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">🪶 4. Kondisi Bulu <span class="text-danger">*</span></label>
              <select name="kondisi_bulu" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="normal" {{ old('kondisi_bulu', $pemeriksaanAyam->kondisi_bulu) === 'normal' ? 'selected' : '' }}>Normal (Bersih &amp; Rapi)</option>
                <option value="kusut" {{ old('kondisi_bulu', $pemeriksaanAyam->kondisi_bulu) === 'kusut' ? 'selected' : '' }}>Kusut / Kusam (Mengembang)</option>
                <option value="rontok" {{ old('kondisi_bulu', $pemeriksaanAyam->kondisi_bulu) === 'rontok' ? 'selected' : '' }}>Rontok Berlebih</option>
              </select>
            </div>

            <!-- 5. Batuk & Bersin -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">🗣️ 5. Batuk &amp; Bersin (Rule R06) <span class="text-danger">*</span></label>
              <select name="batuk_bersin" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="tidak_ada" {{ old('batuk_bersin', $pemeriksaanAyam->batuk_bersin) === 'tidak_ada' ? 'selected' : '' }}>Tidak Ada (Napas Bersih)</option>
                <option value="ringan" {{ old('batuk_bersin', $pemeriksaanAyam->batuk_bersin) === 'ringan' ? 'selected' : '' }}>Ringan (Sesekali Bersin)</option>
                <option value="sering" {{ old('batuk_bersin', $pemeriksaanAyam->batuk_bersin) === 'sering' ? 'selected' : '' }}>Sering (Suara Ngorok / CRD)</option>
              </select>
            </div>

            <!-- 6. Kondisi Kotoran -->
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-semibold mb-1">💩 6. Kondisi Kotoran (Rule R07) <span class="text-danger">*</span></label>
              <select name="kondisi_kotoran" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #d8e2d8 !important;">
                <option value="normal" {{ old('kondisi_kotoran', $pemeriksaanAyam->kondisi_kotoran) === 'normal' ? 'selected' : '' }}>Normal (Padat Berkepala Putih)</option>
                <option value="encer" {{ old('kondisi_kotoran', $pemeriksaanAyam->kondisi_kotoran) === 'encer' ? 'selected' : '' }}>Encer (Diare / Mencret)</option>
                <option value="kehijauan" {{ old('kondisi_kotoran', $pemeriksaanAyam->kondisi_kotoran) === 'kehijauan' ? 'selected' : '' }}>Kehijauan</option>
                <option value="berdarah" {{ old('kondisi_kotoran', $pemeriksaanAyam->kondisi_kotoran) === 'berdarah' ? 'selected' : '' }}>Berdarah (Kritis / Koksidiosis)</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fs-7 text-secondary fw-semibold mb-1">Catatan Tambahan Petugas</label>
            <textarea name="catatan" rows="3" class="form-control rounded-3 py-2 px-3 border" placeholder="Catatan perkembangan klinis...">{{ old('catatan', $pemeriksaanAyam->catatan) }}</textarea>
          </div>

          <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-tambah-kandang d-inline-flex align-items-center gap-2 px-4 py-2" style="border-radius: 10px; font-weight: 600;">
              <i class="bi bi-check-circle"></i>
              <span>Perbarui Pemeriksaan</span>
            </button>
            <a href="{{ route('pemeriksaan-ayam.index') }}" class="btn btn-outline-secondary rounded-3 px-4 py-2">
              Batal
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
