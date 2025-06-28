<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Partido;
use App\Models\Movimiento;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\ProcesoVotacion;
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

    

        //CREAR PARTIDOS
        $partidos = [
            ['nombre' => 'Partido Nacional'],
            ['nombre' => 'Partido Liberal'],
            ['nombre' => 'Partido Libertad y Refundación (LIBRE)'],
        ];

        foreach ($partidos as $partido) {
            Partido::firstOrCreate(['nombre' => $partido['nombre']], $partido);
        }

        //CREAR MOVIMIENTOS PARA CADA PARTIDO
        $movimientos = [
            ['id_partido' => 1, 'nombre' => 'Papi a la Orden'], //id_movimiento = 1
            ['id_partido' => 1, 'nombre' => 'Avanza Por la Justicia y la Unidad (AVANZAN)'], //id_movimiento = 2
            ['id_partido' => 1, 'nombre' => 'Renovación Unidad Nacionalista (RUN)'], //id_movimiento = 3
            ['id_partido' => 1, 'nombre' => 'Rescate y Transformación'], //id_movimiento = 4
            ['id_partido' => 2, 'nombre' => 'Vamos Honduras'], //id_movimiento = 5
            ['id_partido' => 2, 'nombre' => 'Juntos por el Cambio'], //id_movimiento = 6
            ['id_partido' => 2, 'nombre' => 'Todos por Honduras'], //id_movimiento = 7
            ['id_partido' => 2, 'nombre' => 'Recuperar Honduras'], //id_movimiento = 8
            ['id_partido' => 3, 'nombre' => 'Alianza Presidencial Rixi Moncada'], //id_movimiento = 9
            ['id_partido' => 3, 'nombre' => 'Movimiento Renovación Nuevas Alternativas (MORENA)'], //id_movimiento = 10
            ['id_partido' => 3, 'nombre' => 'Fuerza de Refundacion Popular (FRP)'], //id_movimiento = 11
            ['id_partido' => 3, 'nombre' => 'M28 Poder Para vos'], //id_movimiento = 12
            ['id_partido' => 3, 'nombre' => 'Somos +'], //id_movimiento = 13
            ['id_partido' => 3, 'nombre' => 'Pueblo Organizado En Resistencia (POR)'], //id_movimiento = 14
            ['id_partido' => 3, 'nombre' => 'Nueva Corriente'], //id_movimiento = 15
        ];

        foreach ($movimientos as $movimiento) {
            Movimiento::firstOrCreate(['nombre' => $movimiento['nombre']], $movimiento);
        }

        //CREAR DEPARTAMENTOS
        $departamentos = [
            ['nombre' => 'Santa Barbara'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::firstOrCreate(['nombre' => $departamento['nombre']], $departamento);
        }

        //CREAR MUNICIPIOS DE SANTA BARBARA
        $municipios = [
            ['id_departamento' => 1, 'nombre' => 'Santa Barbara'],
            ['id_departamento' => 1, 'nombre' => 'Arada'],
            ['id_departamento' => 1, 'nombre' => 'Atima'],
            ['id_departamento' => 1, 'nombre' => 'Azacualpa'],
            ['id_departamento' => 1, 'nombre' => 'Ceguaca'],
            ['id_departamento' => 1, 'nombre' => 'San Jose de Colinas'],
            ['id_departamento' => 1, 'nombre' => 'Concepcion Del Norte'],
            ['id_departamento' => 1, 'nombre' => 'Concepcion Del Sur'],
            ['id_departamento' => 1, 'nombre' => 'Chinda'],
            ['id_departamento' => 1, 'nombre' => 'El Nispero'],
            ['id_departamento' => 1, 'nombre' => 'Gualala'],
            ['id_departamento' => 1, 'nombre' => 'Ilama'],
            ['id_departamento' => 1, 'nombre' => 'Macuelizo'],
            ['id_departamento' => 1, 'nombre' => 'Naranjito'],
            ['id_departamento' => 1, 'nombre' => 'Nuevo Celilac']
        ];

        foreach ($municipios as $municipio) {
            Municipio::firstOrCreate(['nombre' => $municipio['nombre']], $municipio);
        }

        //CREAR PERSONAS (solo las priemras tres personas tendran usuario)
        $personas = [
            ['nombre' => 'William Cole', 'no_identidad' => '0000000000001', 'id_municipio' => 1],
            ['nombre' => 'Jorge Paz', 'no_identidad' => '0000000000002', 'id_municipio' => 1],
            ['nombre' => 'Fabrizio Ramos', 'no_identidad' => '0000000000003', 'id_municipio' => 1],
        ];

        foreach ($personas as $persona) {
            Persona::firstOrCreate(['no_identidad' => $persona['no_identidad']], $persona);
        }

        for($i = 4; $i <= 53; $i++){
            $municipioId = (($i - 4) % 15) + 1; 
            $personaAdicional = [
                'nombre' => 'Persona #' . $i, 
                'no_identidad' => '000000000000' . $i, 
                'id_municipio' => $municipioId
            ];
            Persona::firstOrCreate(['no_identidad' => $personaAdicional['no_identidad']], $personaAdicional);
        }

        //CREAR USUARIOS
        $usuarios = [
            ['correo' => 'william.cole@gmail.com', 'contrasena' => Hash::make('admin123'), 'id_persona' => 1],
            ['correo' => 'jorge.paz@gmail.com', 'contrasena' => Hash::make('admin123'), 'id_persona' => 2],
            ['correo' => 'fabrizio.ramos@gmail.com', 'contrasena' => Hash::make('admin123'), 'id_persona' => 3],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::firstOrCreate(['correo' => $usuario['correo']], $usuario);
        }

         //inciar proceso de votacion
        $proceso = ProcesoVotacion::create([
            'etapa' => 'Prevotacion',
            'modificado_por' => 1,
        ]);

        //CREAR CANDIDATOS PRESIDENTE
        $candidatosPresidente = [
            ['id_partido' => 2, 'id_movimiento' => 5, 'nombre' => 'Salvador Alejandro Cesar Nasralla Salum', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000003.10100000.792.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'nombre' => 'Nasry Juan Asfura Zablah', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010343.10200000.793.png'],
            ['id_partido' => 3, 'id_movimiento' => 9, 'nombre' => 'Rixi Moncada', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC019662.10700000.827.png'],
        ];

        foreach ($candidatosPresidente as $candidato) {
            CandidatoPresidente::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }

        //CREAR CANDIDATOS DIPUTADOS (10 POR PARTIDO)
        
        //CREAR CANDIDATOS DIPUTADOS PARTIDO NACIONAL
        $candidatosDiputadosNacional = [
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1,'nombre' => 'Mario Orlando Reyes Mejia', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010784.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Mario Alonso Perez Lopez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010780.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Marcos Bertilio Paz Sabillon', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010782.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Maria Fernanda Sandres Umanzor', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010781.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Mirian Azucena Villanueva Sarmiento', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010785.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Hector Danilo Perdomo Paz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010786.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Carmen Judith Hernandez Leiva', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010783.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1, 'nombre' => 'Kellyn Iveth Enamorado Chavez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010787.20216000.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_departamento' => 1,  'nombre' => 'Kristo Jordi Mejia Flores', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC010788.20216000.793.png'],
        ];

        foreach ($candidatosDiputadosNacional as $candidato) {
            CandidatoDiputado::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }

        //CREAR ALCALDES PARA LOS 15 MUNICIPIOS ANTES INSERTADOS DE SANTABARBARA PARA PARTIDIO NACiONA
        $candidatosAlcaldeNacional = [
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 1, 'nombre' => 'Roger Yovany Lopez Pinera', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011730.30216010.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 2, 'nombre' => 'Elmer Edgardo Leiva Chavez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011734.30216020.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 2, 'id_municipio' => 3, 'nombre' => 'Servio Anibal Garcia Rivera', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011737.30216030.794.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 4, 'nombre' => 'Kelvin Yovani Reyes Perez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011741.30216040.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 5, 'nombre' => 'Fredy Yovany Sagastume Pineda', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011744.30216050.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 6, 'nombre' => 'Fernando Paredes Paz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011748.30216060.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 7, 'nombre' => 'Miguel Angel Bueso Torres', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011751.30216070.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 8, 'nombre' => 'Gonzalo Pineda Pacheco', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011755.30216080.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 9, 'nombre' => 'Mirian Lizeth Lopez Galeas', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011758.30216090.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 10, 'nombre' => 'Karen Mabey Funez Rodriguez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011761.30216100.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 11, 'nombre' => 'Fredy Antonio Sabillon Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011764.30216110.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 12, 'nombre' => 'Henry Henok Paz Martinez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011768.30216120.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 13, 'nombre' => 'Cristian Yeovany Moreno Murillo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011771.30216130.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 14, 'nombre' => 'Kleyner Roney Dubon Cardona', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011774.30216140.793.png'],
            ['id_partido' => 1, 'id_movimiento' => 1, 'id_municipio' => 15, 'nombre' => 'J. Andres Gutierrez Perez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC011777.30216150.793.png'],
        ];

        foreach ($candidatosAlcaldeNacional as $candidato) {
            CandidatoAlcalde::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }
        

        //CREAR CANDIDATOS DIPUTADOS PARA PARTIDO LIBERAL
        $candidatosDiputadosLiberal = [
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Ramon Estuardo Enamorado Rodriguez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000447.20116000.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_departamento' => 1, 'nombre' => 'Jose Rolando Sabillon Muñoz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000429.20116000.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Sandra Maribel Mancia Fajardo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000448.20116000.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Nixon Geovany Leiva Rapalo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000455.20116000.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Pablo Erick Bardales Pineda', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000449.20116000.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_departamento' => 1, 'nombre' => 'Jose Benigno Pineda Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000433.20116000.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_departamento' => 1, 'nombre' => 'Teodolinda Anderson Mejia', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000430.20116000.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Kency Dariana Rivera Rivera', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000450.20116000.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_departamento' => 1, 'nombre' => 'Hipolito Perdomo Rivera', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC000453.20116000.792.png'],
        ];

        foreach ($candidatosDiputadosLiberal as $candidato) {
            CandidatoDiputado::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }


        //CREAR ALCALDES PARA LOS 15 MUNICIPIOS ANTES INSERTADOS DE SANTABARBARA PARA LIBERAL
        $candidatosAlcaldeLiberal = [
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 1, 'nombre' => 'Ediño Josue Yanez Diaz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001508.30116010.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 2, 'nombre' => 'Joel Ambrocio Lopez Gomez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001512.30116020.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 7, 'id_municipio' => 3, 'nombre' => 'Francis Alexis Mateo Quintanilla', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001518.30116030.791.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 4, 'nombre' => 'Nelson Rene Bueso Guerra', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001519.30116040.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 5, 'nombre' => 'Allan Alberto Guzman Erazo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001523.30116050.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 7, 'id_municipio' => 6, 'nombre' => 'Alex Ricardo Gomez Bueso', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001530.30116060.791.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_municipio' => 7, 'nombre' => 'Olvin Alejandro Zamora Manzano', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001532.30116070.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 8, 'nombre' => 'Reina Leticia Pineda Tinoco', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001534.30116080.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 9, 'nombre' => 'Carlos Roberto Borjas', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001538.30116090.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_municipio' => 10, 'nombre' => 'Fredy Jhonatan Dubon Dubon', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001543.30116100.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 11, 'nombre' => 'Marco Antonio Fernandez Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001545.30116110.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_municipio' => 12, 'nombre' => 'Jerson Omar Javier Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001551.30116120.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 5, 'id_municipio' => 13, 'nombre' => 'Merlin Alcides Gomez Leiva', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001555.30116130.792.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 14, 'nombre' => 'Jose Reyes Ardon Vargas', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001557.30116140.790.png'],
            ['id_partido' => 2, 'id_movimiento' => 6, 'id_municipio' => 15, 'nombre' => 'Tedwa Mabel Rivera Anderson', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC001561.30116150.790.png'],
        ];

        foreach ($candidatosAlcaldeLiberal as $candidato) {
            CandidatoAlcalde::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }


        //CREAR CANDIDATOS A ALCALDES PARA PARTIDO LIBRE
        $candidatosAlcaldeLibre = [
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_municipio' => 1, 'nombre' => 'Edgardo Antonio Barahona Toro', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021949.30716010.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 13, 'id_municipio' => 2, 'nombre' => 'Jose Arnold Avelar Hernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021950.30716020.800.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_municipio' => 3, 'nombre' => 'Edward Yasmin Vega Castellanos', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021958.30716030.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_municipio' => 4, 'nombre' => 'Medardo Rosa Pineda', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021960.30716040.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_municipio' => 5, 'nombre' => 'Luis Antonio Enamorado Muñoz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021963.30716050.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_municipio' => 6, 'nombre' => 'Luis Ramon Perdomo Perdomo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021965.30716060.804.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_municipio' => 7, 'nombre' => 'Jose Trinidad Lopez Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021967.30716070.804.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_municipio' => 8, 'nombre' => 'Nelson Yovany Castellanos Perdomo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021970.30716080.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_municipio' => 9, 'nombre' => 'Hector Enrique Zelaya Arias', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021976.30716090.804.png'],
            ['id_partido' => 3, 'id_movimiento' => 11, 'id_municipio' => 10, 'nombre' => 'Pablo Antonio Leiva Hernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021979.30716100.805.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_municipio' => 11, 'nombre' => 'Johnmy Martin Perdomo Hernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021986.30716110.804.png'],
            ['id_partido' => 3, 'id_movimiento' => 15, 'id_municipio' => 12, 'nombre' => 'Cristian Omar Paz Fernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021988.30716120.801.png'],
            ['id_partido' => 3, 'id_movimiento' => 11, 'id_municipio' => 13, 'nombre' => 'Suyapa Jacqueline Trejo Cordon', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021997.30716130.805.png'],
            ['id_partido' => 3, 'id_movimiento' => 13, 'id_municipio' => 14, 'nombre' => 'Edmundo Omar Lopez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC021999.30716140.800.png'],
            ['id_partido' => 3, 'id_movimiento' => 13, 'id_municipio' => 15, 'nombre' => 'Adrian Antonio Rodriguez Briones', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC022002.30716150.800.png'],
        ];

        foreach ($candidatosAlcaldeLibre as $candidato) {
            CandidatoAlcalde::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }


        $candidatosDiputadosLibre= [
            ['id_partido' => 3, 'id_movimiento' => 11, 'id_departamento' => 1, 'nombre' => 'Edgardo Antonio Casaña Mejia', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020421.20716000.805.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_departamento' => 1, 'nombre' => 'Luz Angelica', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020439.20716000.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 13, 'id_departamento' => 1, 'nombre' => 'Sergio Arturo Castellanos Perdomo', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020394.20716000.800.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_departamento' => 1, 'nombre' => 'Cristian de Jesus Hernandez Diaz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020430.20716000.804.png'],
            ['id_partido' => 3, 'id_movimiento' => 12, 'id_departamento' => 1, 'nombre' => 'Juan Angel Lanza Sabillon', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020440.20716000.803.png'],
            ['id_partido' => 3, 'id_movimiento' => 11, 'id_departamento' => 1, 'nombre' => 'Angel Adelso Reyes Aguilar', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020423.20716000.805.png'],
            ['id_partido' => 3, 'id_movimiento' => 11, 'id_departamento' => 1, 'nombre' => 'Eunice Yamileth Ramirez Mejia', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020422.20716000.805.png'],
            ['id_partido' => 3, 'id_movimiento' => 15, 'id_departamento' => 1, 'nombre' => 'German Oswaldo Altamirano Diaz', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020385.20716000.801.png'],
            ['id_partido' => 3, 'id_movimiento' => 14, 'id_departamento' => 1, 'nombre' => 'Aylin Lizeth Tejada Hernandez', 'foto_url' => 'https://resultadosprimarias2025.cne.hn/assets/images/parties/CCC020431.20716000.804.png'],
        ];

        foreach ($candidatosDiputadosLibre as $candidato) {
            CandidatoDiputado::firstOrCreate(['nombre' => $candidato['nombre']], $candidato);
        }


    }
} 