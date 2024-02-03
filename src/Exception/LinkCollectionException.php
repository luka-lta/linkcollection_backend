<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Exception;

use Throwable;

class LinkCollectionException extends \Exception
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}