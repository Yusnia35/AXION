<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalisisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $analises = [
            [
                'id' => 1,
                'kandang_id' => 1,
                'kelompok_id' => 1,
                'monitoring_id' => null,
                'kondisi_id' => null,
                'pemeriksaan_id' => null,
                'health_score' => 78,
                'level_risiko' => 'sedang',
                'status_kandang' => 'perlu_pantau',
                'cf_gabungan' => 0.650,
                'ringkasan' => 'Suhu kandang agak hangat dan ventilasi perlu ditingkatkan untuk mencegah stres panas.',
                'user_id' => 1,
                'dibuat_pada' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'kandang_id' => 2,
                'kelompok_id' => 2,
                'monitoring_id' => null,
                'kondisi_id' => null,
                'pemeriksaan_id' => null,
                'health_score' => 92,
                'level_risiko' => 'rendah',
                'status_kandang' => 'normal',
                'cf_gabungan' => 0.150,
                'ringkasan' => 'Kondisi mikroklimat kandang dan kesehatan ayam terpantau normal dan optimal.',
                'user_id' => 1,
                'dibuat_pada' => now()->subHours(1),
            ],
        ];

        foreach ($analises as $item) {
            DB::table('analisis')->updateOrInsert(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
