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
        Schema::create('monitoring_sensor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kandang_id');
            $table->unsignedInteger('sensor_id')->nullable();
            $table->decimal('suhu', 4, 1);
            $table->decimal('kelembapan', 4, 1);
            $table->enum('ventilasi', ['baik', 'cukup', 'kurang'])->nullable();
            $table->enum('kebersihan', ['baik', 'cukup', 'kurang'])->nullable();
            $table->enum('sumber', ['sensor', 'manual'])->default('sensor');
            $table->unsignedInteger('user_id')->nullable();
            $table->dateTime('dicatat_pada')->useCurrent();

            $table->foreign('kandang_id', 'fk_mon_kandang')
                ->references('id')
                ->on('kandang')
                ->cascadeOnDelete();

            $table->foreign('sensor_id', 'fk_mon_sensor')
                ->references('id')
                ->on('sensor')
                ->nullOnDelete();

            $table->foreign('user_id', 'fk_mon_user')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['kandang_id', 'dicatat_pada'], 'idx_mon_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_sensor');
    }
};
