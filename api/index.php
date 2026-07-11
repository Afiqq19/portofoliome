<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>Error Detected di Vercel</h1>";
    echo "<pre style='white-space: pre-wrap;'>" . (string) $e . "</pre>";
}
