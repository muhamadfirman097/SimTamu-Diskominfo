<?php

/*
|--------------------------------------------------------------------------
| Vercel Entry Point - Serverless Ready
|--------------------------------------------------------------------------
*/

// --- Matikan Debug Kasar (Agar tidak muncul kotak merah di user) ---
// Biarkan Laravel yang menangani error lewat Log
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// Tentukan path penyimpanan sementara yang valid di Vercel
$storagePath = '/tmp/storage';
$cachePath = '/tmp/cache';

// Buat struktur folder log & cache jika belum ada
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/framework/cache', 0777, true);
    mkdir($storagePath . '/framework/sessions', 0777, true);
    mkdir($storagePath . '/logs', 0777, true);
}
if (!is_dir($cachePath)) {
    mkdir($cachePath, 0777, true);
}

// Inject Env Vars
$_ENV['APP_STORAGE'] = $storagePath;
$_ENV['VIEW_COMPILED_PATH'] = $storagePath . '/framework/views';
$_ENV['APP_SERVICES_CACHE'] = $cachePath . '/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $cachePath . '/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $cachePath . '/config.php';
$_ENV['APP_ROUTES_CACHE'] = $cachePath . '/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $cachePath . '/events.php';

$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_DRIVER'] = 'array';

// Masuk ke aplikasi
require __DIR__ . '/../public/index.php';