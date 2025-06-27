<?php

/**
 * Script para crear votos de prueba para estadísticas
 * Uso: php crear_votos_prueba.php
 */

$baseUrl = 'http://localhost:8000/api';

echo "🎯 Creando votos de prueba para estadísticas...\n";

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
        echo "✅ Voto presidencial creado: Persona $personaId -> Candidato $candidatoId\n";
        return true;
    } else {
        echo "❌ Error creando voto presidencial: HTTP {$result['code']}\n";
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
        echo "✅ Voto diputado creado: Persona $personaId -> Candidato $candidatoId\n";
        return true;
    } else {
        echo "❌ Error creando voto diputado: HTTP {$result['code']}\n";
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
        echo "✅ Voto alcalde creado: Persona $personaId -> Candidato $candidatoId (Municipio $municipioId)\n";
        return true;
    } else {
        echo "❌ Error creando voto alcalde: HTTP {$result['code']}\n";
        return false;
    }
}

// Crear votos presidenciales
echo "\n🗳️ Creando votos presidenciales...\n";

// Votos para Salvador Nasralla (Partido Liberal - Candidato 1)
for ($i = 1; $i <= 50; $i++) {
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 10:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoPresidencial($i, 1, $tiempo);
    usleep(100000); // Pausa de 0.1 segundos
}

// Votos para Nasry Asfura (Partido Nacional - Candidato 2)
for ($i = 51; $i <= 100; $i++) {
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 11:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoPresidencial($i, 2, $tiempo);
    usleep(100000);
}

// Votos para Rixi Moncada (Partido LIBRE - Candidato 3)
for ($i = 101; $i <= 150; $i++) {
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 12:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoPresidencial($i, 3, $tiempo);
    usleep(100000);
}

// Crear votos diputados
echo "\n🗳️ Creando votos diputados...\n";

// Votos para diputados del Partido Nacional (Candidatos 1-9)
for ($i = 1; $i <= 30; $i++) {
    $candidatoId = 1 + ($i % 9);
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 10:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoDiputado($i, $candidatoId, $tiempo);
    usleep(100000);
}

// Votos para diputados del Partido Liberal (Candidatos 10-18)
for ($i = 31; $i <= 60; $i++) {
    $candidatoId = 10 + ($i % 9);
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 11:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoDiputado($i, $candidatoId, $tiempo);
    usleep(100000);
}

// Crear votos alcaldes
echo "\n🗳️ Creando votos alcaldes...\n";

// Votos para alcaldes del Partido Nacional (Candidatos 1-15)
for ($i = 1; $i <= 25; $i++) {
    $candidatoId = 1 + ($i % 15);
    $municipioId = 1 + ($i % 15);
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 10:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoAlcalde($i, $candidatoId, $municipioId, $tiempo);
    usleep(100000);
}

// Votos para alcaldes del Partido Liberal (Candidatos 16-30)
for ($i = 26; $i <= 50; $i++) {
    $candidatoId = 16 + ($i % 15);
    $municipioId = 1 + ($i % 15);
    $tiempo = date('Y-m-d H:i:s', strtotime("2025-01-15 11:" . sprintf("%02d", $i % 60) . ":00"));
    crearVotoAlcalde($i, $candidatoId, $municipioId, $tiempo);
    usleep(100000);
}

echo "\n🎉 ¡Votos de prueba creados exitosamente!\n";
echo "📊 Ahora puedes probar las estadísticas en:\n";
echo "   - $baseUrl/estadisticas/generales\n";
echo "   - $baseUrl/estadisticas/presidenciales\n";
echo "   - $baseUrl/estadisticas/diputados\n";
echo "   - $baseUrl/estadisticas/alcaldes\n";
echo "   - $baseUrl/estadisticas/ranking-presidentes\n";
echo "   - $baseUrl/estadisticas/ranking-diputados\n";
echo "   - $baseUrl/estadisticas/ranking-alcaldes\n";
echo "   - $baseUrl/estadisticas/comparativa-partidos\n"; 