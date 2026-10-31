<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_riwayat');
        DB::statement('
            CREATE VIEW v_riwayat AS
            SELECT a.id            AS analisis_id,
                   a.dibuat_pada,
                   k.nama          AS kandang,
                   g.kode          AS kelompok_ayam,
                   m.suhu,
                   m.kelembapan,
                   a.health_score,
                   a.level_risiko,
                   a.status_kandang,
                   a.ringkasan,
                   u.nama          AS dianalisis_oleh
            FROM analisis a
            JOIN kandang k             ON k.id = a.kandang_id
            LEFT JOIN kelompok_ayam g  ON g.id = a.kelompok_id
            LEFT JOIN monitoring_sensor m ON m.id = a.monitoring_id
            LEFT JOIN users u          ON u.id = a.user_id
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_riwayat');
    }
};
