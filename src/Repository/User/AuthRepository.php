<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\User;

use LinkCollectionBackend\Exception\DatabaseException;
use LinkCollectionBackend\Exception\LoginException;
use LinkCollectionBackend\Value\AuthObject;
use PDO;
use PDOException;

class AuthRepository
{
    public function __construct(
        private readonly PDO $database,
        private readonly UserRepository $userRepository
    ) {}

    /**
     * @throws DatabaseException
     * @throws LoginException
     */
    public function loginUser(string $email, string $password): AuthObject
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

            $user = $this->userRepository->getUserById($result['id']);
            $token = [
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60),
                'data' => [
                    'id' => $user->getUserId(),
                    'email' => $user->getEmail(),
                    'username' => $user->getUsername(),
                ],
            ];

            return AuthObject::fromTokenData($token, $user);
        } catch (PDOException) {
            throw new DatabaseException('Could not login user');
        }
    }
}