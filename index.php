<?php

require_once __DIR__ . "/core/Application.php";
$app = new Application();

$app->router->get('/hello', function () {
    return 'Hello world';
});

$app->router->get('/', function () {
    return 'def world';
});

$app->run();