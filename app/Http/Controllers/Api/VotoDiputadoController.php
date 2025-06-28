<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VotoDiputado;

class VotoDiputadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $votos = VotoDiputado::all();
        return response()->json($votos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_persona' => 'required|exists:personas,id_persona',
            'id_candidato' => 'nullable|exists:candidato_diputados,id_candidato',
            'id_departamento' => 'required|exists:departamentos,id_departamento',
            'tiempo' => 'required|date',
        ]);

        $voto = VotoDiputado::create($request->all());
        return response()->json($voto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $voto = VotoDiputado::find($id);
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
        $voto = VotoDiputado::find($id);
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
        $voto = VotoDiputado::find($id);
        if($voto){
            $voto->delete();
            return response()->json(['message' => 'Voto eliminado'], 200);
        }else{
            return response()->json(['message' => 'Voto no encontrado'], 404);
        }
    }
}
