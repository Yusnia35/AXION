@extends('layouts.adminlte')

@section('title', 'AXION - Monitoring Suhu & Kelembapan')
@section('topbar_page', 'Monitoring Suhu')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-7">
      
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Monitoring Suhu & Kelembapan
      </h1>
      
    </div>
    <div class="col-12 col-md-5 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
      <!-- Tombol Hasil Diagnosa Utama -->
      <button type="button" class="btn btn-primary rounded-3 px-3.5 py-2 fs-7 fw-semibold shadow-sm d-inline-flex align-items-center" onclick="bukaModalDiagnosa({{ $suhu ?? 28.0 }}, {{ $kelembapan ?? 65.0 }}, '{{ $latest?->kandang?->nama ?? 'Kandang Utama' }}', 'Sensor Terkini')" style="background: linear-gradient(135deg, #f97316, #ea580c); border: none; color: #ffffff;">
        <i class="bi bi-robot fs-6 me-1.5"></i> Hasil Diagnosa Pakar
      </button>
      <a href="{{ route('sensor.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7">
        <i class="bi bi-broadcast me-1"></i> Pengaturan IoT & API
      </a>
      <a href="{{ route('kandang.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7">
        <i class="bi bi-house me-1"></i> Daftar Kandang
      </a>
    </div>
  </div>

  <!-- Telemetry Live Gauges -->
  <div class="row g-3 g-xl-4 mb-3">
    <div class="col-12 col-md-6">
      <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #fdf6ec; border: 1px solid #fae7cb !important;">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-semibold" style="color: #a06325;">Suhu Kandang Terkini</span>
          <i class="bi bi-thermometer-half fs-4" style="color: #a06325;"></i>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold display-4 lh-1" style="color: #16241b;">{{ $suhu !== null ? number_format($suhu, 1) : '--' }}</span>
          <span class="fs-4 ms-2 text-secondary">°C</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          <span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background-color: {{ $suhu === null ? '#94a3b8' : ($suhu > 32 ? '#d97706' : ($suhu < 24 ? '#0284c7' : '#16a34a')) }};"></span>
          <span class="text-secondary ms-1">
            @if($suhu === null)
              Menunggu sinyal sensor IoT
            @elseif($suhu > 32)
              Suhu Hangat / Panas (&gt;32°C)
            @elseif($suhu < 24)
              Suhu Terlalu Dingin (&lt;24°C)
            @else
              Rentang Suhu Nyaman (24-31°C)
            @endif
          </span>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4 border">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fs-7 fw-semibold text-secondary">Kelembapan Udara (RH)</span>
          <i class="bi bi-droplet-half fs-4 text-primary"></i>
        </div>
        <div class="d-flex align-items-baseline my-1">
          <span class="fw-bold display-4 lh-1 text-body">{{ $kelembapan !== null ? round($kelembapan) : '--' }}</span>
          <span class="fs-4 ms-2 text-secondary">%</span>
        </div>
        <div class="d-flex align-items-center fs-7 mt-2">
          <span class="d-inline-block rounded-circle me-1.5" style="width: 8px; height: 8px; background-color: {{ $kelembapan === null ? '#94a3b8' : ($kelembapan > 75 ? '#ea580c' : ($kelembapan < 50 ? '#eab308' : '#16a34a')) }};"></span>
          <span class="text-secondary ms-1">
            @if($kelembapan === null)
              Belum ada data sensor
            @elseif($kelembapan > 75)
              Kelembapan Tinggi (&gt;75%)
            @elseif($kelembapan < 50)
              Udara Cenderung Kering (&lt;50%)
            @else
              Taraf Kelembapan Normal (50-75%)
            @endif
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Live Quick Diagnosa Card Banner -->
  <div class="card border-0 shadow-sm rounded-4 p-3.5 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #fffbf7 100%); border: 1.5px solid #fed7aa !important;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
      <div class="d-flex align-items-start gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 44px; height: 44px; background: linear-gradient(135deg, #f97316, #ea580c); box-shadow: 0 4px 12px rgba(234, 88, 12, 0.28);">
          <i class="bi bi-robot fs-5"></i>
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
            <span class="badge text-uppercase fw-bold rounded-pill px-2.5 py-1" id="bannerBadgeStatus" style="font-size: 0.72rem; letter-spacing: 0.05em;">
              Analisis Cepat Pakar
            </span>
            <span class="fs-8 text-secondary">Sensor Terbaca: <strong>{{ $suhu !== null ? number_format($suhu, 1) . '°C' : '--' }}</strong> &middot; <strong>{{ $kelembapan !== null ? round($kelembapan) . '% RH' : '--' }}</strong></span>
          </div>
          <h6 class="fw-bold mb-1 text-dark" id="bannerJudulDiagnosa">
            Memuat kesimpulan mikroklimat...
          </h6>
          <p class="text-secondary fs-7 mb-0" id="bannerDeskripsiDiagnosa">
            Menganalisis kondisi suhu dan kelembapan...
          </p>
        </div>
      </div>
      <div class="text-md-end flex-shrink-0">
        <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1.5 fs-7 fw-semibold shadow-2xs" onclick="bukaModalDiagnosa({{ $suhu ?? 28.0 }}, {{ $kelembapan ?? 65.0 }}, '{{ $latest?->kandang?->nama ?? 'Kandang Utama' }}', 'Sensor Terkini')">
          <i class="bi bi-shield-check me-1 text-success"></i> Lihat Solusi & Rekomendasi &rarr;
        </button>
      </div>
    </div>
  </div>

  <!-- Telemetry Log Table -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0">Riwayat Telemetri Sensor Terkini</h5>
      <span class="badge bg-secondary-subtle text-secondary fs-8">20 Catatan Terakhir</span>
    </div>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Waktu Catat</th>
            <th>Kandang</th>
            <th>Suhu (°C)</th>
            <th>Kelembapan (%)</th>
            <th>Ventilasi</th>
            <th>Kebersihan</th>
            <th>Sumber Data</th>
            <th class="text-center" style="min-width: 120px;">Hasil Diagnosa</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($monitorings as $item)
          <tr>
            <td class="text-secondary font-monospace">{{ \Carbon\Carbon::parse($item->dicatat_pada)->format('d M Y H:i:s') }}</td>
            <td class="fw-semibold text-body">{{ $item->kandang?->nama ?? 'Kandang A' }}</td>
            <td>
              <span class="badge {{ $item->suhu > 32 ? 'bg-warning-subtle text-warning' : ($item->suhu < 24 ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success') }} fs-7">
                {{ number_format($item->suhu, 1) }} °C
              </span>
            </td>
            <td>{{ number_format($item->kelembapan, 1) }} %</td>
            <td><span class="badge bg-light text-dark border">{{ ucfirst($item->ventilasi ?? 'cukup') }}</span></td>
            <td>{{ ucfirst($item->kebersihan ?? 'bersih') }}</td>
            <td><span class="badge bg-primary-subtle text-primary">{{ ucfirst($item->sumber ?? 'sensor') }}</span></td>
            <td class="text-center">
              <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5 fs-8 fw-semibold" onclick="bukaModalDiagnosa({{ $item->suhu }}, {{ $item->kelembapan }}, '{{ $item->kandang?->nama ?? 'Kandang' }}', '{{ \Carbon\Carbon::parse($item->dicatat_pada)->format('d M Y H:i') }}')">
                <i class="bi bi-robot me-1"></i> Diagnosa
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-4 text-secondary">Belum ada rekaman sensor tersimpan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: HASIL DIAGNOSA DARI SUHU & KELEMBAPAN (SISTEM PAKAR) -->
<!-- ======================================================== -->
<div class="modal fade" id="modalDiagnosaSuhu" tabindex="-1" aria-labelledby="modalDiagnosaSuhuLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom pb-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; background: linear-gradient(135deg, #f97316, #ea580c); box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4);">
            <i class="bi bi-robot fs-5"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 mb-0.5">
              <h5 class="modal-title fw-bold text-white mb-0" id="modalDiagnosaSuhuLabel">
                Hasil Diagnosa Sistem Pakar
              </h5>
              <span class="badge bg-orange text-white" id="modalBadgeStatus" style="background: #f97316; font-size: 0.72rem;">RISIKO TINGGI</span>
            </div>
            <small class="text-secondary" style="color: #94a3b8 !important;">
              Kandang: <strong id="modalKandangNama" class="text-white">-</strong> &middot; Waktu: <span id="modalWaktuCatat" class="text-white">-</span>
            </small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4 bg-light">
        <!-- Parameter Values Header Card -->
        <div class="p-3 bg-white rounded-4 border shadow-2xs mb-3">
          <div class="row g-3 text-center">
            <div class="col-4 border-end">
              <span class="fs-8 text-secondary text-uppercase fw-semibold d-block">Suhu Terbaca</span>
              <span class="fs-4 fw-bold" id="modalValSuhu" style="color: #d97706;">32.5</span>
              <span class="fs-7 text-secondary">°C</span>
            </div>
            <div class="col-4 border-end">
              <span class="fs-8 text-secondary text-uppercase fw-semibold d-block">Kelembapan (RH)</span>
              <span class="fs-4 fw-bold text-primary" id="modalValKelembapan">76.0</span>
              <span class="fs-7 text-secondary">%</span>
            </div>
            <div class="col-4">
              <span class="fs-8 text-secondary text-uppercase fw-semibold d-block">Skor Kesehatan</span>
              <span class="fs-4 fw-bold" id="modalValSkor" style="color: #0f172a;">80</span>
              <span class="fs-7 text-secondary">/ 100</span>
            </div>
          </div>
        </div>

        <!-- Kesimpulan Pakar Card -->
        <div class="card border-0 shadow-2xs rounded-4 bg-white p-3.5 mb-3 border">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fs-8 text-uppercase fw-bold text-secondary">
              <i class="bi bi-diagram-3-fill text-primary me-1"></i> Kesimpulan Inferensi Pakar:
            </span>
            <span class="badge bg-primary-subtle text-primary fs-8 fw-semibold" id="modalFiredRuleCode">
              Rule Terpicu
            </span>
          </div>

          <h5 class="fw-bold text-dark mb-2" id="modalJudulKesimpulan">
            Terindikasi Risiko Heat Stress
          </h5>

          <p class="text-secondary fs-7 mb-2 lh-base" id="modalDeskripsiKesimpulan">
            Suhu dan kelembapan berada di atas batas ideal...
          </p>

          <div class="p-2.5 rounded-3 border" style="background: #f8fafc;" id="modalRuleBox">
            <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.72rem;">LOGIKA ATURAN YANG MEMICU (RULE TRACE):</small>
            <code class="fs-8 text-dark" id="modalRuleTrace">IF suhu > 32 AND kelembapan > 80 THEN Heat Stress</code>
          </div>
        </div>

        <!-- Rekomendasi Solusi & Tindakan Cepat Card -->
        <div class="card border-0 shadow-2xs rounded-4 bg-white p-3.5 mb-3 border">
          <span class="fs-8 text-uppercase fw-bold text-success mb-2 d-block">
            <i class="bi bi-shield-check me-1"></i> Rekomendasi Tindakan Otomatis (SOP):
          </span>

          <ul class="mb-0 ps-3 fs-7 text-dark lh-base" id="modalListTindakan">
            <li>Nyalakan kipas blower exhaust segera.</li>
            <li>Siapkan air minum dingin dengan elektrolit.</li>
          </ul>
        </div>

        <!-- Simulator Uji Coba Cepat (Slider Dinamis dalam Modal) -->
        <div class="p-3 bg-white rounded-4 border">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fs-8 text-uppercase fw-bold text-secondary">
              <i class="bi bi-sliders me-1"></i> Uji Coba Nilai Suhu & Kelembapan Lain:
            </span>
            <small class="text-muted">Geser untuk melihat kesimpulan instan</small>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <div class="d-flex justify-content-between fs-8 mb-1">
                <span class="text-secondary">Uji Suhu:</span>
                <strong id="sliderSuhuVal" class="text-dark">32.5 °C</strong>
              </div>
              <input type="range" class="form-range" min="18" max="42" step="0.5" id="sliderSuhuInput" oninput="updateLiveSimulator()">
            </div>
            <div class="col-6">
              <div class="d-flex justify-content-between fs-8 mb-1">
                <span class="text-secondary">Uji Kelembapan:</span>
                <strong id="sliderKelembapanVal" class="text-dark">76 %</strong>
              </div>
              <input type="range" class="form-range" min="30" max="95" step="1" id="sliderKelembapanInput" oninput="updateLiveSimulator()">
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer border-top bg-white d-flex justify-content-between">
        <a href="{{ route('analisis.index') }}" class="btn btn-outline-secondary rounded-3 fs-7">
          <i class="bi bi-clipboard-data me-1"></i> Buka Hasil Analisis Lengkap
        </a>
        <button type="button" class="btn btn-dark rounded-3 fs-7 px-4" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  /**
   * Logika Inferensi Forward Chaining untuk Parameter Suhu & Kelembapan
   */
  function hitungDiagnosaMikroklimat(suhu, kelembapan) {
    suhu = parseFloat(suhu);
    kelembapan = parseFloat(kelembapan);

    let status = 'PRIMA';
    let badgeClass = 'bg-success text-white';
    let skor = 100;
    let judul = 'Kondisi Mikroklimat Ideal (Thermo-Neutral Zone)';
    let deskripsi = 'Suhu ' + suhu.toFixed(1) + '°C dan kelembapan ' + kelembapan.toFixed(0) + '% berada dalam rentang fisiologis optimal ayam broiler. Ayam merasa nyaman, metabolisme stabil, dan nafsu makan terjaga.';
    let ruleKode = 'NORMAL (Optimal)';
    let ruleTrace = 'IF suhu (24°C - 31°C) AND kelembapan (50% - 75%) THEN Kondisi Prima (CF: 95%)';
    let tindakan = [
      'Pertahankan setelan sirkulasi blower dan tirai saat ini.',
      'Pastikan kontinuitas ketersediaan air minum dan pakan.',
      'Lanjutkan monitoring berkala per segmen kandang.'
    ];

    // Evaluasi Rule 1: Heat Stress Parah (Suhu > 32 dan Lembap > 80)
    if (suhu > 32 && kelembapan > 80) {
      status = 'BAHAYA / KRITIS';
      badgeClass = 'bg-danger text-white';
      skor = 65;
      judul = 'R01: Risiko Heat Stress Parah (Akut)';
      deskripsi = 'Suhu ' + suhu.toFixed(1) + '°C (>32°C) dan kelembapan ' + kelembapan.toFixed(0) + '% (>80%) sangat tinggi bersamaan. Ayam broiler tidak memiliki kelenjar keringat sehingga kesulitan membuang panas tubuh lewat panting, rentan dehidrasi dan kematian mendadak.';
      ruleKode = 'R01 (CF: 85%)';
      ruleTrace = 'IF suhu > 32.0°C AND kelembapan > 80% THEN Heat Stress Parah (CF: 85%, Penalti: -35)';
      tindakan = [
        'Nyalakan seluruh kipas exhaust blower pada kecepatan maksimal segera.',
        'Aktifkan cooling pad selulosa untuk menurunkan suhu udara masuk.',
        'Sediakan air minum dingin (suhu 20-22°C) dan tambahkan larutan elektrolit/vitamin anti-stress.',
        'Kurangi kepadatan sekat agar ayam memiliki ruang sirkulasi lebih longgar.'
      ];
    }
    // Evaluasi Rule 2: Suhu Hangat / Panas (Suhu >= 32 dan Lembap <= 80)
    else if (suhu >= 32) {
      status = 'SIAGA / RISIKO TINGGI';
      badgeClass = 'bg-warning text-dark';
      skor = 75;
      judul = 'R02: Suhu Melebihi Batas Nyaman (>32°C)';
      deskripsi = 'Suhu ' + suhu.toFixed(1) + '°C di atas batas ideal (32°C). Ayam mulai mengalami panting (napas terengah-engah) dan konsumsi pakan akan menurun jika tidak segera dibantu pendinginan.';
      ruleKode = 'R02 (CF: 75%)';
      ruleTrace = 'IF suhu >= 32.0°C AND ventilasi/kelembapan kurang optimal THEN Suhu Hangat Berlebih (CF: 75%, Penalti: -25)';
      tindakan = [
        'Tingkatkan kecepatan putaran kipas blower untuk mempercepat angin sirkulasi.',
        'Buka tirai samping 10-15 cm untuk membuang udara panas yang terperangkap di plafon.',
        'Pastikan pipa dan nipple drinker terisi air bersih tanpa hambatan.'
      ];
    }
    // Evaluasi Rule 3: Suhu Terlalu Rendah / Chilling (Suhu < 24)
    else if (suhu < 24) {
      status = 'SIAGA / RISIKO DINGIN';
      badgeClass = 'bg-info text-dark';
      skor = 75;
      judul = 'R03: Suhu Kandang Terlalu Dingin (<24°C)';
      deskripsi = 'Suhu ' + suhu.toFixed(1) + '°C berada di bawah batas thermo-neutral. Ayam berisiko mengalami chilling (kedinginan), bergerombol menumpuk, dan daya tahan tubuh menurun.';
      ruleKode = 'R03 (CF: 75%)';
      ruleTrace = 'IF suhu < 24.0°C THEN Risiko Chilling / Kedinginan (CF: 75%, Penalti: -25)';
      tindakan = [
        'Nyalakan pemanas (gasolec / brooder) tambahan untuk mencapai suhu minimal 26-28°C.',
        'Tutup sebagian tirai samping kandang untuk mencegah hembusan angin dingin langsung.',
        'Periksa sebaran ayam di lantai; jika menumpuk di satu sudut, arahkan ke sumber hangat.'
      ];
    }
    // Evaluasi Rule 4: Kelembapan Terlalu Tinggi (> 75%)
    else if (kelembapan > 75) {
      status = 'WASPADA / LEMBAP TINGGI';
      badgeClass = 'bg-primary-subtle text-primary border border-primary';
      skor = 85;
      judul = 'R05: Kelembapan Udara Terlalu Tinggi (>75%)';
      deskripsi = 'Kelembapan ' + kelembapan.toFixed(0) + '% tergolong tinggi. Udara yang lembap memperlambat pengeringan kotoran ayam dan memicu sekam (litter) basah serta bau gas amonia.';
      ruleKode = 'R05 (CF: 65%)';
      ruleTrace = 'IF kelembapan > 75% AND suhu normal THEN Litter Rentan Lembap (CF: 65%, Penalti: -15)';
      tindakan = [
        'Tingkatkan pertukaran udara bawah kandang untuk mengeringkan lantai litter.',
        'Periksa jalur nipple drinker, pastikan tidak ada tetesan air yang membasahi sekam.',
        'Taburkan sekam kering baru atau balik litter yang mulai menggumpal.'
      ];
    }
    // Evaluasi Rule 5: Kelembapan Terlalu Rendah / Kering (< 50%)
    else if (kelembapan < 50) {
      status = 'WASPADA / KERING';
      badgeClass = 'bg-secondary-subtle text-secondary border';
      skor = 88;
      judul = 'R06: Kelembapan Terlalu Rendah / Kering (<50%)';
      deskripsi = 'Kelembapan ' + kelembapan.toFixed(0) + '% terlalu kering. Kondisi ini memicu debu sekam dan partikel pakan beterbangan, berisiko mengiritasi saluran pernapasan ayam.';
      ruleKode = 'R06 (CF: 60%)';
      ruleTrace = 'IF kelembapan < 50% THEN Udara Kering Berdebu (CF: 60%, Penalti: -12)';
      tindakan = [
        'Semprotkan kabut air halus (nozzle misting) secara periodik untuk menambah kelembapan.',
        'Bersihkan debu pada jaring tirai kandang agar aliran udara tetap segar.'
      ];
    }

    return {
      status: status,
      badgeClass: badgeClass,
      skor: skor,
      judul: judul,
      deskripsi: deskripsi,
      ruleKode: ruleKode,
      ruleTrace: ruleTrace,
      tindakan: tindakan
    };
  }

  /**
   * Tampilkan Modal Hasil Diagnosa dan render kesimpulannya
   */
  function bukaModalDiagnosa(suhu, kelembapan, namaKandang, waktuCatat) {
    suhu = parseFloat(suhu) || 32.5;
    kelembapan = parseFloat(kelembapan) || 76.0;
    namaKandang = namaKandang || 'Kandang Utama';
    waktuCatat = waktuCatat || 'Sensor Live Terkini';

    document.getElementById('modalKandangNama').textContent = namaKandang;
    document.getElementById('modalWaktuCatat').textContent = waktuCatat;

    // Set slider values
    document.getElementById('sliderSuhuInput').value = suhu;
    document.getElementById('sliderKelembapanInput').value = kelembapan;

    renderDiagnosaModal(suhu, kelembapan);

    const modal = new bootstrap.Modal(document.getElementById('modalDiagnosaSuhu'));
    modal.show();
  }

  /**
   * Render konten hasil diagnosa ke elemen-elemen modal
   */
  function renderDiagnosaModal(suhu, kelembapan) {
    const hasil = hitungDiagnosaMikroklimat(suhu, kelembapan);

    document.getElementById('modalValSuhu').textContent = suhu.toFixed(1);
    document.getElementById('modalValKelembapan').textContent = kelembapan.toFixed(0);
    document.getElementById('modalValSkor').textContent = hasil.skor;

    const badgeStatus = document.getElementById('modalBadgeStatus');
    badgeStatus.className = 'badge ' + hasil.badgeClass;
    badgeStatus.textContent = hasil.status;

    document.getElementById('modalJudulKesimpulan').textContent = hasil.judul;
    document.getElementById('modalDeskripsiKesimpulan').textContent = hasil.deskripsi;
    document.getElementById('modalFiredRuleCode').textContent = hasil.ruleKode;
    document.getElementById('modalRuleTrace').textContent = hasil.ruleTrace;

    document.getElementById('sliderSuhuVal').textContent = suhu.toFixed(1) + ' °C';
    document.getElementById('sliderKelembapanVal').textContent = kelembapan.toFixed(0) + ' %';

    const listTindakan = document.getElementById('modalListTindakan');
    listTindakan.innerHTML = hasil.tindakan.map(t => '<li>' + t + '</li>').join('');
  }

  /**
   * Reaktif saat slider di dalam modal digeser
   */
  function updateLiveSimulator() {
    const s = parseFloat(document.getElementById('sliderSuhuInput').value);
    const k = parseFloat(document.getElementById('sliderKelembapanInput').value);
    renderDiagnosaModal(s, k);
  }

  // Jalankan render awal untuk Banner Cepat saat halaman pertama kali dimuat
  document.addEventListener('DOMContentLoaded', () => {
    const liveSuhu = {{ $suhu }};
    const liveKelembapan = {{ $kelembapan }};
    const hasilLive = hitungDiagnosaMikroklimat(liveSuhu, liveKelembapan);

    const bannerBadge = document.getElementById('bannerBadgeStatus');
    if (bannerBadge) {
      bannerBadge.className = 'badge text-uppercase fw-bold rounded-pill px-2.5 py-1 ' + hasilLive.badgeClass;
      bannerBadge.textContent = hasilLive.status;
    }

    const bannerJudul = document.getElementById('bannerJudulDiagnosa');
    if (bannerJudul) {
      bannerJudul.textContent = hasilLive.judul;
    }

    const bannerDesc = document.getElementById('bannerDeskripsiDiagnosa');
    if (bannerDesc) {
      bannerDesc.textContent = hasilLive.deskripsi;
    }
  });
</script>
@endpush
@endsection
