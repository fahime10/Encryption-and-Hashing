<?php

require 'vendor/autoload.php';

$app_path = __DIR__ . '/app/';

$settings = require $app_path .'settings.php';

$container = new \Slim\Container($settings);

require $app_path .'dependencies.php';

$app = new \Slim\App($container);

require $app_path .'routes.php';

try {
    $app->run();
} catch (Exception $e) {
    // display an error message
    die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}

