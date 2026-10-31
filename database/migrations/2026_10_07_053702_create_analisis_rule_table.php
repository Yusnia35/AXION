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
        Schema::create('analisis_rule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('analisis_id');
            $table->unsignedInteger('rule_id');
            $table->decimal('cf_nilai', 4, 3);

            $table->foreign('analisis_id', 'fk_ar_analisis')
                ->references('id')
                ->on('analisis')
                ->cascadeOnDelete();

            $table->foreign('rule_id', 'fk_ar_rule')
                ->references('id')
                ->on('rules')
                ->cascadeOnDelete();

            $table->unique(['analisis_id', 'rule_id'], 'uq_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_rule');
    }
};
