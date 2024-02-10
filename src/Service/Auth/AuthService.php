<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Auth;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Repository\User\AuthRepository;
use LinkCollectionBackend\Service\ValidationService;
use LinkCollectionBackend\Value\ResultObject;

class AuthService
{
    public function __construct(
        private readonly AuthRepository    $authRepository,
        private readonly ValidationService $validationService,
    )
    {
    }

    public function authUser(array $payload): ResultObject
    {
        try {
            if (!isset($payload['email'], $payload['password'])) {
                throw new ValidationFailureException('Email and password must not be empty');
            }

            $email = $payload['email'];
            $password = $payload['password'];

            $this->validationService->validateLoginCredentials($email, $password);
            $token = $this->authRepository->login($email, $password);

            return ResultObject::from('User authenticated', 200, [
                'token' => $token->getEncodedToken(),
                'user' => $token->getAuthUser()->toArray()
            ]);
        } catch (LinkCollectionException $exception) {
            return ResultObject::from($exception->getMessage(), $exception->getCode());
        }
    }
}