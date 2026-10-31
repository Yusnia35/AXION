@extends('layouts.adminlte')

@section('title', 'AXION - Detail ' . $kandang->nama)
@section('topbar_page', 'Detail ' . $kandang->nama)
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Back Link -->
  <div class="mb-3 pt-2">
    <a href="{{ route('kandang.index') }}" class="text-decoration-none text-secondary fs-7 fw-medium d-inline-flex align-items-center gap-1.5">
      <i class="bi bi-arrow-left"></i>
      <span>Kembali ke Daftar Kandang</span>
    </a>
  </div>

  <!-- Header Section -->
  <div class="card border-0 shadow-sm rounded-4 bg-body mb-4 p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="p-3 rounded-3 d-flex align-items-center justify-content-center" style="background-color: #f7eee2; color: #b48348; width: 56px; height: 56px;">
          <i class="bi bi-house fs-2"></i>
        </div>
        <div>
          <div class="kandang-kicker text-uppercase fw-semibold mb-1">
            {{ $kandang->jenis_ayam }} &middot; {{ $kandang->tipe_kandang_formatted }}
          </div>
          <h1 class="kandang-hero-title mb-0" style="font-size: 2.2rem;">
            {{ $kandang->nama }}
          </h1>
          <span class="text-secondary fs-7">
            <i class="bi bi-geo-alt me-1"></i> {{ $kandang->lokasi ?: 'Lokasi belum disetel' }}
          </span>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('kandang.edit', $kandang) }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7 fw-semibold">
          <i class="bi bi-pencil me-1"></i> Edit Kandang
        </a>
        <a href="{{ route('kandang.index') }}" class="btn btn-tambah-kandang px-3 py-2 fs-7">
          <i class="bi bi-grid me-1"></i> Semua Kandang
        </a>
      </div>
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body p-3">
        <span class="stat-summary-label">Kapasitas Maksimal</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="stat-summary-number">{{ number_format($kandang->kapasitas, 0, ',', '.') }}</span>
          <span class="stat-summary-unit ms-2">ekor</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body p-3">
        <span class="stat-summary-label">Populasi Ayam Saat Ini</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="stat-summary-number">{{ number_format($kandang->total_ayam, 0, ',', '.') }}</span>
          <span class="stat-summary-unit ms-2">ekor</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body p-3">
        <span class="stat-summary-label">Tingkat Kepadatan / Terisi</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="stat-summary-number">{{ $kandang->persentase_terisi }}</span>
          <span class="stat-summary-unit ms-1">%</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <div class="card h-100 border-0 stat-summary-card bg-body p-3">
        <span class="stat-summary-label">Skor Kesehatan Terbaru</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="stat-summary-number">{{ $kandang->health_score }}</span>
          <span class="stat-summary-unit ms-1">/100</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Information -->
  <div class="row g-4">
    <!-- Active Flock -->
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <h5 class="fw-bold text-body mb-3">
          <i class="bi bi-people me-2 text-success"></i> Kelompok Ayam Aktif
        </h5>
        @if ($kandang->kelompokAyams->isEmpty())
        <div class="text-center py-4 text-secondary">
          <p class="mb-0 fs-7">Belum ada kelompok ayam yang dimasukkan ke kandang ini.</p>
        </div>
        @else
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light fs-8 text-uppercase">
              <tr>
                <th>Kode Kelompok</th>
                <th>Jumlah Ayam</th>
                <th>Tanggal Masuk</th>
                <th>Profil</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody class="fs-7">
              @foreach ($kandang->kelompokAyams as $flock)
              <tr>
                <td class="fw-bold font-monospace">{{ $flock->kode }}</td>
                <td>{{ number_format($flock->jumlah_ayam) }} ekor</td>
                <td>{{ \Carbon\Carbon::parse($flock->tanggal_masuk)->format('d M Y') }}</td>
                <td>{{ $flock->profil }}</td>
                <td>
                  <span class="badge {{ $flock->is_active ? 'bg-success-subtle text-success' : 'bg-secondary' }}">
                    {{ $flock->is_active ? 'Aktif' : 'Selesai' }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>

    <!-- Analisis & Status -->
    <div class="col-12 col-lg-5">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <h5 class="fw-bold text-body mb-3">
          <i class="bi bi-shield-check me-2 text-primary"></i> Status & Diagnosa Pakar
        </h5>
        <div class="p-3 rounded-3 mb-3" style="background-color: #f8faf8; border: 1px solid #e2ebe3;">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fs-8 text-secondary">Kondisi Kandang</span>
            <span class="badge {{ $kandang->status_kandang === 'perlu_pantau' ? 'bg-warning text-dark' : 'bg-success' }}">
              {{ strtoupper(str_replace('_', ' ', $kandang->status_kandang)) }}
            </span>
          </div>
          <div class="fs-7 text-secondary">
            {{ $kandang->latestAnalisis?->ringkasan ?: 'Kondisi mikroklimat stabil, seluruh parameter sensor normal.' }}
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center fs-7 text-secondary pt-2">
          <span>Terakhir dianalisis</span>
          <span class="fw-semibold text-body">
            {{ $kandang->latestAnalisis?->dibuat_pada ? \Carbon\Carbon::parse($kandang->latestAnalisis->dibuat_pada)->diffForHumans() : 'Baru saja' }}
          </span>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
