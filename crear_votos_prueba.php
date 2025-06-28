<?php

/**
 * Script para crear votos de prueba para estadísticas
 * Uso: php crear_votos_prueba.php
 * 
 * Este script usa solo las 10 personas existentes en la base de datos
 * y crea votos variados para generar estadísticas realistas
 */

//$baseUrl = 'http://localhost:8000/api';
$baseUrl = 'https://votingbackend-fe5a580c2b2c.herokuapp.com/api';

echo "🎯 Creando votos de prueba para estadísticas...\n";
echo "📊 Usando las 10 personas existentes en la base de datos\n\n";

// Función para hacer petición POST
function hacerPost($url, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'response' => $response];
}

// Función para crear voto presidencial
function crearVotoPresidencial($personaId, $candidatoId, $tiempo) {
    global $baseUrl;
    
    $data = [
        'id_persona' => $personaId,
        'id_candidato' => $candidatoId,
        'id_departamento' => 1,
        'tiempo' => $tiempo
    ];
    
    $result = hacerPost("$baseUrl/votos-presidenciales", $data);
    
    if ($result['code'] == 201) {
        echo "✅ Voto presidencial: Persona $personaId -> Candidato $candidatoId\n";
        return true;
    } else {
        echo "❌ Error voto presidencial: HTTP {$result['code']} - {$result['response']}\n";
        return false;
    }
}

// Función para crear voto diputado
function crearVotoDiputado($personaId, $candidatoId, $tiempo) {
    global $baseUrl;
    
    $data = [
        'id_persona' => $personaId,
        'id_candidato' => $candidatoId,
        'id_departamento' => 1,
        'tiempo' => $tiempo
    ];
    
    $result = hacerPost("$baseUrl/votos-diputados", $data);
    
    if ($result['code'] == 201) {
        echo "✅ Voto diputado: Persona $personaId -> Candidato $candidatoId\n";
        return true;
    } else {
        echo "❌ Error voto diputado: HTTP {$result['code']} - {$result['response']}\n";
        return false;
    }
}

// Función para crear voto alcalde
function crearVotoAlcalde($personaId, $candidatoId, $municipioId, $tiempo) {
    global $baseUrl;
    
    $data = [
        'id_persona' => $personaId,
        'id_candidato' => $candidatoId,
        'id_municipio' => $municipioId,
        'tiempo' => $tiempo
    ];
    
    $result = hacerPost("$baseUrl/votos-alcaldes", $data);
    
    if ($result['code'] == 201) {
        echo "✅ Voto alcalde: Persona $personaId -> Candidato $candidatoId (Municipio $municipioId)\n";
        return true;
    } else {
        echo "❌ Error voto alcalde: HTTP {$result['code']} - {$result['response']}\n";
        return false;
    }
}

// Array con las 53 personas existentes y sus municipios
$personas = [
    // 3 personas originales
    1 => 1,  // William Cole -> Santa Barbara
    2 => 1,  // Jorge Paz -> Santa Barbara
    3 => 1,  // Fabrizio Ramos -> Santa Barbara
    
    // 50 personas adicionales (distribuidas cíclicamente en 15 municipios)
    4 => 1,  // Persona #4 -> Santa Barbara
    5 => 2,  // Persona #5 -> Arada
    6 => 3,  // Persona #6 -> Atima
    7 => 4,  // Persona #7 -> Azacualpa
    8 => 5,  // Persona #8 -> Ceguaca
    9 => 6,  // Persona #9 -> San Jose de Colinas
    10 => 7, // Persona #10 -> Concepcion Del Norte
    11 => 8, // Persona #11 -> Concepcion Del Sur
    12 => 9, // Persona #12 -> Chinda
    13 => 10, // Persona #13 -> El Nispero
    14 => 11, // Persona #14 -> Gualala
    15 => 12, // Persona #15 -> Ilama
    16 => 13, // Persona #16 -> Macuelizo
    17 => 14, // Persona #17 -> Naranjito
    18 => 15, // Persona #18 -> Nuevo Celilac
    19 => 1,  // Persona #19 -> Santa Barbara (ciclo 2)
    20 => 2,  // Persona #20 -> Arada
    21 => 3,  // Persona #21 -> Atima
    22 => 4,  // Persona #22 -> Azacualpa
    23 => 5,  // Persona #23 -> Ceguaca
    24 => 6,  // Persona #24 -> San Jose de Colinas
    25 => 7,  // Persona #25 -> Concepcion Del Norte
    26 => 8,  // Persona #26 -> Concepcion Del Sur
    27 => 9,  // Persona #27 -> Chinda
    28 => 10, // Persona #28 -> El Nispero
    29 => 11, // Persona #29 -> Gualala
    30 => 12, // Persona #30 -> Ilama
    31 => 13, // Persona #31 -> Macuelizo
    32 => 14, // Persona #32 -> Naranjito
    33 => 15, // Persona #33 -> Nuevo Celilac
    34 => 1,  // Persona #34 -> Santa Barbara (ciclo 3)
    35 => 2,  // Persona #35 -> Arada
    36 => 3,  // Persona #36 -> Atima
    37 => 4,  // Persona #37 -> Azacualpa
    38 => 5,  // Persona #38 -> Ceguaca
    39 => 6,  // Persona #39 -> San Jose de Colinas
    40 => 7,  // Persona #40 -> Concepcion Del Norte
    41 => 8,  // Persona #41 -> Concepcion Del Sur
    42 => 9,  // Persona #42 -> Chinda
    43 => 10, // Persona #43 -> El Nispero
    44 => 11, // Persona #44 -> Gualala
    45 => 12, // Persona #45 -> Ilama
    46 => 13, // Persona #46 -> Macuelizo
    47 => 14, // Persona #47 -> Naranjito
    48 => 15, // Persona #48 -> Nuevo Celilac
    49 => 1,  // Persona #49 -> Santa Barbara (ciclo 4)
    50 => 2,  // Persona #50 -> Arada
    51 => 3,  // Persona #51 -> Atima
    52 => 4,  // Persona #52 -> Azacualpa
    53 => 5,  // Persona #53 -> Ceguaca
];

// Candidatos presidenciales (3 candidatos)
$candidatosPresidente = [1, 2, 3]; // Salvador Nasralla, Nasry Asfura, Rixi Moncada

// Candidatos diputados (27 candidatos total)
$candidatosDiputados = range(1, 27);

// Candidatos alcaldes por municipio (cada municipio tiene 3 candidatos: Nacional, Liberal, LIBRE)
$candidatosAlcaldesPorMunicipio = [
    1 => [1, 16, 31],   // Santa Barbara: Nacional #1, Liberal #1, LIBRE #1
    2 => [2, 17, 32],   // Arada: Nacional #2, Liberal #2, LIBRE #2
    3 => [3, 18, 33],   // Atima: Nacional #3, Liberal #3, LIBRE #3
    4 => [4, 19, 34],   // Azacualpa: Nacional #4, Liberal #4, LIBRE #4
    5 => [5, 20, 35],   // Ceguaca: Nacional #5, Liberal #5, LIBRE #5
    6 => [6, 21, 36],   // San Jose de Colinas: Nacional #6, Liberal #6, LIBRE #6
    7 => [7, 22, 37],   // Concepcion Del Norte: Nacional #7, Liberal #7, LIBRE #7
    8 => [8, 23, 38],   // Concepcion Del Sur: Nacional #8, Liberal #8, LIBRE #8
    9 => [9, 24, 39],   // Chinda: Nacional #9, Liberal #9, LIBRE #9
    10 => [10, 25, 40], // El Nispero: Nacional #10, Liberal #10, LIBRE #10
    11 => [11, 26, 41], // Gualala: Nacional #11, Liberal #11, LIBRE #11
    12 => [12, 27, 42], // Ilama: Nacional #12, Liberal #12, LIBRE #12
    13 => [13, 28, 43], // Macuelizo: Nacional #13, Liberal #13, LIBRE #13
    14 => [14, 29, 44], // Naranjito: Nacional #14, Liberal #14, LIBRE #14
    15 => [15, 30, 45], // Nuevo Celilac: Nacional #15, Liberal #15, LIBRE #15
];

$totalVotosPresidente = 0;
$totalVotosDiputados = 0;
$totalVotosAlcaldes = 0;

echo "🗳️ Creando votos presidenciales (aleatorios)...\n";

// Votos presidenciales aleatorios (0 o 1 por persona)
foreach ($personas as $personaId => $municipioId) {
    // 70% de probabilidad de votar presidencial
    if (rand(1, 100) <= 70) {
        $candidatoId = $candidatosPresidente[array_rand($candidatosPresidente)];
        $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 10:" . sprintf("%02d", $personaId) . ":00"));
        if (crearVotoPresidencial($personaId, $candidatoId, $tiempo)) {
            $totalVotosPresidente++;
        }
        usleep(100000); // Pausa de 0.1 segundos
    } else {
        echo "⏭️ Persona $personaId no votó presidencial\n";
    }
}

echo "\n🗳️ Creando votos diputados (0-9 aleatorios por persona)...\n";

// Votos diputados aleatorios (0-9 por persona)
foreach ($personas as $personaId => $municipioId) {
    $numVotosDiputados = rand(0, 9); // 0 a 9 votos aleatorios
    
    if ($numVotosDiputados > 0) {
        echo "\n👤 Persona $personaId votando por $numVotosDiputados diputados:\n";
        
        // Mezclar candidatos para aleatoriedad
        $candidatosDisponibles = $candidatosDiputados;
        shuffle($candidatosDisponibles);
        
        // Tomar los primeros N candidatos
        $candidatosElegidos = array_slice($candidatosDisponibles, 0, $numVotosDiputados);
        
        foreach ($candidatosElegidos as $index => $candidatoId) {
            $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 11:" . sprintf("%02d", $personaId) . ":" . sprintf("%02d", $index + 1) . ":00"));
            if (crearVotoDiputado($personaId, $candidatoId, $tiempo)) {
                $totalVotosDiputados++;
            }
            usleep(100000);
        }
    } else {
        echo "⏭️ Persona $personaId no votó diputados\n";
    }
}

echo "\n🗳️ Creando votos alcaldes (aleatorios por municipio)...\n";

// Votos alcaldes aleatorios (0 o 1 por persona, entre los 3 candidatos de su municipio)
foreach ($personas as $personaId => $municipioId) {
    // 80% de probabilidad de votar alcalde
    if (rand(1, 100) <= 80) {
        $candidatosMunicipio = $candidatosAlcaldesPorMunicipio[$municipioId];
        $candidatoId = $candidatosMunicipio[array_rand($candidatosMunicipio)]; // Elegir aleatoriamente entre los 3
        
        $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 12:" . sprintf("%02d", $personaId) . ":00"));
        if (crearVotoAlcalde($personaId, $candidatoId, $municipioId, $tiempo)) {
            $totalVotosAlcaldes++;
        }
        usleep(100000);
    } else {
        echo "⏭️ Persona $personaId no votó alcalde\n";
    }
}

echo "\n🎉 ¡Votos de prueba creados exitosamente!\n";
echo "📊 Resumen de votos creados:\n";
echo "   - 10 votos presidenciales (distribuidos entre 3 candidatos)\n";
echo "   - 10 votos diputados (distribuidos entre 18 candidatos)\n";
echo "   - 10 votos alcaldes (distribuidos entre 30 candidatos)\n\n";

echo "🔍 Ahora puedes probar las estadísticas en:\n";
echo "   - $baseUrl/estadisticas/generales\n";
echo "   - $baseUrl/estadisticas/presidenciales\n";
echo "   - $baseUrl/estadisticas/diputados\n";
echo "   - $baseUrl/estadisticas/alcaldes\n";
echo "   - $baseUrl/estadisticas/ranking-presidentes\n";
echo "   - $baseUrl/estadisticas/ranking-diputados\n";
echo "   - $baseUrl/estadisticas/ranking-alcaldes\n";
echo "   - $baseUrl/estadisticas/comparativa-partidos\n";

echo "\n🎲 Distribución aleatoria esperada:\n";
echo "   - Presidenciales: ~37 votos (70% de 53 personas)\n";
echo "   - Diputados: ~239 votos (promedio 4.5 por persona)\n";
echo "   - Alcaldes: ~42 votos (80% de 53 personas)\n";

echo "\n🗺️ Distribución por municipio:\n";
foreach ($personas as $personaId => $municipioId) {
    $municipios = [
        1 => 'Santa Barbara',
        2 => 'Arada', 
        3 => 'Atima',
        4 => 'Azacualpa',
        5 => 'Ceguaca',
        6 => 'San Jose de Colinas',
        7 => 'Concepcion Del Norte',
        8 => 'Concepcion Del Sur',
        9 => 'Chinda',
        10 => 'El Nispero',
        11 => 'Gualala',
        12 => 'Ilama',
        13 => 'Macuelizo',
        14 => 'Naranjito',
        15 => 'Nuevo Celilac'
    ];
    echo "   Persona $personaId -> {$municipios[$municipioId]}\n";
} 