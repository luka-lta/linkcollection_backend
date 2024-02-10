<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Link;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\Link\LinkRepository;
use LinkCollectionBackend\Value\ResultObject;
use LinkCollectionBackend\Value\TokenObject;

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
            $token = TokenObject::fromEncodedToken($authToken);
            $pageId = (int)$linkData['pageId'];
            $ownerId = $token->getAuthUser()->getUserId();
            $name = $linkData['name'];
            $url = $linkData['url'];

            $this->linkRepository->create($pageId, $ownerId, $name, $url);
        } catch (LinkCollectionException $e) {
            return ResultObject::from($e->getMessage(), $e->getCode());
        }

        return ResultObject::from('Link created', 200);
    }
}