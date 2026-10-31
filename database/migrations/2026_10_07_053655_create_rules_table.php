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
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 10)->unique();
            $table->string('nama', 120);
            $table->text('kesimpulan');
            $table->enum('level_risiko', ['rendah', 'sedang', 'tinggi', 'kritis']);
            $table->decimal('bobot_cf', 3, 2)->default(0.80);
            $table->unsignedTinyInteger('pengurang_skor')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
