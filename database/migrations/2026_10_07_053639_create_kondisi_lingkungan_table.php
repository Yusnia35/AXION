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
        Schema::create('kondisi_lingkungan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kandang_id');
            $table->enum('ventilasi', ['baik', 'cukup', 'kurang']);
            $table->enum('kebersihan', ['baik', 'cukup', 'kurang']);
            $table->enum('kondisi_litter', ['kering', 'lembap', 'basah']);
            $table->enum('kepadatan', ['rendah', 'normal', 'padat']);
            $table->unsignedInteger('user_id')->nullable();
            $table->dateTime('dicatat_pada')->useCurrent();

            $table->foreign('kandang_id', 'fk_kl_kandang')
                ->references('id')
                ->on('kandang')
                ->cascadeOnDelete();

            $table->foreign('user_id', 'fk_kl_user')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index(['kandang_id', 'dicatat_pada'], 'idx_kl_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_lingkungan');
    }
};
