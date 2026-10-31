@extends('layouts.adminlte')

@section('title', 'AXION - Riwayat Analisis Sistem Pakar')
@section('topbar_page', 'Riwayat Analisis')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Riwayat Analisis
      </h1>
      
    </div>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">Semua Catatan Historis</h5>
      <span class="badge bg-primary-subtle text-primary">Tampilan Data View</span>
    </div>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Waktu</th>
            <th>Kandang</th>
            <th>Kelompok</th>
            <th>Level Risiko</th>
            <th>Status</th>
            <th>Skor Kesehatan</th>
            <th>Suhu</th>
            <th>Kelembapan</th>
            <th>Ringkasan</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($riwayats as $item)
          <tr>
            <td class="font-monospace text-secondary">{{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y H:i') }}</td>
            <td class="fw-bold text-body">{{ $item->kandang }}</td>
            <td>{{ $item->kelompok_ayam ?? 'Semua' }}</td>
            <td>
              <span class="badge {{ $item->level_risiko === 'rendah' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} text-uppercase fs-8">
                {{ $item->level_risiko }}
              </span>
            </td>
            <td>
              <span class="badge {{ $item->status_kandang === 'normal' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ str_replace('_', ' ', ucfirst($item->status_kandang)) }}
              </span>
            </td>
            <td><strong>{{ $item->health_score }}%</strong></td>
            <td>{{ $item->suhu ?? '-' }}°C</td>
            <td>{{ $item->kelembapan ?? '-' }}%</td>
            <td class="text-secondary">{{ $item->ringkasan ?: 'Pemeriksaan rutin' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center py-4 text-secondary">Belum ada catatan riwayat analisis.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
