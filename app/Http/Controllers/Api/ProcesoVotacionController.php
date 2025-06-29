<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcesoVotacion;

class ProcesoVotacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $procesos = ProcesoVotacion::with('usuario')->get();
        return response()->json($procesos);
    }

    /**
     * Get the active voting process.
     */
    public function getActive()
    {
        $proceso = ProcesoVotacion::where('etapa', 'activo')
                                  ->orWhere('etapa', 'en_proceso')
                                  ->orderBy('created_at', 'desc')
                                  ->first();
        
        if (!$proceso) {
            // Si no hay proceso activo, crear uno por defecto
            $proceso = ProcesoVotacion::create([
                'etapa' => 'activo',
                'modificado_por' => 1 // Usuario por defecto
            ]);
        }
        
        return response()->json($proceso);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $proceso = ProcesoVotacion::create($request->all());
        return response()->json($proceso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proceso = ProcesoVotacion::find($id);
        return response()->json($proceso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proceso = ProcesoVotacion::find($id);
        $proceso->update($request->all());
        return response()->json($proceso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proceso = ProcesoVotacion::find($id);
        $proceso->delete();
        return response()->json(null, 204);
    }
}
