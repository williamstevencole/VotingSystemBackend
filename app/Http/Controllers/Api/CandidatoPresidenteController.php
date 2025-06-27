<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidatoPresidente;
use Illuminate\Http\JsonResponse;

class CandidatoPresidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $candidatos = CandidatoPresidente::with(['partido', 'movimiento'])->get();
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
            'nombre' => 'required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoPresidente::create($request->all());
        return response()->json($candidato->load(['partido', 'movimiento']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $candidato = CandidatoPresidente::with(['partido', 'movimiento', 'votos'])
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
            'nombre' => 'sometimes|required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoPresidente::findOrFail($id);
        $candidato->update($request->all());
        return response()->json($candidato->load(['partido', 'movimiento']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $candidato = CandidatoPresidente::findOrFail($id);
        $candidato->delete();
        return response()->json(null, 204);
    }

    /**
     * Get candidatos by partido
     */
    public function getByPartido(string $partidoId): JsonResponse
    {
        $candidatos = CandidatoPresidente::where('id_partido', $partidoId)
            ->with(['partido', 'movimiento'])
            ->get();
        return response()->json($candidatos);
    }

    /**
     * Get candidatos by movimiento
     */
    public function getByMovimiento(string $movimientoId): JsonResponse
    {
        $candidatos = CandidatoPresidente::where('id_movimiento', $movimientoId)
            ->with(['partido', 'movimiento'])
            ->get();
        return response()->json($candidatos);
    }
}
