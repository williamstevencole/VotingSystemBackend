<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::all();
        return response()->json($personas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $persona = Persona::create($request->all());
        return response()->json($persona, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_persona)
    {
        $persona = Persona::find($id_persona);
        return response()->json($persona);
    }

    /**
     * Get persona by no_identidad
     */
    public function getByNoIdentidad(string $no_identidad)
    {
        $persona = Persona::where('no_identidad', $no_identidad)->first();
        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }
        return response()->json($persona);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_persona)
    {
        $persona = Persona::find($id_persona);
        $persona->update($request->all());
        return response()->json($persona);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_persona)
    {
        $persona = Persona::find($id_persona);
        $persona->delete();
        return response()->json(null, 204);
    }
}
