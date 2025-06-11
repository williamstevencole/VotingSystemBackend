<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Partido;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Partido::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nombre'=>'required|unique:partidos']);
        return Partido::create($request->only('nombre'));
    }

    public function show(string $id)
    {
        return Partido::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $p = Partido::findOrFail($id);
        $request->validate(['nombre'=>"required|unique:partidos,nombre,{$id},id_partido"]);
        $p->update($request->only('nombre'));
        return $p;
    }

    public function destroy(string $id)
    {
        $p = Partido::findOrFail($id);
        $p->delete();
        return response()->noContent();
    }
}
