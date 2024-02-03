<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Middleware;

use LinkCollectionBackend\Exception\AuthException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Service\ValidationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ValidationService $validationService,
    ) {}

    /**
     * @throws ValidationFailureException
     * @throws AuthException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwtHeader = $request->getHeaderLine('Authorization');
        if (!$jwtHeader) {
            throw new AuthException('No Authorization header found');
        }

        $tokenData = $this->validationService->validateToken($jwtHeader);
        $object = (array)$request->getParsedBody();
        $object['tokenData'] = $tokenData;

        return $handler->handle($request->withParsedBody($object));
    }
}