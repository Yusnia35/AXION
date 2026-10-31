@extends('layouts.adminlte')

@section('title', 'AXION - Hasil Analisis Sistem Pakar')
@section('topbar_page', 'Hasil Analisis')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-8">
    
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 2.2rem; font-weight: 600; color: #16241b;">
        Hasil Analisis Sistem Pakar
      </h1>
      
    </div>
    <div class="col-12 col-md-4 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
      <button type="button" class="btn btn-outline-secondary rounded-3 px-3 py-2 fs-7" data-bs-toggle="collapse" data-bs-target="#penjelasanAlurCollapse" aria-expanded="false" aria-controls="penjelasanAlurCollapse">
        <i class="bi bi-info-circle me-1"></i> Cara Kerja Sistem
      </button>
      <button type="button" class="btn btn-primary rounded-3 px-3.5 py-2 fs-7 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDiagnosaBaru">
        <i class="bi bi-cpu me-1"></i> + Jalankan Analisis Baru
      </button>
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

  <!-- SECTION: INFOGRAFIS CARA KERJA SISTEM PAKAR (COLLAPSIBLE / ACCORDION) -->
  <div class="collapse show mb-4" id="penjelasanAlurCollapse">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #fffaf5 0%, #fff7ed 100%); border: 1px solid #fed7aa !important;">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <span class="badge px-2.5 py-1 text-uppercase fw-bold rounded-pill mb-1" style="background-color: #ffedd5; color: #c2410c; font-size: 0.7rem; letter-spacing: 0.08em;">
              Alur Transparansi Inferensi
            </span>
            <h5 class="fw-bold mb-0 text-dark">Dari Mana Hasil Analisis Didapatkan?</h5>
          </div>
          <span class="text-secondary fs-8">4 Tahap Forward Chaining</span>
        </div>

       

        <!-- 4 Step Flow Grid -->
        <div class="row g-3">
          <!-- Step 1 -->
          <div class="col-12 col-md-6 col-xl-3">
            <div class="p-3 rounded-4 bg-white border h-100 shadow-2xs position-relative" style="border-color: #ffedd5 !important;">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 26px; height: 26px; background-color: #ea580c; font-size: 0.75rem;">1</span>
                <i class="bi bi-broadcast fs-5" style="color: #ea580c;"></i>
              </div>
              <h6 class="fw-bold mb-1 fs-7 text-dark">Pengumpulan Fakta</h6>
              <p class="text-secondary fs-8 mb-0">
                Sistem menarik data mikroklimat (suhu & kelembapan sensor DHT22), observasi lingkungan fisik (litter, ventilasi), dan observasi 6 gejala klinis ayam.
              </p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="col-12 col-md-6 col-xl-3">
            <div class="p-3 rounded-4 bg-white border h-100 shadow-2xs position-relative" style="border-color: #ffedd5 !important;">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 26px; height: 26px; background-color: #ea580c; font-size: 0.75rem;">2</span>
                <i class="bi bi-diagram-3 fs-5" style="color: #ea580c;"></i>
              </div>
              <h6 class="fw-bold mb-1 fs-7 text-dark">Pencocokan Aturan</h6>
              <p class="text-secondary fs-8 mb-0">
                Mesin Forward Chaining mengevaluasi premis pada <strong>8 Aturan Pakar (R01–R08)</strong>. Jika semua premis <code>IF</code> terpenuhi, aturan menjadi <strong>AKTIF (FIRED)</strong>.
              </p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="col-12 col-md-6 col-xl-3">
            <div class="p-3 rounded-4 bg-white border h-100 shadow-2xs position-relative" style="border-color: #ffedd5 !important;">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 26px; height: 26px; background-color: #ea580c; font-size: 0.75rem;">3</span>
                <i class="bi bi-calculator fs-5" style="color: #ea580c;"></i>
              </div>
              <h6 class="fw-bold mb-1 fs-7 text-dark">Kalkulasi Kepastian</h6>
              <p class="text-secondary fs-8 mb-0">
                Menghitung Certainty Factor gabungan <code class="text-dark">CF = CF₁ + CF₂(1-CF₁)</code> serta Health Score dari <code class="text-dark">100 - Σ penalti</code>.
              </p>
            </div>
          </div>

          <!-- Step 4 -->
          <div class="col-12 col-md-6 col-xl-3">
            <div class="p-3 rounded-4 bg-white border h-100 shadow-2xs position-relative" style="border-color: #ffedd5 !important;">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width: 26px; height: 26px; background-color: #ea580c; font-size: 0.75rem;">4</span>
                <i class="bi bi-shield-check fs-5" style="color: #ea580c;"></i>
              </div>
              <h6 class="fw-bold mb-1 fs-7 text-dark">Diagnosis & Rekomendasi</h6>
              <p class="text-secondary fs-8 mb-0">
                Menetapkan Status Kandang (Normal, Perlu Pantau, Bahaya) dan otomatis menerbitkan SOP penanganan ke menu <strong>Rekomendasi Tindakan</strong>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card border-0 shadow-sm rounded-4 bg-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div>
        <h5 class="fw-bold mb-0">Daftar Hasil Analisis</h5>
      
      </div>
      <span class="badge bg-secondary-subtle text-secondary fs-8">{{ $analises->count() }} Sesi Analisis</span>
    </div>

    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th style="min-width: 130px;">Waktu Dibuat</th>
            <th style="min-width: 140px;">Kandang</th>
            <th style="min-width: 130px;">Skor Kesehatan</th>
            <th style="min-width: 110px;">Tingkat Risiko</th>
            <th style="min-width: 110px;">Status Kandang</th>
            <th style="min-width: 90px;" class="text-center">CF Gabungan</th>
            <th>Ringkasan Diagnosis</th>
            <th style="min-width: 110px;" class="text-end">Aksi & Detail</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($analises as $item)
          <tr>
            <td class="font-monospace text-secondary">
              <div>{{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d M Y') }}</div>
              <small class="text-muted">{{ \Carbon\Carbon::parse($item->dibuat_pada)->format('H:i') }} WIB</small>
            </td>
            <td>
              <div class="fw-semibold text-body">{{ $item->kandang?->nama ?? 'Kandang' }}</div>
              @if ($item->kelompokAyam)
                <small class="badge bg-light text-secondary border font-monospace">{{ $item->kelompokAyam->kode }}</small>
              @endif
            </td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <strong class="fs-6 {{ $item->health_score < 70 ? 'text-danger' : ($item->health_score < 85 ? 'text-warning' : 'text-success') }}">
                  {{ $item->health_score }}
                </strong>
                <span class="text-muted fs-8">/100</span>
              </div>
              <div class="progress mt-1" style="height: 4px; width: 80px;">
                <div class="progress-bar {{ $item->health_score < 70 ? 'bg-danger' : ($item->health_score < 85 ? 'bg-warning' : 'bg-success') }}" role="progressbar" style="width: {{ $item->health_score }}%"></div>
              </div>
            </td>
            <td>
              @php
                $badgeRisk = match($item->level_risiko) {
                  'kritis' => 'bg-danger text-white',
                  'tinggi' => 'bg-danger-subtle text-danger',
                  'sedang' => 'bg-warning-subtle text-warning',
                  default => 'bg-success-subtle text-success',
                };
              @endphp
              <span class="badge {{ $badgeRisk }} text-uppercase fs-8">{{ $item->level_risiko }}</span>
            </td>
            <td>
              @php
                $badgeStatus = match($item->status_kandang) {
                  'bahaya' => 'bg-danger text-white',
                  'perlu_pantau' => 'bg-warning text-dark',
                  default => 'bg-success text-white',
                };
              @endphp
              <span class="badge {{ $badgeStatus }} text-capitalize">
                {{ str_replace('_', ' ', $item->status_kandang) }}
              </span>
            </td>
            <td class="text-center font-monospace fw-bold text-dark">
              {{ number_format($item->cf_gabungan, 3) }}
            </td>
            <td class="text-secondary">
              <div class="text-truncate-2" style="max-width: 320px;" title="{{ $item->ringkasan }}">
                {{ $item->ringkasan }}
              </div>
            </td>
            <td class="text-end">
              <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 fs-8 text-nowrap" data-bs-toggle="modal" data-bs-target="#modalDetailAnalisis-{{ $item->id }}">
                <i class="bi bi-journal-text me-1"></i> Alur Logika
              </button>
            </td>
          </tr>

          <!-- MODAL DETAIL ALUR LOGIKA ANALISIS (EXPLAINABLE AI) -->
          <div class="modal fade" id="modalDetailAnalisis-{{ $item->id }}" tabindex="-1" aria-labelledby="modalDetailAnalisisLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom pb-3">
                  <div>
                    <span class="badge text-uppercase bg-secondary-subtle text-secondary fs-8 mb-1">
                      Bukti Inferensi ID #{{ $item->id }}
                    </span>
                    <h5 class="modal-title fw-bold" id="modalDetailAnalisisLabel-{{ $item->id }}">
                      Rincian Logika & Inferensi: {{ $item->kandang?->nama }}
                    </h5>
                    <small class="text-secondary">Dianalisis pada {{ \Carbon\Carbon::parse($item->dibuat_pada)->format('d F Y - H:i') }} WIB</small>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                  <!-- Summary Banner -->
                  <div class="p-3 rounded-4 mb-4" style="background-color: #f7faf7; border: 1px solid #e1ede2;">
                    <div class="row align-items-center g-3">
                      <div class="col-6 col-md-3 text-center border-end">
                        <small class="text-secondary d-block fs-8">Skor Kesehatan</small>
                        <span class="fs-3 fw-bold {{ $item->health_score < 70 ? 'text-danger' : ($item->health_score < 85 ? 'text-warning' : 'text-success') }}">
                          {{ $item->health_score }}/100
                        </span>
                      </div>
                      <div class="col-6 col-md-3 text-center border-end">
                        <small class="text-secondary d-block fs-8">Level Risiko</small>
                        <span class="badge {{ $badgeRisk }} text-uppercase fs-7 mt-1">{{ $item->level_risiko }}</span>
                      </div>
                      <div class="col-6 col-md-3 text-center border-end">
                        <small class="text-secondary d-block fs-8">Status Kandang</small>
                        <span class="badge {{ $badgeStatus }} fs-7 mt-1">{{ str_replace('_', ' ', ucfirst($item->status_kandang)) }}</span>
                      </div>
                      <div class="col-6 col-md-3 text-center">
                        <small class="text-secondary d-block fs-8">CF Gabungan</small>
                        <span class="fs-4 font-monospace fw-bold text-dark">{{ number_format($item->cf_gabungan, 3) }}</span>
                      </div>
                    </div>
                  </div>

                  <!-- Ringkasan Kesimpulan -->
                  <div class="mb-4">
                    <h6 class="fw-bold fs-7 text-uppercase text-secondary mb-2">Ringkasan Diagnosis Pakar</h6>
                    <div class="p-3 bg-light rounded-3 text-dark fs-7">
                      {{ $item->ringkasan }}
                    </div>
                  </div>

                  <!-- Aturan Pakar Yang Terpicu -->
                  <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <h6 class="fw-bold fs-7 text-uppercase text-secondary mb-0">Aturan Yang Terpicu (Fired Rules)</h6>
                      <span class="badge text-bg-warning">{{ $item->analisisRules->count() }} Aturan Aktif</span>
                    </div>

                    @if ($item->analisisRules->count() > 0)
                      <div class="list-group rounded-3 shadow-2xs">
                        @foreach ($item->analisisRules as $ar)
                          <div class="list-group-item p-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <div>
                                <span class="badge bg-dark font-monospace me-1">{{ $ar->rule?->kode }}</span>
                                <strong class="text-dark">{{ $ar->rule?->nama }}</strong>
                              </div>
                              <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-warning-subtle text-warning">CF: {{ number_format($ar->cf_nilai, 2) }}</span>
                                <span class="badge bg-danger-subtle text-danger">-{{ $ar->rule?->pengurang_skor }} Skor</span>
                              </div>
                            </div>
                            <p class="text-secondary fs-8 mb-2">{{ $ar->rule?->kesimpulan }}</p>

                            <!-- Syarat Kondisi Rule -->
                            @if ($ar->rule && $ar->rule->ruleKondisis->count() > 0)
                              <div class="p-2 bg-light rounded-2 fs-8 text-secondary">
                                <div class="fw-semibold text-dark mb-1">Kondisi Logika (Premis IF):</div>
                                <div class="d-flex flex-wrap gap-2">
                                  @foreach ($ar->rule->ruleKondisis as $kondisi)
                                    <span class="badge bg-white text-dark border">
                                      <code>{{ $kondisi->parameter }}</code> {{ $kondisi->operator }} <strong>{{ $kondisi->nilai }}</strong>
                                    </span>
                                  @endforeach
                                </div>
                              </div>
                            @endif
                          </div>
                        @endforeach
                      </div>
                    @else
                      <div class="p-3 bg-light rounded-3 text-secondary fs-7 text-center">
                        <i class="bi bi-shield-check text-success fs-4 d-block mb-1"></i>
                        Tidak ada aturan risiko yang terpicu. Seluruh parameter berada dalam rentang normal dan aman.
                      </div>
                    @endif
                  </div>

                  <!-- Rekomendasi Tindakan Yang Diterbitkan -->
                  <div>
                    <h6 class="fw-bold fs-7 text-uppercase text-secondary mb-2">Rekomendasi Tindakan Otomatis</h6>
                    @if ($item->rekomendasis->count() > 0)
                      <ul class="list-group list-group-flush border rounded-3 fs-7">
                        @foreach ($item->rekomendasis as $rek)
                          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div class="d-flex align-items-center gap-2">
                              <i class="bi bi-check2-circle text-primary fs-5"></i>
                              <span>{{ $rek->tindakan }}</span>
                            </div>
                            <span class="badge {{ $rek->prioritas === 'tinggi' ? 'bg-danger' : 'bg-warning text-dark' }} text-uppercase fs-8">
                              {{ $rek->prioritas }}
                            </span>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <div class="p-2 text-secondary fs-8">
                        Belum ada tindakan darurat yang diperlukan. Terus pantau suhu dan pakan harian.
                      </div>
                    @endif
                  </div>
                </div>

                <div class="modal-footer border-top py-2">
                  <a href="{{ route('rekomendasi.index') }}" class="btn btn-outline-secondary fs-7">
                    <i class="bi bi-shield-check me-1"></i> Buka Menu Rekomendasi
                  </a>
                  <button type="button" class="btn btn-secondary fs-7" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL DETAIL -->

          @empty
          <tr>
            <td colspan="8" class="text-center py-5 text-secondary">
              <i class="bi bi-clipboard2-x fs-1 d-block mb-2 text-muted"></i>
              Belum ada hasil analisis tersimpan. Klik <strong>"+ Jalankan Analisis Baru"</strong> di atas untuk memulai.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: JALANKAN ANALISIS BARU (FORWARD CHAINING SIMULATOR) -->
<!-- ======================================================== -->
<div class="modal fade" id="modalDiagnosaBaru" tabindex="-1" aria-labelledby="modalDiagnosaBaruLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 shadow">
      <form action="{{ route('analisis.diagnosa') }}" method="POST">
        @csrf
        <div class="modal-header border-bottom pb-3">
          <div>
            <span class="badge text-uppercase bg-success-subtle text-success fs-8 mb-1">
              Inferensi Real-Time
            </span>
            <h5 class="modal-title fw-bold" id="modalDiagnosaBaruLabel">
              Jalankan Analisis Sistem Pakar
            </h5>
            <small class="text-secondary">Uji fakta mikroklimat & gejala klinis terhadap 8 aturan pakar veteriner</small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <!-- Preset Tombol Cepat Skenario -->
          <div class="p-3 rounded-4 mb-4 bg-light border">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fs-8 fw-bold text-uppercase text-secondary">Uji Coba Cepat (Pilih Skenario):</span>
              <span class="fs-8 text-muted">Isi form secara otomatis</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <button type="button" class="btn btn-sm btn-outline-success bg-white fs-8 rounded-pill" onclick="setPreset('normal')">
                <i class="bi bi-check-circle me-1"></i> 1. Skenario Normal (Sehat)
              </button>
              <button type="button" class="btn btn-sm btn-outline-warning bg-white fs-8 rounded-pill" onclick="setPreset('heat_stress')">
                <i class="bi bi-thermometer-sun me-1"></i> 2. Risiko Heat Stress (R01)
              </button>
              <button type="button" class="btn btn-sm btn-outline-danger bg-white fs-8 rounded-pill" onclick="setPreset('amonia')">
                <i class="bi bi-exclamation-triangle me-1"></i> 3. Risiko Amonia (R04)
              </button>
              <button type="button" class="btn btn-sm btn-outline-danger bg-white fs-8 rounded-pill" onclick="setPreset('pernapasan')">
                <i class="bi bi-lungs me-1"></i> 4. Gangguan Napas (R06)
              </button>
              <button type="button" class="btn btn-sm btn-danger bg-danger text-white fs-8 rounded-pill" onclick="setPreset('kritis')">
                <i class="bi bi-virus me-1"></i> 5. Kritis Berdarah (R07)
              </button>
            </div>
          </div>

          <!-- Bagian 1: Kandang & Kelompok -->
          <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
              <label for="diag_kandang_id" class="form-label fw-bold fs-7">Pilih Kandang Target <span class="text-danger">*</span></label>
              <select name="kandang_id" id="diag_kandang_id" class="form-select fs-7 rounded-3" required>
                @foreach ($kandangs as $kdg)
                  <option value="{{ $kdg->id }}">{{ $kdg->nama }} ({{ ucfirst(str_replace('_', ' ', $kdg->tipe_kandang)) }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label for="diag_kelompok_id" class="form-label fw-bold fs-7">Kelompok Kawanan Ayam (Opsional)</label>
              <select name="kelompok_id" id="diag_kelompok_id" class="form-select fs-7 rounded-3">
                <option value="">-- Semua / Sesuai Kandang --</option>
                @foreach ($kandangs as $kdg)
                  @foreach ($kdg->kelompokAyams as $flock)
                    <option value="{{ $flock->id }}">{{ $kdg->nama }} - {{ $flock->kode }} ({{ $flock->jumlah_ayam }} ekor)</option>
                  @endforeach
                @endforeach
              </select>
            </div>
          </div>

          <!-- Bagian 2: Fakta Mikroklimat & Lingkungan -->
          <h6 class="fw-bold fs-7 text-uppercase text-secondary border-bottom pb-2 mb-3">
            <i class="bi bi-thermometer-half text-danger me-1"></i> Fakta Sensor Mikroklimat & Lingkungan
          </h6>
          <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold">Suhu Udara (°C) <span class="text-danger">*</span></label>
              <input type="number" step="0.1" name="suhu" id="diag_suhu" class="form-control fs-7 rounded-3" value="28.5" required>
            </div>
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold">Kelembapan (%) <span class="text-danger">*</span></label>
              <input type="number" step="0.1" name="kelembapan" id="diag_kelembapan" class="form-control fs-7 rounded-3" value="68.0" required>
            </div>
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold">Ventilasi Udara <span class="text-danger">*</span></label>
              <select name="ventilasi" id="diag_ventilasi" class="form-select fs-7 rounded-3" required>
                <option value="baik">Baik</option>
                <option value="cukup" selected>Cukup</option>
                <option value="kurang">Kurang</option>
              </select>
            </div>
            <div class="col-6 col-md-3">
              <label class="form-label fs-8 fw-semibold">Kebersihan <span class="text-danger">*</span></label>
              <select name="kebersihan" id="diag_kebersihan" class="form-select fs-7 rounded-3" required>
                <option value="bersih" selected>Bersih</option>
                <option value="cukup">Cukup</option>
                <option value="kotor">Kotor</option>
              </select>
            </div>
            <div class="col-6 col-md-6">
              <label class="form-label fs-8 fw-semibold">Kondisi Alas Sekam (Litter) <span class="text-danger">*</span></label>
              <select name="kondisi_litter" id="diag_kondisi_litter" class="form-select fs-7 rounded-3" required>
                <option value="kering" selected>Kering (Optimal)</option>
                <option value="lembap">Lembap (Perlu Diperiksa)</option>
                <option value="basah">Basah (Risiko Amonia)</option>
              </select>
            </div>
            <div class="col-6 col-md-6">
              <label class="form-label fs-8 fw-semibold">Kepadatan Kandang <span class="text-danger">*</span></label>
              <select name="kepadatan" id="diag_kepadatan" class="form-select fs-7 rounded-3" required>
                <option value="longgar">Longgar</option>
                <option value="ideal" selected>Ideal</option>
                <option value="padat">Padat</option>
              </select>
            </div>
          </div>

          <!-- Bagian 3: Fakta Observasi Klinis Ayam -->
          <h6 class="fw-bold fs-7 text-uppercase text-secondary border-bottom pb-2 mb-3">
            <i class="bi bi-activity text-primary me-1"></i> Fakta Observasi Kesehatan Ayam
          </h6>
          <div class="row g-3">
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Nafsu Makan <span class="text-danger">*</span></label>
              <select name="nafsu_makan" id="diag_nafsu_makan" class="form-select fs-7 rounded-3" required>
                <option value="normal" selected>Normal</option>
                <option value="menurun">Menurun</option>
                <option value="tidak_mau_makan">Tidak Mau Makan</option>
              </select>
            </div>
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Aktivitas Gerak <span class="text-danger">*</span></label>
              <select name="aktivitas" id="diag_aktivitas" class="form-select fs-7 rounded-3" required>
                <option value="aktif" selected>Aktif</option>
                <option value="lesu">Lesu</option>
                <option value="sangat_lesu">Sangat Lesu</option>
              </select>
            </div>
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Kondisi Mata <span class="text-danger">*</span></label>
              <select name="kondisi_mata" id="diag_kondisi_mata" class="form-select fs-7 rounded-3" required>
                <option value="normal" selected>Normal / Bersih</option>
                <option value="berair">Berair</option>
                <option value="bengkak">Bengkak</option>
              </select>
            </div>
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Kondisi Bulu <span class="text-danger">*</span></label>
              <select name="kondisi_bulu" id="diag_kondisi_bulu" class="form-select fs-7 rounded-3" required>
                <option value="normal" selected>Normal / Rapi</option>
                <option value="kusut">Kusut / Kusam</option>
                <option value="rontok">Rontok Parah</option>
              </select>
            </div>
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Batuk / Bersin <span class="text-danger">*</span></label>
              <select name="batuk_bersin" id="diag_batuk_bersin" class="form-select fs-7 rounded-3" required>
                <option value="tidak_ada" selected>Tidak Ada</option>
                <option value="ringan">Ringan / Kadang</option>
                <option value="sering">Sering (Gejala Napas)</option>
              </select>
            </div>
            <div class="col-6 col-md-4">
              <label class="form-label fs-8 fw-semibold">Kondisi Feses / Kotoran <span class="text-danger">*</span></label>
              <select name="kondisi_kotoran" id="diag_kondisi_kotoran" class="form-select fs-7 rounded-3" required>
                <option value="normal" selected>Normal</option>
                <option value="encer">Encer / Diare</option>
                <option value="kehijauan">Kehijauan</option>
                <option value="berdarah">Berdarah (Kritis R07)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer border-top py-3">
          <button type="button" class="btn btn-outline-secondary fs-7 rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fs-7 rounded-3 px-4 fw-bold shadow-sm">
            <i class="bi bi-play-circle me-1"></i> Mulai Inferensi (Forward Chaining)
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function setPreset(preset) {
    if (preset === 'normal') {
      document.getElementById('diag_suhu').value = '28.0';
      document.getElementById('diag_kelembapan').value = '65.0';
      document.getElementById('diag_ventilasi').value = 'cukup';
      document.getElementById('diag_kebersihan').value = 'bersih';
      document.getElementById('diag_kondisi_litter').value = 'kering';
      document.getElementById('diag_kepadatan').value = 'ideal';
      document.getElementById('diag_nafsu_makan').value = 'normal';
      document.getElementById('diag_aktivitas').value = 'aktif';
      document.getElementById('diag_kondisi_mata').value = 'normal';
      document.getElementById('diag_kondisi_bulu').value = 'normal';
      document.getElementById('diag_batuk_bersin').value = 'tidak_ada';
      document.getElementById('diag_kondisi_kotoran').value = 'normal';
    } else if (preset === 'heat_stress') {
      document.getElementById('diag_suhu').value = '33.5';
      document.getElementById('diag_kelembapan').value = '82.0';
      document.getElementById('diag_ventilasi').value = 'kurang';
      document.getElementById('diag_kebersihan').value = 'cukup';
      document.getElementById('diag_kondisi_litter').value = 'kering';
      document.getElementById('diag_kepadatan').value = 'padat';
      document.getElementById('diag_nafsu_makan').value = 'menurun';
      document.getElementById('diag_aktivitas').value = 'lesu';
      document.getElementById('diag_kondisi_mata').value = 'normal';
      document.getElementById('diag_kondisi_bulu').value = 'normal';
      document.getElementById('diag_batuk_bersin').value = 'tidak_ada';
      document.getElementById('diag_kondisi_kotoran').value = 'normal';
    } else if (preset === 'amonia') {
      document.getElementById('diag_suhu').value = '30.0';
      document.getElementById('diag_kelembapan').value = '78.0';
      document.getElementById('diag_ventilasi').value = 'kurang';
      document.getElementById('diag_kebersihan').value = 'kotor';
      document.getElementById('diag_kondisi_litter').value = 'basah';
      document.getElementById('diag_kepadatan').value = 'padat';
      document.getElementById('diag_nafsu_makan').value = 'menurun';
      document.getElementById('diag_aktivitas').value = 'lesu';
      document.getElementById('diag_kondisi_mata').value = 'berair';
      document.getElementById('diag_kondisi_bulu').value = 'kusut';
      document.getElementById('diag_batuk_bersin').value = 'ringan';
      document.getElementById('diag_kondisi_kotoran').value = 'normal';
    } else if (preset === 'pernapasan') {
      document.getElementById('diag_suhu').value = '29.0';
      document.getElementById('diag_kelembapan').value = '70.0';
      document.getElementById('diag_ventilasi').value = 'kurang';
      document.getElementById('diag_kebersihan').value = 'cukup';
      document.getElementById('diag_kondisi_litter').value = 'lembap';
      document.getElementById('diag_kepadatan').value = 'ideal';
      document.getElementById('diag_nafsu_makan').value = 'menurun';
      document.getElementById('diag_aktivitas').value = 'lesu';
      document.getElementById('diag_kondisi_mata').value = 'berair';
      document.getElementById('diag_kondisi_bulu').value = 'kusut';
      document.getElementById('diag_batuk_bersin').value = 'sering';
      document.getElementById('diag_kondisi_kotoran').value = 'normal';
    } else if (preset === 'kritis') {
      document.getElementById('diag_suhu').value = '32.0';
      document.getElementById('diag_kelembapan').value = '75.0';
      document.getElementById('diag_ventilasi').value = 'kurang';
      document.getElementById('diag_kebersihan').value = 'kotor';
      document.getElementById('diag_kondisi_litter').value = 'basah';
      document.getElementById('diag_kepadatan').value = 'padat';
      document.getElementById('diag_nafsu_makan').value = 'tidak_mau_makan';
      document.getElementById('diag_aktivitas').value = 'sangat_lesu';
      document.getElementById('diag_kondisi_mata').value = 'bengkak';
      document.getElementById('diag_kondisi_bulu').value = 'rontok';
      document.getElementById('diag_batuk_bersin').value = 'sering';
      document.getElementById('diag_kondisi_kotoran').value = 'berdarah';
    }
  }
</script>
@endsection
