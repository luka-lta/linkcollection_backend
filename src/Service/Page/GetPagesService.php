<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Page;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\Page\PageRepository;
use LinkCollectionBackend\Value\AuthObject;
use LinkCollectionBackend\Value\ResultObject;

class GetPagesService
{
    public function __construct(
        private readonly PageRepository $pageRepository
    )
    {
    }

    public function getPages(string $token): ResultObject
    {
        try {
            $authObject = AuthObject::fromEncodedToken($token);
            $pages = $this->pageRepository->getPageByOwnerId($authObject->getAuthUser()->getUserId());
        } catch (LinkCollectionException $e) {
            return ResultObject::from($e->getMessage(), $e->getCode());
        }

        return ResultObject::from('Pages found!', 200, $pages->toArray());
    }
}