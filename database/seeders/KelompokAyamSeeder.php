<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokAyamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompokAyam = [
            [
                'kandang_id' => 1,
                'kode' => 'Broiler A-01',
                'jumlah_ayam' => 450,
                'tanggal_masuk' => Carbon::now()->subDays(28)->toDateString(),
                'profil' => 'Campuran',
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'kandang_id' => 2,
                'kode' => 'Broiler B-01',
                'jumlah_ayam' => 530,
                'tanggal_masuk' => Carbon::now()->subDays(31)->toDateString(),
                'profil' => 'Campuran',
                'is_active' => 1,
                'created_at' => now(),
            ],
        ];

        foreach ($kelompokAyam as $item) {
            DB::table('kelompok_ayam')->updateOrInsert(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
