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
        Schema::table('voto_diputado', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proceso')->nullable()->after('id_departamento');
            $table->foreign('id_proceso')->references('id_proceso')->on('proceso_votacion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voto_diputado', function (Blueprint $table) {
            $table->dropForeign(['id_proceso']);
            $table->dropColumn('id_proceso');
        });
    }
};
