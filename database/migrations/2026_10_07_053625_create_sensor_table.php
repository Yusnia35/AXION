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
        Schema::create('sensor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kandang_id');
            $table->string('nama', 50);
            $table->enum('jenis', ['suhu', 'kelembapan', 'suhu_kelembapan']);
            $table->string('perangkat', 30)->default('DHT22');
            $table->string('mikrokontroler', 30)->default('ESP32');
            $table->enum('status', ['online', 'offline'])->default('online');
            $table->dateTime('last_sync')->nullable();

            $table->foreign('kandang_id', 'fk_sensor_kandang')
                ->references('id')
                ->on('kandang')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor');
    }
};
