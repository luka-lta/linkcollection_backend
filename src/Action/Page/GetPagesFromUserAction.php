<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Page;

use LinkCollectionBackend\Service\Page\GetPagesService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPagesFromUserAction
{
    public function __construct(
        private readonly GetPagesService $pagesService,
    )
    {
    }

    public function handleGetPagesFromUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');

        $result = $this->pagesService->getPages($authHeader);
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