<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\DriverManager;

$app->post(
    '/loginresult',
    function(Request $request, Response $response) use ($app) {
        $loginuser_controller = $app->getContainer()->get('loginUserController');
        $loginuser_controller->createHtmlOutput($app, $request, $response);
    }
);