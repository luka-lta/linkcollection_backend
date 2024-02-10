<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\User;

use LinkCollectionBackend\Service\Auth\AuthService;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RefreshTokenAction
{
//    public function __construct(
//        private readonly AuthService $authService,
//    )
//    {
//    }
//
//    public function handleRefreshTokenAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
//    {
//        $parsedBody = $request->getParsedBody();
////        $result = $this->authService->refreshToken($parsedBody['refreshToken']);
////        $response->getBody()->write(json_encode($result->getResponseArray()));
//
//        return $response
//            ->withHeader('Content-Type', 'application/json')
//            ->withHeader('Access-Control-Allow-Origin', '*')
//            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//            ->withHeader('Access-Control-Allow-Headers', '*')
//            ->withHeader('Access-Control-Max-Age', '86400');
////            ->withStatus($result->getStatusCode());
//    }
}