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
            ->withStatus($result->getStatusCode());
    }
}