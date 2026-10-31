<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Analisis;
use App\Models\Kandang;
use App\Models\MonitoringSensor;
use App\Models\Sensor;
use App\Services\ExpertSystemInferenceService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IotTelemetryController extends Controller
{
    /**
     * Store real telemetry data incoming from IoT microcontrollers (e.g. ESP32 + DHT22).
     */
    public function store(Request $request, ExpertSystemInferenceService $inferenceService): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kandang_id' => ['nullable', 'integer', 'exists:kandang,id'],
            'sensor_id' => ['nullable', 'integer', 'exists:sensor,id'],
            'suhu' => ['required', 'numeric', 'between:0,60'],
            'kelembapan' => ['required', 'numeric', 'between:0,100'],
            'ventilasi' => ['nullable', 'in:baik,cukup,kurang'],
            'kebersihan' => ['nullable', 'in:baik,cukup,kurang'],
            'sumber' => ['nullable', 'in:sensor,manual'],
        ], [
            'suhu.required' => 'Nilai suhu (°C) wajib disertakan.',
            'suhu.numeric' => 'Nilai suhu harus berupa angka numerik.',
            'suhu.between' => 'Nilai suhu berada di luar batas wajar (0 - 60°C).',
            'kelembapan.required' => 'Nilai kelembapan (% RH) wajib disertakan.',
            'kelembapan.numeric' => 'Nilai kelembapan harus berupa angka numerik.',
            'kelembapan.between' => 'Nilai kelembapan berada di luar batas wajar (0 - 100%).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi data sensor gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Determine target kandang
        $kandangId = $request->input('kandang_id');
        $sensorId = $request->input('sensor_id');

        if (! $kandangId && $sensorId) {
            $sensor = Sensor::find($sensorId);
            $kandangId = $sensor?->kandang_id;
        }

        $kandang = $kandangId
            ? Kandang::with('kelompokAyams')->find($kandangId)
            : Kandang::with('kelompokAyams')->first();

        if (! $kandang) {
            return response()->json([
                'success' => false,
                'message' => 'Kandang target tidak ditemukan. Harap daftarkan kandang terlebih dahulu di sistem.',
            ], 404);
        }

        // Find or associate sensor
        $sensor = $sensorId
            ? Sensor::find($sensorId)
            : Sensor::where('kandang_id', $kandang->id)->first();

        // Update sensor state to online
        if ($sensor) {
            $sensor->update([
                'status' => 'online',
                'last_sync' => now(),
            ]);
        }

        // Save telemetry record to database
        $monitoring = MonitoringSensor::create([
            'kandang_id' => $kandang->id,
            'sensor_id' => $sensor?->id,
            'suhu' => (float) $request->input('suhu'),
            'kelembapan' => (float) $request->input('kelembapan'),
            'ventilasi' => $request->input('ventilasi', 'baik'),
            'kebersihan' => $request->input('kebersihan', 'baik'),
            'sumber' => $request->input('sumber', 'sensor'),
            'dicatat_pada' => now(),
        ]);

        // Automatically trigger Expert System inference (Forward Chaining)
        $kelompokAyam = $kandang->kelompokAyams->firstWhere('is_active', true) ?? $kandang->kelompokAyams->first();

        $facts = [
            'suhu' => (float) $monitoring->suhu,
            'kelembapan' => (float) $monitoring->kelembapan,
            'ventilasi' => $monitoring->ventilasi ?? 'baik',
            'kebersihan' => $monitoring->kebersihan ?? 'baik',
            'kondisi_litter' => 'kering',
            'kepadatan' => 'normal',
            'nafsu_makan' => 'normal',
            'aktivitas' => 'aktif',
            'kondisi_mata' => 'normal',
            'kondisi_bulu' => 'normal',
            'batuk_bersin' => 'tidak_ada',
            'kondisi_kotoran' => 'normal',
        ];

        $inferenceResult = $inferenceService->infer(
            facts: $facts,
            kandangId: $kandang->id,
            kelompokId: $kelompokAyam?->id,
            monitoringId: $monitoring->id,
            kondisiId: null,
            pemeriksaanId: null,
            userId: null,
            saveToDatabase: true
        );

        return response()->json([
            'success' => true,
            'message' => 'Data telemetri IoT berhasil diterima dan diproses oleh sistem pakar AXION.',
            'data' => [
                'monitoring_id' => $monitoring->id,
                'kandang' => [
                    'id' => $kandang->id,
                    'nama' => $kandang->nama,
                ],
                'sensor' => $sensor ? [
                    'id' => $sensor->id,
                    'nama' => $sensor->nama,
                    'perangkat' => $sensor->perangkat,
                    'mikrokontroler' => $sensor->mikrokontroler,
                    'status' => 'online',
                ] : null,
                'telemetri' => [
                    'suhu' => (float) $monitoring->suhu,
                    'kelembapan' => (float) $monitoring->kelembapan,
                    'ventilasi' => $monitoring->ventilasi,
                    'kebersihan' => $monitoring->kebersihan,
                    'waktu' => $monitoring->dicatat_pada->format('Y-m-d H:i:s'),
                ],
                'hasil_pakar' => [
                    'skor_kesehatan' => $inferenceResult['skor_kesehatan'] ?? 100,
                    'status_kandang' => $inferenceResult['status_kandang'] ?? 'normal',
                    'level_risiko' => $inferenceResult['level_risiko'] ?? 'rendah',
                    'kesimpulan' => $inferenceResult['kesimpulan'] ?? 'Kondisi stabil.',
                    'rekomendasi' => $inferenceResult['rekomendasi_tindakan'] ?? [],
                ],
            ],
        ], 201);
    }

    /**
     * Retrieve latest telemetry data for real-time dashboard polling.
     */
    public function latest(Request $request): JsonResponse
    {
        $kandangId = $request->query('kandang_id');

        $query = MonitoringSensor::with(['kandang', 'sensor'])->latest('dicatat_pada');
        if ($kandangId) {
            $query->where('kandang_id', $kandangId);
        }

        $latest = $query->first();

        if (! $latest) {
            return response()->json([
                'success' => true,
                'has_data' => false,
                'message' => 'Belum ada data telemetri yang tercatat dari sensor IoT.',
                'data' => null,
            ]);
        }

        // Get latest analysis
        $analisis = Analisis::where('kandang_id', $latest->kandang_id)
            ->latest('dibuat_pada')
            ->first();

        // Calculate dynamic thermal status
        $suhu = (float) $latest->suhu;
        $kelembapan = (float) $latest->kelembapan;

        $statusSuhu = match (true) {
            $suhu > 32.0 => 'Suhu Tinggi / Panas',
            $suhu < 24.0 => 'Suhu Terlalu Dingin',
            default => 'Suhu Ideal',
        };

        $statusKelembapan = match (true) {
            $kelembapan > 75.0 => 'Kelembapan Tinggi',
            $kelembapan < 50.0 => 'Udara Kering',
            default => 'Optimal',
        };

        return response()->json([
            'success' => true,
            'has_data' => true,
            'data' => [
                'id' => $latest->id,
                'kandang_id' => $latest->kandang_id,
                'kandang_nama' => $latest->kandang?->nama ?? 'Kandang Utama',
                'suhu' => $suhu,
                'kelembapan' => $kelembapan,
                'status_suhu' => $statusSuhu,
                'status_kelembapan' => $statusKelembapan,
                'ventilasi' => $latest->ventilasi,
                'kebersihan' => $latest->kebersihan,
                'sumber' => $latest->sumber,
                'dicatat_pada' => $latest->dicatat_pada->toIso8601String(),
                'waktu_relatif' => $latest->dicatat_pada->diffForHumans(),
                'analisis' => $analisis ? [
                    'skor_kesehatan' => $analisis->health_score,
                    'level_risiko' => $analisis->level_risiko,
                    'status_kandang' => $analisis->status_kandang,
                    'ringkasan' => $analisis->ringkasan,
                ] : null,
            ],
        ]);
    }

    /**
     * Retrieve telemetry history for dynamic Chart.js rendering.
     */
    public function history(Request $request): JsonResponse
    {
        $kandangId = $request->query('kandang_id');
        $limit = min((int) $request->query('limit', 20), 50);

        $query = MonitoringSensor::latest('dicatat_pada');
        if ($kandangId) {
            $query->where('kandang_id', $kandangId);
        }

        $records = $query->take($limit)->get()->reverse()->values();

        $labels = $records->map(fn ($item) => Carbon::parse($item->dicatat_pada)->format('H:i'));
        $suhu = $records->pluck('suhu')->map(fn ($val) => (float) $val);
        $kelembapan = $records->pluck('kelembapan')->map(fn ($val) => (float) $val);

        return response()->json([
            'success' => true,
            'count' => $records->count(),
            'labels' => $labels,
            'suhu' => $suhu,
            'kelembapan' => $kelembapan,
            'records' => $records->map(fn ($item) => [
                'id' => $item->id,
                'suhu' => (float) $item->suhu,
                'kelembapan' => (float) $item->kelembapan,
                'waktu' => Carbon::parse($item->dicatat_pada)->format('d M H:i:s'),
            ]),
        ]);
    }

    /**
     * List all registered IoT sensors and their live status.
     */
    public function sensors(): JsonResponse
    {
        $sensors = Sensor::with('kandang')->get();

        return response()->json([
            'success' => true,
            'total' => $sensors->count(),
            'online_count' => $sensors->where('status', 'online')->count(),
            'sensors' => $sensors->map(fn ($sensor) => [
                'id' => $sensor->id,
                'nama' => $sensor->nama,
                'kandang' => $sensor->kandang?->nama ?? 'Tidak terhubung',
                'perangkat' => $sensor->perangkat,
                'mikrokontroler' => $sensor->mikrokontroler,
                'status' => $sensor->status,
                'last_sync' => $sensor->last_sync?->toIso8601String(),
                'last_sync_relative' => $sensor->last_sync ? $sensor->last_sync->diffForHumans() : 'Belum pernah sinkron',
            ]),
        ]);
    }

    /**
     * Connectivity ping check endpoint for IoT microcontrollers.
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'AXION IoT Gateway online dan siap menerima telemetri.',
            'server_time' => now()->toIso8601String(),
            'version' => '1.0.0',
        ]);
    }
}

