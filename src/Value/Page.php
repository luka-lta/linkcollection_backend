<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class Page
{
    private function __construct(
        private readonly int $pageId,
        private readonly int $ownerId,
        private readonly string $title,
        private readonly string $theme,
    ) {}

    public static function from(int $pageId, int $ownerId, string $title, string $theme): self
    {
        return new self($pageId, $ownerId, $title, $theme);
    }

    public static function fromDatabase(array $data): self
    {
        return new self(
            $data['id'],
            $data['owner_id'],
            $data['title'],
            $data['theme']
        );
    }

    public function getPageId(): int
    {
        return $this->pageId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }
}