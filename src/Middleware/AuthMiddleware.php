<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Middleware;

use LinkCollectionBackend\Exception\AuthException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Service\ValidationService;
use LinkCollectionBackend\Value\TokenObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @throws AuthException
     * @throws ValidationFailureException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwtHeader = $request->getHeaderLine('Authorization');
        if (!$jwtHeader) {
            throw new AuthException('No Authorization header found');
        }

        $tokenData = TokenObject::fromEncodedToken($jwtHeader);

        if ($tokenData->getExpiration()->getTimestamp() < time()) {
            throw new ValidationFailureException('Token is expired');
        }

        $object = (array)$request->getParsedBody();
        $object['tokenData'] = $tokenData;

        return $handler->handle($request->withParsedBody($object));
    }
}