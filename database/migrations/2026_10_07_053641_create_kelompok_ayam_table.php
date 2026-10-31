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
        Schema::create('kelompok_ayam', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kandang_id');
            $table->string('kode', 30)->unique();
            $table->unsignedInteger('jumlah_ayam');
            $table->date('tanggal_masuk');
            $table->string('profil', 30)->default('Campuran');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('kandang_id', 'fk_ka_kandang')
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
        Schema::dropIfExists('kelompok_ayam');
    }
};
