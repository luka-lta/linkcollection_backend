<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class PageLink
{
    private function __construct(
        private readonly int $linkId,
        private readonly int $pageId,
        private readonly int $ownerId,
        private readonly string $name,
        private readonly string $url,
    ){}

    public static function from(int $linkId, int $pageId, int $ownerId, string $name, string $url): self
    {
        return new self($linkId, $pageId, $ownerId, $name, $url);
    }

    public static function fromDatabase(array $data): self
    {
        return new self(
            $data['id'],
            $data['page_id'],
            $data['owner_id'],
            $data['name'],
            $data['url']
        );
    }

    public function getLinkId(): int
    {
        return $this->linkId;
    }

    public function getPageId(): int
    {
        return $this->pageId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}