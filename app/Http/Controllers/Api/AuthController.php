<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login user and return token
     */


     //SI la request incluye correo y contraseña, se debe verificar si el usuario existe y si la contraseña es correcta, si es correcto, se debe de crear el token con los datos de ese usuario.
     //Si la request solo incluye numero de identidad, se debe verificar si la persona existe, si no existe, se debe de crear la persona y se manda el token con los datos de esa persona.
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required_without:no_identidad',
            'no_identidad' => 'required_without:correo',
            'contrasena' => 'required_with:correo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->has('correo') && $request->has('contrasena')) {
            $usuario = Usuario::where('correo', $request->correo)->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            if (!Hash::check($request->contrasena, $usuario->contrasena)) {
                return response()->json(['error' => 'Contraseña incorrecta'], 401);
            }
            $token = $usuario->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'id_usuario' => $usuario->id_usuario, 'correo' => $usuario->correo, 'id_persona' => $usuario->persona->id_persona, 'nombre' => $usuario->persona->nombre, 'no_identidad' => $usuario->persona->no_identidad], 200);
        }

        if ($request->has('no_identidad')) {
            $persona = Persona::where('no_identidad', $request->no_identidad)->first();
            if (!$persona) {
                return response()->json(['error' => 'Persona no encontrada'], 404);
            }
            $token = $persona->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'id_persona' => $persona->id_persona, 'nombre' => $persona->nombre, 'no_identidad' => $persona->no_identidad], 200);
        }

        return response()->json(['error' => 'No se proporcionó correo o contraseña'], 400);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout exitoso'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user info
     */
    public function me(Request $request)
    {
        try {
            $usuario = $request->user();
            $usuario->load('persona.municipio.departamento');

            return response()->json([
                'success' => true,
                'data' => [
                    'id_usuario' => $usuario->id_usuario,
                    'correo' => $usuario->correo,
                    'persona' => [
                        'id_persona' => $usuario->persona->id_persona,
                        'nombre' => $usuario->persona->nombre,
                        'no_identidad' => $usuario->persona->no_identidad,
                        'municipio' => [
                            'id_municipio' => $usuario->persona->municipio->id_municipio,
                            'nombre' => $usuario->persona->municipio->nombre,
                            'departamento' => [
                                'id_departamento' => $usuario->persona->municipio->departamento->id_departamento,
                                'nombre' => $usuario->persona->municipio->departamento->nombre,
                            ]
                        ]
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información del usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 