<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(-1);
require_once __DIR__ . "/vendor/autoload.php";

use app\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    "db" => [
        "dsn" => $_ENV['DB_DSN'],
        "user" => $_ENV['DB_USER'],
        "password" => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);
$app->db->applyMigrations();