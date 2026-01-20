<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $request = Request::capture();
    $response = $app->handle($request);
    $response->send();

    $app->terminate($request, $response);
} catch (\Throwable $e) {
    // Handle bootstrap errors gracefully
    http_response_code(500);
    
    // Display error message in development
    if (function_exists('env') && env('APP_DEBUG', false)) {
        echo '<pre style="color: #d63031; font-family: monospace; padding: 20px; background: #f5f6fa; border-radius: 8px; margin: 20px;">';
        echo "<strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "\n\n";
        echo "<strong>File:</strong> " . htmlspecialchars($e->getFile()) . "\n";
        echo "<strong>Line:</strong> " . htmlspecialchars($e->getLine()) . "\n\n";
        echo "<strong>Stack Trace:</strong>\n";
        echo htmlspecialchars($e->getTraceAsString());
        echo '</pre>';
    } else {
        // Production error message
        echo 'Something went wrong. Please try again later.';
    }
    exit(1);
}
