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
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('analisis_id');
            $table->unsignedInteger('rule_id')->nullable();
            $table->string('tindakan', 255);
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status', ['baru', 'in_progress', 'selesai'])->default('baru');
            $table->dateTime('selesai_pada')->nullable();
            $table->dateTime('dibuat_pada')->useCurrent();

            $table->foreign('analisis_id', 'fk_rek_analisis')
                ->references('id')
                ->on('analisis')
                ->cascadeOnDelete();

            $table->foreign('rule_id', 'fk_rek_rule')
                ->references('id')
                ->on('rules')
                ->nullOnDelete();

            $table->index('status', 'idx_rek_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
