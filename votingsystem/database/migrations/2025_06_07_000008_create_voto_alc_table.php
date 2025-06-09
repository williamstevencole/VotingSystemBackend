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
        Schema::create('voto_alcalde', function (Blueprint $table) {
            $table->id('id_voto');
            $table->foreignId('id_persona')
                  ->constrained('personas','id_persona');
            $table->foreignId('id_candidato')
                  ->constrained('candidato_alcaldes','id_candidato');
            $table->foreignId('id_municipio')
                  ->constrained('municipios','id_municipio');
            $table->dateTime('tiempo');
            $table->index(['id_candidato','id_municipio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voto_alcalde');
    }
};
