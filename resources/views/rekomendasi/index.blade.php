@extends('layouts.adminlte')

@section('title', 'AXION - Rekomendasi Tindakan Pakar')
@section('topbar_page', 'Rekomendasi Tindakan')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Rekomendasi Tindakan
      </h1>
      
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <a href="{{ route('analisis.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7">
        <i class="bi bi-graph-up-arrow me-1"></i> Lihat Hasil Analisis
      </a>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
      <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-2 text-success"></i>
        <div>
          <strong>Berhasil!</strong> {{ session('success') }}
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Metrics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-3 border">
        <span class="fs-8 fw-semibold text-secondary text-uppercase">Total Rekomendasi</span>
        <div class="d-flex align-items-baseline gap-2 mt-1">
          <span class="fs-2 fw-bold text-dark">{{ $rekomendasis->count() }}</span>
          <span class="fs-8 text-secondary">instruksi</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 border" style="background-color: #fdf5f5;">
        <span class="fs-8 fw-semibold text-danger text-uppercase">Prioritas Tinggi (Mendesak)</span>
        <div class="d-flex align-items-baseline gap-2 mt-1">
          <span class="fs-2 fw-bold text-danger">{{ $rekomendasis->where('prioritas', 'tinggi')->count() }}</span>
          <span class="fs-8 text-danger">butuh tindakan segera</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-3 border" style="background-color: #f4fbf5;">
        <span class="fs-8 fw-semibold text-success text-uppercase">Tindakan Selesai</span>
        <div class="d-flex align-items-baseline gap-2 mt-1">
          <span class="fs-2 fw-bold text-success">{{ $rekomendasis->where('status', 'selesai')->count() }}</span>
          <span class="fs-8 text-success">teratasi</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">Daftar Tindakan Rekomendasi Aktif</h5>
      <span class="badge bg-secondary-subtle text-secondary fs-8">Terhubung ke Analisis Pakar</span>
    </div>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th style="min-width: 130px;">Waktu Terbit</th>
            <th style="min-width: 140px;">Kandang</th>
            <th>Tindakan yang Disarankan</th>
            <th style="min-width: 110px;">Prioritas</th>
            <th style="min-width: 120px;">Status Pengerjaan</th>
            <th style="min-width: 150px;" class="text-end">Tandai Status</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($rekomendasis as $item)
          <tr>
            <td class="font-monospace text-secondary">
              <div>{{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d M Y') }}</div>
              <small class="text-muted">{{ \Carbon\Carbon::parse($item->dibuat_pada)->format('H:i') }} WIB</small>
            </td>
            <td>
              <div class="fw-semibold text-body">{{ $item->analisis?->kandang?->nama ?? 'Kandang' }}</div>
              @if ($item->rule)
                <small class="badge bg-dark-subtle text-dark font-monospace fs-8">{{ $item->rule->kode }}</small>
              @endif
            </td>
            <td class="fw-medium text-body">
              <div class="d-flex align-items-start gap-2">
                <i class="bi bi-shield-exclamation text-warning mt-0.5"></i>
                <span>{{ $item->tindakan }}</span>
              </div>
            </td>
            <td>
              <span class="badge {{ $item->prioritas === 'tinggi' ? 'bg-danger text-white' : ($item->prioritas === 'sedang' ? 'bg-warning text-dark' : 'bg-secondary-subtle text-secondary') }} text-uppercase fs-8">
                {{ $item->prioritas }}
              </span>
            </td>
            <td>
              @php
                $statusBadge = match($item->status) {
                  'selesai' => 'bg-success text-white',
                  'in_progress' => 'bg-primary-subtle text-primary border border-primary-subtle',
                  default => 'bg-secondary-subtle text-secondary',
                };
                $statusLabel = match($item->status) {
                  'selesai' => 'Selesai',
                  'in_progress' => 'Sedang Diproses',
                  default => 'Belum Dikerjakan',
                };
              @endphp
              <span class="badge {{ $statusBadge }} fs-8">
                {{ $statusLabel }}
              </span>
              @if ($item->selesai_pada)
                <div class="text-muted fs-8 mt-0.5">{{ \Carbon\Carbon::parse($item->selesai_pada)->diffForHumans() }}</div>
              @endif
            </td>
            <td class="text-end">
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-2.5 py-1 fs-8" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Ubah Status
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm fs-7">
                  <li>
                    <form action="{{ route('rekomendasi.updateStatus', $item) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="baru">
                      <button type="submit" class="dropdown-item d-flex align-items-center gap-2 {{ $item->status === 'baru' ? 'active' : '' }}">
                        <i class="bi bi-circle text-secondary"></i> Belum Dikerjakan
                      </button>
                    </form>
                  </li>
                  <li>
                    <form action="{{ route('rekomendasi.updateStatus', $item) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="in_progress">
                      <button type="submit" class="dropdown-item d-flex align-items-center gap-2 {{ $item->status === 'in_progress' ? 'active' : '' }}">
                        <i class="bi bi-hourglass-split text-primary"></i> Sedang Dikerjakan
                      </button>
                    </form>
                  </li>
                  <li>
                    <form action="{{ route('rekomendasi.updateStatus', $item) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="selesai">
                      <button type="submit" class="dropdown-item d-flex align-items-center gap-2 {{ $item->status === 'selesai' ? 'active' : '' }}">
                        <i class="bi bi-check-circle-fill text-success"></i> Selesai Ditangani
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-secondary">
              <i class="bi bi-shield-check fs-1 d-block mb-2 text-success"></i>
              Belum ada rekomendasi tindakan aktif. Seluruh kandang dalam kondisi optimal.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
