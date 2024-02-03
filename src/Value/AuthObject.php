<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

use Firebase\JWT\JWT;
use LinkCollectionBackend\Exception\AuthException;
use stdClass;

final class AuthObject
{
    private const SECRET_KEY = '1b6593d5235c98dcb60177a73f7a2e03ea94a4eaa89b61ed15ec0901d5cf8466';

    private function __construct(
        private readonly array $tokenData,
    ) {}

    public static function fromTokenData(array $tokenData): self
    {
        return new self($tokenData);
    }

    /**
     * @throws AuthException
     */
    public static function fromEncodedToken(string $encodedToken): self
    {
        $jwt = explode('Bearer ', $encodedToken);
        if (!isset($jwt[1])) {
            throw new AuthException('No valid Authorization header found');
        }

        return new self((array)JWT::decode($jwt[1], self::SECRET_KEY, ['HS256']));
    }

    public function getAuthUser(): User
    {
        $encodedData = $this->getDecodedToken()['data'];
        return User::from($encodedData->username, $encodedData->email, null, $encodedData->id);
    }

    public function getTokenData(): array
    {
        return $this->tokenData;
    }

    public function getEncodedToken(): string
    {
        return JWT::encode($this->tokenData, self::SECRET_KEY);
    }

    public function getDecodedToken(): array
    {
        return (array)JWT::decode($this->getEncodedToken(), self::SECRET_KEY, ['HS256']);
    }
}
