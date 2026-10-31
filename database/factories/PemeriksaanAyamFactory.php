<?php

namespace Database\Factories;

use App\Models\KelompokAyam;
use App\Models\PemeriksaanAyam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PemeriksaanAyam>
 */
class PemeriksaanAyamFactory extends Factory
{
    protected $model = PemeriksaanAyam::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kelompok_id' => KelompokAyam::factory(),
            'nafsu_makan' => fake()->randomElement(['normal', 'menurun', 'tidak_mau_makan']),
            'aktivitas' => fake()->randomElement(['aktif', 'lesu', 'sangat_lesu']),
            'kondisi_mata' => fake()->randomElement(['normal', 'berair', 'bengkak']),
            'kondisi_bulu' => fake()->randomElement(['normal', 'kusut', 'rontok']),
            'batuk_bersin' => fake()->randomElement(['tidak_ada', 'ringan', 'sering']),
            'kondisi_kotoran' => fake()->randomElement(['normal', 'encer', 'kehijauan', 'berdarah']),
            'catatan' => fake()->optional()->sentence(),
            'user_id' => User::factory(),
            'dicatat_pada' => now(),
        ];
    }
}
