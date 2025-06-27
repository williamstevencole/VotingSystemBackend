<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidatoAlcalde;
use Illuminate\Http\JsonResponse;

class CandidatoAlcaldeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $candidatos = CandidatoAlcalde::with(['partido', 'movimiento', 'municipio'])->get();
        return response()->json($candidatos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_partido' => 'required|exists:partidos,id_partido',
            'id_movimiento' => 'nullable|exists:movimientos,id_movimiento',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'nombre' => 'required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoAlcalde::create($request->all());
        return response()->json($candidato->load(['partido', 'movimiento', 'municipio']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $candidato = CandidatoAlcalde::with(['partido', 'movimiento', 'municipio', 'votos'])
            ->findOrFail($id);
        return response()->json($candidato);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'id_partido' => 'sometimes|required|exists:partidos,id_partido',
            'id_movimiento' => 'nullable|exists:movimientos,id_movimiento',
            'id_municipio' => 'sometimes|required|exists:municipios,id_municipio',
            'nombre' => 'sometimes|required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoAlcalde::findOrFail($id);
        $candidato->update($request->all());
        return response()->json($candidato->load(['partido', 'movimiento', 'municipio']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $candidato = CandidatoAlcalde::findOrFail($id);
        $candidato->delete();
        return response()->json(null, 204);
    }

    /**
     * Get candidatos by partido
     */
    public function getByPartido(string $partidoId = null): JsonResponse
    {
        $candidatos = CandidatoAlcalde::where('id_partido', $partidoId)
            ->with(['partido', 'movimiento', 'municipio'])
            ->get();
        return response()->json($candidatos);
    }

    /**
     * Get candidatos by movimiento
     */
    public function getByMovimiento(string $movimientoId): JsonResponse
    {
        $candidatos = CandidatoAlcalde::where('id_movimiento', $movimientoId)
            ->with(['partido', 'movimiento', 'municipio'])
            ->get();
        return response()->json($candidatos);
    }
}
