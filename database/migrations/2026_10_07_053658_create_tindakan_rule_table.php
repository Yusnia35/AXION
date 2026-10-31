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
        Schema::create('tindakan_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rule_id');
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->string('tindakan', 255);
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');

            $table->foreign('rule_id', 'fk_tr_rule')
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
        Schema::dropIfExists('tindakan_rule');
    }
};
