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
        Schema::create('candidato_presidentes', function (Blueprint $table) {
            $table->id('id_candidato');
            $table->foreignId('id_partido')
                  ->constrained('partidos','id_partido')
                  ->onDelete('cascade');
            $table->string('nombre');
            $table->string('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidato_presidentes');
    }
};
