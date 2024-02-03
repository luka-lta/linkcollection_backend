<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Register;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\User\UserRepository;
use LinkCollectionBackend\Value\ResultObject;

class RegisterService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    public function registerUser(array $parsedBody): ResultObject
    {
        try {
            $this->userRepository->registerUser($parsedBody['username'], $parsedBody['email'], $parsedBody['password']);
            return ResultObject::from('User registered', 201);
        } catch (LinkCollectionException $exception) {
            return ResultObject::from($exception->getMessage(), $exception->getCode());
        }
    }
}