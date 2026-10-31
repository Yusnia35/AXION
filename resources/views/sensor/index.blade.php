@extends('layouts.adminlte')

@section('title', 'AXION - Sensor IoT & Gateway API')
@section('topbar_page', 'Sensor IoT')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <!-- Header -->
  <div class="row align-items-end justify-content-between g-3 mb-4 pt-2">
    <div class="col-12 col-md-7">
     
      <h1 class="kandang-hero-title mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.85rem; font-weight: 700; color: #0f172a;">
        Sensor IoT & Gateway API
      </h1>
     
    </div>
    <div class="col-12 col-md-5 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
      <a href="{{ route('monitoring.suhu') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; border: none;">
        <i class="bi bi-broadcast"></i> Monitoring Live Suhu
      </a>
      <form action="{{ route('sensor.clearDummy') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membersihkan data dummy telemetri dan analisis?')">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1.5 bg-white shadow-sm">
          <i class="bi bi-trash3"></i> Bersihkan Data Dummy
        </button>
      </form>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;">
    <i class="bi bi-check-circle-fill me-2 fs-6"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Summary Cards -->
  <div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-white p-4" style="border: 1px solid #ffedd5 !important;">
        <span class="fs-7 text-secondary fw-medium">Total Sensor Terdaftar</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold text-dark">{{ $sensors->count() }}</span>
          <span class="fs-7 text-secondary ms-2">unit</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-white p-4" style="border: 1px solid #ffedd5 !important;">
        <span class="fs-7 text-secondary fw-medium">Status Koneksi IoT</span>
        <div class="d-flex align-items-baseline mt-2">
          @php $onlineCount = $sensors->where('status', 'online')->count(); @endphp
          <span class="fs-1 fw-bold {{ $onlineCount > 0 ? 'text-success' : 'text-secondary' }}">{{ $onlineCount }}</span>
          <span class="fs-7 text-secondary ms-2">{{ $onlineCount > 0 ? 'Online & Mengirim Data' : 'Offline / Standby' }}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 bg-white p-4" style="border: 1px solid #ffedd5 !important;">
        <span class="fs-7 text-secondary fw-medium">Hardware Rekomendasi</span>
        <div class="d-flex align-items-baseline mt-2">
          <span class="fs-1 fw-bold" style="color: #ea580c;">ESP32</span>
          <span class="fs-7 text-secondary ms-2">+ DHT22 (Wi-Fi Telemetri)</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Sensor -->
  <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4" style="border: 1px solid #ffedd5 !important;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-bold mb-0 text-dark">Daftar Modul Sensor Terpasang</h5>
      <span class="badge rounded-pill px-3 py-1.5" style="background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 0.75rem;">
        <i class="bi bi-broadcast me-1"></i> Sinkronisasi Telemetri
      </span>
    </div>
    <div class="table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light fs-8 text-uppercase">
          <tr>
            <th>Nama Perangkat</th>
            <th>Kandang Terpasang</th>
            <th>Tipe Sensor</th>
            <th>Mikrokontroler</th>
            <th>Status</th>
            <th>Terakhir Sinkronisasi</th>
          </tr>
        </thead>
        <tbody class="fs-7">
          @forelse ($sensors as $sensor)
          <tr>
            <td class="fw-bold text-dark">
              <i class="bi bi-cpu text-primary me-2"></i>{{ $sensor->nama }}
            </td>
            <td>
              <span class="badge bg-light text-dark border">{{ $sensor->kandang?->nama ?? 'Tidak terhubung' }}</span>
            </td>
            <td>{{ strtoupper($sensor->perangkat ?? 'DHT22') }} (Suhu & Kelembapan)</td>
            <td><code class="text-orange fw-bold" style="color: #c2410c;">{{ $sensor->mikrokontroler ?? 'ESP32' }}</code></td>
            <td>
              <span class="badge {{ ($sensor->status ?? 'online') === 'online' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> {{ ucfirst($sensor->status ?? 'offline') }}
              </span>
            </td>
            <td class="text-secondary">
              {{ $sensor->last_sync ? \Carbon\Carbon::parse($sensor->last_sync)->diffForHumans() : 'Belum pernah terhubung' }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-secondary">Belum ada sensor terdaftar.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- IoT Integration & API Guide Section -->
  <div class="card border-0 shadow-sm rounded-4 bg-white p-4" style="border: 1.5px solid #fed7aa !important;">
    <div class="d-flex align-items-center gap-3 mb-3">
      <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 44px; height: 44px; background: linear-gradient(135deg, #f97316, #ea580c); box-shadow: 0 4px 14px rgba(234, 88, 12, 0.3);">
        <i class="bi bi-code-square fs-5"></i>
      </div>
      <div>
        <h5 class="fw-bold mb-0 text-dark">Panduan Integrasi API IoT (ESP32 / Arduino / HTTP)</h5>
        <p class="text-secondary fs-8 mb-0">Hubungkan mikrokontroler kandang Anda untuk mengirim telemetri real-time langsung ke AXION.</p>
      </div>
    </div>

    <div class="row g-4 mt-1">
      <!-- Left Column: API Endpoint & cURL -->
      <div class="col-12 col-lg-5">
        <h6 class="fw-bold text-dark mb-2 fs-7"><i class="bi bi-link-45deg text-primary me-1"></i> Endpoint API Ingestion</h6>
        <div class="p-3 rounded-3 border bg-light mb-3">
          <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="badge bg-success text-white fs-8">POST</span>
            <small class="text-muted">Content-Type: application/json</small>
          </div>
          <code class="d-block text-break fs-7 fw-bold text-dark my-2">{{ url('/api/iot/telemetry') }}</code>
        </div>

        <h6 class="fw-bold text-dark mb-2 fs-7"><i class="bi bi-braces text-primary me-1"></i> Format JSON Payload</h6>
        <pre class="p-3 rounded-3 border bg-dark text-light mb-3" style="font-size: 0.78rem;"><code>{
  "kandang_id": 1,
  "suhu": 30.5,
  "kelembapan": 72.0,
  "ventilasi": "baik",
  "kebersihan": "baik"
}</code></pre>

        <h6 class="fw-bold text-dark mb-2 fs-7"><i class="bi bi-terminal text-primary me-1"></i> Tes dengan cURL Terminal</h6>
        <pre class="p-3 rounded-3 border bg-dark text-light mb-0" style="font-size: 0.74rem; overflow-x: auto;"><code>curl -X POST "{{ url('/api/iot/telemetry') }}" \
  -H "Content-Type: application/json" \
  -d '{"kandang_id":1,"suhu":31.2,"kelembapan":68.5}'</code></pre>
      </div>

      <!-- Right Column: ESP32 Arduino C++ Code -->
      <div class="col-12 col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="fw-bold text-dark mb-0 fs-7"><i class="bi bi-cpu text-primary me-1"></i> Source Code ESP32 + DHT22 (Arduino IDE)</h6>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5 fs-8" onclick="navigator.clipboard.writeText(document.getElementById('esp32CodeSnippet').innerText).then(() => alert('Kode program ESP32 berhasil disalin!'))">
            <i class="bi bi-clipboard me-1"></i> Salin Kode C++
          </button>
        </div>
        <pre class="p-3 rounded-3 border bg-dark text-light mb-0" style="font-size: 0.74rem; max-height: 380px; overflow-y: auto;"><code id="esp32CodeSnippet">#include &lt;WiFi.h&gt;
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
  Serial.print("Menghubungkan WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung! IP ESP32: " + WiFi.localIP().toString());
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    float suhu = dht.readTemperature();
    float kelembapan = dht.readHumidity();

    if (isnan(suhu) || isnan(kelembapan)) {
      Serial.println("Gagal membaca sensor DHT22!");
      delay(3000);
      return;
    }

    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/json");

    String jsonPayload = "{\"kandang_id\": 1, \"suhu\": " + String(suhu, 1) + ", \"kelembapan\": " + String(kelembapan, 1) + ", \"ventilasi\": \"baik\", \"kebersihan\": \"baik\"}";

    int httpResponseCode = http.POST(jsonPayload);
    Serial.print("Kirim data: ");
    Serial.println(jsonPayload);
    Serial.print("Respon HTTP AXION: ");
    Serial.println(httpResponseCode);

    http.end();
  }
  delay(10000); // Kirim telemetri setiap 10 detik
}</code></pre>
      </div>
    </div>
  </div>
</div>
@endsection
