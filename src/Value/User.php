<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class User
{
    private function __construct(
        private readonly string $username,
        private readonly string $email,
        private ?string $password,
        private readonly ?int $userId,
    ) {}

    public static function from(string $username, string $email, ?string $password = null, ?int $userId = null): self
    {
        return new self($username, $email, $password, $userId);
    }

    public static function fromDatabase(array $data): self
    {
        return new self(
            $data['username'],
            $data['email'],
            $data['password'],
            $data['id'],
        );
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'username' => $this->username,
            'email' => $this->email
        ];
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}