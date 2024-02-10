<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\User;

use Firebase\JWT\JWT;
use LinkCollectionBackend\Exception\DatabaseException;
use LinkCollectionBackend\Exception\LoginException;
use LinkCollectionBackend\Service\TokenService;
use LinkCollectionBackend\Value\TokenObject;
use LinkCollectionBackend\Value\User;
use PDO;
use PDOException;

class AuthRepository
{
    public function __construct(
        private readonly PDO            $database,
        private readonly UserRepository $userRepository,
        private readonly TokenService   $tokenService,
    )
    {
    }

    /**
     * @throws DatabaseException
     * @throws LoginException
     */
    public function login(string $email, string $password): TokenObject
    {
        try {
            $statement = $this->database->prepare('SELECT `id`, `password` FROM `users` WHERE `email` = :email');
            $statement->execute([
                'email' => $email
            ]);
            $result = $statement->fetch();

            if ($result === false) {
                throw new DatabaseException('User not found');
            }
            if (!password_verify($password, $result['password'])) {
                throw new LoginException('Password is wrong');
            }

            $user = $this->userRepository->getById($result['id']);

            return $this->tokenService->generateToken($user, time() + (7 * 24 * 60 * 60));
        } catch (PDOException) {
            throw new DatabaseException('Could not login user');
        }
    }
}