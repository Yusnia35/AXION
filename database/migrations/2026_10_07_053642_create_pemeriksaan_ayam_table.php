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
        Schema::create('pemeriksaan_ayam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kelompok_id');
            $table->enum('nafsu_makan', ['normal', 'menurun', 'tidak_mau_makan']);
            $table->enum('aktivitas', ['aktif', 'lesu', 'sangat_lesu']);
            $table->enum('kondisi_mata', ['normal', 'berair', 'bengkak']);
            $table->enum('kondisi_bulu', ['normal', 'kusut', 'rontok']);
            $table->enum('batuk_bersin', ['tidak_ada', 'ringan', 'sering']);
            $table->enum('kondisi_kotoran', ['normal', 'encer', 'kehijauan', 'berdarah']);
            $table->text('catatan')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->dateTime('dicatat_pada')->useCurrent();

            $table->foreign('kelompok_id', 'fk_pa_kelompok')
                ->references('id')
                ->on('kelompok_ayam')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'fk_pa_user')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['kelompok_id', 'dicatat_pada'], 'idx_pa_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_ayam');
    }
};
