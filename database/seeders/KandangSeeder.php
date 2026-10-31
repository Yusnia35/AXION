<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kandangs = [
            [
                'id' => 1,
                'workspace_id' => 1,
                'nama' => 'Kandang A',
                'jenis_ayam' => 'Broiler',
                'tipe_kandang' => 'open_house',
                'lokasi' => 'Blok Utara',
                'kapasitas' => 500,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'workspace_id' => 1,
                'nama' => 'Kandang B',
                'jenis_ayam' => 'Broiler',
                'tipe_kandang' => 'closed_house',
                'lokasi' => 'Blok Selatan',
                'kapasitas' => 600,
                'created_at' => now(),
            ],
        ];

        foreach ($kandangs as $kandang) {
            DB::table('kandang')->updateOrInsert(
                ['id' => $kandang['id']],
                $kandang
            );
        }
    }
}
