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
            ->withStatus($result->getStatusCode());
    }
}