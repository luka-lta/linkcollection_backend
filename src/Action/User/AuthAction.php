<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\User;

use LinkCollectionBackend\Service\Auth\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthAction
{
    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    public function handleAuthAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $result = $this->authService->authUser($parsedBody);
        $response->getBody()->write(json_encode($result->getResponseArray()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->getStatusCode());
    }
}