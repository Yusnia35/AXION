@extends('layouts.adminlte')

@section('title', 'AXION - Detail Rekam Medis Pemeriksaan #' . $pemeriksaanAyam->id)
@section('topbar_page', 'Detail Pemeriksaan')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-10">

      <!-- Breadcrumbs & Back link -->
      <div class="mb-3 pt-2 d-flex justify-content-between align-items-center">
        <a href="{{ route('pemeriksaan-ayam.index') }}" class="text-decoration-none text-secondary fs-7 fw-medium d-inline-flex align-items-center gap-1.5">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali ke Daftar Pemeriksaan</span>
        </a>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-3" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
          </button>
          <a href="{{ route('pemeriksaan-ayam.edit', $pemeriksaanAyam) }}" class="btn btn-sm btn-outline-secondary rounded-3">
            <i class="bi bi-pencil me-1"></i> Edit Data
          </a>
        </div>
      </div>

      <!-- Detail Card (Veterinary Certificate / Clinical Report) -->
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4 p-md-5 mb-4">
        <!-- Header Info -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 border-bottom pb-4 mb-4">
          <div class="d-flex align-items-center gap-3">
            <div class="p-3 rounded-4 d-flex align-items-center justify-content-center {{ $pemeriksaanAyam->status_klinis === 'kritis' ? 'bg-danger-subtle text-danger' : ($pemeriksaanAyam->status_klinis === 'perlu_pantau' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-success-subtle text-success') }}" style="width: 60px; height: 60px;">
              <i class="bi {{ $pemeriksaanAyam->status_klinis === 'kritis' ? 'bi-shield-exclamation' : ($pemeriksaanAyam->status_klinis === 'perlu_pantau' ? 'bi-exclamation-triangle-fill' : 'bi-shield-check') }} fs-2"></i>
            </div>
            <div>
              <div class="kandang-kicker text-uppercase fw-semibold mb-1" style="font-size: 0.74rem; letter-spacing: 0.12em; color: #728174;">
                OBSERVASI KLINIS HARIAN &middot; RECORD #{{ $pemeriksaanAyam->id }}
              </div>
              <h1 class="kandang-hero-title mb-0" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
                {{ $pemeriksaanAyam->kelompokAyam?->kandang?->nama ?? 'Kandang' }} &mdash; {{ $pemeriksaanAyam->kelompokAyam?->kode }}
              </h1>
              <div class="text-secondary fs-7 mt-1">
                <i class="bi bi-calendar3 me-1"></i> {{ $pemeriksaanAyam->dicatat_pada ? $pemeriksaanAyam->dicatat_pada->translatedFormat('l, d F Y - H:i') . ' WIB' : '-' }}
                &middot; <i class="bi bi-person me-1"></i> Pemeriksa: {{ $pemeriksaanAyam->user?->nama ?? 'Petugas Farm' }}
              </div>
            </div>
          </div>

          <div class="text-md-end">
            @if ($pemeriksaanAyam->status_klinis === 'kritis')
              <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-semibold fs-7 shadow-sm">
                <i class="bi bi-exclamation-octagon-fill me-1"></i> {{ $pemeriksaanAyam->status_klinis_label }}
              </span>
            @elseif ($pemeriksaanAyam->status_klinis === 'perlu_pantau')
              <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold fs-7 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $pemeriksaanAyam->status_klinis_label }}
              </span>
            @else
              <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-semibold fs-7 shadow-sm">
                <i class="bi bi-check-circle-fill me-1"></i> {{ $pemeriksaanAyam->status_klinis_label }}
              </span>
            @endif
          </div>
        </div>

        <!-- Evaluation Banner -->
        <div class="alert {{ $pemeriksaanAyam->status_klinis === 'kritis' ? 'alert-danger' : ($pemeriksaanAyam->status_klinis === 'perlu_pantau' ? 'alert-warning' : 'alert-success') }} border-0 rounded-4 p-4 mb-4">
          <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-lightbulb-fill fs-5"></i>
            <h6 class="fw-bold mb-0">Kesimpulan Diagnosis Veteriner &amp; Inferensi Pakar</h6>
          </div>
          <div class="fs-7">
            {!! $pemeriksaanAyam->indikasi_diagnosa !!}
          </div>
          @if ($pemeriksaanAyam->status_klinis === 'kritis')
            <div class="mt-2 pt-2 border-top border-danger-subtle fs-8 fw-semibold">
              <i class="bi bi-shield-slash me-1"></i> Peringatan Segera: Isolasi kelompok ayam yang terindikasi dan segera berikan elektrolit serta konsultasikan dengan dokter hewan.
            </div>
          @endif
        </div>

        <!-- 6 Clinical Parameters Cards -->
        <h5 class="fw-bold mb-3" style="color: #16241b;">Rincian 6 Parameter Observasi Fisik</h5>
        <div class="row g-3 g-md-4 mb-4">
          <!-- 1. Nafsu Makan -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">🍽️ 1. Nafsu Makan</span>
                <span class="badge {{ $pemeriksaanAyam->nafsu_makan === 'normal' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill">
                  {{ ucfirst($pemeriksaanAyam->nafsu_makan) }}
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->nafsu_makan_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Konsumsi pakan harian kawanan</small>
            </div>
          </div>

          <!-- 2. Aktivitas -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">🏃 2. Aktivitas Gerak</span>
                <span class="badge {{ $pemeriksaanAyam->aktivitas === 'aktif' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }} rounded-pill">
                  {{ ucfirst($pemeriksaanAyam->aktivitas) }}
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->aktivitas_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Kelincahan pergerakan ayam</small>
            </div>
          </div>

          <!-- 3. Kondisi Mata -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">👁️ 3. Kondisi Mata</span>
                <span class="badge {{ $pemeriksaanAyam->kondisi_mata === 'normal' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }} rounded-pill">
                  {{ ucfirst($pemeriksaanAyam->kondisi_mata) }}
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->kondisi_mata_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Indikator iritasi amonia / coryza</small>
            </div>
          </div>

          <!-- 4. Kondisi Bulu -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">🪶 4. Kondisi Bulu</span>
                <span class="badge {{ $pemeriksaanAyam->kondisi_bulu === 'normal' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }} rounded-pill">
                  {{ ucfirst($pemeriksaanAyam->kondisi_bulu) }}
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->kondisi_bulu_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Kerapian dan kilau bulu</small>
            </div>
          </div>

          <!-- 5. Batuk & Bersin -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">🗣️ 5. Batuk &amp; Bersin</span>
                <span class="badge {{ $pemeriksaanAyam->batuk_bersin === 'tidak_ada' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill">
                  Rule R06
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->batuk_bersin_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Sistem saluran pernapasan ayam</small>
            </div>
          </div>

          <!-- 6. Kondisi Kotoran -->
          <div class="col-12 col-md-4">
            <div class="card h-100 border rounded-4 p-3.5 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs-8 text-secondary fw-semibold">💩 6. Kondisi Kotoran</span>
                <span class="badge {{ $pemeriksaanAyam->kondisi_kotoran === 'normal' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill">
                  Rule R07
                </span>
              </div>
              <div class="fw-bold fs-6 text-body mt-2">{{ $pemeriksaanAyam->kondisi_kotoran_formatted }}</div>
              <small class="text-secondary fs-8 mt-1">Feses &amp; saluran pencernaan</small>
            </div>
          </div>
        </div>

        <!-- Catatan Lapangan -->
        <div class="mb-4">
          <h6 class="fw-bold mb-2 text-secondary text-uppercase fs-8">Catatan Petugas Lapangan:</h6>
          <div class="p-3.5 rounded-3 bg-light border fs-7 text-secondary">
            {{ $pemeriksaanAyam->catatan ?: 'Tidak ada catatan tambahan yang dilaporkan.' }}
          </div>
        </div>

        <!-- Footer Actions -->
        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
          <a href="{{ route('pemeriksaan-ayam.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
          </a>

          <div class="d-flex gap-2">
            <a href="{{ route('pemeriksaan-ayam.edit', $pemeriksaanAyam) }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7">
              <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <form action="{{ route('pemeriksaan-ayam.destroy', $pemeriksaanAyam) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemeriksaan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger rounded-3 px-3 py-2 fs-7">
                <i class="bi bi-trash me-1"></i> Hapus
              </button>
            </form>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
@endsection
