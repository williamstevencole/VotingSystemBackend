<?php

use Illuminate\Support\Facades\Route; # This line is necessary to import the Route facade for defining API routes

# Importing the necessary controllers for handling API requests
use App\Http\Controllers\Api\PartidoController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\MunicipioController;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\CandidatoPresidenteController;
use App\Http\Controllers\Api\CandidatoDiputadoController;
use App\Http\Controllers\Api\CandidatoAlcaldeController;
use App\Http\Controllers\Api\VotoPresidencialController;
use App\Http\Controllers\Api\VotoDiputadoController;
use App\Http\Controllers\Api\VotoAlcaldeController;


# Defining API routes for the voting system application
Route::middleware('api')->group(function () {
    Route::apiResource('partidos', PartidoController::class);
    Route::apiResource('departamentos', DepartamentoController::class);
    Route::apiResource('municipios', MunicipioController::class);
    Route::apiResource('personas', PersonaController::class);
    Route::apiResource('candidatos/presidente', CandidatoPresidenteController::class);
    Route::apiResource('candidatos/diputado', CandidatoDiputadoController::class);
    Route::apiResource('candidatos/alcalde', CandidatoAlcaldeController::class);
    Route::apiResource('votos/presidencial', VotoPresidencialController::class);
    Route::apiResource('votos/diputado', VotoDiputadoController::class);
    Route::apiResource('votos/alcalde', VotoAlcaldeController::class);
});
