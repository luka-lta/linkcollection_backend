<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Page;

use LinkCollectionBackend\Service\Page\CreatePageService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreatePageAction
{
    public function __construct(
        private readonly CreatePageService $createPageService
    )
    {
    }

    public function handleCreatePageAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $authHeader = $request->getHeaderLine('Authorization');

        $result = $this->createPageService->createPage($authHeader, $parsedBody);
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