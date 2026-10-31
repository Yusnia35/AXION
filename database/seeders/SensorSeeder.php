<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensors = [
            [
                'kandang_id' => 1,
                'nama' => 'DHT22 Kandang A',
                'jenis' => 'suhu_kelembapan',
                'perangkat' => 'DHT22',
                'mikrokontroler' => 'ESP32',
                'status' => 'offline',
                'last_sync' => null,
            ],
            [
                'kandang_id' => 2,
                'nama' => 'DHT22 Kandang B',
                'jenis' => 'suhu_kelembapan',
                'perangkat' => 'DHT22',
                'mikrokontroler' => 'ESP32',
                'status' => 'offline',
                'last_sync' => null,
            ],
        ];

        foreach ($sensors as $sensor) {
            DB::table('sensor')->updateOrInsert(
                [
                    'kandang_id' => $sensor['kandang_id'],
                    'nama' => $sensor['nama'],
                ],
                $sensor
            );
        }
    }
}
