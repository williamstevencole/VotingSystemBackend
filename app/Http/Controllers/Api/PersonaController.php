<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\VotoPresidencial;
use App\Models\VotoDiputado;
use App\Models\VotoAlcalde;

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
        $persona = Persona::with('municipio.departamento')->where('no_identidad', $no_identidad)->first();
        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        $persona->departamento_id = $persona->municipio->departamento->id_departamento;
        $persona->municipio_id = $persona->municipio->id_municipio;

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

    /*
    * VErificar si la persona ya ha votado (aunque sea nulo)
    */
    public function verificarVoto(string $id_persona, string $id_proceso)
    {
        \Log::info("Verificando voto para persona: {$id_persona}, proceso: {$id_proceso}");
        
        $persona = Persona::find($id_persona);
        if (!$persona) {
            \Log::warning("Persona no encontrada: {$id_persona}");
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        \Log::info("Persona encontrada: {$persona->nombre}");

        // Verificar votos presidenciales
        $votosPresidenciales = VotoPresidencial::where('id_persona', $id_persona)->where('id_proceso', $id_proceso)->get();
        $votoPresidencial = $votosPresidenciales->count() > 0;
        \Log::info("Votos presidenciales encontrados: " . $votosPresidenciales->count());

        // Verificar votos diputados
        $votosDiputados = VotoDiputado::where('id_persona', $id_persona)->where('id_proceso', $id_proceso)->get();
        $votoDiputado = $votosDiputados->count() > 0;
        \Log::info("Votos diputados encontrados: " . $votosDiputados->count());

        // Verificar votos alcaldes
        $votosAlcaldes = VotoAlcalde::where('id_persona', $id_persona)->where('id_proceso', $id_proceso)->get();
        $votoAlcalde = $votosAlcaldes->count() > 0;
        \Log::info("Votos alcaldes encontrados: " . $votosAlcaldes->count());

        $yaVoto = $votoPresidencial || $votoDiputado || $votoAlcalde;

        \Log::info("Resultado final: yaVoto={$yaVoto}");

        return response()->json([
            'voto' => $yaVoto,
            'detalles' => [
                'presidencial' => $votoPresidencial,
                'diputado' => $votoDiputado,
                'alcalde' => $votoAlcalde
            ]
        ]);
    }
}
