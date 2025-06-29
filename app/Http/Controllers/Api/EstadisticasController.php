<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\VotoPresidencial;
use App\Models\VotoDiputado;
use App\Models\VotoAlcalde;
use App\Models\CandidatoPresidente;
use App\Models\CandidatoDiputado;
use App\Models\CandidatoAlcalde;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Partido;
use App\Models\Movimiento;
use App\Models\ProcesoVotacion;

class EstadisticasController extends Controller
{
    /**
     * Obtener estadísticas generales del sistema
     */
    public function generales(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }
        
        $totalVotosPresidenciales = VotoPresidencial::where('id_proceso', $proceso->id_proceso)->count();
        $totalVotosDiputados = VotoDiputado::where('id_proceso', $proceso->id_proceso)->count();
        $totalVotosAlcaldes = VotoAlcalde::where('id_proceso', $proceso->id_proceso)->count();
        $totalVotos = $totalVotosPresidenciales + $totalVotosDiputados + $totalVotosAlcaldes;

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'totales' => [
                'votos_presidenciales' => $totalVotosPresidenciales,
                'votos_diputados' => $totalVotosDiputados,
                'votos_alcaldes' => $totalVotosAlcaldes,
                'total_general' => $totalVotos
            ],
            'fecha_consulta' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Estadísticas de votos presidenciales
     */
    public function presidenciales(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $porDepartamento = $request->get('por_departamento', false);
        $porPartido = $request->get('por_partido', false);
        $porMovimiento = $request->get('por_movimiento', false);

        $totalVotos = VotoPresidencial::where('id_proceso', $proceso->id_proceso)->count();

        // Estadísticas por candidato
        $estadisticasCandidatos = CandidatoPresidente::with(['partido', 'movimiento'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->get()
            ->map(function ($candidato) use ($totalVotos) {
                $porcentaje = $totalVotos > 0 ? round(($candidato->votos_count / $totalVotos) * 100, 2) : 0;
                return [
                    'id_candidato' => $candidato->id_candidato,
                    'nombre' => $candidato->nombre,
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'movimiento' => $candidato->movimiento ? $candidato->movimiento->nombre : 'Sin movimiento',
                    'total_votos' => $candidato->votos_count,
                    'porcentaje' => $porcentaje,
                    'foto_url' => $candidato->foto_url
                ];
            })
            ->sortByDesc('total_votos')
            ->values();

        $resultado = [
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'total_votos' => $totalVotos,
            'candidatos' => $estadisticasCandidatos
        ];

        // Estadísticas por departamento
        if ($porDepartamento) {
            $estadisticasDepartamento = VotoPresidencial::with(['candidato', 'departamento'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_departamento', 'id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_departamento', 'id_candidato')
                ->get()
                ->groupBy('id_departamento')
                ->map(function ($departamento) {
                    return $departamento->map(function ($voto) {
                        return [
                            'candidato' => $voto->candidato->nombre,
                            'total_votos' => $voto->total_votos
                        ];
                    });
                });

            $resultado['por_departamento'] = $estadisticasDepartamento;
        }

        // Estadísticas por partido
        if ($porPartido) {
            $estadisticasPartido = VotoPresidencial::with(['candidato.partido'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.partido.nombre')
                ->map(function ($partido) {
                    return $partido->sum('total_votos');
                });

            $resultado['por_partido'] = $estadisticasPartido;
        }

        // Estadísticas por movimiento
        if ($porMovimiento) {
            $estadisticasMovimiento = VotoPresidencial::with(['candidato.movimiento'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.movimiento.nombre')
                ->map(function ($movimiento) {
                    return $movimiento->sum('total_votos');
                });

            $resultado['por_movimiento'] = $estadisticasMovimiento;
        }

        return response()->json($resultado);
    }

    /**
     * Estadísticas de votos para diputados
     */
    public function diputados(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $porDepartamento = $request->get('por_departamento', false);
        $porPartido = $request->get('por_partido', false);
        $porMovimiento = $request->get('por_movimiento', false);

        $totalVotos = VotoDiputado::where('id_proceso', $proceso->id_proceso)->count();

        // Estadísticas por candidato
        $estadisticasCandidatos = CandidatoDiputado::with(['partido', 'movimiento', 'departamento'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->get()
            ->map(function ($candidato) use ($totalVotos) {
                $porcentaje = $totalVotos > 0 ? round(($candidato->votos_count / $totalVotos) * 100, 2) : 0;
                return [
                    'id_candidato' => $candidato->id_candidato,
                    'nombre' => $candidato->nombre,
                    'departamento' => $candidato->departamento ? $candidato->departamento->nombre : 'Sin departamento',
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'movimiento' => $candidato->movimiento ? $candidato->movimiento->nombre : 'Sin movimiento',
                    'total_votos' => $candidato->votos_count,
                    'porcentaje' => $porcentaje,
                    'foto_url' => $candidato->foto_url
                ];
            })
            ->sortByDesc('total_votos')
            ->values();

        $resultado = [
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'total_votos' => $totalVotos,
            'candidatos' => $estadisticasCandidatos
        ];

        // Estadísticas por departamento
        if ($porDepartamento) {
            $estadisticasDepartamento = VotoDiputado::with(['candidato', 'departamento'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_departamento', 'id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_departamento', 'id_candidato')
                ->get()
                ->groupBy('id_departamento')
                ->map(function ($departamento) {
                    return $departamento->map(function ($voto) {
                        return [
                            'candidato' => $voto->candidato->nombre,
                            'total_votos' => $voto->total_votos
                        ];
                    });
                });

            $resultado['por_departamento'] = $estadisticasDepartamento;
        }

        // Estadísticas por partido
        if ($porPartido) {
            $estadisticasPartido = VotoDiputado::with(['candidato.partido'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.partido.nombre')
                ->map(function ($partido) {
                    return $partido->sum('total_votos');
                });

            $resultado['por_partido'] = $estadisticasPartido;
        }

        // Estadísticas por movimiento
        if ($porMovimiento) {
            $estadisticasMovimiento = VotoDiputado::with(['candidato.movimiento'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.movimiento.nombre')
                ->map(function ($movimiento) {
                    return $movimiento->sum('total_votos');
                });

            $resultado['por_movimiento'] = $estadisticasMovimiento;
        }

        return response()->json($resultado);
    }

    /**
     * Estadísticas de votos para alcaldes
     */
    public function alcaldes(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $porMunicipio = $request->get('por_municipio', false);
        $porPartido = $request->get('por_partido', false);
        $porMovimiento = $request->get('por_movimiento', false);

        $totalVotos = VotoAlcalde::where('id_proceso', $proceso->id_proceso)->count();

        // Estadísticas por candidato
        $estadisticasCandidatos = CandidatoAlcalde::with(['partido', 'movimiento', 'municipio'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->get()
            ->map(function ($candidato) use ($totalVotos) {
                $porcentaje = $totalVotos > 0 ? round(($candidato->votos_count / $totalVotos) * 100, 2) : 0;
                return [
                    'id_candidato' => $candidato->id_candidato,
                    'nombre' => $candidato->nombre,
                    'municipio' => $candidato->municipio ? $candidato->municipio->nombre : 'Sin municipio',
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'movimiento' => $candidato->movimiento ? $candidato->movimiento->nombre : 'Sin movimiento',
                    'total_votos' => $candidato->votos_count,
                    'porcentaje' => $porcentaje,
                    'foto_url' => $candidato->foto_url
                ];
            })
            ->sortByDesc('total_votos')
            ->values();

        $resultado = [
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'total_votos' => $totalVotos,
            'candidatos' => $estadisticasCandidatos
        ];

        // Estadísticas por municipio
        if ($porMunicipio) {
            $estadisticasMunicipio = VotoAlcalde::with(['candidato', 'municipio'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_municipio', 'id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_municipio', 'id_candidato')
                ->get()
                ->groupBy('id_municipio')
                ->map(function ($municipio) {
                    return $municipio->map(function ($voto) {
                        return [
                            'candidato' => $voto->candidato->nombre,
                            'total_votos' => $voto->total_votos
                        ];
                    });
                });

            $resultado['por_municipio'] = $estadisticasMunicipio;
        }

        // Estadísticas por partido
        if ($porPartido) {
            $estadisticasPartido = VotoAlcalde::with(['candidato.partido'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.partido.nombre')
                ->map(function ($partido) {
                    return $partido->sum('total_votos');
                });

            $resultado['por_partido'] = $estadisticasPartido;
        }

        // Estadísticas por movimiento
        if ($porMovimiento) {
            $estadisticasMovimiento = VotoAlcalde::with(['candidato.movimiento'])
                ->where('id_proceso', $proceso->id_proceso)
                ->select('id_candidato', DB::raw('count(*) as total_votos'))
                ->groupBy('id_candidato')
                ->get()
                ->groupBy('candidato.movimiento.nombre')
                ->map(function ($movimiento) {
                    return $movimiento->sum('total_votos');
                });

            $resultado['por_movimiento'] = $estadisticasMovimiento;
        }

        return response()->json($resultado);
    }

    /**
     * Estadísticas comparativas entre partidos políticos
     */
    public function comparativaPartidos(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        // Votos presidenciales por partido
        $votosPresidenciales = VotoPresidencial::with(['candidato.partido'])
            ->where('id_proceso', $proceso->id_proceso)
            ->select('id_candidato', DB::raw('count(*) as total_votos'))
            ->groupBy('id_candidato')
            ->get()
            ->groupBy('candidato.partido.nombre')
            ->map(function ($partido) {
                return $partido->sum('total_votos');
            });

        // Votos diputados por partido
        $votosDiputados = VotoDiputado::with(['candidato.partido'])
            ->where('id_proceso', $proceso->id_proceso)
            ->select('id_candidato', DB::raw('count(*) as total_votos'))
            ->groupBy('id_candidato')
            ->get()
            ->groupBy('candidato.partido.nombre')
            ->map(function ($partido) {
                return $partido->sum('total_votos');
            });

        // Votos alcaldes por partido
        $votosAlcaldes = VotoAlcalde::with(['candidato.partido'])
            ->where('id_proceso', $proceso->id_proceso)
            ->select('id_candidato', DB::raw('count(*) as total_votos'))
            ->groupBy('id_candidato')
            ->get()
            ->groupBy('candidato.partido.nombre')
            ->map(function ($partido) {
                return $partido->sum('total_votos');
            });

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'presidenciales' => $votosPresidenciales,
            'diputados' => $votosDiputados,
            'alcaldes' => $votosAlcaldes,
            'total_por_partido' => [
                'presidenciales' => $votosPresidenciales->sum(),
                'diputados' => $votosDiputados->sum(),
                'alcaldes' => $votosAlcaldes->sum()
            ]
        ]);
    }

    /**
     * Ranking de candidatos más votados
     */
    public function rankingPresidentes(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        // Ranking presidentes
        $rankingPresidentes = CandidatoPresidente::with(['partido', 'movimiento'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->orderByDesc('votos_count')
            ->limit(10)
            ->get()
            ->map(function ($candidato) {
                return [
                    'tipo' => 'Presidente',
                    'nombre' => $candidato->nombre,
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'movimiento' => $candidato->movimiento ? $candidato->movimiento->nombre : 'Sin movimiento',
                    'total_votos' => $candidato->votos_count
                ];
            });

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'presidentes' => $rankingPresidentes,
        ]);
    }

    /**
     * Ranking de candidatos más votados
     */
    public function rankingDiputados(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $rankingDiputados = CandidatoDiputado::with(['partido', 'movimiento', 'departamento'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->orderByDesc('votos_count')
            ->limit(10)
            ->get()
            ->map(function ($candidato) {
                return [
                    'tipo' => 'Diputado',
                    'nombre' => $candidato->nombre,
                    'departamento' => $candidato->departamento ? $candidato->departamento->nombre : 'Sin departamento',
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'total_votos' => $candidato->votos_count
                ];
            });

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'diputados' => $rankingDiputados,
        ]);
    }

    /**
     * Ranking de candidatos más votados
     */
    public function rankingAlcaldes(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $rankingAlcaldes = CandidatoAlcalde::with(['partido', 'movimiento', 'municipio'])
            ->withCount(['votos' => function($query) use ($proceso) {
                $query->where('id_proceso', $proceso->id_proceso);
            }])
            ->orderByDesc('votos_count')
            ->get()
            ->map(function ($candidato) {
                return [
                    'tipo' => 'Alcalde',
                    'nombre' => $candidato->nombre,
                    'municipio' => $candidato->municipio ? $candidato->municipio->nombre : 'Sin municipio',
                    'partido' => $candidato->partido ? $candidato->partido->nombre : 'Sin partido',
                    'total_votos' => $candidato->votos_count
                ];
            });

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'alcaldes' => $rankingAlcaldes,
        ]);
    }

    /**
     * Estadísticas de participación por departamento
     */
    public function participacionDepartamentos(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $departamentos = Departamento::with(['municipios'])
            ->get()
            ->map(function ($departamento) use ($proceso) {
                $votosPresidenciales = VotoPresidencial::where('id_departamento', $departamento->id_departamento)
                    ->where('id_proceso', $proceso->id_proceso)
                    ->count();
                $votosDiputados = VotoDiputado::where('id_departamento', $departamento->id_departamento)
                    ->where('id_proceso', $proceso->id_proceso)
                    ->count();
                
                return [
                    'id_departamento' => $departamento->id_departamento,
                    'nombre' => $departamento->nombre,
                    'votos_presidenciales' => $votosPresidenciales,
                    'votos_diputados' => $votosDiputados,
                    'total_votos' => $votosPresidenciales + $votosDiputados
                ];
            })
            ->sortByDesc('total_votos');

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'departamentos' => $departamentos
        ]);
    }   

    /**
     * Estadísticas de participación por municipio
     */
    public function participacionMunicipios(Request $request)
    {
        $proceso_id = $request->get('proceso_id', 1);
        $proceso = ProcesoVotacion::find($proceso_id);
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de votación no encontrado'], 404);
        }

        $municipios = Municipio::with(['departamento'])
            ->get()
            ->map(function ($municipio) use ($proceso) {
                $votosAlcaldes = VotoAlcalde::where('id_municipio', $municipio->id_municipio)
                    ->where('id_proceso', $proceso->id_proceso)
                    ->count();
                
                return [
                    'id_municipio' => $municipio->id_municipio,
                    'nombre' => $municipio->nombre,
                    'departamento' => $municipio->departamento ? $municipio->departamento->nombre : 'Sin departamento',
                    'votos_alcaldes' => $votosAlcaldes
                ];
            })
            ->sortByDesc('votos_alcaldes');

        return response()->json([
            'proceso' => [
                'id_proceso' => $proceso->id_proceso,
                'etapa' => $proceso->etapa,
                'created_at' => $proceso->created_at
            ],
            'municipios' => $municipios
        ]);
    }

    /**
     * Obtener todos los procesos de votación disponibles
     */
    public function getProcesos()
    {
        $procesos = ProcesoVotacion::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'procesos' => $procesos->map(function ($proceso) {
                return [
                    'id_proceso' => $proceso->id_proceso,
                    'etapa' => $proceso->etapa,
                    'created_at' => $proceso->created_at,
                    'updated_at' => $proceso->updated_at
                ];
            })
        ]);
    }
} 