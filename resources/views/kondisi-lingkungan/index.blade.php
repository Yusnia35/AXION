@extends('layouts.adminlte')

@section('title', 'AXION - Kondisi Lingkungan Kandang')
@section('topbar_page', 'Kondisi Lingkungan')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Kondisi Lingkungan
      </h1>
     
    </div>
  </div>

  <!-- Cards Overview -->
  <div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Kondisi Sekam (Litter)</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-2 fw-bold text-success">Kering</span>
          <span class="fs-7 text-secondary ms-2">(Optimal)</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Tingkat Bau Gas Amonia</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-2 fw-bold text-body">Ringan / Samar</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
        <span class="fs-7 text-secondary fw-medium">Kebisingan / Stres Ayam</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-2 fw-bold text-success">Tenang</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <h5 class="fw-bold mb-3">Catatan Observasi Lingkungan</h5>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Waktu Pengecekan</th>
            <th>Kandang</th>
            <th>Bau Amonia</th>
            <th>Kondisi Alas (Litter)</th>
            <th>Tingkat Kebisingan</th>
            <th>Catatan Petugas</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($kondisis as $item)
          <tr>
            <td class="font-monospace text-secondary">{{ \Carbon\Carbon::parse($item->dicatat_pada)->format('d M Y H:i') }}</td>
            <td class="fw-semibold text-body">{{ $item->kandang?->nama ?? 'Kandang A' }}</td>
            <td><span class="badge bg-light text-dark border">{{ ucfirst($item->bau_amonia ?? 'rendah') }}</span></td>
            <td><span class="badge bg-success-subtle text-success">{{ ucfirst($item->kondisi_litter ?? 'kering') }}</span></td>
            <td>{{ ucfirst($item->tingkat_kebisingan ?? 'normal') }}</td>
            <td class="text-secondary">{{ $item->catatan ?: '-' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-secondary">Belum ada data observasi kondisi lingkungan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
