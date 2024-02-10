<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Value\TokenObject;
use LinkCollectionBackend\Value\User;

class TokenService
{
    public function generateToken(User $authUser, int $expiration): TokenObject
    {
        $tokenData = $this->createTokenData($authUser, $expiration);
        return TokenObject::fromTokenData($tokenData);
    }

    private function createTokenData(User $user, int $expiration): array
    {
        return [
            'iat' => time(),
            'exp' => $expiration,
            'data' => [
                'id' => $user->getUserId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
            ],
        ];
    }
}