@extends('layouts.adminlte')

@section('title', 'AXION - Laporan & Ekspor Data')
@section('topbar_page', 'Laporan & Ekspor')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
     
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Laporan & Ekspor
      </h1>
      
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <button type="button" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak Laporan
      </button>
    </div>
  </div>

  <!-- Cards -->
  <div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Total Unit Kandang</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-body">{{ $kandangs->count() }}</span>
          <span class="fs-7 text-secondary ms-2">kandang aktif</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Total Populasi Terdata</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-success">{{ number_format($totalAyam) }}</span>
          <span class="fs-7 text-secondary ms-2">ekor ayam</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Total Sesi Analisis</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-body">{{ $totalAnalisis }}</span>
          <span class="fs-7 text-secondary ms-2">diagnosa</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Rekap Per Kandang -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4 mb-4">
    <h5 class="fw-bold mb-3">Rekapitulasi Operasional Per Kandang</h5>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Kandang</th>
            <th>Tipe Bangunan</th>
            <th>Kapasitas</th>
            <th>Populasi Aktif</th>
            <th>Tingkat Kepadatan</th>
            <th>Skor Kesehatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @foreach ($kandangs as $kandang)
          <tr>
            <td class="fw-bold text-body">{{ $kandang->nama }}</td>
            <td>{{ $kandang->tipe_kandang_formatted }}</td>
            <td>{{ number_format($kandang->kapasitas) }} ekor</td>
            <td>{{ number_format($kandang->total_ayam) }} ekor</td>
            <td>
              <span class="badge {{ $kandang->persentase_terisi > 90 ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' }}">
                {{ $kandang->persentase_terisi }}%
              </span>
            </td>
            <td><strong>{{ $kandang->health_score }}</strong> /100</td>
            <td>
              <a href="{{ route('kandang.show', $kandang) }}" class="btn btn-sm btn-light border rounded-3 px-2 py-1 fs-8">
                <i class="bi bi-eye me-1"></i> Detail
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
