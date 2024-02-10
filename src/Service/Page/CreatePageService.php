<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Page;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\Page\PageRepository;
use LinkCollectionBackend\Value\TokenObject;
use LinkCollectionBackend\Value\ResultObject;

class CreatePageService
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {}

    public function createPage(string $authToken, array $pageData): ResultObject
    {
        $authObject = TokenObject::fromEncodedToken($authToken);

        try {
            $this->pageRepository->create(
                $authObject->getAuthUser()->getUserId(),
                $pageData['title'],
                $pageData['theme']
            );
        } catch (LinkCollectionException $e) {
            return ResultObject::from($e->getMessage(), $e->getCode());
        }

        return ResultObject::from('Page created', 201);
    }
}