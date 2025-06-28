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
        Schema::create('proceso_votacion', function (Blueprint $table) {
            $table->id('id_proceso'); 
            $table->enum('etapa', ['Prevotacion','Votacion','Postvotacion'])
                  ->default('Prevotacion');
            $table->unsignedBigInteger('modificado_por')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proceso_votacion');
    }
};
