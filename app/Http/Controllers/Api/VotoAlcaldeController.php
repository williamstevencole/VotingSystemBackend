<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VotoAlcalde;

class VotoAlcaldeController extends Controller
{
    /**
     * Display a listing of the of alcalde votes.
     */
    public function index()
    {
        $votos = VotoAlcalde::all();
        return response()->json($votos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'id_candidato' => 'nullable|exists:candidato_alcaldes,id_candidato',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_proceso' => 'nullable|exists:proceso_votacion,id_proceso',
            'tiempo' => 'required|date',
        ]);

        $voto = VotoAlcalde::create($request->all());
        return response()->json($voto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $voto = VotoAlcalde::find($id);
        if($voto){
            return response()->json($voto);
        }else{
            return response()->json(['message' => 'Voto no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $voto = VotoAlcalde::find($id);
        if($voto){
            $voto->update($request->all());
            return response()->json($voto);
        }else{
            return response()->json(['message' => 'Voto no encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voto = VotoAlcalde::find($id);
        if($voto){
            $voto->delete();
            return response()->json(['message' => 'Voto eliminado'], 200);
        }else{
            return response()->json(['message' => 'Voto no encontrado'], 404);
        }
    }
}
