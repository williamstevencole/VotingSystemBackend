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
use App\Http\Controllers\Api\EstadisticasController;

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
Route::get('/municipios/{municipioId}/candidatos-alcalde', [CandidatoAlcaldeController::class, 'getByMunicipio']);

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
Route::get('/votos-presidenciales', [VotoPresidencialController::class, 'index']);
Route::post('/votos-presidenciales', [VotoPresidencialController::class, 'store']);
Route::get('/votos-presidenciales/{id}', [VotoPresidencialController::class, 'show']);
Route::put('/votos-presidenciales/{id}', [VotoPresidencialController::class, 'update']);
Route::delete('/votos-presidenciales/{id}', [VotoPresidencialController::class, 'destroy']);

Route::get('/votos-diputados', [VotoDiputadoController::class, 'index']);
Route::post('/votos-diputados', [VotoDiputadoController::class, 'store']);
Route::get('/votos-diputados/{id}', [VotoDiputadoController::class, 'show']);
Route::put('/votos-diputados/{id}', [VotoDiputadoController::class, 'update']);
Route::delete('/votos-diputados/{id}', [VotoDiputadoController::class, 'destroy']);

Route::get('/votos-alcaldes', [VotoAlcaldeController::class, 'index']);
Route::post('/votos-alcaldes', [VotoAlcaldeController::class, 'store']);
Route::get('/votos-alcaldes/{id}', [VotoAlcaldeController::class, 'show']);
Route::put('/votos-alcaldes/{id}', [VotoAlcaldeController::class, 'update']);
Route::delete('/votos-alcaldes/{id}', [VotoAlcaldeController::class, 'destroy']);

# Estadísticas routes
Route::prefix('estadisticas')->group(function () {
    //generales -> total de votos, total de personas, total de usuarios, total de partidos, total de movimientos, total de candidatos, total de votos por partido, total de votos por movimiento, total de votos por candidato
    Route::get('/generales', [EstadisticasController::class, 'generales']);
    //participacion de presidenciales por departamento, participacion = votos presidenciales / votos presidenciales totales
    Route::get('/presidenciales', [EstadisticasController::class, 'presidenciales']);
    //participacion de presidenciales por departamento, participacion = votos presidenciales / votos presidenciales totales
    Route::get('/diputados', [EstadisticasController::class, 'diputados']);
    //participacion de diputados por departamento, participacion = votos diputados / votos diputados totales
    Route::get('/alcaldes', [EstadisticasController::class, 'alcaldes']);
    //comparativa de partidos, comparativa = votos partido / votos partido total
    Route::get('/comparativa-partidos', [EstadisticasController::class, 'comparativaPartidos']);
    //ranking de presidentes por departamento, ranking = votos presidenciales / votos presidenciales totales
    Route::get('/ranking-presidentes', [EstadisticasController::class, 'rankingPresidentes']);
    //ranking de alcaldes por municipio, ranking = votos alcaldes / votos alcaldes totales
    Route::get('/ranking-alcaldes', [EstadisticasController::class, 'rankingAlcaldes']);
    //ranking de diputados por departamento, ranking = votos diputados / votos diputados totales
    Route::get('/ranking-diputados', [EstadisticasController::class, 'rankingDiputados']);
    //participacion de alcaldes por departamento, participacion = votos alcaldes / votos alcaldes totales
    Route::get('/participacion-departamentos', [EstadisticasController::class, 'participacionDepartamentos']);
    //participacion de alcaldes por municipio, participacion = votos alcaldes / votos alcaldes totales
    Route::get('/participacion-municipios', [EstadisticasController::class, 'participacionMunicipios']);
});

# Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    #aca irian las rutas que requieren autenticacion 

});
