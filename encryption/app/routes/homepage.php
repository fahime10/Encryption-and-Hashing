<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/',
    function(Request $request, Response $response) use ($app)
    {
        $home_page_controller = $app->getContainer()->get('homePageController');
        $home_page_controller->createHtmlOutput($app, $request, $response);
    }
);

