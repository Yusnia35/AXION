<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemeriksaanAyamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemeriksaans = [
            [
                'id' => 1,
                'kelompok_id' => 1, // Broiler A-01 (Kandang A)
                'nafsu_makan' => 'menurun',
                'aktivitas' => 'lesu',
                'kondisi_mata' => 'normal',
                'kondisi_bulu' => 'kusut',
                'batuk_bersin' => 'ringan',
                'kondisi_kotoran' => 'encer',
                'catatan' => 'Beberapa ekor ayam tampak lesu dan bergerombol di dekat tirai. Terdengar bersin ringan sesekali saat siang hari hangat.',
                'user_id' => 1,
                'dicatat_pada' => Carbon::now()->subHours(3),
            ],
            [
                'id' => 2,
                'kelompok_id' => 2, // Broiler B-01 (Kandang B)
                'nafsu_makan' => 'normal',
                'aktivitas' => 'aktif',
                'kondisi_mata' => 'normal',
                'kondisi_bulu' => 'normal',
                'batuk_bersin' => 'tidak_ada',
                'kondisi_kotoran' => 'normal',
                'catatan' => 'Kawanan ayam sangat lincah, penyebaran pakan merata, dan kotoran feses normal padat.',
                'user_id' => 1,
                'dicatat_pada' => Carbon::now()->subHours(2),
            ],
            [
                'id' => 3,
                'kelompok_id' => 1, // Broiler A-01 (Kandang A)
                'nafsu_makan' => 'normal',
                'aktivitas' => 'aktif',
                'kondisi_mata' => 'normal',
                'kondisi_bulu' => 'normal',
                'batuk_bersin' => 'tidak_ada',
                'kondisi_kotoran' => 'normal',
                'catatan' => 'Pemeriksaan rutin pagi hari, kondisi kawanan terpantau sehat dan tidak ada gejala klinis.',
                'user_id' => 1,
                'dicatat_pada' => Carbon::now()->subDay()->setTime(8, 0),
            ],
            [
                'id' => 4,
                'kelompok_id' => 2, // Broiler B-01 (Kandang B)
                'nafsu_makan' => 'normal',
                'aktivitas' => 'aktif',
                'kondisi_mata' => 'normal',
                'kondisi_bulu' => 'normal',
                'batuk_bersin' => 'tidak_ada',
                'kondisi_kotoran' => 'normal',
                'catatan' => 'Mikroklimat closed house optimal, tingkat konsumsi pakan harian memenuhi target pertumbuhan FCR.',
                'user_id' => 1,
                'dicatat_pada' => Carbon::now()->subDays(2)->setTime(8, 30),
            ],
        ];

        foreach ($pemeriksaans as $item) {
            DB::table('pemeriksaan_ayam')->updateOrInsert(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
