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
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:no_identidad|email',
            'no_identidad' => 'required_without:email|string',
            'password' => 'required|string|min:6',
        ], [
            'email.required_without' => 'El email es requerido cuando no se proporciona número de identidad.',
            'no_identidad.required_without' => 'El número de identidad es requerido cuando no se proporciona email.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $usuario = null;

            // Try to find user by email or identity number
            if ($request->has('email')) {
                $usuario = Usuario::where('correo', $request->email)->first();
            } else {
                // Find persona by identity number first, then get associated usuario
                $persona = Persona::where('no_identidad', $request->no_identidad)->first();
                if ($persona) {
                    $usuario = Usuario::where('id_persona', $persona->id_persona)->first();
                }
            }

            // Check if user exists and password is correct
            if (!$usuario || !Hash::check($request->password, $usuario->contrasena)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            // Create token
            $token = $usuario->createToken('auth-token')->plainTextToken;

            // Load persona relationship
            $usuario->load('persona.municipio.departamento');

            return response()->json([
                'success' => true,
                'message' => 'Login exitoso',
                'data' => [
                    'token' => $token,
                    'user' => [
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
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
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