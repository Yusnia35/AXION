<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSistemPakarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'id' => 1,
                'kode' => 'R01',
                'nama' => 'Risiko heat stress',
                'kesimpulan' => 'Suhu dan kelembapan tinggi bersamaan, ayam berisiko mengalami heat stress.',
                'level_risiko' => 'tinggi',
                'bobot_cf' => 0.85,
                'pengurang_skor' => 25,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'kode' => 'R02',
                'nama' => 'Suhu hangat dengan ventilasi kurang',
                'kesimpulan' => 'Suhu kandang hangat dan ventilasi tidak memadai, panas mudah terperangkap.',
                'level_risiko' => 'sedang',
                'bobot_cf' => 0.70,
                'pengurang_skor' => 15,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'kode' => 'R03',
                'nama' => 'Suhu terlalu rendah',
                'kesimpulan' => 'Suhu kandang rendah, ayam berisiko kedinginan (chilling).',
                'level_risiko' => 'sedang',
                'bobot_cf' => 0.70,
                'pengurang_skor' => 15,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'kode' => 'R04',
                'nama' => 'Risiko amonia tinggi',
                'kesimpulan' => 'Litter basah dan ventilasi kurang meningkatkan kadar amonia.',
                'level_risiko' => 'tinggi',
                'bobot_cf' => 0.80,
                'pengurang_skor' => 20,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'kode' => 'R05',
                'nama' => 'Litter mulai lembap',
                'kesimpulan' => 'Litter lembap dengan kelembapan tinggi, perlu dijaga tetap kering.',
                'level_risiko' => 'rendah',
                'bobot_cf' => 0.50,
                'pengurang_skor' => 5,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'kode' => 'R06',
                'nama' => 'Indikasi gangguan pernapasan',
                'kesimpulan' => 'Batuk/bersin sering disertai nafsu makan menurun, indikasi gangguan pernapasan.',
                'level_risiko' => 'tinggi',
                'bobot_cf' => 0.80,
                'pengurang_skor' => 25,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 7,
                'kode' => 'R07',
                'nama' => 'Kotoran berdarah',
                'kesimpulan' => 'Kotoran berdarah, indikasi gangguan pencernaan serius (mis. koksidiosis).',
                'level_risiko' => 'kritis',
                'bobot_cf' => 0.90,
                'pengurang_skor' => 35,
                'is_active' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 8,
                'kode' => 'R08',
                'nama' => 'Kepadatan tinggi saat hangat',
                'kesimpulan' => 'Kandang padat pada suhu hangat meningkatkan stres panas.',
                'level_risiko' => 'sedang',
                'bobot_cf' => 0.60,
                'pengurang_skor' => 10,
                'is_active' => 1,
                'created_at' => now(),
            ],
        ];

        foreach ($rules as $rule) {
            DB::table('rules')->updateOrInsert(
                ['kode' => $rule['kode']],
                $rule
            );
        }

        // rule_kondisi
        DB::table('rule_kondisi')->delete();
        $ruleKondisi = [
            ['rule_id' => 1, 'parameter' => 'suhu',           'operator' => '>',  'nilai' => '32'],
            ['rule_id' => 1, 'parameter' => 'kelembapan',     'operator' => '>',  'nilai' => '80'],
            ['rule_id' => 2, 'parameter' => 'suhu',           'operator' => '>=', 'nilai' => '32'],
            ['rule_id' => 2, 'parameter' => 'ventilasi',      'operator' => '=',  'nilai' => 'kurang'],
            ['rule_id' => 3, 'parameter' => 'suhu',           'operator' => '<',  'nilai' => '24'],
            ['rule_id' => 4, 'parameter' => 'kondisi_litter', 'operator' => '=',  'nilai' => 'basah'],
            ['rule_id' => 4, 'parameter' => 'ventilasi',      'operator' => '=',  'nilai' => 'kurang'],
            ['rule_id' => 5, 'parameter' => 'kondisi_litter', 'operator' => '=',  'nilai' => 'lembap'],
            ['rule_id' => 5, 'parameter' => 'kelembapan',     'operator' => '>',  'nilai' => '75'],
            ['rule_id' => 6, 'parameter' => 'batuk_bersin',   'operator' => '=',  'nilai' => 'sering'],
            ['rule_id' => 6, 'parameter' => 'nafsu_makan',    'operator' => '!=', 'nilai' => 'normal'],
            ['rule_id' => 7, 'parameter' => 'kondisi_kotoran', 'operator' => '=',  'nilai' => 'berdarah'],
            ['rule_id' => 8, 'parameter' => 'kepadatan',      'operator' => '=',  'nilai' => 'padat'],
            ['rule_id' => 8, 'parameter' => 'suhu',           'operator' => '>=', 'nilai' => '31'],
        ];
        DB::table('rule_kondisi')->insert($ruleKondisi);

        // tindakan_rule
        DB::table('tindakan_rule')->delete();
        $tindakanRule = [
            ['rule_id' => 1, 'urutan' => 1, 'tindakan' => 'Aktifkan kipas/tambah ventilasi segera', 'prioritas' => 'tinggi'],
            ['rule_id' => 1, 'urutan' => 2, 'tindakan' => 'Pastikan air minum dingin dan tersedia cukup', 'prioritas' => 'tinggi'],
            ['rule_id' => 1, 'urutan' => 3, 'tindakan' => 'Cek ulang suhu dan kelembapan dalam 1 jam', 'prioritas' => 'sedang'],
            ['rule_id' => 2, 'urutan' => 1, 'tindakan' => 'Buka tirai samping 10-15 cm', 'prioritas' => 'sedang'],
            ['rule_id' => 2, 'urutan' => 2, 'tindakan' => 'Periksa kipas dan aliran udara', 'prioritas' => 'sedang'],
            ['rule_id' => 3, 'urutan' => 1, 'tindakan' => 'Nyalakan pemanas/brooder dan tutup sebagian tirai', 'prioritas' => 'sedang'],
            ['rule_id' => 4, 'urutan' => 1, 'tindakan' => 'Ganti atau balik litter yang basah', 'prioritas' => 'tinggi'],
            ['rule_id' => 4, 'urutan' => 2, 'tindakan' => 'Tingkatkan ventilasi untuk membuang amonia', 'prioritas' => 'tinggi'],
            ['rule_id' => 5, 'urutan' => 1, 'tindakan' => 'Pastikan litter tetap kering di sekitar tempat minum', 'prioritas' => 'rendah'],
            ['rule_id' => 5, 'urutan' => 2, 'tindakan' => 'Cek ulang suhu dan kelembapan dalam 2 jam', 'prioritas' => 'rendah'],
            ['rule_id' => 6, 'urutan' => 1, 'tindakan' => 'Pisahkan ayam yang bergejala dan perbaiki ventilasi', 'prioritas' => 'tinggi'],
            ['rule_id' => 6, 'urutan' => 2, 'tindakan' => 'Konsultasikan dengan dokter hewan', 'prioritas' => 'tinggi'],
            ['rule_id' => 7, 'urutan' => 1, 'tindakan' => 'Segera hubungi dokter hewan', 'prioritas' => 'tinggi'],
            ['rule_id' => 7, 'urutan' => 2, 'tindakan' => 'Isolasi ayam sakit dan jaga kebersihan kandang', 'prioritas' => 'tinggi'],
            ['rule_id' => 8, 'urutan' => 1, 'tindakan' => 'Kurangi kepadatan atau perbaiki sirkulasi udara', 'prioritas' => 'sedang'],
        ];
        DB::table('tindakan_rule')->insert($tindakanRule);
    }
}
