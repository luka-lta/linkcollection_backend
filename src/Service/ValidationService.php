<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Exception\ValidationFailureException;

class ValidationService
{
    /**
     * @throws ValidationFailureException
     */
    public function validateLoginCredentials(string $email, string $password): void
    {
        if (empty($email) || empty($password)) {
            throw new ValidationFailureException('Email and password must not be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationFailureException('Email is not valid');
        }
    }
}