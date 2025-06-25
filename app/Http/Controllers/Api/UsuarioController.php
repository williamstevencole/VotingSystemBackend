<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        if($usuarios->count() > 0){
            return response()->json($usuarios);
        }else{
            return response()->json(['message' => 'No se encontraron usuarios'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Usuario::create($request->all());
        if($usuario){
            return response()->json($usuario, 201);
        }else{
            return response()->json(['message' => 'Error al crear el usuario'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = Usuario::find($id_usuario);
        if($usuario){
            return response()->json($usuario);
        }else{
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        if($usuario){
            $usuario->update($request->all());
            return response()->json($usuario);
        }else{
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);
        if($usuario){
            $usuario->delete();
            return response()->json(null, 204);
        }else{
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
}
