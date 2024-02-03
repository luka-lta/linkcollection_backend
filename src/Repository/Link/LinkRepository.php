<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\Link;

use LinkCollectionBackend\Exception\DatabaseException;
use LinkCollectionBackend\Exception\NotOwnerOfPageException;
use LinkCollectionBackend\Repository\Page\PageRepository;
use LinkCollectionBackend\Value\PageLink;
use PDO;
use PDOException;

class LinkRepository
{
    public function __construct(
        private readonly PDO            $database,
        private readonly PageRepository $pageRepository,
    )
    {
    }

    /**
     * @throws DatabaseException
     * @throws NotOwnerOfPageException
     */
    public function createLink(int $pageId, int $ownerId, string $name, string $url): PageLink
    {
        try {
            if (!$this->pageRepository->isOwnerOfPage($pageId, $ownerId)) {
                throw new NotOwnerOfPageException('Not owner of page');
            }

            $statement = $this->database->prepare('INSERT INTO links (page_id, owner_id, name, url) VALUES (:pageId, :ownerId, :name, :url)');
            $statement->execute([
                'pageId' => $pageId,
                'ownerId' => $ownerId,
                'name' => $name,
                'url' => $url,
            ]);
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return PageLink::fromDatabase([
            'id' => (int)$this->database->lastInsertId(),
            'page_id' => $pageId,
            'owner_id' => $ownerId,
            'name' => $name,
            'url' => $url,
        ]);
    }

    /**
     * @throws DatabaseException
     */
    public function getLinksByPageId(int $pageId): array
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM links WHERE page_id = :pageId');
            $statement->execute(['pageId' => $pageId]);
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }
        return $statement->fetchAll();
    }
}