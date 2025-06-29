<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\ProcesoVotacion;
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
        // Obtener el proceso de votación activo
        $procesoVotacion = ProcesoVotacion::where('etapa', 'activo')
                                          ->orWhere('etapa', 'en_proceso')
                                          ->orderBy('created_at', 'desc')
                                          ->first();
        
        if (!$procesoVotacion) {
            // Si no hay proceso activo, crear uno por defecto
            $procesoVotacion = ProcesoVotacion::create([
                'etapa' => 'activo',
                'modificado_por' => 1 // Usuario por defecto
            ]);
        }

        // Si se envía correo, validar que también venga contraseña
        if ($request->has('correo')) {
            $validator = Validator::make($request->all(), [
                'correo' => 'required|email',
                'contrasena' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Verificar que el usuario existe
            $usuario = Usuario::where('correo', $request->correo)->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Verificar que la contraseña es correcta
            if (!Hash::check($request->contrasena, $usuario->contrasena)) {
                return response()->json(['error' => 'Contraseña incorrecta'], 401);
            }

            $token = $usuario->createToken('auth_token')->plainTextToken;
            $usuario->load('persona.municipio.departamento');
            
            return response()->json([
                'token' => $token, 
                'id_usuario' => $usuario->id_usuario, 
                'correo' => $usuario->correo, 
                'id_persona' => $usuario->persona->id_persona, 
                'nombre' => $usuario->persona->nombre, 
                'no_identidad' => $usuario->persona->no_identidad, 
                'municipio_id' => $usuario->persona->municipio->id_municipio, 
                'departamento_id' => $usuario->persona->municipio->departamento->id_departamento,
                'proceso_id' => $procesoVotacion->id_proceso
            ], 200);
        }

        // Si solo se envía número de identidad
        if ($request->has('no_identidad')) {
            $validator = Validator::make($request->all(), [
                'no_identidad' => 'required',
                'nombre' => 'required',
                'municipio_id' => 'required|exists:municipios,id_municipio',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $persona = Persona::where('no_identidad', $request->no_identidad)->first();
            

            if (!$persona) {
                $persona = Persona::create([
                    'no_identidad' => $request->no_identidad,
                    'nombre' => $request->nombre,
                    'id_municipio' => $request->municipio_id,
                ]);
            }

            $token = $persona->createToken('auth_token')->plainTextToken;
            $persona->load('municipio.departamento');
            
            return response()->json([
                'token' => $token, 
                'id_persona' => $persona->id_persona, 
                'nombre' => $persona->nombre, 
                'no_identidad' => $persona->no_identidad, 
                'municipio_id' => $persona->municipio->id_municipio, 
                'departamento_id' => $persona->municipio->departamento->id_departamento, 
                'municipio_nombre' => $persona->municipio->nombre, 
                'departamento_nombre' => $persona->municipio->departamento->nombre,
                'proceso_id' => $procesoVotacion->id_proceso
            ], 200);
        }

        // Si no se proporciona ni correo ni número de identidad
        return response()->json(['error' => 'Se debe proporcionar correo o número de identidad'], 400);
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

            // Obtener el proceso de votación activo
            $procesoVotacion = ProcesoVotacion::where('etapa', 'activo')
                                              ->orWhere('etapa', 'en_proceso')
                                              ->orderBy('created_at', 'desc')
                                              ->first();

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
                    ],
                    'proceso_id' => $procesoVotacion ? $procesoVotacion->id_proceso : null
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