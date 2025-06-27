<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidatoDiputado;
use Illuminate\Http\JsonResponse;

class CandidatoDiputadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $candidatos = CandidatoDiputado::with(['partido', 'movimiento', 'departamento'])->get();
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
            'id_departamento' => 'required|exists:departamentos,id_departamento',
            'nombre' => 'required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoDiputado::create($request->all());
        return response()->json($candidato->load(['partido', 'movimiento', 'departamento']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $candidato = CandidatoDiputado::with(['partido', 'movimiento', 'departamento', 'votos'])
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
            'id_departamento' => 'sometimes|required|exists:departamentos,id_departamento',
            'nombre' => 'sometimes|required|string|max:255',
            'foto_url' => 'nullable|url|max:500'
        ]);

        $candidato = CandidatoDiputado::findOrFail($id);
        $candidato->update($request->all());
        return response()->json($candidato->load(['partido', 'movimiento', 'departamento']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $candidato = CandidatoDiputado::findOrFail($id);
        $candidato->delete();
        return response()->json(null, 204);
    }

    /**
     * Get candidatos by partido
     */
    public function getByPartido(string $partidoId): JsonResponse
    {
        $candidatos = CandidatoDiputado::where('id_partido', $partidoId)
            ->with(['partido', 'movimiento', 'departamento'])
            ->get();
        return response()->json($candidatos);
    }

    /**
     * Get candidatos by movimiento
     */
    public function getByMovimiento(string $movimientoId): JsonResponse
    {
        $candidatos = CandidatoDiputado::where('id_movimiento', $movimientoId)
            ->with(['partido', 'movimiento', 'departamento'])
            ->get();
        return response()->json($candidatos);
    }
}
