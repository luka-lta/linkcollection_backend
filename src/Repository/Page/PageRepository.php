<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\Page;

use LinkCollectionBackend\Exception\DatabaseException;
use LinkCollectionBackend\Exception\PageAlreadyExistsException;
use LinkCollectionBackend\Value\Page\Page;
use PDO;
use PDOException;

class PageRepository
{
    public function __construct(
        private readonly PDO $database,
    )
    {
    }

    /**
     * @throws DatabaseException
     * @throws PageAlreadyExistsException
     */
    public function create(int $ownerId, string $title, ?string $theme): Page
    {
        if ($this->existsByOwnerId($ownerId)) {
            throw new PageAlreadyExistsException('Page already exists');
        }

        try {
            $statement = $this->database->prepare('INSERT INTO pages (owner_id, title, theme) VALUES (:owner_id, :title, :theme)');
            $statement->execute([
                'owner_id' => $ownerId,
                'title' => $title,
                'theme' => $theme
            ]);
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return Page::fromDatabase([
            'id' => (int)$this->database->lastInsertId(),
            'owner_id' => $ownerId,
            'title' => $title,
            'theme' => $theme
        ]);
    }

    /**
     * @throws DatabaseException
     */
    public function getById(int $pageId): Page
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM pages WHERE id = :id');
            $statement->execute([
                'id' => $pageId
            ]);
            $pageData = $statement->fetch();
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return Page::fromDatabase($pageData);
    }

    /**
     * @throws DatabaseException
     */
    public function getByOwnerId(int $ownerId): Page
    {
        try {
            $statement = $this->database->prepare('SELECT * FROM pages WHERE owner_id = :owner_id');
            $statement->execute([
                'owner_id' => $ownerId
            ]);
            $pageData = $statement->fetch();
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        if ($pageData === false) {
            throw new DatabaseException('No pages exists for this user');
        }

        return Page::fromDatabase($pageData);
    }

    /**
     * @throws DatabaseException
     */
    public function isOwner(int $pageId, int $ownerId): bool
    {
        try {
            $statement = $this->database->prepare('SELECT COUNT(*) FROM pages WHERE owner_id = :owner_id AND id = :id');
            $statement->execute([
                'owner_id' => $ownerId,
                'id' => $pageId
            ]);
            $result = $statement->fetchColumn();
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return $result > 0;
    }

    /**
     * @throws DatabaseException
     */
    public function existsByOwnerId(int $ownerId): bool
    {
        try {
            $statement = $this->database->prepare('SELECT COUNT(*) FROM pages WHERE owner_id = :owner_id');
            $statement->execute([
                'owner_id' => $ownerId
            ]);
            $result = $statement->fetchColumn();
        } catch (PDOException) {
            throw new DatabaseException('Database error');
        }

        return $result > 0;
    }
}