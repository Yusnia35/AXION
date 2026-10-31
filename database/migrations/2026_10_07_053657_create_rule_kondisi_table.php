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
        Schema::create('rule_kondisi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rule_id');
            $table->enum('parameter', [
                'suhu',
                'kelembapan',
                'ventilasi',
                'kebersihan',
                'kondisi_litter',
                'kepadatan',
                'nafsu_makan',
                'aktivitas',
                'kondisi_mata',
                'kondisi_bulu',
                'batuk_bersin',
                'kondisi_kotoran',
            ]);
            $table->enum('operator', ['>', '>=', '<', '<=', '=', '!=']);
            $table->string('nilai', 30);

            $table->foreign('rule_id', 'fk_rk_rule')
                ->references('id')
                ->on('rules')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_kondisi');
    }
};
