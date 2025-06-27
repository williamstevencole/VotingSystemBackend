<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movimiento;
use Illuminate\Http\JsonResponse;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $movimientos = Movimiento::with('partido')->get();
        return response()->json($movimientos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_partido' => 'required|exists:partidos,id_partido',
            'nombre' => 'required|string|max:255',
        ]);

        $movimiento = Movimiento::create($request->all());
        return response()->json($movimiento->load('partido'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $movimiento = Movimiento::with(['partido', 'candidatosPresidente', 'candidatosDiputado', 'candidatosAlcalde'])
            ->findOrFail($id);
        return response()->json($movimiento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'id_partido' => 'sometimes|required|exists:partidos,id_partido',
            'nombre' => 'sometimes|required|string|max:255',   
        ]);

        $movimiento = Movimiento::findOrFail($id);
        $movimiento->update($request->all());
        return response()->json($movimiento->load('partido'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $movimiento = Movimiento::findOrFail($id);
        $movimiento->delete();
        return response()->json(null, 204);
    }

    /**
     * Get movimientos by partido
     */
    public function getByPartido(string $partidoId): JsonResponse
    {
        $movimientos = Movimiento::where('id_partido', $partidoId)
            ->with('partido')
            ->get();
        return response()->json($movimientos);
    }
}
