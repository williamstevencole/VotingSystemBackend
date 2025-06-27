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
        Schema::table('candidato_presidentes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_movimiento')->nullable()->after('id_partido');
            $table->foreign('id_movimiento')->references('id_movimiento')->on('movimientos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidato_presidentes', function (Blueprint $table) {
            $table->dropForeign(['id_movimiento']);
            $table->dropColumn('id_movimiento');
        });
    }
};
