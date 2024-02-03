<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use Exception;
use Firebase\JWT\JWT;
use LinkCollectionBackend\Exception\AuthException;
use LinkCollectionBackend\Exception\ValidationFailureException;

class ValidationService
{
    /**
     * @throws ValidationFailureException
     */
    public function validateToken(string $token): array
    {
        try {
            $jwt = explode('Bearer ', $token);
            if (!isset($jwt[1])) {
                throw new AuthException('No valid Authorization header found');
            }
            $decoded = JWT::decode($jwt[1], "1b6593d5235c98dcb60177a73f7a2e03ea94a4eaa89b61ed15ec0901d5cf8466", ['HS256']);
            return (array) $decoded;
        } catch (Exception) {
            throw new ValidationFailureException('Token is invalid');
        }
    }
}