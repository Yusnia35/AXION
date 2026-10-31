<?php

namespace Database\Seeders;

use App\Models\Kandang;
use App\Models\MonitoringSensor;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MonitoringSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kandangA = Kandang::firstOrCreate(['nama' => 'Kandang A'], [
            'workspace_id' => 1,
            'kode' => 'KDG-01',
            'tipe' => 'closed_house',
            'kapasitas' => 5000,
            'status' => 'aktif',
        ]);

        $kandangB = Kandang::where('id', 2)->first() ?? Kandang::first();

        $sensorA = Sensor::where('kandang_id', $kandangA->id)->first();
        $sensorB = Sensor::where('kandang_id', $kandangB?->id)->first() ?? $sensorA;

        // Generate 20 realistic records with varied telemetry across hours
        $telemetris = [
            [
                'suhu' => 32.8,
                'kelembapan' => 78.5,
                'ventilasi' => 'kurang',
                'kebersihan' => 'cukup',
                'sumber' => 'sensor',
                'menit_lalu' => 2,
            ],
            [
                'suhu' => 33.4,
                'kelembapan' => 82.0,
                'ventilasi' => 'kurang',
                'kebersihan' => 'cukup',
                'sumber' => 'sensor',
                'menit_lalu' => 15,
            ],
            [
                'suhu' => 32.1,
                'kelembapan' => 75.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 30,
            ],
            [
                'suhu' => 31.5,
                'kelembapan' => 74.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 45,
            ],
            [
                'suhu' => 30.2,
                'kelembapan' => 71.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 60,
            ],
            [
                'suhu' => 28.5,
                'kelembapan' => 68.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 90,
            ],
            [
                'suhu' => 27.2,
                'kelembapan' => 65.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 120,
            ],
            [
                'suhu' => 26.5,
                'kelembapan' => 64.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 180,
            ],
            [
                'suhu' => 25.8,
                'kelembapan' => 62.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 240,
            ],
            [
                'suhu' => 24.5,
                'kelembapan' => 60.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 300,
            ],
            [
                'suhu' => 23.2,
                'kelembapan' => 67.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 360,
            ],
            [
                'suhu' => 22.8,
                'kelembapan' => 69.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 420,
            ],
            [
                'suhu' => 25.0,
                'kelembapan' => 63.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 480,
            ],
            [
                'suhu' => 27.8,
                'kelembapan' => 66.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 540,
            ],
            [
                'suhu' => 29.5,
                'kelembapan' => 70.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 600,
            ],
            [
                'suhu' => 31.0,
                'kelembapan' => 72.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 660,
            ],
            [
                'suhu' => 32.5,
                'kelembapan' => 76.0,
                'ventilasi' => 'kurang',
                'kebersihan' => 'cukup',
                'sumber' => 'sensor',
                'menit_lalu' => 720,
            ],
            [
                'suhu' => 33.1,
                'kelembapan' => 81.0,
                'ventilasi' => 'kurang',
                'kebersihan' => 'cukup',
                'sumber' => 'sensor',
                'menit_lalu' => 780,
            ],
            [
                'suhu' => 30.8,
                'kelembapan' => 73.0,
                'ventilasi' => 'cukup',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 840,
            ],
            [
                'suhu' => 28.0,
                'kelembapan' => 65.0,
                'ventilasi' => 'baik',
                'kebersihan' => 'baik',
                'sumber' => 'sensor',
                'menit_lalu' => 900,
            ],
        ];

        // Clear existing data safely
        MonitoringSensor::query()->delete();

        foreach ($telemetris as $index => $item) {
            $kandang = ($index % 3 === 0 && $kandangB) ? $kandangB : $kandangA;
            $sensor = ($index % 3 === 0 && $sensorB) ? $sensorB : $sensorA;

            MonitoringSensor::create([
                'kandang_id' => $kandang->id,
                'sensor_id' => $sensor?->id,
                'suhu' => $item['suhu'],
                'kelembapan' => $item['kelembapan'],
                'ventilasi' => $item['ventilasi'],
                'kebersihan' => $item['kebersihan'],
                'sumber' => $item['sumber'],
                'user_id' => 1,
                'dicatat_pada' => Carbon::now()->subMinutes($item['menit_lalu']),
            ]);
        }
    }
}
