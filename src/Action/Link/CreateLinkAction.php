<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Link;

use LinkCollectionBackend\Service\Link\LinkService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateLinkAction
{
    public function __construct(
        private readonly LinkService $linkService,
    )
    {
    }

    public function handleCreateLinkAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = $request->getHeaderLine('Authorization');
        $linkData = $request->getParsedBody();

        $result = $this->linkService->createLink($token, $linkData);
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