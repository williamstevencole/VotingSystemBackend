<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Models\Municipio;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipios = Municipio::all();
        return response()->json($municipios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $municipio = Municipio::create($request->all());
        return response()->json($municipio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $municipio = Municipio::find($id);
        return response()->json($municipio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $municipio = Municipio::find($id);
        $municipio->update($request->all());
        return response()->json($municipio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $municipio = Municipio::find($id);
        $municipio->delete();
        return response()->json(null, 204);
    }

    public function getByDepartamento(string $departamentoId = null)
    {
        try {
            if (!$departamentoId) {
                return response()->json(['error' => 'ID de departamento requerido'], 400);
            }

            $municipios = Municipio::where('id_departamento', $departamentoId)->get();
            
            return response()->json($municipios);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener municipios',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
