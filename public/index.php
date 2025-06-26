<?php

define('LARAVEL_START', microtime(true));

// 1. Carga el autoloader de Composer
require __DIR__.'/../vendor/autoload.php';

// 2. Bootstrap de la aplicación
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// 3. Captura la petición
$request = Illuminate\Http\Request::capture();

// 4. Delega al kernel para obtener la respuesta
$response = $kernel->handle($request);

// 5. Envía cabeceras y contenido
$response->send();

// 6. Termina el kernel (middleware terminable, listeners, etc)
$kernel->terminate($request, $response);
