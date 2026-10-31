@extends('layouts.adminlte')

@section('title', 'AXION - Data Kelompok Ayam')
@section('topbar_page', 'Kelompok Ayam')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Kelompok Ayam
      </h1>
      
    </div>
  </div>

  <!-- Cards -->
  <div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Total Batch Aktif</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-body">{{ $flocks->where('is_active', true)->count() }}</span>
          <span class="fs-7 text-secondary ms-2">kelompok</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Total Populasi Ayam Hidup</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-success">{{ number_format($flocks->where('is_active', true)->sum('jumlah_ayam')) }}</span>
          <span class="fs-7 text-secondary ms-2">ekor</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Rata-rata Usia Pemeliharaan</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-body">29</span>
          <span class="fs-7 text-secondary ms-2">hari</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <h5 class="fw-bold mb-3">Daftar Kelompok Ayam Terdaftar</h5>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Kode Batch</th>
            <th>Kandang</th>
            <th>Jumlah Populasi</th>
            <th>Tanggal Masuk</th>
            <th>Profil</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($flocks as $flock)
          <tr>
            <td class="fw-bold font-monospace text-primary">{{ $flock->kode }}</td>
            <td class="fw-semibold text-body">{{ $flock->kandang?->nama ?? 'Kandang' }}</td>
            <td><strong>{{ number_format($flock->jumlah_ayam) }}</strong> ekor</td>
            <td>{{ \Carbon\Carbon::parse($flock->tanggal_masuk)->format('d F Y') }}</td>
            <td>{{ $flock->profil ?? 'Campuran' }}</td>
            <td>
              <span class="badge {{ $flock->is_active ? 'bg-success-subtle text-success' : 'bg-secondary' }}">
                {{ $flock->is_active ? 'Aktif' : 'Selesai Panen' }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-secondary">Belum ada kelompok ayam terdaftar.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
