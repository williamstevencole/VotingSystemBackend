<?php

define('LARAVEL_START', microtime(true));

// Autoload de Composer
require __DIR__.'/../vendor/autoload.php';

// Bootstrap de la aplicación
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Captura la petición, la procesa y envía la respuesta
$request  = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

$response->send();

// Termina el kernel (listeners, terminable middleware, etc)
$kernel->terminate($request, $response);