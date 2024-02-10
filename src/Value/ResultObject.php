<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class ResultObject
{
    private function __construct(
        private readonly string $message,
        private readonly int $statusCode,
        private readonly ?array $data,
    )
    {
    }

    public static function from(string $message, int $statusCode, ?array $data = null): self
    {
        return new self($message, $statusCode, $data);
    }

    public function getResponseArray(): array
    {
        if ($this->data === null) {
            return [
                'message' => $this->message,
                'statusCode' => $this->statusCode
            ];
        }

        return [
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            'data' => $this->data
        ];
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}