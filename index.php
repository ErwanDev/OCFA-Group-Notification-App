<?php

// Debug errors
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);

// XSS
ini_set('session.cookie_httponly', 1);

session_start();

require __DIR__ . '/bootstrap/app.php';

$app->run();