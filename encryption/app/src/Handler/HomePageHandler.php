<?php

namespace Encryption\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomePageHandler implements RequestHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getAttribute('name', 'world');
        $response = new Response();
        $response->getBody()->write("Hello $name");
        return $response;
    }
}