<?php

define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$agent = new App\Ai\Agents\ChatAgent([]);
$response = $agent->prompt('Hello, I need help building a website for my business.');
echo $response->text . PHP_EOL;
