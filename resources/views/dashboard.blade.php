@extends('layouts.adminlte')

@section('title', 'Dashboard - AXION Monitoring Suhu & Sistem Pakar')
@section('topbar_page', 'Dashboard')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
<!--begin::Page Header-->
<div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
  <div class="col-12 col-md-7">
    <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
      Dashboard Monitoring
    </h1>
   
  </div>
  <div class="col-12 col-md-5 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
    <!-- Tombol Hubungkan IoT & ESP32 -->
    <button type="button" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#modalIotConnection" style="background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; border: none;">
      <i class="bi bi-broadcast"></i> Hubungkan IoT & ESP32
    </button>
    <!-- Tombol Bersihkan Data Dummy -->
    <form action="{{ route('sensor.clearDummy') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data dummy telemetri dan analisis? Sistem akan bersih dan siap untuk data real IoT.')">
      @csrf
      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1.5 bg-white shadow-sm">
        <i class="bi bi-trash3"></i> Bersihkan Data Dummy
      </button>
    </form>
  </div>
</div>
<!--end::Page Header-->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;">
  <i class="bi bi-check-circle-fill me-2 fs-6"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!--begin::Row 1 - KPI Cards (Real Dynamic Data)-->
<div class="row g-3 mb-4">
  <!-- Card 1: Flock size -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-white">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-semibold text-secondary">Populasi Ayam</span>
          <span class="kpi-icon-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2C8 2 5 8 5 14a7 7 0 0 0 14 0c0-6-3-12-7-12z"/>
            </svg>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-dark lh-1" style="font-size: 2.25rem !important;">{{ number_format($totalAyam ?? 0) }}</span>
          <span class="fs-7 ms-2 text-secondary">ekor</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          @if(($totalAyam ?? 0) > 0)
            <span class="fw-semibold me-1" style="color: #ea580c;">
              <i class="bi bi-collection me-0.5"></i>{{ $activeFlocksCount ?? 0 }}
            </span>
            <span class="text-secondary">kelompok ayam aktif</span>
          @else
            <span class="text-secondary"><i class="bi bi-info-circle me-1"></i>Belum ada kawanan aktif</span>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Active houses -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-white">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-semibold text-secondary">Kandang Aktif</span>
          <span class="kpi-icon-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
              <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-dark lh-1" style="font-size: 2.25rem !important;">{{ $kandangs->count() }}</span>
          <span class="fs-7 ms-2 text-secondary">kandang</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          @php $onlineCount = $sensors->where('status', 'online')->count(); @endphp
          <span class="d-inline-block rounded-circle me-1.5" id="liveDotKandangSensor" style="width: 7px; height: 7px; background-color: {{ $onlineCount > 0 ? '#16a34a' : '#94a3b8' }};"></span>
          <span class="text-secondary ms-1" id="liveStatusKandangSensor">
            @if($onlineCount > 0)
              {{ $onlineCount }} / {{ $sensors->count() }} sensor online
            @else
              Menunggu sinyal sensor
            @endif
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 3: Real Temperature -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card kpi-card-temp">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-bold" style="color: #c2410c;">Suhu Terkini</span>
          <span class="kpi-icon-badge" style="background-color: #ffffff; color: #ea580c;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"/>
            </svg>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 lh-1" style="font-size: 2.25rem !important; color: #9a3412;" id="liveKpiSuhu">{{ $suhu !== null ? number_format($suhu, 1) : '--' }}</span>
          <span class="fs-7 ms-1 fw-semibold" style="color: #c2410c;">°C</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          <span class="d-inline-block rounded-circle me-1.5" id="liveDotSuhu" style="width: 7px; height: 7px; background-color: {{ $suhu === null ? '#94a3b8' : ($suhu > 32 ? '#dc2626' : ($suhu < 24 ? '#0284c7' : '#16a34a')) }};"></span>
          <span class="ms-1 fw-medium" id="liveStatusSuhu" style="color: {{ $suhu === null ? '#64748b' : '#9a3412' }};">
            @if($suhu === null)
              Menunggu data IoT
            @elseif($suhu > 32)
              Suhu Hangat / Panas (&gt;32°C)
            @elseif($suhu < 24)
              Suhu Dingin (&lt;24°C)
            @else
              Rentang Ideal (24–31°C)
            @endif
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 4: Real Humidity -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="card h-100 border-0 shadow-sm kpi-card bg-white">
      <div class="card-body p-4 d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-semibold text-secondary">Kelembapan Udara (RH)</span>
          <span class="kpi-icon-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"/>
              <path d="M15.56 19.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19s-2-2.31-2.29-3.76c-.29 1.45-1.14 2.84-2.29 3.76s-1.71 2.03-1.71 3.19c0 2.22 1.8 4.05 4 4.05z"/>
            </svg>
          </span>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold fs-1 text-dark lh-1" style="font-size: 2.25rem !important;" id="liveKpiKelembapan">{{ $kelembapan !== null ? round($kelembapan) : '--' }}</span>
          <span class="fs-7 ms-0.5 text-secondary">%</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          <span class="d-inline-block rounded-circle me-1.5" id="liveDotKelembapan" style="width: 7px; height: 7px; background-color: {{ $kelembapan === null ? '#94a3b8' : ($kelembapan > 75 ? '#ea580c' : ($kelembapan < 50 ? '#eab308' : '#16a34a')) }};"></span>
          <span class="text-secondary ms-1" id="liveStatusKelembapan">
            @if($kelembapan === null)
              Belum ada data sensor
            @elseif($kelembapan > 75)
              Kelembapan Tinggi (&gt;75%)
            @elseif($kelembapan < 50)
              Udara Cenderung Kering (&lt;50%)
            @else
              Optimal (50–75%)
            @endif
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end::Row 1-->

<!--begin::Row 2 - Real Dynamic Flock Pulse & Latest Recommendations-->
<div class="row g-4 mb-4">
  <!-- Card 1: Flock Pulse (Expert System Analysis) -->
  <div class="col-12 col-xl-7">
    <div class="card h-100 border-0 shadow-sm editorial-card p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="kicker-label" style="color: #ea580c;">STATUS KAWANAN & SISTEM PAKAR</span>
        @php
          $skor = $latestAnalisis?->health_score ?? null;
          $badgeClass = $skor === null ? 'bg-secondary-subtle text-secondary' : ($skor >= 80 ? 'bg-success-subtle text-success' : ($skor >= 60 ? 'bg-warning-subtle text-warning-emphasis' : 'bg-danger-subtle text-danger'));
          $statusLabel = $skor === null ? 'Menunggu Telemetri' : ($skor >= 80 ? 'Kondisi Prima' : ($skor >= 60 ? 'Perlu Pengawasan' : 'Risiko Tinggi'));
        @endphp
        <span class="badge rounded-pill fw-semibold px-3 py-1.5 d-inline-flex align-items-center {{ $badgeClass }}" id="liveBadgeAnalisis" style="font-size: 0.75rem;">
          <span class="rounded-circle me-1.5" style="width: 6px; height: 6px; background-color: currentColor;"></span> {{ $statusLabel }}
        </span>
      </div>

      <h3 class="card-editorial-title fw-bold text-dark mb-4" id="liveJudulAnalisis" style="font-size: 1.55rem;">
        @if($latestAnalisis)
          {{ $skor >= 80 ? 'Kondisi Kawanan Prima & Terkendali' : ($skor >= 60 ? 'Kondisi Stabil, Perlu Pengawasan' : 'Peringatan: Perlu Tindakan Cepat') }}
        @else
          Sistem AXION Siap Menerima Data IoT
        @endif
      </h3>

      <div class="d-flex align-items-center mb-4 flex-wrap flex-sm-nowrap gap-4">
        <!-- Circular Health Score Gauge -->
        <div class="position-relative d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 124px; height: 124px;">
          @php
            $displaySkor = $skor ?? 100;
            $dashOffset = (1 - ($displaySkor / 100)) * 301.6;
          @endphp
          <svg width="124" height="124" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="48" fill="none" stroke="#ffedd5" stroke-width="10" />
            <circle id="liveGaugeCircle" cx="60" cy="60" r="48" fill="none" stroke="#ea580c" stroke-width="10" stroke-dasharray="301.6" stroke-dashoffset="{{ $dashOffset }}" stroke-linecap="round" transform="rotate(-90 60 60)" style="transition: stroke-dashoffset 0.6s ease;" />
          </svg>
          <div class="position-absolute text-center" style="line-height: 1.1;">
            <div class="fw-bold text-dark" style="font-size: 1.9rem; letter-spacing: -0.02em;">
              <span id="liveValSkor">{{ $skor ?? '--' }}</span>@if($skor !== null)<span style="font-size: 1rem; font-weight: 600; color: #ea580c;">%</span>@endif
            </div>
            <div class="text-secondary" style="font-size: 0.72rem;">skor kesehatan</div>
          </div>
        </div>

        <!-- Diagnostic Text & Link -->
        <div>
          <p class="text-secondary mb-2" id="liveDeskripsiAnalisis" style="font-size: 0.95rem; line-height: 1.55;">
            @if($latestAnalisis)
              {{ $latestAnalisis->ringkasan }}
            @else
              Data telemetri sensor belum tercatat. Hubungkan perangkat ESP32 dengan sensor DHT22 untuk memulai evaluasi inferensi Forward Chaining secara otomatis.
            @endif
          </p>
          <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('monitoring.suhu') }}" class="fw-bold text-decoration-none d-inline-flex align-items-center" style="color: #ea580c; font-size: 0.9rem;">
              Lihat telemetri live <i class="bi bi-chevron-right ms-1 fs-8"></i>
            </a>
            <a href="{{ route('analisis.index') }}" class="fw-bold text-decoration-none text-secondary d-inline-flex align-items-center fs-8">
              Detail Sistem Pakar <i class="bi bi-arrow-up-right ms-1 fs-8"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Bottom Status Pills -->
      <div class="row g-2 pt-3 border-top mt-auto" style="border-color: #ffedd5 !important;">
        <div class="col-4">
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
              <i class="bi bi-shield-check fs-6"></i>
            </div>
            <div>
              <div class="text-secondary" style="font-size: 0.72rem;">Status Kawanan</div>
              <div class="fw-bold text-dark text-truncate" id="liveStatusKawanan" style="font-size: 0.88rem;">
                {{ $latestAnalisis ? ucwords(str_replace('_', ' ', $latestAnalisis->status_kandang)) : 'Standby' }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
              <i class="bi bi-wind fs-6"></i>
            </div>
            <div>
              <div class="text-secondary" style="font-size: 0.72rem;">Ventilasi</div>
              <div class="fw-bold text-dark text-truncate" id="liveStatusVentilasi" style="font-size: 0.88rem;">
                {{ ucfirst($latestMonitoring?->ventilasi ?? 'Normal') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
              <i class="bi bi-activity fs-6"></i>
            </div>
            <div>
              <div class="text-secondary" style="font-size: 0.72rem;">Tingkat Risiko</div>
              <div class="fw-bold text-dark text-truncate" id="liveStatusRisiko" style="font-size: 0.88rem;">
                {{ $latestAnalisis ? ucfirst($latestAnalisis->level_risiko) . ' (' . number_format(($latestAnalisis->cf_gabungan ?? 0) * 100, 0) . '%)' : 'Rendah (0%)' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Real Actionable Insights (Rekomendasi Nyata) -->
  <div class="col-12 col-xl-5">
    <div class="card h-100 border-0 shadow-sm insight-card p-4 position-relative overflow-hidden">
      <!-- Background Curved Lines -->
      <svg class="position-absolute bottom-0 end-0 pointer-events-none" style="width: 180px; height: 180px; margin-bottom: -35px; margin-right: -35px; opacity: 0.22;" viewBox="0 0 100 100">
        <circle cx="100" cy="100" r="95" fill="none" stroke="#ffffff" stroke-width="1.5" />
        <circle cx="100" cy="100" r="70" fill="none" stroke="#ffffff" stroke-width="1.5" />
        <circle cx="100" cy="100" r="45" fill="none" stroke="#ffffff" stroke-width="1.5" />
      </svg>

      <div class="d-flex justify-content-between align-items-center mb-2 position-relative z-1">
        <span class="kicker-label" style="color: rgba(255, 255, 255, 0.9);">REKOMENDASI SISTEM PAKAR</span>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: rgba(255, 255, 255, 0.2); color: #ffffff;">
          <i class="bi bi-shield-check fs-6"></i>
        </div>
      </div>

      <h3 class="card-editorial-title fw-bold text-white mb-2 position-relative z-1" style="font-size: 1.45rem;">
        {{ $rekomendasis->isNotEmpty() ? 'Tindakan Direkomendasikan' : 'Kondisi Terkendali' }}
      </h3>
      <p class="mb-3 position-relative z-1" style="color: rgba(255, 255, 255, 0.92); font-size: 0.85rem; line-height: 1.45;">
        {{ $rekomendasis->isNotEmpty() ? 'Panduan SOP otomatis yang dihasilkan oleh mesin inferensi pakar:' : 'Seluruh indikator mikroklimat kandang saat ini berada dalam rentang aman.' }}
      </p>

      <div class="d-flex flex-column gap-2 mb-4 position-relative z-1">
        @forelse($rekomendasis as $index => $rek)
          <div class="d-flex align-items-baseline">
            <span class="badge rounded-pill me-2.5 flex-shrink-0" style="background: rgba(255, 255, 255, 0.22); color: #ffffff; font-size: 0.75rem;">0{{ $index + 1 }}</span>
            <span style="color: #ffffff; font-size: 0.875rem;">{{ $rek->tindakan ?? $rek->ringkasan }}</span>
          </div>
        @empty
          <div class="d-flex align-items-baseline">
            <span class="badge rounded-pill me-2.5" style="background: rgba(255, 255, 255, 0.22); color: #ffffff; font-size: 0.75rem;">01</span>
            <span style="color: #ffffff; font-size: 0.875rem;">Sensor IoT aktif memantau suhu dan kelembapan setiap detik.</span>
          </div>
          <div class="d-flex align-items-baseline">
            <span class="badge rounded-pill me-2.5" style="background: rgba(255, 255, 255, 0.22); color: #ffffff; font-size: 0.75rem;">02</span>
            <span style="color: #ffffff; font-size: 0.875rem;">Aturan inferensi pakar siap mengevaluasi jika suhu melebihi 32°C.</span>
          </div>
          <div class="d-flex align-items-baseline">
            <span class="badge rounded-pill me-2.5" style="background: rgba(255, 255, 255, 0.22); color: #ffffff; font-size: 0.75rem;">03</span>
            <span style="color: #ffffff; font-size: 0.875rem;">Rekomendasi penyesuaian tirai & ventilasi akan otomatis muncul di sini.</span>
          </div>
        @endforelse
      </div>

      <div class="mt-auto position-relative z-1">
        <a href="{{ route('rekomendasi.index') }}" class="btn btn-sm rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center shadow-sm" style="background: #ffffff; color: #c2410c; border: none;">
          Buka Halaman Solusi Pakar <i class="bi bi-chevron-right ms-1.5 fs-8"></i>
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::Row 2-->

<!--begin::Row 3 - Real Environmental Trends & Kandang-->
<div class="row g-4 mb-4">
  <!-- Card 3: Environmental Trends (Real Dynamic Chart.js) -->
  <div class="col-12 col-xl-7">
    <div class="card h-100 border-0 shadow-sm editorial-card p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <span class="kicker-label" style="color: #ea580c;">TREN TELEMETRI REAL</span>
        <span class="badge rounded-pill px-2.5 py-1" id="liveChartBadge" style="background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 0.72rem;">
          <i class="bi bi-broadcast me-1"></i> Data Sensor Real
        </span>
      </div>

      <h3 class="card-editorial-title fw-bold text-dark mb-3" style="font-size: 1.5rem;">Kondisi Sepanjang Waktu</h3>

      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-3">
          <span class="fs-7 text-secondary">
            <span class="d-inline-block rounded-pill me-1" style="width: 16px; height: 3px; background-color: #ea580c; vertical-align: middle;"></span> Suhu (°C)
          </span>
          <span class="fs-7 text-secondary">
            <span class="d-inline-block rounded-pill me-1" style="width: 16px; height: 3px; background-color: #fb923c; vertical-align: middle;"></span> Kelembapan (%)
          </span>
        </div>

        <div class="dropdown">
          <button class="btn btn-sm text-secondary bg-transparent border-0 d-flex align-items-center py-0 fw-semibold dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <span class="rounded-circle me-1.5" style="width: 7px; height: 7px; background-color: #ea580c;"></span> {{ $kandangs->first()?->nama ?? 'Kandang Utama' }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            @forelse($kandangs as $k)
              <li><a class="dropdown-item {{ $loop->first ? 'active' : '' }}" href="#">{{ $k->nama }}</a></li>
            @empty
              <li><a class="dropdown-item active" href="#">Kandang Utama</a></li>
            @endforelse
          </ul>
        </div>
      </div>

      <div style="height: 220px; position: relative;" class="mt-2">
        <canvas id="environmentalTrendsChart"></canvas>
      </div>
      <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top fs-8 text-secondary" style="border-color: #ffedd5 !important;">
        <span><i class="bi bi-clock-history me-1"></i> Grafik memuat telemetri real yang masuk dari sensor IoT.</span>
        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" style="color: #ea580c;" onclick="refreshChartData()">
          <i class="bi bi-arrow-repeat me-1"></i> Refresh Grafik
        </button>
      </div>
    </div>
  </div>

  <!-- Card 4: Kandang Saya (Dynamic Loop) -->
  <div class="col-12 col-xl-5">
    <div class="card h-100 border-0 shadow-sm editorial-card p-4 d-flex flex-column bg-white">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <span class="kicker-label" style="color: #ea580c;">KANDANG SAYA</span>
        <a href="{{ route('kandang.index') }}" class="btn btn-sm border-0 bg-transparent p-0" style="color: #ea580c;">
          <i class="bi bi-arrow-up-right-circle fs-5"></i>
        </a>
      </div>

      <h3 class="card-editorial-title fw-bold text-dark mb-4" style="font-size: 1.5rem;">{{ $kandangs->count() }} Kandang Terdaftar</h3>

      <div class="d-flex flex-column gap-3 flex-grow-1">
        @forelse($kandangs as $kandangItem)
          @php
            $sensorKandang = $kandangItem->sensors->first();
            $kandangScore = $kandangItem->latestAnalisis?->health_score ?? ($skor ?? 100);
          @endphp
          <div class="p-3 rounded-4 border" style="background-color: #fffbf7; border-color: #fed7aa !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                  <i class="bi bi-house-door-fill fs-5"></i>
                </div>
                <div>
                  <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $kandangItem->nama }}</div>
                  <div class="text-secondary" style="font-size: 0.74rem;">
                    {{ $kandangItem->jenis_ayam ?? 'Broiler' }} &middot; {{ ucwords(str_replace('_', ' ', $kandangItem->tipe_kandang ?? 'open_house')) }}
                    &middot; <span class="{{ ($sensorKandang?->status ?? 'offline') === 'online' ? 'text-success fw-semibold' : 'text-muted' }}">
                      {{ ucfirst($sensorKandang?->status ?? 'offline') }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="text-end">
                <div class="fw-bold lh-1" style="font-size: 1.35rem; color: #ea580c;">{{ $kandangScore }}</div>
                <div class="text-secondary" style="font-size: 0.72rem;">skor</div>
              </div>
            </div>
            <div class="w-100 rounded-pill" style="height: 6px; background-color: #ffedd5; overflow: hidden;">
              <div class="rounded-pill" style="height: 100%; width: {{ min(max($kandangScore, 5), 100) }}%; background: linear-gradient(90deg, #f97316, #ea580c);"></div>
            </div>
          </div>
        @empty
          <div class="text-center py-4 text-secondary">
            <i class="bi bi-house fs-2 text-muted mb-2 d-block"></i>
            Belum ada kandang terdaftar.
          </div>
        @endforelse
      </div>

      <div class="mt-4 pt-2">
        <a href="{{ route('kandang.index') }}" class="text-decoration-none fw-bold d-inline-flex align-items-center" style="color: #ea580c; font-size: 0.88rem;">
          Kelola semua kandang <i class="bi bi-chevron-right ms-1 fs-8"></i>
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::Row 3-->
</div>
<!--end::kandang-page-container-->

<!-- ======================================================== -->
<!-- MODAL: KONEKSI IOT & DOKUMENTASI API ESP32 -->
<!-- ======================================================== -->
<div class="modal fade" id="modalIotConnection" tabindex="-1" aria-labelledby="modalIotConnectionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom pb-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; background: linear-gradient(135deg, #f97316, #ea580c); box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4);">
            <i class="bi bi-broadcast fs-5"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-white mb-0" id="modalIotConnectionLabel">
              Integrasi API & Sensor IoT (ESP32)
            </h5>
            <small class="text-secondary" style="color: #94a3b8 !important;">
              Panduan integrasi telemetri hardware mikrokontroler dengan sistem AXION.
            </small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <!-- API Endpoint Card -->
        <div class="p-3 bg-white rounded-4 border shadow-2xs mb-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fs-8 text-uppercase fw-bold text-secondary">
              <i class="bi bi-link-45deg text-primary me-1"></i> Endpoint API Ingestion Telemetri:
            </span>
            <span class="badge bg-success text-white fs-8">POST</span>
          </div>
          <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between">
            <code class="fs-7 text-dark fw-bold" id="apiUrlDisplay">{{ url('/api/iot/telemetry') }}</code>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5 fs-8" onclick="copyApiUrl()">
              <i class="bi bi-clipboard me-1"></i> Salin URL
            </button>
          </div>
        </div>

        <!-- Uji Coba Langsung (Simulasi Pengiriman Data Real) -->
        <div class="p-3 bg-white rounded-4 border shadow-2xs mb-3">
          <h6 class="fw-bold text-dark mb-1"><i class="bi bi-send-check text-orange me-1.5" style="color: #ea580c;"></i> Uji Coba Pengiriman Data (Simulasi IoT)</h6>
          <p class="text-secondary fs-8 mb-3">Kirim payload data telemetri langsung ke API untuk menguji koneksi dan memicu Sistem Pakar:</p>
          <div class="row g-2 mb-3">
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold mb-1">Kandang Target</label>
              <select class="form-select form-select-sm rounded-3" id="testKandangId">
                @foreach($kandangs as $kd)
                  <option value="{{ $kd->id }}">{{ $kd->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold mb-1">Suhu (°C)</label>
              <input type="number" step="0.1" class="form-control form-control-sm rounded-3" id="testSuhu" value="30.5">
            </div>
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold mb-1">Kelembapan (%)</label>
              <input type="number" step="0.1" class="form-control form-control-sm rounded-3" id="testKelembapan" value="70.0">
            </div>
            <div class="col-6 col-md-3 d-flex align-items-end">
              <button type="button" class="btn btn-sm w-100 rounded-3 text-white fw-semibold" id="btnKirimTestIot" onclick="kirimTestIot()" style="background: linear-gradient(135deg, #f97316, #ea580c); height: 32px;">
                <i class="bi bi-play-fill me-1"></i> Kirim ke API
              </button>
            </div>
          </div>
          <div id="testResultBox" class="p-2.5 rounded-3 border d-none" style="background-color: #f8fafc; font-size: 0.78rem;"></div>
        </div>

        <!-- Arduino C++ Code Snippet -->
        <div class="p-3 bg-white rounded-4 border shadow-2xs mb-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fs-8 text-uppercase fw-bold text-secondary">
              <i class="bi bi-cpu text-primary me-1"></i> Contoh Source Code ESP32 + DHT22 (Arduino IDE):
            </span>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5 fs-8" onclick="copyArduinoCode()">
              <i class="bi bi-clipboard me-1"></i> Salin Kode C++
            </button>
          </div>
          <pre class="p-3 rounded-3 border bg-dark text-light mb-0" style="font-size: 0.76rem; max-height: 260px; overflow-y: auto;"><code id="arduinoCodeText">#include &lt;WiFi.h&gt;
#include &lt;HTTPClient.h&gt;
#include &lt;DHT.h&gt;

#define DHTPIN 4
#define DHTTYPE DHT22

const char* ssid = "NAMA_WIFI_ANDA";
const char* password = "PASSWORD_WIFI";
const char* serverUrl = "{{ url('/api/iot/telemetry') }}";

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  dht.begin();
  
  WiFi.begin(ssid, password);
  Serial.print("Menghubungkan ke WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung! IP: " + WiFi.localIP().toString());
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    float suhu = dht.readTemperature();
    float kelembapan = dht.readHumidity();

    if (isnan(suhu) || isnan(kelembapan)) {
      Serial.println("Gagal membaca dari sensor DHT22!");
      delay(3000);
      return;
    }

    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/json");

    String jsonPayload = "{\"kandang_id\": 1, \"suhu\": " + String(suhu, 1) + ", \"kelembapan\": " + String(kelembapan, 1) + ", \"ventilasi\": \"baik\", \"kebersihan\": \"baik\"}";

    int httpResponseCode = http.POST(jsonPayload);
    Serial.print("Mengirim: ");
    Serial.println(jsonPayload);
    Serial.print("Respon HTTP: ");
    Serial.println(httpResponseCode);

    http.end();
  }
  delay(10000); // Kirim telemetri setiap 10 detik
}</code></pre>
        </div>
      </div>

      <div class="modal-footer bg-light border-top">
        <button type="button" class="btn btn-secondary rounded-pill px-4 py-2 fs-7" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Floating "Tanya AXION" Button -->
<button type="button" class="btn shadow-lg rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center ask-axion-floating" data-bs-toggle="offcanvas" data-bs-target="#askAxionOffcanvas" aria-controls="askAxionOffcanvas" style="position: fixed; bottom: 28px; right: 28px; background: linear-gradient(135deg, #f97316, #ea580c); color: #ffffff; z-index: 1040; box-shadow: 0 8px 24px rgba(234, 88, 12, 0.4) !important; border: none; cursor: pointer;">
  <i class="bi bi-robot fs-5 me-2"></i> Tanya AXION
</button>

<!--begin::Ask AXION Offcanvas Drawer-->
<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="askAxionOffcanvas" aria-labelledby="askAxionLabel" style="width: 390px; z-index: 1060;">
  <div class="offcanvas-header border-bottom py-3" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);">
    <div class="d-flex align-items-center gap-2">
      <div class="p-2 rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #f97316, #ea580c);">
        <i class="bi bi-robot fs-5"></i>
      </div>
      <div>
        <h6 class="offcanvas-title fw-bold text-dark mb-0" id="askAxionLabel" style="font-family: 'Outfit', sans-serif;">AXION AI Assistant</h6>
        <small class="text-secondary fs-8">Pakar Mikroklimat & Pemeliharaan Ayam</small>
      </div>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-4 d-flex flex-column justify-content-between" style="background-color: #fffaf5;">
    <div>
      <div class="alert border-0 rounded-4 p-3 fs-7 mb-3 shadow-2xs" style="background-color: #ffffff; border-left: 4px solid #ea580c !important; color: #334155;">
        <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-1.5">
          <i class="bi bi-stars text-warning"></i> Halo Peternak!
        </div>
        Saya asisten pintar AXION. Anda bisa menanyakan kondisi suhu, kelembaban, kesehatan ayam, serta rekomendasi tindakan kandang secara langsung.
      </div>

      <div class="mb-3">
        <label class="fs-8 fw-bold text-uppercase text-secondary tracking-wide mb-2 d-block">Pertanyaan Cepat</label>
        <div class="d-flex flex-column gap-2">
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-white shadow-2xs border-0" onclick="setDashboardQuickPrompt('Bagaimana kondisi suhu dan kelembaban kandang saat ini?')">
            🌡️ Bagaimana kondisi suhu & kelembaban saat ini?
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-white shadow-2xs border-0" onclick="setDashboardQuickPrompt('Apakah ayam berisiko heat stress hari ini?')">
            🐔 Apakah ayam berisiko heat stress hari ini?
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-white shadow-2xs border-0" onclick="setDashboardQuickPrompt('Rekomendasi tindakan apa yang perlu dilakukan?')">
            💨 Rekomendasi ventilasi & tindakan apa yang perlu dilakukan?
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary text-start rounded-3 p-2 fs-7 bg-white shadow-2xs border-0" onclick="setDashboardQuickPrompt('Berapa total populasi ayam yang aktif?')">
            📊 Berapa total populasi ayam yang aktif?
          </button>
        </div>
      </div>

      <div id="aiDashboardChatOutput" class="p-3 rounded-4 bg-white fs-7 text-secondary border shadow-2xs mb-3" style="min-height: 140px; font-size: 0.85rem; line-height: 1.6;">
        <span class="text-muted"><i class="bi bi-chat-dots me-1"></i> Pilih pertanyaan cepat di atas atau ketik pertanyaan Anda di bawah.</span>
      </div>
    </div>

    <div>
      <div class="input-group shadow-sm rounded-pill overflow-hidden border" style="border-color: #fed7aa !important;">
        <input type="text" id="aiDashboardInputPrompt" class="form-control border-0 px-3.5 fs-7" placeholder="Tanyakan seputar kandang..." onkeypress="if(event.key === 'Enter') submitDashboardAiPrompt()">
        <button class="btn text-white px-3.5" type="button" style="background: linear-gradient(135deg, #f97316, #ea580c); border: none;" onclick="submitDashboardAiPrompt()">
          <i class="bi bi-send-fill"></i>
        </button>
      </div>
    </div>
  </div>
</div>
<!--end::Ask AXION Offcanvas Drawer-->

@push('styles')
<style>
  .kpi-card {
    border-radius: 18px !important;
    border: 1px solid #ffedd5 !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(234, 88, 12, 0.08) !important;
  }
  .kpi-icon-badge {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background-color: #fff7ed;
    color: #ea580c;
    border: 1px solid #fed7aa;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .kpi-card-temp {
    background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%) !important;
    border: 1.5px solid #fdba74 !important;
  }
  .editorial-card {
    border-radius: 20px !important;
    border: 1px solid #ffedd5 !important;
    background-color: #ffffff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .editorial-card:hover {
    box-shadow: 0 10px 26px rgba(234, 88, 12, 0.07) !important;
  }
  .card-editorial-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.02em;
    line-height: 1.25;
  }
  .kicker-label {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
  }
  .insight-card {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 55%, #c2410c 100%) !important;
    border-radius: 20px !important;
    border: 1.5px solid #ea580c !important;
    color: #ffffff !important;
    box-shadow: 0 12px 28px rgba(234, 88, 12, 0.28) !important;
  }
  .ask-axion-floating {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .ask-axion-floating:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #ea580c, #c2410c) !important;
    box-shadow: 0 12px 28px rgba(234, 88, 12, 0.5) !important;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let trendsChart = null;

// Initialize dynamic Real Data from Controller
const initialChartLabels = @json($chartLabels);
const initialChartSuhu = @json($chartSuhu);
const initialChartKelembapan = @json($chartKelembapan);

document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('environmentalTrendsChart');
  if (!ctx) return;

  const gridColor = 'rgba(234, 88, 12, 0.08)';
  const textColor = '#64748b';

  const defaultLabels = initialChartLabels.length > 0 ? initialChartLabels : ['Menunggu Telemetri Sensor'];
  const defaultSuhu = initialChartSuhu.length > 0 ? initialChartSuhu : [0];
  const defaultKelembapan = initialChartKelembapan.length > 0 ? initialChartKelembapan : [0];

  trendsChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: defaultLabels,
      datasets: [
        {
          label: 'Suhu (°C)',
          data: defaultSuhu,
          borderColor: '#ea580c',
          backgroundColor: function(context) {
            const chartArea = context.chart.chartArea;
            if (!chartArea) return 'rgba(234, 88, 12, 0.12)';
            const gradient = context.chart.ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
            gradient.addColorStop(0, 'rgba(234, 88, 12, 0.24)');
            gradient.addColorStop(1, 'rgba(234, 88, 12, 0.0)');
            return gradient;
          },
          fill: true,
          tension: 0.35,
          borderWidth: 2.5,
          pointRadius: defaultLabels.length > 1 ? 3 : 0,
          pointHoverRadius: 6,
        },
        {
          label: 'Kelembapan (%)',
          data: defaultKelembapan,
          borderColor: '#fb923c',
          borderDash: [5, 5],
          backgroundColor: 'transparent',
          fill: false,
          tension: 0.35,
          borderWidth: 2.2,
          pointRadius: defaultLabels.length > 1 ? 3 : 0,
          pointHoverRadius: 6,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          backgroundColor: '#0f172a',
          titleColor: '#fff',
          bodyColor: '#cbd5e1',
          padding: 10,
          cornerRadius: 8
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: textColor,
            font: {
              size: 11
            }
          }
        },
        y: {
          min: 0,
          max: 100,
          ticks: {
            stepSize: 20,
            color: textColor,
            font: {
              size: 11
            }
          },
          grid: {
            color: gridColor,
            borderDash: [4, 4]
          },
          border: {
            display: false
          }
        }
      }
    }
  });

  // Start polling every 8 seconds for real-time telemetry updates
  setInterval(pollLatestTelemetry, 8000);
});

// Real-time polling function
function pollLatestTelemetry() {
  fetch('{{ route('api.iot.telemetry.latest') }}')
    .then(res => res.json())
    .then(res => {
      if (!res.success || !res.has_data) return;

      const data = res.data;
      // Update Suhu KPI
      const suhuEl = document.getElementById('liveKpiSuhu');
      if (suhuEl) suhuEl.textContent = Number(data.suhu).toFixed(1);

      const dotSuhu = document.getElementById('liveDotSuhu');
      const statusSuhu = document.getElementById('liveStatusSuhu');
      if (dotSuhu && statusSuhu) {
        dotSuhu.style.backgroundColor = data.suhu > 32 ? '#dc2626' : (data.suhu < 24 ? '#0284c7' : '#16a34a');
        statusSuhu.textContent = data.status_suhu;
        statusSuhu.style.color = '#9a3412';
      }

      // Update Kelembapan KPI
      const kelembapanEl = document.getElementById('liveKpiKelembapan');
      if (kelembapanEl) kelembapanEl.textContent = Math.round(data.kelembapan);

      const dotKelembapan = document.getElementById('liveDotKelembapan');
      const statusKelembapan = document.getElementById('liveStatusKelembapan');
      if (dotKelembapan && statusKelembapan) {
        dotKelembapan.style.backgroundColor = data.kelembapan > 75 ? '#ea580c' : (data.kelembapan < 50 ? '#eab308' : '#16a34a');
        statusKelembapan.textContent = data.status_kelembapan;
      }

      // Update Expert System Card
      if (data.analisis) {
        const skorEl = document.getElementById('liveValSkor');
        if (skorEl) skorEl.textContent = data.analisis.skor_kesehatan;

        const circleEl = document.getElementById('liveGaugeCircle');
        if (circleEl) {
          const dashOffset = (1 - (data.analisis.skor_kesehatan / 100)) * 301.6;
          circleEl.setAttribute('stroke-dashoffset', dashOffset);
        }

        const descEl = document.getElementById('liveDeskripsiAnalisis');
        if (descEl && data.analisis.ringkasan) descEl.textContent = data.analisis.ringkasan;

        const statusKawanan = document.getElementById('liveStatusKawanan');
        if (statusKawanan) statusKawanan.textContent = data.analisis.status_kandang;

        const statusRisiko = document.getElementById('liveStatusRisiko');
        if (statusRisiko) statusRisiko.textContent = data.analisis.level_risiko;
      }
    })
    .catch(err => console.log('Polling telemetry error:', err));
}

// Function to refresh chart dynamically from API history
function refreshChartData() {
  fetch('{{ route('api.iot.telemetry.history') }}?limit=14')
    .then(res => res.json())
    .then(res => {
      if (!res.success || !trendsChart) return;
      if (res.labels && res.labels.length > 0) {
        trendsChart.data.labels = res.labels;
        trendsChart.data.datasets[0].data = res.suhu;
        trendsChart.data.datasets[1].data = res.kelembapan;
        trendsChart.update();
      }
    })
    .catch(err => console.log('Refresh chart error:', err));
}

// Function to copy API URL
function copyApiUrl() {
  const url = document.getElementById('apiUrlDisplay').textContent.trim();
  navigator.clipboard.writeText(url).then(() => {
    alert('URL API berhasil disalin ke clipboard:\n' + url);
  });
}

// Function to copy Arduino C++ code
function copyArduinoCode() {
  const code = document.getElementById('arduinoCodeText').textContent;
  navigator.clipboard.writeText(code).then(() => {
    alert('Kode program Arduino C++ ESP32 berhasil disalin!');
  });
}

// Function to test send telemetry directly to API
function kirimTestIot() {
  const btn = document.getElementById('btnKirimTestIot');
  const resultBox = document.getElementById('testResultBox');
  const kandangId = document.getElementById('testKandangId').value;
  const suhu = parseFloat(document.getElementById('testSuhu').value);
  const kelembapan = parseFloat(document.getElementById('testKelembapan').value);

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';
  resultBox.classList.remove('d-none');
  resultBox.className = 'p-2.5 rounded-3 border bg-light text-secondary';
  resultBox.textContent = 'Mengirimkan payload ke API...';

  fetch('{{ route('api.iot.telemetry.store') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      kandang_id: kandangId,
      suhu: suhu,
      kelembapan: kelembapan,
      ventilasi: 'baik',
      kebersihan: 'baik'
    })
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-play-fill me-1"></i> Kirim ke API';
    if (data.success) {
      resultBox.className = 'p-2.5 rounded-3 border bg-success-subtle text-success fw-semibold';
      resultBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Berhasil! ' + data.message + '<br><small class="text-dark">Suhu: ' + data.data.telemetri.suhu + '°C | Kelembapan: ' + data.data.telemetri.kelembapan + '% | Skor Pakar: ' + data.data.hasil_pakar.skor_kesehatan + '% (' + data.data.hasil_pakar.level_risiko + ')</small>';
      
      // Update chart & live cards immediately
      refreshChartData();
      pollLatestTelemetry();
    } else {
      resultBox.className = 'p-2.5 rounded-3 border bg-danger-subtle text-danger';
      resultBox.textContent = 'Gagal: ' + (data.message || 'Terjadi kesalahan');
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-play-fill me-1"></i> Kirim ke API';
    resultBox.className = 'p-2.5 rounded-3 border bg-danger-subtle text-danger';
    resultBox.textContent = 'Error koneksi: ' + err.message;
  });
}

function setDashboardQuickPrompt(text) {
  const input = document.getElementById('aiDashboardInputPrompt');
  if (input) {
    input.value = text;
    submitDashboardAiPrompt();
  }
}

function submitDashboardAiPrompt() {
  const input = document.getElementById('aiDashboardInputPrompt');
  const output = document.getElementById('aiDashboardChatOutput');
  if (!input || !output) return;
  const query = input.value.trim();
  if (!query) return;

  output.innerHTML = `<div class="d-flex align-items-center gap-2 text-primary py-2"><div class="spinner-border spinner-border-sm" role="status"></div><span>AXION AI sedang menganalisis data telemetri kandang...</span></div>`;

  setTimeout(() => {
    let response = '';
    const qLower = query.toLowerCase();
    const curSuhu = {{ $suhu !== null ? number_format($suhu, 1, '.', '') : '28.5' }};
    const curRh = {{ $kelembapan !== null ? number_format($kelembapan, 1, '.', '') : '65.0' }};
    const totalAyamCount = {{ $totalAyam ?? 0 }};
    const flockCount = {{ $activeFlocksCount ?? 0 }};

    if (qLower.includes('suhu') || qLower.includes('kelembaban') || qLower.includes('kondisi')) {
      const statusSuhu = curSuhu > 32 
        ? '<span class="badge bg-danger">Tinggi (Waspada Heat Stress)</span>' 
        : (curSuhu < 26 ? '<span class="badge bg-info text-dark">Dingin</span>' : '<span class="badge bg-success">Optimal (Zona Nyaman)</span>');
      response = `<strong>Data Telemetri Mikroklimat Terkini:</strong><br>&bull; Suhu Udara: <strong>${curSuhu}°C</strong> &mdash; ${statusSuhu}<br>&bull; Kelembaban: <strong>${curRh}%</strong> (Standar ideal 60%–70%)<br>&bull; Status Sensor: <em>Aktif & tersinkronisasi via IoT ESP32</em>.`;
    } else if (qLower.includes('heat stress') || qLower.includes('panas') || qLower.includes('risiko') || qLower.includes('kesehatan')) {
      if (curSuhu > 32) {
        response = `<strong>Peringatan Risiko Heat Stress:</strong><br>Suhu kandang terpantau <strong>${curSuhu}°C</strong> yang melebihi ambang batas nyaman 30°C. Ayam berpotensi mengalami panting (terengah-engah), konsumsi pakan menurun, dan dehidrasi. Segera nyalakan exhaust blower dan cooling pad!`;
      } else {
        response = `<strong>Status Risiko Kesehatan Ayam:</strong><br>Suhu saat ini <strong>${curSuhu}°C</strong> berada dalam rentang toleransi normal. Tidak terdeteksi indikasi heat stress ekstrem pada kawanan ayam. Tetap pantau sirkulasi udara berkala.`;
      }
    } else if (qLower.includes('ventilasi') || qLower.includes('tindakan') || qLower.includes('rekomendasi')) {
      if (curSuhu > 30) {
        response = `<strong>Rekomendasi Ventilasi AXION:</strong><br>&bull; Maksimalkan kecepatan kipas exhaust blower.<br>&bull; Pastikan inlet tirai terbuka sesuai target pertukaran udara minimum.<br>&bull; Sediakan air minum bersuhu sejuk dan campurkan elektrolit/vitamin anti-stress.`;
      } else {
        response = `<strong>Rekomendasi Operasional:</strong><br>&bull; Pertahankan ventilasi minimum untuk pasokan oksigen dan pembuangan amonia.<br>&bull; Cek kebersihan litter/sekam agar tetap kering.<br>&bull; Pencatatan sensor DHT22 berjalan otomatis setiap 10 detik.`;
      }
    } else if (qLower.includes('populasi') || qLower.includes('ayam') || qLower.includes('flok') || qLower.includes('jumlah')) {
      response = `<strong>Data Populasi Peternakan:</strong><br>&bull; Total Populasi: <strong>${totalAyamCount.toLocaleString('id-ID')} ekor</strong> ayam aktif.<br>&bull; Jumlah Flok Aktif: <strong>${flockCount} kelompok ayam</strong>.<br>&bull; Tercatat di database AXION Monitoring.`;
    } else {
      response = `<strong>Asisten AXION:</strong><br>Terima kasih atas pertanyaan Anda mengenai "<em>${query}</em>".<br>Saat ini suhu kandang <strong>${curSuhu}°C</strong>, kelembaban <strong>${curRh}%</strong>, dan total populasi <strong>${totalAyamCount.toLocaleString('id-ID')} ekor</strong>. Jika ada indikasi gejala klinis pada ayam, Anda juga dapat menggunakan menu <em>Pemeriksaan Ayam</em> untuk diagnosa Forward Chaining.`;
    }
    output.innerHTML = response;
  }, 450);
}
</script>
@endpush
@endsection
