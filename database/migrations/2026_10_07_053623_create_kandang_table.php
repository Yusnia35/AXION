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
        Schema::create('kandang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('workspace_id');
            $table->string('nama', 50);
            $table->string('jenis_ayam', 30)->default('Broiler');
            $table->enum('tipe_kandang', ['open_house', 'closed_house']);
            $table->string('lokasi', 100)->nullable();
            $table->unsignedInteger('kapasitas');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('workspace_id', 'fk_kandang_ws')
                ->references('id')
                ->on('workspaces')
                ->cascadeOnDelete();

            $table->unique(['workspace_id', 'nama'], 'uq_kandang_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandang');
    }
};
