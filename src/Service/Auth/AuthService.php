<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Auth;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\User\AuthRepository;
use LinkCollectionBackend\Value\ResultObject;

class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository
    )
    {
    }

    public function authUser(array $payload): ResultObject
    {
        try {
            $token = $this->authRepository->loginUser($payload['email'], $payload['password']);
            return ResultObject::from('User authenticated', 200, [
                'token' => $token->getEncodedToken(),
                'user' => $token->getAuthUser()->toArray()
            ]);
        } catch (LinkCollectionException $exception) {
            return ResultObject::from($exception->getMessage(), $exception->getCode(), null);
        }
    }
}