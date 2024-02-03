<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\User;

use LinkCollectionBackend\Exception\DatabaseException;
use LinkCollectionBackend\Exception\UserAlreadyExistsException;
use LinkCollectionBackend\Value\User;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct(
        private readonly PDO $database,
    ) {}

    /**
     * @throws UserAlreadyExistsException
     * @throws DatabaseException
     */
    public function registerUser(string $username, string $email, string $password): User
    {
        if ($this->userExistsByEmail($email)) {
            throw new UserAlreadyExistsException('User with this email already exists');
        }

        if ($this->userExistsByUsername($username)) {
            throw new UserAlreadyExistsException('User with this username already exists');
        }

        try {
            $statement = $this->database->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $statement->execute([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return $this->getUserById((int)$this->database->lastInsertId());
    }

    /**
     * @throws DatabaseException
     */
    public function getUserById(int $userId): User
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM users WHERE id = :id');
            $statement->execute([
                'id' => $userId
            ]);
            $userData = $statement->fetch();
        } catch (PDOException $e) {
            throw new DatabaseException('Database error');
        }

        if ($userData === false) {
            throw new DatabaseException('User not found');
        }

        return User::fromDatabase($userData);
    }

    public function userExistsByEmail(string $email): bool
    {
        try {
            $statement = $this->database->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
            $statement->execute([
                'email' => $email
            ]);
            $count = $statement->fetchColumn();
        } catch (PDOException $e) {
            throw new DatabaseException('Database error');
        }

        return $count > 0;
    }

    public function userExistsByUsername(string $username): bool
    {
        try {
            $statement = $this->database->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
            $statement->execute([
                'username' => $username
            ]);
            $count = $statement->fetchColumn();
        } catch (PDOException $e) {
            throw new DatabaseException('Database error');
        }

        return $count > 0;
    }
}