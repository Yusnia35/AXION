<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kandang_id');
            $table->unsignedInteger('kelompok_id')->nullable();
            $table->unsignedBigInteger('monitoring_id')->nullable();
            $table->unsignedBigInteger('kondisi_id')->nullable();
            $table->unsignedBigInteger('pemeriksaan_id')->nullable();
            $table->unsignedTinyInteger('health_score');
            $table->enum('level_risiko', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('rendah');
            $table->enum('status_kandang', ['normal', 'perlu_pantau', 'bahaya'])->default('normal');
            $table->decimal('cf_gabungan', 4, 3)->nullable();
            $table->text('ringkasan')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->dateTime('dibuat_pada')->useCurrent();

            $table->foreign('kandang_id', 'fk_an_kandang')
                ->references('id')
                ->on('kandang')
                ->cascadeOnDelete();

            $table->foreign('kelompok_id', 'fk_an_kelompok')
                ->references('id')
                ->on('kelompok_ayam')
                ->nullOnDelete();

            $table->foreign('monitoring_id', 'fk_an_mon')
                ->references('id')
                ->on('monitoring_sensor')
                ->nullOnDelete();

            $table->foreign('kondisi_id', 'fk_an_kl')
                ->references('id')
                ->on('kondisi_lingkungan')
                ->nullOnDelete();

            $table->foreign('pemeriksaan_id', 'fk_an_pa')
                ->references('id')
                ->on('pemeriksaan_ayam')
                ->nullOnDelete();

            $table->foreign('user_id', 'fk_an_user')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['kandang_id', 'dibuat_pada'], 'idx_an_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis');
    }
};
