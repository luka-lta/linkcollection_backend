<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Link;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\Link\LinkRepository;
use LinkCollectionBackend\Value\AuthObject;
use LinkCollectionBackend\Value\ResultObject;

class LinkService
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    )
    {
    }

    public function createLink(string $authToken, array $linkData): ResultObject
    {
        try {
            $token = AuthObject::fromEncodedToken($authToken);
            $pageId = (int)$linkData['pageId'];
            $ownerId = $token->getAuthUser()->getUserId();
            $name = $linkData['name'];
            $url = $linkData['url'];

            $this->linkRepository->createLink($pageId, $ownerId, $name, $url);
        } catch (LinkCollectionException $e) {
            return ResultObject::from($e->getMessage(), $e->getCode());
        }

        return ResultObject::from('Link created', 200);
    }
}