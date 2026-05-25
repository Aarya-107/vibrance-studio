<?php

// Bootstrap the SQLite database if it doesn't exist (Vercel /tmp is ephemeral)
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);

    // Boot a minimal Laravel app to run migrations + seed
    define('LARAVEL_START', microtime(true));
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('migrate', ['--force' => true, '--no-interaction' => true]);
    $kernel->call('db:seed', ['--force' => true, '--no-interaction' => true]);
    $kernel->terminate(new Symfony\Component\Console\Input\ArrayInput([]), 0);
}

// Forward request to normal Laravel public/index.php
require __DIR__ . '/../public/index.php';
