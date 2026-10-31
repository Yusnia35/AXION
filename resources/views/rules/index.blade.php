@extends('layouts.adminlte')

@section('title', 'AXION - Basis Aturan Sistem Pakar')
@section('topbar_page', 'Basis Aturan Pakar')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Basis Aturan Sistem Pakar
      </h1>
     
    </div>
  </div>

  <!-- Table Rules -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">Daftar Aturan Pakar (Basis Pengetahuan)</h5>
      <span class="badge text-bg-warning">{{ $rules->count() }} Aturan Aktif</span>
    </div>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th style="width: 80px;">Kode</th>
            <th>Nama Aturan & Kesimpulan</th>
            <th style="width: 120px;">Level Risiko</th>
            <th style="width: 100px;" class="text-center">Bobot CF</th>
            <th style="width: 110px;" class="text-center">Pengurang Skor</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @foreach ($rules as $rule)
          <tr>
            <td><span class="badge bg-dark font-monospace">{{ $rule->kode }}</span></td>
            <td>
              <div class="fw-bold text-body">{{ $rule->nama }}</div>
              <small class="text-secondary d-block">{{ $rule->kesimpulan }}</small>
            </td>
            <td>
              @php
                $badgeClass = match($rule->level_risiko) {
                  'rendah' => 'bg-success-subtle text-success',
                  'sedang' => 'bg-warning-subtle text-warning',
                  'tinggi' => 'bg-danger-subtle text-danger',
                  'kritis' => 'bg-danger text-white',
                  default => 'bg-secondary',
                };
              @endphp
              <span class="badge {{ $badgeClass }} text-uppercase fs-8">{{ $rule->level_risiko }}</span>
            </td>
            <td class="text-center font-monospace fw-bold">{{ number_format($rule->bobot_cf, 2) }}</td>
            <td class="text-center text-danger font-monospace fw-bold">-{{ $rule->pengurang_skor }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
