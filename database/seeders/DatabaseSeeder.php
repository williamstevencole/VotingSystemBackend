<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Partido;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\CandidatoPresidente;
use App\Models\CandidatoDiputado;
use App\Models\CandidatoAlcalde;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Partidos Políticos
        $partidos = [
            ['nombre' => 'Partido Nacional'],
            ['nombre' => 'Partido Liberal'],
            ['nombre' => 'Partido Libertad y Refundación (LIBRE)'],
            ['nombre' => 'Partido Salvador de Honduras'],
            ['nombre' => 'Partido Demócrata Cristiano'],
            ['nombre' => 'Partido Innovación y Unidad'],
        ];

        foreach ($partidos as $partido) {
            Partido::firstOrCreate(['nombre' => $partido['nombre']], $partido);
        }

        // Seed Departamentos
        $departamentos = [
            ['nombre' => 'Francisco Morazán'],
            ['nombre' => 'Cortés'],
            ['nombre' => 'Yoro'],
            ['nombre' => 'Atlántida'],
            ['nombre' => 'Colón'],
            ['nombre' => 'Olancho'],
            ['nombre' => 'El Paraíso'],
            ['nombre' => 'Choluteca'],
            ['nombre' => 'Valle'],
            ['nombre' => 'Comayagua'],
            ['nombre' => 'La Paz'],
            ['nombre' => 'Intibucá'],
            ['nombre' => 'Lempira'],
            ['nombre' => 'Ocotepeque'],
            ['nombre' => 'Copán'],
            ['nombre' => 'Santa Bárbara'],
            ['nombre' => 'Islas de la Bahía'],
            ['nombre' => 'Gracias a Dios'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::firstOrCreate(['nombre' => $departamento['nombre']], $departamento);
        }

        // Seed Municipios (some major ones)
        $municipios = [
            ['id_departamento' => 1, 'nombre' => 'Tegucigalpa'], // Francisco Morazán
            ['id_departamento' => 1, 'nombre' => 'Comayagüela'], // Francisco Morazán
            ['id_departamento' => 1, 'nombre' => 'Valle de Ángeles'], // Francisco Morazán
            ['id_departamento' => 2, 'nombre' => 'San Pedro Sula'], // Cortés
            ['id_departamento' => 2, 'nombre' => 'Choloma'], // Cortés
            ['id_departamento' => 2, 'nombre' => 'La Lima'], // Cortés
            ['id_departamento' => 3, 'nombre' => 'El Progreso'], // Yoro
            ['id_departamento' => 3, 'nombre' => 'Yoro'], // Yoro
            ['id_departamento' => 4, 'nombre' => 'La Ceiba'], // Atlántida
            ['id_departamento' => 4, 'nombre' => 'Tela'], // Atlántida
            ['id_departamento' => 5, 'nombre' => 'Trujillo'], // Colón
            ['id_departamento' => 6, 'nombre' => 'Juticalpa'], // Olancho
            ['id_departamento' => 7, 'nombre' => 'Yuscarán'], // El Paraíso
            ['id_departamento' => 8, 'nombre' => 'Choluteca'], // Choluteca
            ['id_departamento' => 9, 'nombre' => 'Nacaome'], // Valle
            ['id_departamento' => 10, 'nombre' => 'Comayagua'], // Comayagua
            ['id_departamento' => 11, 'nombre' => 'La Paz'], // La Paz
            ['id_departamento' => 12, 'nombre' => 'La Esperanza'], // Intibucá
            ['id_departamento' => 13, 'nombre' => 'Gracias'], // Lempira
            ['id_departamento' => 14, 'nombre' => 'Ocotepeque'], // Ocotepeque
            ['id_departamento' => 15, 'nombre' => 'Santa Rosa de Copán'], // Copán
            ['id_departamento' => 16, 'nombre' => 'Santa Bárbara'], // Santa Bárbara
            ['id_departamento' => 17, 'nombre' => 'Roatán'], // Islas de la Bahía
            ['id_departamento' => 18, 'nombre' => 'Puerto Lempira'], // Gracias a Dios
        ];

        foreach ($municipios as $municipio) {
            $departamento = Departamento::where('nombre', $this->getDepartamentoName($municipio['id_departamento']))->first();
            if ($departamento) {
                Municipio::firstOrCreate(
                    ['nombre' => $municipio['nombre'], 'id_departamento' => $departamento->id_departamento],
                    ['id_departamento' => $departamento->id_departamento, 'nombre' => $municipio['nombre']]
                );
            }
        }

        // Seed Personas
        $personas = [
            ['nombre' => 'Juan Carlos Hernández', 'no_identidad' => '0801199012345', 'municipio' => 'Tegucigalpa'],
            ['nombre' => 'María Elena López', 'no_identidad' => '0802198512346', 'municipio' => 'Tegucigalpa'],
            ['nombre' => 'Carlos Roberto Martínez', 'no_identidad' => '0803198812347', 'municipio' => 'San Pedro Sula'],
            ['nombre' => 'Ana Patricia Flores', 'no_identidad' => '0804199212348', 'municipio' => 'San Pedro Sula'],
            ['nombre' => 'Luis Fernando Ramírez', 'no_identidad' => '0805198712349', 'municipio' => 'La Ceiba'],
            ['nombre' => 'Carmen Rosa Vásquez', 'no_identidad' => '0806199012350', 'municipio' => 'La Ceiba'],
            ['nombre' => 'Roberto Antonio García', 'no_identidad' => '0807198512351', 'municipio' => 'Juticalpa'],
            ['nombre' => 'Sofia Alejandra Torres', 'no_identidad' => '0808198812352', 'municipio' => 'Juticalpa'],
            ['nombre' => 'Miguel Ángel Jiménez', 'no_identidad' => '0809199212353', 'municipio' => 'Santa Rosa de Copán'],
            ['nombre' => 'Diana Carolina Mendoza', 'no_identidad' => '0810198712354', 'municipio' => 'Santa Rosa de Copán'],
        ];

        foreach ($personas as $persona) {
            $municipio = Municipio::where('nombre', $persona['municipio'])->first();
            if ($municipio) {
                Persona::firstOrCreate(
                    ['no_identidad' => $persona['no_identidad']],
                    [
                        'nombre' => $persona['nombre'],
                        'no_identidad' => $persona['no_identidad'],
                        'id_municipio' => $municipio->id_municipio
                    ]
                );
            }
        }

        // Seed Usuarios Administradores
        $usuarios = [
            ['correo' => 'admin@votaciones.hn', 'contrasena' => Hash::make('admin123'), 'no_identidad' => '0801199012345'],
            ['correo' => 'supervisor@votaciones.hn', 'contrasena' => Hash::make('supervisor123'), 'no_identidad' => '0802198512346'],
            ['correo' => 'juan.hernandez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0801199012345'],
            ['correo' => 'maria.lopez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0802198512346'],
            ['correo' => 'carlos.martinez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0803198812347'],
            ['correo' => 'ana.flores@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0804199212348'],
            ['correo' => 'luis.ramirez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0805198712349'],
            ['correo' => 'carmen.vasquez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0806199012350'],
            ['correo' => 'roberto.garcia@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0807198512351'],
            ['correo' => 'sofia.torres@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0808198812352'],
            ['correo' => 'miguel.jimenez@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0809199212353'],
            ['correo' => 'diana.mendoza@email.com', 'contrasena' => Hash::make('password123'), 'no_identidad' => '0810198712354'],
        ];

        foreach ($usuarios as $usuario) {
            $persona = Persona::where('no_identidad', $usuario['no_identidad'])->first();
            if ($persona) {
                Usuario::firstOrCreate(
                    ['correo' => $usuario['correo']],
                    [
                        'correo' => $usuario['correo'],
                        'contrasena' => $usuario['contrasena'],
                        'id_persona' => $persona->id_persona
                    ]
                );
            }
        }

        // Seed Candidatos Presidente
        $candidatosPresidente = [
            ['id_partido' => 1, 'nombre' => 'Juan Orlando Hernández', 'foto' => 'candidato1.jpg'],
            ['id_partido' => 2, 'nombre' => 'Xiomara Castro', 'foto' => 'candidato2.jpg'],
            ['id_partido' => 3, 'nombre' => 'Salvador Nasralla', 'foto' => 'candidato3.jpg'],
            ['id_partido' => 4, 'nombre' => 'Yani Rosenthal', 'foto' => 'candidato4.jpg'],
        ];

        foreach ($candidatosPresidente as $candidato) {
            $partido = Partido::find($candidato['id_partido']);
            if ($partido) {
                CandidatoPresidente::firstOrCreate(
                    ['nombre' => $candidato['nombre']],
                    [
                        'id_partido' => $partido->id_partido,
                        'nombre' => $candidato['nombre'],
                        'foto' => $candidato['foto']
                    ]
                );
            }
        }

        // Seed Candidatos Diputado (2 por departamento)
        $departamentos = Departamento::all();
        foreach ($departamentos as $departamento) {
            $partidos = Partido::inRandomOrder()->take(2)->get();
            foreach ($partidos as $index => $partido) {
                CandidatoDiputado::firstOrCreate(
                    [
                        'nombre' => 'Diputado ' . ($index + 1) . ' - ' . $departamento->nombre,
                        'id_departamento' => $departamento->id_departamento
                    ],
                    [
                        'id_partido' => $partido->id_partido,
                        'id_departamento' => $departamento->id_departamento,
                        'nombre' => 'Diputado ' . ($index + 1) . ' - ' . $departamento->nombre,
                        'foto' => 'diputado' . ($index + 1) . '.jpg'
                    ]
                );
            }
        }

        // Seed Candidatos Alcalde (2 por municipio)
        $municipios = Municipio::all();
        foreach ($municipios as $municipio) {
            $partidos = Partido::inRandomOrder()->take(2)->get();
            foreach ($partidos as $index => $partido) {
                CandidatoAlcalde::firstOrCreate(
                    [
                        'nombre' => 'Alcalde ' . ($index + 1) . ' - ' . $municipio->nombre,
                        'id_municipio' => $municipio->id_municipio
                    ],
                    [
                        'id_partido' => $partido->id_partido,
                        'id_municipio' => $municipio->id_municipio,
                        'nombre' => 'Alcalde ' . ($index + 1) . ' - ' . $municipio->nombre,
                        'foto' => 'alcalde' . ($index + 1) . '.jpg'
                    ]
                );
    }
}

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@votaciones.hn / admin123');
        $this->command->info('Supervisor credentials: supervisor@votaciones.hn / supervisor123');
    }

    private function getDepartamentoName($id)
    {
        $departamentos = [
            1 => 'Francisco Morazán',
            2 => 'Cortés',
            3 => 'Yoro',
            4 => 'Atlántida',
            5 => 'Colón',
            6 => 'Olancho',
            7 => 'El Paraíso',
            8 => 'Choluteca',
            9 => 'Valle',
            10 => 'Comayagua',
            11 => 'La Paz',
            12 => 'Intibucá',
            13 => 'Lempira',
            14 => 'Ocotepeque',
            15 => 'Copán',
            16 => 'Santa Bárbara',
            17 => 'Islas de la Bahía',
            18 => 'Gracias a Dios',
        ];

        return $departamentos[$id] ?? 'Francisco Morazán';
    }
} 