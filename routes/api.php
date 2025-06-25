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
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;

use App\Models\Usuario;

# Authentication routes
Route::post('/login', [AuthController::class, 'login']);

# Usuario routes (todas las rutas)
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id_usuario}', [UsuarioController::class, 'show']);
Route::put('/usuarios/{id_usuario}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id_usuario}', [UsuarioController::class, 'destroy']);

# Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    #aca irian las rutas que requieren autenticacion 

});
