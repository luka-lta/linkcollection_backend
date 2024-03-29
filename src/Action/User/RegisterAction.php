<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\User;

use LinkCollectionBackend\Service\Register\RegisterService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterAction
{
    public function __construct(
        private readonly RegisterService $registerService
    )
    {
    }

    public function handleRegisterAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();

        $result = $this->registerService->registerUser($parsedBody);
        $response->getBody()->write(json_encode($result->getResponseArray()));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Max-Age', '86400')
            ->withStatus($result->getStatusCode());
    }
}