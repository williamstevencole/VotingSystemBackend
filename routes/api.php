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
use App\Http\Controllers\Api\MovimientoController;

use App\Models\Usuario;

# Authentication routes
Route::post('/login', [AuthController::class, 'login']);

# Usuario routes (todas las rutas)
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id_usuario}', [UsuarioController::class, 'show']);
Route::put('/usuarios/{id_usuario}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id_usuario}', [UsuarioController::class, 'destroy']);

# Movimiento routes
Route::get('/movimientos', [MovimientoController::class, 'index']);
Route::post('/movimientos', [MovimientoController::class, 'store']);
Route::get('/movimientos/{id}', [MovimientoController::class, 'show']);
Route::put('/movimientos/{id}', [MovimientoController::class, 'update']);
Route::delete('/movimientos/{id}', [MovimientoController::class, 'destroy']);
Route::get('/partidos/{partidoId}/movimientos', [MovimientoController::class, 'getByPartido']);

# Candidato Presidente routes
Route::get('/candidatos-presidente', [CandidatoPresidenteController::class, 'index']);
Route::post('/candidatos-presidente', [CandidatoPresidenteController::class, 'store']);
Route::get('/candidatos-presidente/{id}', [CandidatoPresidenteController::class, 'show']);
Route::put('/candidatos-presidente/{id}', [CandidatoPresidenteController::class, 'update']);
Route::delete('/candidatos-presidente/{id}', [CandidatoPresidenteController::class, 'destroy']);
Route::get('/partidos/{partidoId}/candidatos-presidente', [CandidatoPresidenteController::class, 'getByPartido']);
Route::get('/movimientos/{movimientoId}/candidatos-presidente', [CandidatoPresidenteController::class, 'getByMovimiento']);

# Candidato Diputado routes
Route::get('/candidatos-diputado', [CandidatoDiputadoController::class, 'index']);
Route::post('/candidatos-diputado', [CandidatoDiputadoController::class, 'store']);
Route::get('/candidatos-diputado/{id}', [CandidatoDiputadoController::class, 'show']);
Route::put('/candidatos-diputado/{id}', [CandidatoDiputadoController::class, 'update']);
Route::delete('/candidatos-diputado/{id}', [CandidatoDiputadoController::class, 'destroy']);
Route::get('/partidos/{partidoId}/candidatos-diputado', [CandidatoDiputadoController::class, 'getByPartido']);
Route::get('/movimientos/{movimientoId}/candidatos-diputado', [CandidatoDiputadoController::class, 'getByMovimiento']);

# Candidato Alcalde routes
Route::get('/candidatos-alcalde', [CandidatoAlcaldeController::class, 'index']);
Route::post('/candidatos-alcalde', [CandidatoAlcaldeController::class, 'store']);
Route::get('/candidatos-alcalde/{id}', [CandidatoAlcaldeController::class, 'show']);
Route::put('/candidatos-alcalde/{id}', [CandidatoAlcaldeController::class, 'update']);
Route::delete('/candidatos-alcalde/{id}', [CandidatoAlcaldeController::class, 'destroy']);
Route::get('/partidos/{partidoId}/candidatos-alcalde', [CandidatoAlcaldeController::class, 'getByPartido']);
Route::get('/movimientos/{movimientoId}/candidatos-alcalde', [CandidatoAlcaldeController::class, 'getByMovimiento']);

# Partido routes
Route::get('/partidos', [PartidoController::class, 'index']);
Route::post('/partidos', [PartidoController::class, 'store']);
Route::get('/partidos/{id}', [PartidoController::class, 'show']);
Route::put('/partidos/{id}', [PartidoController::class, 'update']);
Route::delete('/partidos/{id}', [PartidoController::class, 'destroy']);

#Movimiento routes
Route::get('/movimientos', [MovimientoController::class, 'index']);
Route::post('/movimientos', [MovimientoController::class, 'store']);
Route::get('/movimientos/{id}', [MovimientoController::class, 'show']);
Route::put('/movimientos/{id}', [MovimientoController::class, 'update']);
Route::delete('/movimientos/{id}', [MovimientoController::class, 'destroy']);

#Persona routes
Route::get('/personas', [PersonaController::class, 'index']);
Route::post('/personas', [PersonaController::class, 'store']);
Route::get('/personas/{id_persona}', [PersonaController::class, 'show']);
Route::put('/personas/{id_persona}', [PersonaController::class, 'update']);
Route::delete('/personas/{id_persona}', [PersonaController::class, 'destroy']);

#Usuario routes
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id_usuario}', [UsuarioController::class, 'show']);
Route::put('/usuarios/{id_usuario}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id_usuario}', [UsuarioController::class, 'destroy']);

#VOTO ROUTES


# Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    #aca irian las rutas que requieren autenticacion 

});
